
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if(Auth::user()->type == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed side-products" href="{{route('products.index')}}">
                    <i class="bi bi-box"></i>
                    <span>{{__('pages.products')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-users" href="{{route('users.index')}}">
                    <i class="bi bi-people"></i>
                    <span>{{__('pages.users')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-categories" href="{{route('categories.index')}}">
                    <i class="bi bi-list"></i>
                    <span>{{__('pages.categories')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-orders" href="{{route('orders.dashboard.index')}}">
                    <i class="bi bi-receipt"></i>
                    <span>{{__('pages.orders')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-contacts" href="{{route('contact_messages.index')}}">
                    <i class="bi bi-envelope"></i>
                    <span>{{__('pages.contacts')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-analytics" href="{{route('analytics.index')}}">
                    <i class="bi bi-bar-chart"></i>
                    <span>{{__('pages.site_analytics')}}</span>
                </a>
            </li>
        @endif

        @if(Auth::user()->type == 'seller')
            <li class="nav-item">
                <a class="nav-link collapsed side-products" href="{{route('products.index')}}">
                    <i class="bi bi-box"></i>
                    <span>{{__('pages.products')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-reviews" href="{{route('reviews.index')}}">
                    <i class="bi bi-chat-square-text"></i>
                    <span>{{__('pages.reviews')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-orders" href="{{route('orders.index')}}">
                    <i class="bi bi-receipt"></i>
                    <span>{{__('pages.orders')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed side-analytics" href="{{route('analytics.index')}}">
                    <i class="bi bi-bar-chart"></i>
                    <span>{{__('pages.analytics')}}</span>
                </a>
            </li>
        @endif



    </ul>

</aside>
