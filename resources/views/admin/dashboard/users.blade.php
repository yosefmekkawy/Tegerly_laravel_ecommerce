@extends('layout')
@section('content')

    <div class="container">
        <div class="row">
            @include('components.sidebar')


            <div class="col-lg-12">
                <h1 class="text-center mt-2 underline">{{__('pages.users')}}</h1>
                <div class="row justify-content-between gy-2">
                    <form class="row g-3 justify-content-center" method="get" action="{{route('users.index')}}">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="search" class="form-control" placeholder="{{__('pages.search_user')}}" name="username" value="{{request('username')}}">
                                <span class="input-group-text" style="cursor: pointer" id="basic-addon2"><i class="ri-search-line"></i></span>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="{{__('pages.search_email')}}" name="email" value="{{request('email')}}">
                                <span class="input-group-text" style="cursor: pointer" id="basic-addon2"><i class="ri-mail-fill"></i></span>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="{{__('pages.search_phone')}}" name="email" value="{{request('phone')}}">
                                <span class="input-group-text" style="cursor: pointer" id="basic-addon2"><i class="ri-phone-fill"></i></span>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select class="form-control"  name="type">
                                    <option selected class="form-control" value="">{{__('pages.choose_type')}}</option>
                                        <option value="admin" {{"admin"==request('type') ? 'selected' : ''}}>{{__('pages.admin')}}</option>
                                        <option value="seller" {{"seller"==request('type') ? 'selected' : ''}}>{{__('pages.seller')}}</option>
                                        <option value="client" {{"client"==request('type') ? 'selected' : ''}}>{{__('pages.client')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="submit" class="form-control btn btn-success" value="{{__('pages.filter')}}">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                        <tr>
                            <td>{{__('pages.photo')}}</td>
                            <td>{{__('pages.username')}}</td>
                            <td>{{__('pages.email')}}</td>
                            <td>{{__('pages.phone')}}</td>
                            <td>{{__('pages.type')}}</td>
                            <td>{{__('pages.control')}}</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><img src="{{asset( $user['image']==null ? 'images/placeholder.png' : 'images/'.$user['image']->name)}}"></td>
                                <td>{{$user['username']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user['phone']}}</td>
                                <td>{{__('pages.'.$user['type'])}}</td>
                                <td class="">
                                    <div class="d-flex justify-content-center align-items-center gap-4">
                                        <a href="{{route('users.edit',$user['id'])}}" class="btn btn-primary ">{{__('pages.edit')}}</a>
                                        <a href="javascript:void(0)" class="btn btn-danger delete " data-id="{{$user['id']}}">{{__('pages.delete')}}</a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$object->links()}}
            </div>
        </div>
    </div>

@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <style>

        .pagination{
            margin-top: 1rem;
        }
        td img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>


        document.querySelector('.side-users').classList.add('active');


        document.querySelectorAll('.delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');

                Swal.fire({
                    title: '{{__('pages.sure_delete')}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor:  '#3085d6',
                    confirmButtonText: '{{__('pages.yes')}}',
                    cancelButtonText:'{{__('pages.no')}}'
                }).then((result) => {
                    if (result.isConfirmed) {

                        window.location.href = `/delete-item?model=users&id=${userId}`;
                    }
                });
            });
        });
    </script>


@endsection
