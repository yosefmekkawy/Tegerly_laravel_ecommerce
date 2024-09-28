@extends('layout')

@section('content')
    <div class="container">
        <h1 class="text-center mt-2 underline">{{ __('pages.checkout') }}</h1>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="address" class="form-label">{{ __('pages.shipping_address') }}</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>

            <h3>{{ __('pages.order_summary') }}</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('pages.product') }}</th>
                    <th>{{ __('pages.quantity') }}</th>
                    <th>{{ __('pages.price') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart['items'] as $item)
                    <tr>
                        <td>{{ $item['product']['title'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ $item['product']['price'] * $item['quantity'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h4>{{ __('pages.total') }}: ${{ $total * 1.14 }}</h4>
                <button type="submit" class="btn btn-primary">{{ __('pages.place_order') }}</button>
            </div>
        </form>
    </div>
@endsection
