
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{asset('https://htmlstream.com/front-dashboard/favicon.ico')}}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    {{-- select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">

    <link rel="stylesheet" href="{{asset('https://use.fontawesome.com/releases/v5.6.3/css/all.css')}}">
    <link href="{{asset('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap')}}" rel="stylesheet">


    <link rel="stylesheet" href="{{asset('admin_asset/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('admin_asset/css/styleNews.css')}}">
</head>
<body>

    <div class="container-fuild d-flex">
        <div class="navbar-vertical">
            <div class="navbar-vertical-top px-4 py-3 justify-content-between">
                <!-- logo -->
                <a href="" class="nav-brand py-2">
                    <img src="{{asset('admin_asset/image/logos/logo.svg')}}" alt="" class="navbar-brand-logo">
                </a>
            </div>
                <!-- End Logo -->
            <div class="navbar-vertical-content">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="left-nav">
                            <ul id="nav">
                                <li class="current"><a href="javascrip:0;"><i class="fas fa-tachometer-alt"></i>  Dashboard</a></li>
                                <li class="dropdown">
                                    <span class="">News</span>
                                </li>
                                <!-- authentication -->
                                <li class="dropdown">
                                    <a data-toggle="collapse" data-target="#nav-auth" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-lock"></i> Authentication <span class="sub-icon"></span></a>
                                    <div id="nav-auth" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href=""><i class="fas fa-sign-in-alt"></i> Sign in</a></li>
                                            <li><a href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Sign out</a></li>
                                            <li><a href="{{route('get-forget-password')}}"><i class="fas fa-key"></i> Reset password</a></li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- users --}}
                                <li class="dropdown">
                                    <a data-toggle="collapse" data-target="#nav-users" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-users"></i> Users <span class="sub-icon"></span></a>
                                    <div id="nav-users" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href="{{ route('listUsers') }}"><i class="fas fa-address-book"></i> List Users</a></li>
                                            <li><a href="{{ route('getAddUser') }}"><i class="fas fa-user-plus"></i> Add User</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="collapse" data-target="#nav-post" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-newspaper"></i> Post <span class="sub-icon"></span></a>
                                    <div id="nav-post" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href="{{ route('posts.list_posts') }}"><i class="far fa-newspaper"></i> List Post</a></li>
                                            <li><a href="{{ route('add-post')}} "><i class="fas fa-plus-square"></i> Add Post</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="" data-toggle="collapse" data-target="#nav-category" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-box-open"></i> Boards<span class="sub-icon"></span></a>
                                    <div id="nav-category" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href="{{ route('list-categories') }}"><i class="fas fa-list-alt"></i> ALL boards</a></li>
                                            <li><a href="{{ route('add-category') }}"><i class="fas fa-plus-square"></i> Add boards</a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="dropdown">
                                    <a href="{{ route('listComments') }}" ><i class="far fa-comments"></i> Comments </a>
                                </li>

                                <li class="dropdown">
                                    <a data-toggle="collapse" data-target="#Statuses" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-thermometer-three-quarters"></i> Status <span class="sub-icon"></span></a>
                                    <div id="Statuses" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href="{{route('listStatus')}}"><i class="fas fa-list-alt"></i> All status</a></li>
                                            <li><a href="{{route('getAddStatus')}}"><i class="fas fa-plus-square"></i> Add status</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="" data-toggle="collapse" data-target="#nav-roadmaps" href="#" class="collapsed" aria-expanded="false"><i class="far fa-map"></i> Road maps<span class="sub-icon"></span></a>
                                    <div id="nav-roadmaps" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href="{{ route('listRoadmaps') }}"><i class="fas fa-list-alt"></i> All roadmaps</a></li>
                                            <li><a href="{{ route('getAddRoadmaps') }}"><i class="fas fa-plus-square"></i> Add roadmap</a></li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- changelog --}}
                                <li class="dropdown">
                                    <a data-toggle="collapse" data-target="#nav-changelog" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-stream"></i> changelog <span class="sub-icon"></span></a>
                                    <div id="nav-changelog" class="collapse">
                                        <ul class="nav-slt">
                                            <li><a href="{{ route('setting_changelog') }}"><i class="fas fa-cogs"></i> Setting changelog</a></li>
                                            <li><a href="{{ route('changelog.list_posts') }}"><i class="far fa-newspaper"></i> ALL Post</a></li>
                                            <li><a href="{{ route('changelog.get_add_posts')}} "><i class="fas fa-plus-square"></i> Add Post</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <!-- news -->
                                <li class="dropdown">
                                    <a data-toggle="collapse" data-target="#nav-news" href="#" class="collapsed" aria-expanded="false"><i class="fas fa-newspaper"></i> News <span class="sub-icon"></span></a>
                                    <div id="nav-news" class="collapse">
                                        <ul class="nav-slt">
                                            <li class="dropdown">
                                                <a href="{{ route('listImages') }}" ><i class="fas fa-images"></i> Images </a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="{{ route('listTags') }}" ><i class="fas fa-tags"></i> Tags </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
            <div class="navbar-vertical-footer">
            </div>
        </div>
        <div class="main">
            <div class="navbar-nav-wrap">
                <div class="menu">
                        <ul class="nav justify-content-end">
                            <li class="nav-item">
                                <a href="#" class="" data-toggle="dropdown">
                                    <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src=@if(isset(Auth::user()->avatar) && Auth::user()->avatar != "")
                                            {!!asset('admin_asset/image/upload/'.Auth::user()->avatar)!!}
                                        @else
                                            {{Avatar::create(Auth::user()->name)->toBase64()}}
                                        @endif alt="">
                                    </div>
                                </a>
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
                                    <a class="dropdown-item" href="{{route('home')}}" target="_blank">
                                        <span class="text-truncate pr-2" title="Profile & account"><i class="fas fa-home mr-2"></i>home</span>
                                    </a>
                                    <a class="dropdown-item" href="{{route('getEditUser',['id'=>Auth::user()->id])}}">
                                        <span class="text-truncate pr-2" title="Profile & account"><i class="fas fa-user mr-2"></i>Profile & account</span>
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
                </div>
            @yield('content')
        </div>
    </div>


    <script src="{{asset('admin_asset/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <script src="{{asset('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js')}}" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="{{asset('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{asset('admin_asset/js/main.js')}}"></script>

    @yield('script')

</body>
</html>
