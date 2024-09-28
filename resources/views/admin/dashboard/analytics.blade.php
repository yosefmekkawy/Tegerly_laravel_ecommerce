@extends('layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center underline mb-5">{{__('pages.site_analytics')}}</h1>
        @include('components.sidebar')
        @if(Auth::user()->type === 'admin')
            <div class="row">

                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>{{__('pages.total_products')}}</h5>
                            <p>{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>Most Sold Product</h5>
                                <p>
                                    <a
                                        href="{{route('products.show',$mostSoldProduct->id)}}">{{ json_decode($mostSoldProduct->title, true)[app()->getLocale()] }}
                                    </a>
                                </p>
                                <small>{{__('pages.sold')}}: {{ $mostSoldProduct->order_items_count ?? 0 }} {{__('pages.times')}}</small>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>{{__('pages.total_users')}}</h5>
                            <p>{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>{{__('pages.highest_rated_product')}}</h5>
                            <p>{{ $highestRatedProduct->title  }}</p>
                            <p>{{__('pages.average_rating')}}: {{ round($highestRatedProduct->reviews_avg_rating, 1) }} / 5</p>
                        </div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->type === 'seller')
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>Most Sold Product</h5>
                            <a href="{{route('products.show',$mostSoldProduct->id)}}" class="d-block">{{ $mostSoldProduct->title }}</a>
                            <small>{{__('pages.sold')}}: {{ $mostSoldProduct->order_items_count ?? 0 }} {{__('pages.times')}}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>Highest Rated Product</h5>
                            <p>{{ $highestRatedProduct->title ?? 'N/A' }}</p>
                            <small>Rating: {{ $highestRatedProduct->rating ?? 'N/A' }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>Total Orders</h5>
                            <p>{{ $sellerOrders }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>

        document.querySelector('.side-analytics').classList.add('active');

    </script>
@endsection
