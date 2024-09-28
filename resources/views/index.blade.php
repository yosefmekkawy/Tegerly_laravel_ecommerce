
@extends('layout')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-6 order-lg-last hero-img z-3">
                    <img src="{{asset('images/hero.png')}}" alt="" class="img-fluid" />
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center z-3 gap- text-lg-start text-center">
                    <h1>{{__('pages.logo')}}</h1>
                    <p>{{__('pages.slogan')}}</p>
                </div>
            </div>
        </div>
        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
            </defs>
            <g class="wave1"><use xlink:href="#wave-path" x="50" y="3"></use></g>
            <g class="wave2"><use xlink:href="#wave-path" x="50" y="0"></use></g>
            <g class="wave3"><use xlink:href="#wave-path" x="50" y="9"></use></g>
        </svg>
    </section>
    <section class="about-us">
        <div class="container">
            <h2 class="underline my-5 text-center">{{__('pages.about_us')}}</h2>
            <p class="text-center mb-5 fw-bold">{{__('pages.about_description')}}</p>
        </div>

    </section>
    <section id="services" class="services section light-background">
        <div class="container" >
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-bag-check-fill"></i>
                    <div class="stats-item">
                        <p>{{__('pages.sell_easily')}}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-truck"></i>
                    <div class="stats-item">
{{--                        <span  class="purecounter"></span>--}}
                        <p>{{__('pages.quick_delivery')}}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-file-earmark-lock2-fill"></i>
                    <div class="stats-item">
{{--                        <span ></span>--}}
                        <p>{{__('pages.security')}}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                    <div class="stats-item">
{{--                        <span ></span>--}}
                        <p>{{__('pages.direct')}}</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <style>
        section.services{
            background-color: #f4f5fe;
        padding: 60px;
        }
        .services i {
            box-shadow: 0px 2px 25px rgba(0, 0, 0, 0.1);
            width: 54px;
            height: 54px;
            font-size: 24px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .stats-item p{
            background-color: #ffffff;
            margin-top: -27px;
            padding: 30px 30px 25px 30px;
            width: 100%;
            position: relative;
            text-align: center;
            box-shadow: 0px 2px 35px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 0;
            font-size: 27px;
        }
        .services .stats-item p {

        }
        .services .stats-item span {
            font-size: 36px;
            display: block;
            font-weight: 700;
            color:
                color-mix(in srgb, #444444, transparent 20%);
        }
        .about-us p{
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>

    </script>
@endsection
