<?php

namespace App\Http\Controllers;

use App\Actions\HandleRulesValidation;
use App\Actions\ImageModelSave;
use App\Filters\GenericFilter;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Categories;
use App\Models\Images;
use App\Services\Messages;
use Illuminate\Http\Request;
use App\Traits\upload_image;
use Illuminate\Pipeline\Pipeline;

class CategoryControllerResource extends Controller
{
    use upload_image;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $object = Categories::query()
            ->with('image')
            ->orderBy('id','DESC');
        $object = app(Pipeline::class)
            ->send($object)
            ->through([
                new GenericFilter('name','name','like',request('name')),
            ])
            ->thenReturn()
            ->paginate(12);
        $categories = CategoryResource::collection($object)->resolve();
        return view('admin.dashboard.categories', compact('categories'))->with('object', $object);
    }

    public function save(CategoryRequest $request)
    {
        $data = $request->validated();
        $data=HandleRulesValidation::handle_inputs_langs($data,['name']);
        $output = Categories::query()->updateOrCreate([
            'id'=>$data['id'] ?? null
        ],$data);
        if(request()->hasFile('image')){
            $image = $this->upload(request()->file('image'),'categories');
            Images::query()
                ->where('imageable_type','=','App\Models\categories')
                ->where('imageable_id','=',$output->id)->delete();
            ImageModelSave::make($output->id,'Categories',$image);
        }

        $data = Categories::query()->with('image')->find($output->id);
        return Messages::success(__('messages.saved_successfully'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.add_category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        return $this->save($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Categories::query()->with('image')->findOrFail($id);
        $data=CategoryResource::make($data);
        return view('categories.edit_category',compact('data'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        return $this->save($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
