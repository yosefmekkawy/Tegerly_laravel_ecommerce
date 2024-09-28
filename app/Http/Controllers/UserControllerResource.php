<?php

namespace App\Http\Controllers;

use App\Actions\HandleRulesValidation;
use App\Actions\ImageModelSave;
use App\Filters\GenericFilter;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Categories;
use App\Models\Images;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use App\Traits\upload_image;

class UserControllerResource extends Controller
{
    use upload_image;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $object = User::query()
            ->with('image')
            ->orderBy('id','DESC');
        $object = app(Pipeline::class)
            ->send($object)
            ->through([
                new GenericFilter('username','username','like',request('username')),
                new GenericFilter('type','type','=',request('type')),
                new GenericFilter('email','email','=',request('email')),
                new GenericFilter('phone','phone','=',request('phone')),
            ])
            ->thenReturn()
            ->paginate(12);
        $users = UserResource::collection($object)->resolve();
        return view('admin.dashboard.users', compact('users'))->with('object', $object);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

//        try {
//            $data = $request->validated();
//            User::create([
//                'username' => $request->username,
//                 'email' => $request->email,
//                 'password' => bcrypt($request->password),
//                'phone' => $request->phone,
//                 'type' =>'client',
//            ]);
//
//            return response()->json(['success' => true], 200);
//        } catch (\Exception $e) {
//            return response()->json(['success' => false, 'errors' => $e->getMessage()], 400);
//        }
        try {
            $data = $request->validated();
            User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone' => $data['phone'],
                'type' => 'client',
            ]);

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()], 400);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::query()->with('image')->findOrFail($id);
        $user=UserResource::make($data)->resolve();
        return view('users.profile', compact('user'));
    }


    public function save(UserRequest $request)
    {
        $data = $request->validated();
//        dd($data);
        $output = User::query()->updateOrCreate([
            'id'=>$data['id'] ?? null
        ],$data);

        if(request()->hasFile('image')){
//            dd(request('image'));
//            dd('i am here');
            $image = $this->upload(request()->file('image'),'users');
            Images::query()
                ->where('imageable_type','=','App\Models\User')
                ->where('imageable_id','=',$output->id)->delete();
            ImageModelSave::make($output->id,'User',$image);
        }
        return response()->json(['success' => true], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::query()->with('image')->findOrFail($id);
        $user=UserResource::make($data)->resolve();
        return view('users.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
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
