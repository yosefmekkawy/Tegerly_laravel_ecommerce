@extends('layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center mt-2 underline">{{ __('pages.cart') }}</h1>

                @if($cart && !empty($cart['items']))
                    <div class="row justify-content-between gy-2">
                        <form class="form-outline col-lg-8 gy-3" action="{{ route('cart.update', $cart['id']) }}" method="POST">
                            @csrf
                            @foreach($cart['items'] as $item)
                                <div class="row mb-4 align-items-center" data-item-id="{{ $item['id'] }}">
                                    <div class="col-6">
                                        <div class="d-flex">
                                            <img src="{{ asset($item['product']['images']->isEmpty() ? 'images/placeholder.png' : 'images/' . $item['product']['images'][0]->name) }}" class="border rounded me-3" style="width: 96px; height: 96px;" />
                                            <div>
                                                <a href="{{ route('products.show', $item['product']['id']) }}" class="nav-link">{{ $item['product']['title'] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="number" name="quantities[{{ $item['id'] }}]" class="form-control" min="1" value="{{ $item['quantity'] }}">
                                    </div>
                                    <div class="col-2 d-flex flex-column gap-1">
                                        <text class="h6">${{ $item['product']['price'] * $item['quantity'] }}</text>
                                        <small class="text-muted text-nowrap"> ${{ $item['product']['price'] }} / {{ __('pages.price_per_item') }} </small>
                                    </div>
                                    <div class="col-2">
                                        <a href="{{ "/delete-item?model=cart_items&id=" . $item['id'] }}" class="btn btn-danger">{{ __('pages.delete') }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                        <div class="col-lg-4">
                            <div class="card p-5">
                                <div class="d-flex justify-content-between">
                                    <p>{{ __('pages.total_price') }}:</p>
                                    <p>${{ $total }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>{{ __('pages.shipping') }}:</p>
                                    <p>${{ $total * 0.14 }}</p>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <p>{{ __('pages.total') }}:</p>
                                    <p>${{ $total * 1.14 }}</p>
                                </div>
                                <hr>
                                <a href="{{ route('checkout') }}" class="btn btn-success form-control">{{ __('pages.continue_to_checkout') }}</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center my-5">
                        <h3>{{ __('pages.no_items_in_cart') }}</h3>
                        <a href="{{ route('products.main.index') }}" class="btn btn-primary mt-3">{{ __('pages.shop_now') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection

@section('styling')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <style>
        .d-flex img {
            object-fit: contain;
        }
    </style>
@endsection

@section('scripts')
    <script>
        let numbers = document.querySelectorAll('input[type="number"]');
        numbers.forEach(function (number) {
            number.addEventListener('change', function () {
                this.form.submit();
            });
        });
    </script>
@endsection
