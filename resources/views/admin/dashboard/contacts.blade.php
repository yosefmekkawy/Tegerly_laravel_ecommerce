@extends('layout')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-2 text-center underline">{{ __('pages.messages') }}</h1>
        @include('components.sidebar')
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('pages.id') }}</th>
                <th>{{ __('pages.message') }}</th>
                <th>{{ __('pages.problem') }}</th>
                <th>{{ __('pages.email') }}</th>
                <th>{{ __('pages.user_id') }}</th>
                <th>{{ __('pages.created_at') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->message }}</td>
                    <td>{{ $message->problem ?? 'N/A' }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->user_id ?? __('pages.guest') }}</td>
                    <td>{{ $message->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$messages->links()}}
    </div>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        document.querySelector('.side-contacts').classList.add('active');
    </script>
@endsection
