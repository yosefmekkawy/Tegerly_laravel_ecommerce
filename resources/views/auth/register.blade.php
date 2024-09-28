@extends('layout')
@section('content')
    <section class="register d-flex align-items-center">
        <div class="container d-flex align-items-center py-5 p-sm-3 p-lg-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="register-form">
                        <h2 class="form-title text-center text-primary fw-bold mb-5">
                            {{__('pages.register')}}
                        </h2>
                        <form
                            id="registerForm"
                            class="sign-up d-flex flex-column align-content-between"
                            method="post"
                        >
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ri-user-fill"></i>
                                </span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="{{__('pages.username')}}"
                                    aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    name="username"
                                    required
                                />
                            </div>
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
                                    required
                                />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ri-phone-line"></i>
                                </span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="{{__('pages.phone')}}"
                                    aria-label="Phone"
                                    aria-describedby="basic-addon1"
                                    name="phone"
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
                                    id="password"
                                    required
                                />
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer">
                                    <i class="ri-eye-off-fill" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ri-lock-line"></i>
                                </span>
                                <input
                                    type="password"
                                    class="form-control"
                                    placeholder="{{__('pages.repassword')}}"
                                    aria-label="password"
                                    aria-describedby="basic-addon1"
                                    name="password_confirmation"
                                    id="passwordConfirmation"
                                    required
                                />
                                <span class="input-group-text" id="togglePasswordConfirm" style="cursor: pointer">
                                    <i class="ri-eye-off-fill" id="togglePasswordConfirmIcon"></i>
                                </span>
                            </div>
                            <input type="submit" value="{{__('pages.register')}}" class="btn btn-primary" />
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src={{asset('images/register.png')}} alt="" class="sign-up-image img-fluid" />
                    <p class="text-center">
                        {{__('pages.already_member')}}
                        <a href="{{route('login')}}" class="text-decoration-underline text-danger fw-bold">
                            {{__('pages.login')}}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
@endsection

@section('scripts')
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally


            var formData = new FormData(this);


            fetch('{{ route('register.store') }}', {
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
                            title: '{{__('messages.user_registered_successfully')}}',
                            text: '{{__('messages.redirect_login')}}',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {

                            window.location.href = '{{ route('login') }}';
                        });
                    } else {

                        let errorMessages = '';
                        for (const [key, value] of Object.entries(data.errors)) {
                            errorMessages += `${value}\n`;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration failed!',
                            text: errorMessages,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('messages.register_error')}}',
                        text: '{{__('messages.error')}}',
                    });
                });
        });
    </script>
    <script src="{{asset('js/register.js')}}"></script>
@endsection
