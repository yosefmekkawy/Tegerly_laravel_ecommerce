
@extends('layout')

@section('content')
    <div class="container my-4">
        @include('components.sidebar')

    @if(str_contains(request()->fullUrl(), 'dashboard'))
            @include('components.sidebar')
        @endif
        <h2 class="mb-4 text-center underline">{{ __('pages.orders') }}</h2>

        @if ($orders->isEmpty())
            <div class="alert alert-info">
                {{ __('No orders available.') }}
            </div>
        @else
            <div class="accordion" id="ordersAccordion">
                @foreach($ordersArr as $order)
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="heading{{ $order['id'] }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order['id'] }}" aria-expanded="false" aria-controls="collapse{{ $order['id'] }}">
                                {{ __('order_id') }} {{': '. $order['id'] }} - {{ __('Status: ') }} {{ ucfirst($order['status']) }}
                            </button>
                        </h2>
                        <div id="collapse{{ $order['id'] }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order['id'] }}" data-bs-parent="#ordersAccordion">
                            <div class="accordion-body">
                                <h5>{{ __('Shipping Address') }}:</h5>
                                <p>{{ $order['address'] }}</p>

                                <h5>{{ __('Order Items') }}:</h5>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Price per item') }}</th>
                                        <th>{{ __('Subtotal') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order['items'] as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.show', $item['product']['id']) }}">
                                                    {{ $item['product']['title'] }}
                                                </a>
                                            </td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>${{ number_format($item['price'], 2) }}</td>
                                            <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Total Price') }}:</h5>
                                    <h5>${{ number_format(array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $order['items'])), 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        {{$orders->links()}}
    </div>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>


        document.querySelector('.side-orders').classList.add('active');


    </script>


@endsection
