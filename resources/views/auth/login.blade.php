@extends('layout')
@section('content')
    <section class="login d-flex align-items-center">
        <div class="container d-flex align-items-center py-5 p-sm-3 p-lg-5">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-md-6">
                    <div class="login-form">
                        <h2 class="form-title text-center text-primary fw-bold mb-5">
                            {{__('messages.login')}}
                        </h2>
                        <form id="loginForm" class="sign-up d-flex flex-column align-content-between">
                            @csrf
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ri-mail-fill"></i>
                            </span>
                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="{{__('pages.email')}}"
                                    aria-label="email"
                                    aria-describedby="basic-addon1"
                                    name="email"
                                    value="{{old('email')}}"
                                    required
                                />
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ri-lock-2-fill"></i>
                            </span>
                                <input
                                    type="password"
                                    class="form-control"
                                    placeholder="{{__('pages.password')}}"
                                    aria-label="password"
                                    aria-describedby="basic-addon1"
                                    name="password"
                                    required
                                />
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer">
                                <i class="ri-eye-off-fill" id="togglePasswordIcon"></i>
                            </span>
                            </div>
                            <input type="submit" value="{{__('pages.login')}}" class="btn btn-primary" />
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src={{asset('images/login.png')}} alt="" class="sign-up-image img-fluid" />
                    <p class="text-center">
                        {{__('pages.no_account')}}
                        <a href="{{route('register')}}" class="text-decoration-underline text-danger fw-bold">
                            {{__('pages.register')}}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
@endsection

@section('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Capture form data
            var formData = new FormData(this);


            fetch('{{ route('login.post') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        Swal.fire({
                            icon: 'success',
                            title: '{{__('messages.login_successfully')}}',
                            text: '{{__('messages.redirect_home')}}',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {

                            window.location.href = '/';
                        });
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: '{{__('messages.login_error')}}',
                            text: data.error,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('messages.login_error')}}',
                        text: '{{__('messages.error')}}',
                    });
                });
        });
    </script>
    <script src="{{asset('js/login.js')}}"></script>
@endsection
