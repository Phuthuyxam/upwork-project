<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('client/images/logo22.png') }}" alt="" style="width: 100%;">
                    </span>
                    <span class="logo-lg">
                        @php
                            $dataStystem = json_decode(\App\Core\Helper\OptionHelpers::getSystemConfigByKey('general'));
                        @endphp
                        @if(isset($dataStystem->logo))
                            {!! \App\Core\Helper\FrontendHelpers::renderImage($dataStystem->logo)  !!}
                        @endif
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="d-none d-sm-block ml-2">
                @yield('heading')
            </div>

        </div>

        <!-- Search input -->
        <div class="search-wrap" id="search-wrap">
            <div class="search-bar">
                <input class="search-input form-control" placeholder="Search" />
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                    <i class="mdi mdi-close-circle"></i>
                </a>
            </div>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span style="margin-right: .5rem">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
{{--                    <a class="dropdown-item" href="#"><i class="dripicons-user font-size-16 align-middle mr-2"></i> Profile</a>--}}
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        <i class="dripicons-exit font-size-16 align-middle mr-2"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
            </div>

        </div>
    </div>
</header>
