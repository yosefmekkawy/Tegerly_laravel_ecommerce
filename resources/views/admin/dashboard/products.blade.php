@extends('layout')
@section('content')

    <div class="container">
        <div class="row">
            @if(str_contains(request()->fullUrl(), 'dashboard'))
                @include('components.sidebar')
            @endif



            <div class="col-lg-12">
                <h1 class="text-center mt-2 underline">{{__('pages.products')}}</h1>
                <div class="row justify-content-between gy-2">
                    <div class="col-md-3">
                        @if(str_contains(request()->fullUrl(), 'dashboard'))
                            <a href="{{route('products.create')}}" class="btn btn-primary px-3 py-2 form-control">{{__('pages.add_product')}}</a>
                        @endif


                    </div>
                    <form class="row g-3 justify-content-center" method="get"
                    action="{{ str_contains(request()->fullUrl(), 'dashboard') ? route('products.index') : route('products.main.index') }}">
                    <div class="col-md-6">

                            <div class="input-group mb-3">
                                <input type="search" class="form-control" placeholder="{{__('pages.search_product')}}" name="title" value="{{request('title')}}">
                                <span class="input-group-text" onclick="this.submit()" style="cursor: pointer" id="basic-addon2"><i class="ri-search-line"></i></span>
                            </div>

                    </div>
                    <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select class="form-control"  name="category">
                                    <option selected value="">{{__('pages.choose_category')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category['id']}}" {{$category['id']==request('category') ? 'selected' : ''}}>{{$category['name']}}</option>
                                    @endforeach
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

                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 gy-3">
                            <a href="{{route('products.show',$product['id'])}}" class="text-decoration-none text-dark">
                                <div class="card position-relative">
                                    <img src="{{asset($product['images']->isEmpty() ? 'images/placeholder.png' : 'images/'.$product['images'][0]->name)}}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title text-start">{{$product['title']}}</h5>
                                        <hr>
                                        <p class="card-text fw-bold text-center">${{$product['price']}}</p>
                                        <div class="category-buttons d-flex justify-content-center gap-3 mt-3">
                                            @if(str_contains(request()->fullUrl(), 'dashboard'))
                                                <a href="{{route('products.edit',$product['id'])}}" class="btn btn-primary">{{__('pages.edit')}}</a>
                                                <a href="javascript:void(0)" class="btn btn-danger delete" data-id="{{$product['id']}}">{{__('pages.delete')}}</a>
                                            @else
                                                <form action="{{route('cart.add',$product['id'])}}" method="post">
                                                    @csrf
                                                    <input type="submit" class="btn btn-primary" value="{{__('pages.add_to_cart')}}">
                                                    <input type="hidden" name="quantity" value='1'>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach

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
        .card{
            border-radius: 10px;
            padding: 15px;
            border: none;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .card{
            height: 420px;
        }
        .card img{
            width: 100%;
            height: 230px;
            object-fit: contain;
        }

        .card{
            transition: 500ms all;
        }
        .card:hover{
            scale: 1.02;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>


        document.querySelector('.side-products').classList.add('active');


        document.querySelectorAll('.delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');

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

                        window.location.href = `/delete-item?model=products&id=${productId}`;
                    }
                });
            });
        });
    </script>


@endsection
