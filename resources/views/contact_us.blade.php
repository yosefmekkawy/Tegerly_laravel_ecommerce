@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5 underline">{{__('pages.contact_us')}}</h1>

    <form action="{{ route('contact_us.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="message" class="form-label">{{__('pages.messages')}}</label>
            <textarea name="message" id="message" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="problem" class="form-label">{{__('pages.problem')}}</label>
            <textarea name="problem" id="problem" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{__('pages.email')}}</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ Auth::user() ? Auth::user()->email : '' }}">
        </div>

        @if (Auth::check())
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        @endif

        <button type="submit" class="btn btn-primary">{{__('pages.submit')}}</button>
    </form>
</div>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
@endsection
