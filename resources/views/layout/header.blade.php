<div class="header px-3" id="navbar">
    <div class="row">
        <div class="header-left col-lg-2 my-auto">
            <div class="header-logo">
                <a class="logo" href="javascrip:0;">
                    <img src="{{asset('app/image/logocvc.png')}}" class="raven-site-logo-desktop raven-site-logo-tablet raven-site-logo-mobile" data-no-lazy="1">
                </a>
            </div>
        </div>
        <div class="header-center col-lg-4">
            <nav class="navbar navbar-expand-sm navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link nav-a" href="{{route('listPosts')}}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-a" href="{{route('home.all_roadmaps')}}">ROADMAPS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-a" href="{{route('listCategories')}}">CATEGORIES</a>
                    </li>
                    @if (Auth::check() && Auth::user()->role == 2 && Auth::user()->confirmed == 1)
                        <li class="nav-item">
                            <a class="nav-link nav-a" href="{{route('home.list_changelog')}}">CHANGELOG</a>
                        </li>
                    @elseif(Auth::check() && Auth::user()->role !=2 && Auth::user()->confirmed == 1)
                        @if ($changelog->status != 'private')
                            <li class="nav-item">
                                <a class="nav-link nav-a" href="{{route('home.list_changelog')}}">CHANGELOG</a>
                            </li>
                        @endif
                    @else
                        @if ($changelog->status == 'public')
                            <li class="nav-item">
                                <a class="nav-link nav-a" href="{{route('home.list_changelog')}}">CHANGELOG</a>
                            </li>
                        @endif
                    @endif

                    <li class="nav-item">
                        <a class="nav-link nav-a" href="#">CONTACT</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="header-right col-lg-6 row align-items-center">
            <div class="header-right-tell col-lg-4">
                <a class="tel-button-link" href="tel:0347214898">
                    <span class="button-content">
                        <span class="raven-button-text"><i aria-hidden="true" class="fas fa-headset"></i> +0347214898 </span>
                    </span>
                </a>
            </div>
            <div class="header-right-icons-wrapper col-lg-3 row">
                <div class="col-lg-3">
                    <a class="" href="https://www.facebook.com/chienhihe/" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a class="" href="https://twitter.com" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a class="" href="https://www.instagram.com/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a class="" href="https://dribbble.com/" target="_blank">
                        <i class="fab fa-dribbble"></i>
                    </a>
                </div>
            </div>
            <div class="header-right-login-wrapper col-lg-5 d-flex justify-content-end">
                @if (Auth::check())
                    <div class="menu mr-5">
                        <ul class="nav">
                            <li class="nav-item">
                                <div class="d-flex align-items-center" data-toggle="dropdown">
                                    <a href="#" >
                                        <div class="avatar avatar-sm avatar-circle">
                                            <img class="avatar-img" src=@if(isset(Auth::user()->avatar) && Auth::user()->avatar != "")
                                                {!!asset('admin_asset/image/upload/'.Auth::user()->avatar)!!}
                                            @else
                                                {{Avatar::create(Auth::user()->name)->toBase64()}}
                                            @endif alt="">
                                        </div>
                                    </a>
                                    <span class="ml-2 name-account">{{Auth::user()->name}}<i class="fas fa-caret-down ml-1"></i></span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right dropdown-account">
                                    <div class="dropdown-item">
                                        <div class="media align-items-center">
                                            <div class="avatar avatar-sm avatar-circle mr-2">
                                                <img class="avatar-img" src=@if(isset(Auth::user()->avatar) && Auth::user()->avatar != "")
                                                {!!asset('admin_asset/image/upload/'.Auth::user()->avatar)!!}
                                            @else
                                                {{Avatar::create(Auth::user()->name)->toBase64()}}
                                            @endif alt="">
                                            </div>
                                            <div class="media-body">
                                                <span class="card-title h5">{{Auth::user()->name}}</span>
                                                <p>
                                                <small class="card-text">{{Auth::user()->email}}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    @if (Auth::user()->role == 2 && Auth::user()->confirmed == 1)
                                        <a class="dropdown-item" href="{{route('listUsers')}}">
                                            <span class="text-truncate pr-2" title="Profile & account"><i class="fas fa-tachometer-alt mr-2"></i>Admin panel</span>
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="javascrip:0;">
                                        <span class="text-truncate pr-2" title="Profile &a account"><i class="fas fa-user mr-2"></i>Profile & account</span>
                                    </a>
                                    <a class="dropdown-item" href="javascrip:0;">
                                        <span class="text-truncate pr-2" title="Settings"><i class="fas fa-cog mr-2"></i>Settings</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascrip:0;">
                                        <form action="{{route('logout')}}" method="GET">
                                            @csrf
                                            <button type="submit" name="logOut" class="btn btn-white">
                                                <span class="text-truncate pr-2" title="Sign out"><i class="fas fa-sign-out-alt mr-3"></i>Sign out</span>
                                            </button>
                                        </form>

                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="header-right-signin">
                        <a class="tel-button-link" href="{{route('login')}}">
                            <span class="button-content">
                                <span class="raven-button-text"> sign in </span>
                            </span>
                        </a>
                    </div>
                    <div class="header-right-signout ml-2">
                        <a class="tel-button-link" href="{{route('get-signup')}}">
                            <span class="button-content">
                                <span class="raven-button-text">sign up </span>
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
    </div>
</div>
<div class="header-mobile" id="navbar">
    <div class="row px-5 justify-content-between align-items-center mx-0">
        <div class="header-left col-3 my-auto">
            <div class="header-logo">
                <a class="logo" href="javascrip:0;">
                    <img src="http://localhost/bt-laravel/public/app/image/logocvc.png" alt="Hosting - Website Template by Jupiter X WP Theme" class="raven-site-logo-desktop raven-site-logo-tablet raven-site-logo-mobile" data-no-lazy="1">
                </a>
            </div>
        </div>
        <div class="header-right col-auto align-item-center ">
            <div class="xclick" onclick="xClick()" id="xclick">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="header-center header-botton-mobile col-12 px-0">
            <nav class="navbar-mobile" id="menu">
                <ul class="navbar-nav-mobile">
                    <li class="nav-item-mobile">
                      <a class="nav-link-mobile nav-a-mobile" href="{{route('listPosts')}}">HOME</a>
                    </li>
                    <li class="nav-item-mobile">
                      <a class="nav-link-mobile nav-a-mobile" href="">SERVICES</a>
                    </li>
                    <li class="nav-item-mobile">
                        <a class="nav-link-mobile nav-a-mobile" href="#">ABOUT</a>
                    </li>
                    <li class="nav-item-mobile">
                        <a class="nav-link-mobile nav-a-mobile" href="{{route('listCategories')}}">CATEGORIES</a>
                    </li>
                    <li class="nav-item-mobile">
                        <a class="nav-link-mobile nav-a-mobile" href="{{route('listPosts')}}">BLOG</a>
                    </li>
                    <li class="nav-item-mobile">
                        <a class="nav-link-mobile nav-a-mobile" href="#">CONTACT</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</div>
