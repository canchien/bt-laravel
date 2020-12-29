@section('title')
    Categories
@endsection
@extends('layout.index')
@section('content')
    <div class="main">
        <div class="heading-categories-title row">
            <div class="col-lg-12 text-center">
                <h3 class="main-heading-h2">
                    <span class="main-heading-title">
                        Unlimited Possibilities
                    </span>
                </h3>
                <h1 class="main-heading-h1">
                    <span class="raven-heading-title">Categories</span>
                </h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container container-wrap">
                <div class="row">
                    @foreach ($categories as $category)
                        @if (Auth::check() && Auth::user()->role==2 && Auth::user()->confirmed ==1)
                            <div class="col-md-6">
                                <a href="{{route('category_details',['key'=>$category->slug])}}">
                                <div class="category-wrap p-3 mb-3 d-flex justify-content-between">
                                    <span class="category-name">{{$category->name}}</span>
                                    <div class="category-post-count">
                                        <?php
                                            $count = 0;
                                        ?>
                                        @foreach ($category->posts as $post)
                                            @if ($post->post_type == 'boards' && $post->status!='pending')
                                               <?php
                                                    $count = $count+1;
                                               ?>
                                            @endif
                                        @endforeach
                                        {{$count}}
                                    </div>
                                </div>
                                </a>
                            </div>
                        @elseif(Auth::check() && Auth::user()->role != 2 && Auth::user()->confirmed ==1)
                            @if ($category->status != 'private')
                                <div class="col-md-6">
                                    <a href="{{route('category_details',['key'=>$category->slug])}}">
                                    <div class="category-wrap p-3 mb-3 d-flex justify-content-between">
                                        <span class="category-name">{{$category->name}}</span>
                                        <div class="category-post-count">
                                            <?php
                                                $count = 0;
                                            ?>
                                            @foreach ($category->posts as $post)
                                                @if ($post->post_type == 'boards' && $post->status!='pending')
                                                <?php
                                                        $count = $count+1;
                                                ?>
                                                @endif
                                            @endforeach
                                            {{$count}}
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            @endif
                        @else
                            @if ($category->status == 'public')
                                <div class="col-md-6">
                                    <a href="{{route('category_details',['key'=>$category->slug])}}">
                                    <div class="category-wrap p-3 mb-3 d-flex justify-content-between">
                                        <span class="category-name">{{$category->name}}</span>
                                        <div class="category-post-count">
                                            <?php
                                            $count = 0;
                                            ?>
                                            @foreach ($category->posts as $post)
                                                @if ($post->post_type == 'boards' && $post->status!='pending')
                                                <?php
                                                        $count = $count+1;
                                                ?>
                                                @endif
                                            @endforeach
                                            {{$count}}
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
