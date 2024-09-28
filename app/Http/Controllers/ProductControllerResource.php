<?php

namespace App\Http\Controllers;

use App\Actions\DisplayDataWithCurrentLang;
use App\Actions\HandleRulesValidation;
use App\Actions\ImageModelSave;
use App\Filters\GenericFilter;
use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Categories;
use App\Models\Images;
use App\Models\Orders;
use App\Models\Products;
use App\Services\Messages;
use Illuminate\Http\Request;
use App\Traits\upload_image;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class ProductControllerResource extends Controller
{
    use upload_image;

    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $object = Products::query()
            ->with('images')
            ->orderBy('id', 'DESC');


        if (request()->is('dashboard*')) {
            $user = Auth::user();
            if ($user->type === 'seller') {
                $object->where('published_by', $user->id);
            }

        }


        $object = app(Pipeline::class)
            ->send($object)
            ->through([
                new GenericFilter('title', 'title', 'like', request('title')),
                new GenericFilter('category', 'category', '=', request('category')),
            ])
            ->thenReturn()
            ->paginate(12);


        $products = ProductResource::collection($object)->resolve();

        $categories = CategoryResource::collection(Categories::all())->resolve();

        return view('admin.dashboard.products', compact('products', 'categories'))->with('object', $object);
    }



    public function save(ProductFormRequest $request)
    {

        $data = $request->validated();

        $data = HandleRulesValidation::handle_inputs_langs($data, ['title', 'description']);

        $product = Products::query()->updateOrCreate([
            'id' => $data['id'] ?? null
        ], $data);



        if ($request->hasFile('images')) {

            Images::query()
                ->where('imageable_type', '=', 'App\Models\Products')
                ->where('imageable_id', '=', $product->id)
                ->delete();

            foreach ($request->file('images') as $img) {
                $image = $this->upload($img, 'products');

                ImageModelSave::make($product->id, 'Products', $image);
            }

        }

            return response()->json(['success' => true]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = CategoryResource::collection(Categories::all())->resolve();

        return view('products.add_product',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        return $this->save($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::with(['images', 'category', 'user', 'reviews.user'])->findOrFail($id);

        $canReview = false;
        if (Auth::check()) {
            $canReview = Orders::where('ordered_by', Auth::id())
                ->where('status', 'completed')
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();
        }

        $product =ProductResource::make($product)->resolve();



        return view('products.product', compact('product','canReview'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $product = Products::query()->with('images')->findOrFail($id);
        $product = ProductResource::make($product);
        $categories = CategoryResource::collection(Categories::all())->resolve();
        return view('products.edit_product',compact('categories'))->with('product', $product);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, string $id)
    {
        return $this->save($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
