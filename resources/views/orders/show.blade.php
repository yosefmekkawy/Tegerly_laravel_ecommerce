@extends('layout')

@section('content')
    <div class="container">
        <h2 class="my-4">{{ __('pages.order_details') }}</h2>

        <div class="mb-3">
            <strong>{{ __('pages.order_id') }}:</strong> {{ $order->id }} <br>
            <strong>{{ __('pages.shipping_address') }}:</strong> {{ $order->address }} <br>
            <strong>{{ __('pages.order_status') }}:</strong> {{ ucfirst($order->status) }} <br>
        </div>

        <h3>{{ __('pages.order_summary') }}</h3>
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('pages.product') }}</th>
                <th>{{ __('pages.quantity') }}</th>
                <th>{{ __('pages.price') }}</th>
                <th>{{ __('pages.subtotal') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->price }}</td>
                    <td>${{ $item->price * $item->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h4>{{ __('pages.total') }}: ${{ $total }}</h4>
        </div>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">{{ __('pages.back_to_orders') }}</a>
    </div>

@endsection
