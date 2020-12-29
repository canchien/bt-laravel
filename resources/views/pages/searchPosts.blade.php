@section('title')
    search
@endsection
@extends('layout.index')
@section('content')
    <div class="main">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-md-9">
                    <div class="row">
                        @foreach ($posts as $post)
                        <div class="search-single mb-30 d-flex p-3">
                            <div class="search-img col-lg-4" >
                                <img src=@if(!$post->postmeta->isEmpty())
                                @foreach ($post->postmeta as $postmeta)
                                    @if($postmeta->meta_key== "meta_image" && $postmeta->meta_value !== null)
                                        {!!asset('admin_asset/image/upload/'.$postmeta->meta_value)!!}
                                    @else
                                        {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                                    @endif
                                @endforeach
                            @else
                                {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                            @endif
                                alt="avatar">
                            </div>
                            <div class="search-caption py-2 ml-2">
                                <h4><a href="{{route('postDetail',['id'=>$post->id])}}" style="font-size: 25px">{{$post->title}}</a></h4>
                                <p>
                                    {{$post->created_at}}
                                    <span class="">
                                    @foreach ($post->categories as $category)
                                        {{"| ".$category->name}}
                                    @endforeach
                                    </span>
                                </p>
                                <h5><small>{{$post->summary}}</small></h5>
                            </div>
                        </div>
                        @endforeach
                        <div style="margin: 0 auto">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="search mb-3">
                        <form class="jupiterx-search-form form-inline" method="get" action="" role="search">
                            <div class="input-group mb-3">
                                <input type="search" class="form-control" placeholder="search" id="search" name="search">
                                <div class="input-group-append">
                                <button class="input-group-text"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="popular-posts mb-5">
                        <h3 class="card-title mb-3"> Popular posts</h3>
                        @foreach ($popularPosts as $post)
                        <div class="popular-posts-wrapper mb-3">
                            <div class="row">
                                <div class="popular-img col-lg-5">
                                    <img src=@if(!$post->postmeta->isEmpty())
                                    @foreach ($post->postmeta as $postmeta)
                                        @if($postmeta->meta_key== "meta_image" && $postmeta->meta_value !== null)
                                            {!!asset('admin_asset/image/upload/'.$postmeta->meta_value)!!}
                                        @else
                                            {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                                        @endif
                                    @endforeach
                                @else
                                    {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                                @endif
                                    alt="avatar">
                                </div>
                                <div class="popular-caption col-lg-7">
                                    <a title="" href="{{route('postDetail',['id'=>$post->id])}}"><small>{!!Str::substr($post->title, 0, 45).'...'!!}</small></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="socialize">
                        <div id="jupiterx_social-3" class="jupiterx-widget widget_jupiterx_social jupiterx_social-3 widget_jupiterx_social">
                            <h3 class="card-title">Socialize</h3>
                            <div class="jupiterx-widget-content">
                                <div class="jupiterx-social-widget-wrapper jupiterx-social-widget-wrapper-5f8ce5b1cddf2">
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-twitter" target="_blank">
                                        <span class="Social-icon-twitter"><i class="fab fa-twitter"></i></span>
                                    </a>
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-instagram" target="_blank">
                                        <span class="social-icon-instagram"><i class="fab fa-instagram"></i></span>
                                    </a>
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-facebook" target="_blank">
                                        <span class="social-icon-facebook"><i class="fab fa-facebook"></i></span>
                                    </a>
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-youtube" target="_blank">
                                        <span class="social-icon-youtube"><i class="fab fa-youtube-square"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

