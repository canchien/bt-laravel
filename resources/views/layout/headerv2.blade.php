<div class="container-fluid container-info">
    <div class="container ">
        <div class="row">
            <div class="col-md-2">
                <div class="header-left">
                    <div class="header-logo">
                        <a class="logo" href="javascrip:0;">
                            <img src="{{asset('app/image/logocvc.png')}}" class="raven-site-logo-desktop raven-site-logo-tablet raven-site-logo-mobile" data-no-lazy="1">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="header-right-login-wrapper d-flex justify-content-end">
                    @if (Auth::check())
                        <div class="menu">
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
<div class="container-fluid container-categories">
    <div class="container">
        <div class="header-center">
            <nav class="navbar navbar-expand-sm navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link nav-a" href="{{route('home')}}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-a" href="{{route('listCategories')}}">CATEGORIES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-a" href="{{route('home.all_roadmaps')}}">ROADMAPS</a>
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
                </ul>
            </nav>
        </div>
    </div>
</div>
