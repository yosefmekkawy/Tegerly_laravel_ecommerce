<nav class="navbar navbar-expand-lg bg-light px-5 sticky-top">
    <div class="container-fluid">
        <div class="logo_and_sidebar d-flex align-items-center">
            @if(str_contains(request()->fullUrl(), 'dashboard'))
                <div class="">
                    <i class="ri-menu-line toggle-sidebar-btn me-2" style="cursor: pointer"></i>
                </div>
            @endif

            <a class="navbar-brand" href="{{ url('/') }}">
                <!-- Logo -->
                <h2>{{__('pages.logo')}}</h2>
            </a>

        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">{{__('pages.home')}}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/products') }}">{{__('pages.products')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact_us.create') }}">{{__('pages.contact_us')}}</a>
                </li>

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{__('pages.register')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{__('pages.login')}}</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile',auth()->id()) }}">{{__('pages.profile')}}</a>
                    </li>
                    @if (auth()->user()->type == 'client')


                    @elseif (auth()->user()->type == 'seller')

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard/products') }}">{{__('pages.dashboard')}}</a>
                        </li>
                    @elseif (auth()->user()->type == 'admin')

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard/products') }}">{{__('pages.dashboard')}}</a>
                        </li>
                    @endif


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart') }}">{{__('pages.cart')}}</a>
                    </li>

                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{__('pages.logout')}}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth
                <li class="nav-item">
                    @if(App::getLocale() === 'en')
                        <a class="nav-link" href="{{ route('switch-language', 'ar') }}">العربية</a>
                    @else
                        <a class="nav-link" href="{{ route('switch-language', 'en') }}">English</a>
                    @endif
                </li>

            </ul>
            <form class="d-flex" action="{{ url('/products') }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="{{__('pages.search')}}" aria-label="Search" name="title">
                <button class="btn btn-outline-primary" type="submit">{{__('pages.search')}}</button>
            </form>
        </div>
    </div>
</nav>

