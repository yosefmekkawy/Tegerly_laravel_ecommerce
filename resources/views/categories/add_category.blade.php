@extends('layout')
@section('content')

    <section class="add_category">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 py-5">
                    <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" class="form-control my-3" name="ar_name" placeholder="arName">
                        <input type="text" class="form-control my-3" name="en_name" placeholder="enName">
                        <input type="file" accept="image/*" class="form-control" name="image">
                        <input type="submit" value="save" class="btn btn-success form-control">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
@endsection

@section('scripts')

@endsection
