@section('title')
    Changelog
@endsection
@extends('layout.index')
@section('content')
    <div class="main">
        {{-- <div class="main-top position-relative">
            <div class="main-top-background-overlay">
            </div>
            <div class="main-top-content">
                <div class="main-top-title">
                    <h1 class="elementor-heading-title elementor-size-default">Changelog</h1>
                </div>
                <div class="raven-breadcrumbs raven-breadcrumbs-default">
                    <a href="javascrip:0;"><span>Home</span></a>
                    <span>/ News</span>
                </div>
            </div>
        </div> --}}
        <div class="container-fluid">
            <div class="container container-changelog">
                <div class="option-pages">
                    <div class="row">
                        <div class="col-md-6 vertical-line">
                            <div class="option-pages-header mb-4 text-center">
                                <h3 class="title-filter">Categories</h3>
                            </div>
                            <div class="option-pages-categories px-3">
                                <form action="{{route('home.filter_categories')}}" method="GET" id="formFilterCategories" class="row">
                                @foreach ($allTerms as $category)
                                    @if ($category->type == 'category' && $category->parent == 99)
                                        <div class="custom-control custom-checkbox mb-3 col-sm-10">
                                        <label class="container">{{$category->name}}
                                            <input type="checkbox" class="filterCategories" name="categories[]" value="{{$category->id}}"
                                            @if (session('filterCategories') != null && in_array($category->id,session('filterCategories')))
                                                checked
                                            @endif>
                                            <span class="checkmark" style="background-color: {{$category->term_description}};"></span>
                                        </label>
                                        </div>
                                        {{-- <div class="custom-control custom-checkbox mb-3 col-sm-10">
                                            <input type="checkbox" class="custom-control-input filterCategories ml-1" id="check{{$category->id}}" name="categories[]" value="{{$category->id}}"
                                                @if (session('filterCategories') != null && in_array($category->id,session('filterCategories')))
                                                    checked
                                                @endif>

                                            <label class="custom-control-label check-option-value" for="check{{$category->id}}">{{$category->name}}</label>
                                        </div> --}}
                                        @foreach ($countPosts as $key => $value)
                                            @if ($category->id == $key)
                                                <div class="col-sm-2">{{$value}}</div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="option-pages-header mb-4 text-center">
                                <h3 class="title-filter">Tags</h3>
                            </div>
                            <div class="option-pages-tags px-3">
                                <form action="{{route('home.filter_tags')}}" method="GET" id="formFilterTags" class="row">
                                @foreach ($allTerms as $category)
                                    @if ($category->type == 'tag' && in_array($category->id,$termExis))
                                        <div class="custom-control custom-checkbox mb-3 col-sm-10">
                                            <input type="checkbox" class="custom-control-input filterTags" id="check{{$category->id}}" name="tags[]" value="{{$category->id}}"
                                            @if (session('filterTags') != null && in_array($category->id,session('filterTags')))
                                                checked
                                            @endif>
                                            <label class="custom-control-label check-option-value" for="check{{$category->id}}">{{$category->name}}</label>
                                        </div>
                                        @foreach ($countPosts as $key => $value)
                                            @if ($category->id == $key)
                                                <div class="col-sm-2">{{$value}}</div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="changelog-wrap">
                    @foreach ($posts as $post)
                        @if ($post->status != 'pending')
                            @if (Auth::check() && Auth::user()->role==2 && Auth::user()->confirmed == 1)
                                <div class="card-post-wrap pb-5 px-3">
                                    <div class="card-post mb-5">
                                        <div class="post-content">
                                            <h3 class="post-title">
                                                <a class="raven-post-title-link" href="{{route('changelog_details',['id'=>$post->id])}}">{{$post->title}}</a>
                                            </h3>
                                            <div class="post-meta">
                                                <a class="raven-post-meta-item raven-post-date" href="javascrip:0;" rel="bookmark">{{$post->created_at}}</a>
                                                @foreach ($post->categories as $category)
                                                    @if ($category->type == 'tag')
                                                        <span class="px-2">|</span>
                                                        <span class="raven-post-meta-item raven-post-categories">
                                                            <a href="{{route('category_details',['key'=>$category->slug])}}" rel="tag">
                                                                {{$category->name}}
                                                            </a>
                                                        </span>
                                                    @endif
                                                @endforeach
                                                @foreach ($post->categories as $category)
                                                    @if ($category->type == 'category')
                                                        @if ($category->name == "new")
                                                            <p class="badge badge-success" >{{$category->name}}</p>
                                                        @elseif($category->name == "fixed")
                                                            <p class="badge badge-info" >{{$category->name}}</p>
                                                        @elseif($category->name == "improved")
                                                            <p class="badge badge-primary" >{{$category->name}}</p>
                                                        @else
                                                            <p class="badge badge-secondary">{{$category->name}}</p>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="post-excerpt mb-3">
                                                {!!Str::substr($post->content, 0, 200).'...'!!}
                                                <a class="raven-post-title-link" href="{{route('changelog_details',['id'=>$post->id])}}">See More</a>
                                            </div>
                                        </div>
                                        <div class="post-image-wrap">
                                            <a class="post-image" href="{{route('changelog_details',['id'=>$post->id])}}">
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
                                                <span class="raven-post-image-overlay"></span>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @else
                                @if ($post->status == 'public')
                                <div class="card-post-wrap pb-5">
                                    <div class="card-post mb-5">
                                        <div class="post-content">
                                            <h3 class="post-title">
                                                <a class="raven-post-title-link" href="{{route('changelog_details',['id'=>$post->id])}}">{{$post->title}}</a>
                                            </h3>
                                            <div class="post-meta">
                                                <a class="raven-post-meta-item raven-post-date" href="javascrip:0;" rel="bookmark">{{$post->created_at}}</a>
                                                @foreach ($post->categories as $category)
                                                    @if ($category->type == 'tag')
                                                        <span class="px-2">|</span>
                                                        <span class="raven-post-meta-item raven-post-categories">
                                                            <a href="{{route('category_details',['key'=>$category->slug])}}" rel="tag">
                                                                    {{$category->name}}
                                                            </a>
                                                        </span>
                                                    @endif
                                                @endforeach
                                                @foreach ($post->categories as $category)
                                                    @if ($category->type == 'category')
                                                        @if ($category->name == "new")
                                                            <p class="badge badge-success" >{{$category->name}}</p>
                                                        @elseif($category->name == "fixed")
                                                            <p class="badge badge-info" >{{$category->name}}</p>
                                                        @elseif($category->name == "improved")
                                                            <p class="badge badge-primary" >{{$category->name}}</p>
                                                        @else
                                                            <p class="badge badge-secondary">{{$category->name}}</p>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="post-excerpt mb-3">
                                                {!!Str::substr($post->content, 0, 200).'...'!!}
                                                <a class="raven-post-title-link" href="{{route('changelog_details',['id'=>$post->id])}}">See More</a>
                                            </div>
                                        </div>
                                        <div class="post-image-wrap">
                                            <a class="post-image" href="{{route('changelog_details',['id'=>$post->id])}}">
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
                                                <span class="raven-post-image-overlay"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        @endif

                    @endforeach
                </div>

            </div>
            <div class="pagination justify-content-center">
                {{$posts->links()}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#formFilterCategories").on("change", ".filterCategories", function(){
                $("#formFilterCategories").submit();
            });

            $("#formFilterTags").on("change", ".filterTags", function(){
                $("#formFilterTags").submit();
            });
        });
    </script>
@endsection
