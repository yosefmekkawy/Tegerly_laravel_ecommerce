@extends('layout')
@section('content')

    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <h1 class="text-center mt-2 underline">{{__('pages.account_info')}}</h1>
                <div class="row justify-content-center gy-2">
                    <form action="{{route('users.update',$user['id'])}}" class="profile px-5" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p class="alert alert-danger">{{$error}}</p>
                            @endforeach
                        @endif
                        <div class="mb-3 row justify-content-center">
                            <div class="profile-img row align-items-center justify-content-center mb-3  overflow-hidden" style="width: 200px;height: 200px" >
                                <img src="{{asset( $user['image']==null ? 'images/placeholder.png' : 'images/'.$user['image']->name)}}" class="w-100 rounded-circle">
                            </div>
                            <input type="file" accept="image/*" class="form-control d-none " name="image" id="image">
                            <label for="image" class="btn btn-success">{{__('pages.upload_image')}}</label>
                        </div>
                        <div class="mb-3">
                            <label for="InputUsername" class="form-label">{{__('pages.username')}}</label>
                            <input type="text" class="form-control" id="InputUsername" name="username" value="{{$user['username']}}">
                        </div>
                        <div class="mb-3">
                            <label for="InputEmail1" class="form-label">{{__('pages.email')}}</label>
                            <input type="email" class="form-control" id="InputEmail1" name="email" value="{{$user['email']}} ">
                        </div>
                        <input type="hidden" class="form-control" name="id" value="{{$user['id']}}">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">{{__('pages.phone')}}</label>
                            <input type="text" class="form-control" id="InputPhone" name="phone" value="{{$user['phone']}} ">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">{{__('pages.type')}}</label>
                            <select class="form-control"  name="type"
                            @if(!str_contains(request()->fullUrl(), 'dashboard'))
                              disabled
                            @endif
                            >
                                <option selected class="form-control" value="">{{__('pages.choose_type')}}</option>
                                <option value="admin" {{"admin"==$user['type'] ? 'selected' : ''}}>{{__('pages.admin')}}</option>
                                <option value="seller" {{"seller"==$user['type'] ? 'selected' : ''}}>{{__('pages.seller')}}</option>
                                <option value="client" {{"client"==$user['type'] ? 'selected' : ''}}>{{__('pages.client')}}</option>
                            </select>
                        </div>
                        @if(!str_contains(request()->fullUrl(), 'dashboard'))
                            <input type="hidden" name="type" value="{{$user['type']}}">
                        @endif

                        <input type="submit" class="btn btn-primary form-control mt-2" value="{{__('pages.edit')}}">
                    </form>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
@endsection
<style>
    .profile{
        padding: 40px;
        border-radius: 20px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px,
        rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
        max-width: 500px !important;
    }
    .profile-img{
        width: 200px;
        height: 200px;
        border:1px solid #eee ;
    }
    .profile-img img{

        object-fit: cover;

    }
</style>
@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>
        let coverImg=document.querySelector('.profile-img img');
        let fileInput=document.querySelector('input[type="file"]');
        fileInput.addEventListener('change',function (){
            let reader = new FileReader();

            reader.onload = function(e) {
                coverImg.src = e.target.result;
            }


            reader.readAsDataURL(fileInput.files[0]);
        });




    </script>


@endsection
