@section('title')
    Home
@endsection
@extends('layout.index')
@section('content')
    <div class="main">

        <div class="container-fluid">
            <div class="container roadmaps-wrap">
                <div class="card-roadmaps">
                    <div class="card-categories-title mb-3">
                        <a href="{{route('listCategories')}}"><span>FEEDBACK</span></a>
                    </div>
                    <div class="row">
                        @foreach ($categories as $category)
                            @if ($category->show == 1)
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
                            @endif
                        @endforeach
                    </div>
                </div>

                @foreach ($allRoadmaps as $roadmap)
                    @if ($roadmap->show == 1)
                        @if (Auth::check() && Auth::user()->role==2 && Auth::user()->confirmed ==1)
                        <div class="card-roadmaps">
                            <div class="card-roadmaps-title">
                                <h5>{{$roadmap->title}}</h5>
                            </div>
                            <div class="card-roadmaps-content row">
                                @foreach ($roadmap->categories as $term)
                                    @if ($term->type == 'status')
                                    <div class="col">
                                        <div class="status-wrap">
                                            <div class="card-roadmaps-title d-flex align-items-center mb-3">
                                                <div class="color-status mr-1" style="background-color: {{$term->term_description}};"></div>
                                                <span class="status-name px-2">{{$term->name}}</span>
                                            </div>
                                            @foreach ($term->posts as $post)
                                                @if ($post->post_type =='boards' && $post->status !='pending')
                                                    @foreach ($roadmap->categories as $termCheck)
                                                        @if ($termCheck->type == 'category')
                                                            @foreach ($post->categories as $board)
                                                                @if ($board->id == $termCheck->id)
                                                                    <div class="post-wrap mb-2 d-flex">
                                                                        <div class="roadmap-item-votes">
                                                                            <div class="voting-box">
                                                                                @foreach ($userMeta as $value)
                                                                                    @if ($value->user_id == Auth::user()->id && $value->meta_value == $post->id)
                                                                                    <form action="{{route('un_vote')}}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="id" value="{{$value->id}}">
                                                                                        <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                        <button id="" type="submit" class="vote-button fas fa-sort-up unvote" data-toggle="tooltip" data-placement="top" title="Unvote"></button>
                                                                                    </form>
                                                                                    <?php $result = true ?>
                                                                                    @break
                                                                                    @endif
                                                                                    <?php $result = false ?>
                                                                                @endforeach
                                                                                @if ($result != true)
                                                                                <form action="{{route('up_vote')}}" method="POST">
                                                                                    @csrf
                                                                                    <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                    <button id="" type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                                                </form>
                                                                                @endif
                                                                                <div class="vote-count text-center">{{$post->vote_count}}</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="post-content ml-2">
                                                                            <a href="{{route('postDetail',['id'=>$post->id])}}">{{$post->title}}</a>
                                                                            <p>{{$board->name}}</p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @elseif(Auth::check() && Auth::user()->role !=2 && Auth::user()->confirmed ==1)
                            @if ($roadmap->status != 'private')
                            <div class="card-roadmaps">
                                <div class="card-roadmaps-title">
                                    <h5>{{$roadmap->title}}</h5>
                                </div>
                                <div class="card-roadmaps-content row">
                                    @foreach ($roadmap->categories as $term)
                                        @if ($term->type == 'status')
                                        <div class="col">
                                            <div class="status-wrap">
                                                <div class="card-roadmaps-title d-flex align-items-center mb-3">
                                                    <div class="color-status mr-1" style="background-color: {{$term->term_description}};"></div>
                                                    <span class="status-name px-2">{{$term->name}}</span>
                                                </div>
                                                @foreach ($term->posts as $post)
                                                    @if ($post->post_type =='boards' && $post->status == 'public')
                                                        @foreach ($roadmap->categories as $termCheck)
                                                            @if ($termCheck->type == 'category' && $termCheck->status !='private')
                                                                @foreach ($post->categories as $board)
                                                                    @if ($board->id == $termCheck->id)
                                                                        <div class="post-wrap mb-2 d-flex">
                                                                            <div class="roadmap-item-votes">
                                                                                <div class="voting-box">
                                                                                        @foreach ($userMeta as $value)
                                                                                            @if ($value->user_id == Auth::user()->id && $value->meta_value == $post->id)
                                                                                            <form action="{{route('un_vote')}}" method="POST">
                                                                                                @csrf
                                                                                                <input type="hidden" name="id" value="{{$value->id}}">
                                                                                                <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                                <button id="" type="submit" class="vote-button fas fa-sort-up unvote" data-toggle="tooltip" data-placement="top" title="Unvote"></button>
                                                                                            </form>
                                                                                            <?php $result = true ?>
                                                                                            @break
                                                                                            @endif
                                                                                            <?php $result = false ?>
                                                                                        @endforeach
                                                                                        @if ($result != true)
                                                                                        <form action="{{route('up_vote')}}" method="POST">
                                                                                            @csrf
                                                                                            <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                            <button id="" type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                                                        </form>
                                                                                        @endif
                                                                                        <div class="vote-count text-center">{{$post->vote_count}}</div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="post-content ml-2">
                                                                                <a href="{{route('postDetail',['id'=>$post->id])}}">{{$post->title}}</a>
                                                                                <p>{{$board->name}}</p>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @else
                            @if ($roadmap->status == 'public')
                                <div class="card-roadmaps">
                                    <div class="card-roadmaps-title">
                                        <h5>{{$roadmap->title}}</h5>
                                    </div>
                                    <div class="card-roadmaps-content row">
                                        @foreach ($roadmap->categories as $term)
                                            @if ($term->type == 'status')
                                            <div class="col">
                                                <div class="status-wrap">
                                                    <div class="card-roadmaps-title d-flex align-items-center mb-3">
                                                        <div class="color-status mr-1" style="background-color: {{$term->term_description}};"></div>
                                                        <span class="status-name px-2">{{$term->name}}</span>
                                                    </div>
                                                    @foreach ($term->posts as $post)
                                                        @if ($post->post_type =='boards')
                                                            @foreach ($roadmap->categories as $termCheck)
                                                                @if ($termCheck->type == 'category' && $termCheck->status == 'public')
                                                                    @foreach ($post->categories as $board)
                                                                        @if ($board->id == $termCheck->id)
                                                                            @if ($post->status == 'public')
                                                                            <div class="post-wrap mb-2 d-flex">
                                                                                <div class="roadmap-item-votes">
                                                                                    <div class="voting-box">
                                                                                        @if (Auth::check())
                                                                                            @foreach ($userMeta as $value)
                                                                                                @if ($value->user_id == Auth::user()->id && $value->meta_value == $post->id)
                                                                                                <form action="{{route('un_vote')}}" method="POST">
                                                                                                    @csrf
                                                                                                    <input type="hidden" name="id" value="{{$value->id}}">
                                                                                                    <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                                    <button type="submit" class="vote-button fas fa-sort-up unvote" data-toggle="tooltip" data-placement="top" title="Unvote"></button>
                                                                                                </form>
                                                                                                <?php $result = true ?>
                                                                                                @break
                                                                                                @endif
                                                                                                <?php $result = false ?>
                                                                                            @endforeach
                                                                                            @if ($result != true)
                                                                                            <form action="{{route('up_vote')}}" method="POST">
                                                                                                @csrf
                                                                                                <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                                <button id="" type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                                                            </form>
                                                                                            @endif
                                                                                        @else
                                                                                            <form action="{{route('up_vote')}}" method="POST">
                                                                                                @csrf
                                                                                                <input type="hidden" name="postId" value="{{$post->id}}">
                                                                                                <button id="" type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                                                            </form>
                                                                                        @endif
                                                                                        <div class="vote-count text-center">{{$post->vote_count}}</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="post-content ml-2">
                                                                                    <a href="{{route('postDetail',['id'=>$post->id])}}">{{$post->title}}</a>
                                                                                    <p>{{$board->name}}</p>
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection
