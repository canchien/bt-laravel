@section('title')

@endsection
@extends('layout.index')
@section('content')
    <div class="main">
        <div class="container py-5">
            <div class="row py-5">
                <div class="main-left col-lg-9">
                    <div class="d-flex">
                        <div class="details-post-votes mr-2">
                            <div class="details-voting-box">
                                @if (Auth::check())
                                    @foreach ($userMeta as $value)
                                        @if ($value->user_id == Auth::user()->id && $value->meta_value == $postDetail->id)
                                        <form action="{{route('un_vote')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$value->id}}">
                                            <input type="hidden" name="postId" value="{{$postDetail->id}}">
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
                                            <input type="hidden" name="postId" value="{{$postDetail->id}}">
                                            <button id="" type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                        </form>
                                    @endif
                                @else
                                    <form action="{{route('up_vote')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="postId" value="{{$postDetail->id}}">
                                        <button id="" type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                    </form>
                                @endif

                                <div class="vote-count text-center" data-toggle="tooltip" data-placement="bottom" title="Votes for Post: {{$postDetail->vote_count}}">{{$postDetail->vote_count}}</div>
                            </div>
                        </div>
                        <div class="main-post-title mb-3">
                            <h3>{{$postDetail->title}}</h3>
                            <p class="date">{{$postDetail->created_at}}</p>
                        </div>
                    </div>
                    <div class="about-left mb-5">
                        <div class="main-post-summary mb-5">
                            <h3><small>{{$postDetail->summary}}</small></h5>
                        </div>
                        <div class="main-post-img mb-3">
                            <img src=@if(!$postDetail->postmeta->isEmpty())
                                @foreach ($postDetail->postmeta as $postmeta)
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
                        <div class="main-post-content">
                            {!!$postDetail->content!!}
                        </div>
                    </div>
                    <div class="comments-area" id="accordion">
                        <h5 class=" mb-5">{{$commentsPost->count()}} <i class="far fa-comment"></i></h5>
                        @foreach ($commentsPost as $comment)
                            @if ($comment->comment_parent == 0)
                            <div class="comment-list mb-4">
                                <div class="single-comment-parent">
                                    <div class="user d-flex">
                                        <div class="thumb avatar-comment mr-3">
                                            <img class="avatar-img" src=@if($comment->users->avatar != "" && $comment->users->avatar != null)
                                            {!!asset('admin_asset/image/upload/'.$comment->users->avatar)!!}
                                        @else
                                            {{Avatar::create($comment->users->name)->toBase64()}}
                                        @endif alt="">
                                        </div>
                                        <div class="desc">
                                            <div class="d-flex justify-content-between">
                                                @if ($comment->users->role == 1 || $comment->users->role == 2)
                                                    <h6 style="color: #5b5fca">
                                                        {{$comment->users->name}}
                                                        <small class="badge badge-danger">Admin</small>
                                                    </h6>
                                                @else
                                                    <h6>
                                                        {{$comment->users->name}}
                                                    </h6>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="comment-content">{{$comment->comment_content}}</p>
                                                <div class="d-flex mb-2">
                                                    <a href="javascrip:0;"> <small class="date">{{$comment->created_at}}</small></a>
                                                    @if (Auth::Check())

                                                        @if (Auth::User()->role == 2 || Auth::User()->id == $comment->author)
                                                            <a href="{{ route('removeComment',['id'=>$comment->id,'post_id'=>$postDetail->id])}}" class="text-delete mr-1 ml-2" onclick="return removeItem()"><small>Delete</small> </a>
                                                            <p>-</p>
                                                            @endif
                                                        @if (Auth::User()->id == $comment->author)
                                                            <a href="#updateComment" data-toggle="modal" class="update-comment mx-1" id="{{$comment->id}}"> <small>Update</small> </a>
                                                            <p>-</p>
                                                        @endif

                                                        <a data-target="#commentReply{{$comment->id}}" class="ml-1" data-toggle="collapse"><small class="action-comment">Reply</small></a>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="commentReply{{$comment->id}}" data-parent="#accordion" class="collapse border p-3 navbar-collapse ml-5" >
                                        <form action="{{route('addComment')}}" method="POST">
                                            <div class="form-group">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{$postDetail->id}}">
                                                <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                                <label for="content" class=" col-form-label input-label">Content reply</label>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="content" id="contentReply" rows="3"></textarea>
                                                </div>
                                                <div class="alert alert-danger errorMessage" id="contentError" style="display:none">
                                                </div>
                                            </div>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="button" class="btn btn-light closeCollapse">close</button>
                                        </form>
                                    </div>
                                    @foreach ($commentsPost as $cmt)
                                    @if ($cmt->comment_parent == $comment->id)
                                    <div class="comment-list mb-2 ml-5">
                                        <div class="single-comment">
                                            <div class="user d-flex">
                                                <div class="thumb avatar-comment mr-3">
                                                    <img class="avatar-img" src=@if($cmt->users->avatar != "" && $cmt->users->avatar != null)
                                                    {!!asset('admin_asset/image/upload/'.$cmt->users->avatar)!!}
                                                @else
                                                    {{Avatar::create($cmt->users->name)->toBase64()}}
                                                @endif alt="">
                                                </div>
                                                <div class="desc">
                                                    <div class="d-flex justify-content-between">
                                                        @if ($cmt->users->role == 1 || $cmt->users->role == 2)
                                                            <h6 style="color: #5b5fca">
                                                                {{$cmt->users->name}}
                                                                <small class="badge badge-danger">Admin</small>
                                                            </h6>
                                                        @else
                                                            <h6>
                                                                {{$cmt->users->name}}
                                                            </h6>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <p class="comment-content">{{$cmt->comment_content}}</p>
                                                        <div class="d-flex">
                                                            <a href="javascrip:0;"> <small class="date">{{$cmt->created_at}}</small></a>
                                                            @if (Auth::Check())
                                                                @if (Auth::User()->role == 2 || Auth::User()->id == $cmt->author)
                                                                    <a href="{{ route('removeComment',['id'=>$cmt->id,'post_id'=>$postDetail->id])}}" class="text-delete mr-1 ml-2" onclick="return removeItem()"><small>Delete</small> </a>
                                                                    <p>-</p>
                                                                @endif
                                                                @if (Auth::User()->id == $cmt->author)
                                                                    <a href="#" data-toggle="modal" class="update-comment mx-1" id="{{$cmt->id}}"> <small>Update</small> </a>
                                                                    <p>-</p>
                                                                @endif
                                                                <a data-target="#commentReply{{$comment->id}}" class="ml-1" data-toggle="collapse"><small>Reply</small></a>
                                                            @endif

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    @endif

                                @endforeach
                                </div>
                            </div>
                            @endif

                        @endforeach

                        <form action="{{route('postUpdateComment')}}" method="POST" id="updateComment">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="modal fade" id="UpdateComment">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">Update your Comment</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">

                                        <input type="hidden" name="id" id="comment_id">
                                        <div class="form-group">
                                            <label for="content" class=" col-form-label input-label">Content</label>
                                            <div class="input-group">
                                                <textarea class="form-control" name="content" id="content" rows="5"></textarea>
                                            </div>
                                            <div class="alert alert-danger errorMessage" id="contentError" style="display:none">
                                            </div>
                                        </div>

                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" name="">Save changes</button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </form>
                    </div>
                    <div class="comment-form">
                        @if (Auth::check())
                            <h4 class="mb-3 mt-2">Leave a Reply</h4>
                            <form class="form-contact comment_form" action="{{route('addComment')}}" method="POST" id="commentForm">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                <input type="hidden" name="post_id" value="{{$postDetail->id}}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control w-100" name="content" id="comment" cols="30" rows="9"
                                            placeholder="Write Comment" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="button button-contactForm btn_1 boxed-btn">Send Message</button>
                                </div>
                            </form>
                        @else
                            <div class="">
                                <a  class="boxed-btn btn" href="{{route('login')}}">Login to comments</a>
                            </div>
                        @endif
                    </div>

                </div>
                
                {{--  --}}
                <div class="main-right col-md-3">
                    <div class="search mb-3">
                        <form class="form-inline" method="get" action="{{route('search')}}" role="search">
                            @csrf
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
                                    <a title="" href="{{route('postDetail',['id'=>$post->id])}}"><small>{!!Str::substr($post->title, 0, 35).'...'!!}</small></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="socialize">
                        <div class="upiterx_social">
                            <h3 class="card-title">Socialize</h3>
                            <div class="jupiterx-widget-content">
                                <div class="jupiterx-social-widget-wrapper jupiterx-social-widget-wrapper-5f8ce5b1cddf2">
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-twitter" target="_blank">
                                        <img src="{{asset('app/image/icon-tw.png')}}" alt="">
                                    </a>
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-instagram" target="_blank">
                                        <img src="{{asset('app/image/icon-ins.png')}}" alt="">
                                    </a>
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-facebook" target="_blank">
                                        <img src="{{asset('app/image/icon-fb.png')}}" alt="">
                                    </a>
                                    <a href="#" class="jupiterx-widget-social-share-link btn jupiterx-widget-social-icon-youtube" target="_blank">
                                        <img src="{{asset('app/image/icon-yo.png')}}" alt="">
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
@section('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.update-comment', function(){
                var comment_id = $(this).attr("id");
                console.log(comment_id);
                var url = '{{route('getComment')}}';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    method:"get",
                    data:{comment_id:comment_id},
                    dataType:"json",
                    success:function(data){
                        console.log(data);
                        $('#content').val(data.comment_content);
                        $('#comment_id').val(data.id);
                        $('#UpdateComment').modal('show');
                    }
                });
            });
            $('#updateComment').on("submit", function(event){
                event.preventDefault();
                var url = '{{route('postUpdateComment')}}';

                var content = $("#content").val();
                var id = $("#comment_id").val();
                console.log(id + content);
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:url,
                        method:"POST",
                        data:{
                            id:id,
                            content:content
                        },
                        cache:false,
                        success:function(response){
                            console.log(response);
                            if(response.status==1){
                                $("#updateComment")[0].reset();
                                location.reload();

                            }else{
                                $(".errorMessage").css("display","none");
                                $.each( response.errors, function( key, value ) {
                                    if(key == "content"){
                                        $("#contentError").css('display','block');
                                        $("#contentError").html(value);
                                    }
                                });
                            }
                        }
                    });
            });
        });
    </script>
@endsection
