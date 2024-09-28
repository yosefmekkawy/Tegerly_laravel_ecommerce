@extends('layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            @include('components.sidebar')
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            <h1>Dashboard</h1>
            <a href="{{route('categories.create')}}" class="btn btn-primary">Add Category</a>
        </div>
    </div>
</div>


@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
@endsection
