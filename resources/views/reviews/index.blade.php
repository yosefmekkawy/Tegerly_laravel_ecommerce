@extends('layout')

@section('content')

    <div class="container">
        @include('components.sidebar')
        <h1 class="my-4">{{ __('pages.all_reviews') }}</h1>

        @if($reviews->isEmpty())
            <div class="alert alert-info">
                <p>{{ __('pages.no_reviews') }}</p>
            </div>
        @else

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{ __('pages.product') }}</th>
                    <th>{{ __('pages.reviewed_by') }}</th>
                    <th>{{ __('pages.rating') }}</th>
                    <th>{{ __('pages.review_message') }}</th>
                    <th>{{ __('pages.created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', $review->product->id) }}">
                                {{ $review->product->title }}
                            </a>
                        </td>
                        <td>
                            {{ $review->user->name ?? 'Anonymous' }}
                        </td>
                        <td>
                            {{ $review->rating }} / 5
                        </td>
                        <td>
                            {{ $review->review_message }}
                        </td>
                        <td>
                            {{ $review->created_at->format('d M, Y') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table> 

      
            <div class="d-flex justify-content-center">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

@endsection

@section('styling')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>
        document.querySelector('.side-reviews').classList.add('active');
    </script>
@endsection
