@section('title')
    Posts
@endsection
@extends('layout.index')
@section('content')
    <div class="main">
        {{-- <div class="main-top position-relative">
            <div class="main-top-background-overlay">
            </div>
            <div class="main-top-content">
                <div class="main-top-title">
                    <h1 class="elementor-heading-title elementor-size-default">Blog</h1>
                </div>
                <div class="raven-breadcrumbs raven-breadcrumbs-default">
                    <a href="javascrip:0;"><span>Home</span></a>
                    <span>/ News</span>
                </div>
            </div>
        </div> --}}
        <div class="container-fluid">
            <div class="container main-setting">
                <div class="col-lg-12">
                    <div class="filter">
                        <div class="row justify-content-between align-items-center flex-grow-1 px-3">
                            <div class="col-lg-2">
                                @if (Auth::check() && Auth::user()->confirmed ==1)
                                    <a class="new-post-handler d-flex" title="create a post" data-toggle="modal" data-target="#modalNewPost">
                                        <div class="create-button-icon mr-1">
                                            <span class="fas fa-plus-circle icon-create"></span>
                                        </div>
                                        <div class="create-bottom-caption">create a post</div>
                                    </a>
                                @elseif(Auth::check() && Auth::user()->confirmed !=1)
                                    <a class="new-post-handler d-flex" title="login" id="btn-verify">
                                        <div class="create-button-icon mr-1">
                                            <span class="fas fa-plus-circle icon-create"></span>
                                        </div>
                                        <div class="create-bottom-caption">create a post</div>
                                    </a>
                                    <div class="toast toast-verify">
                                        <div class="toast-header justify-content-between">
                                            <strong>Warning!</strong>
                                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                        </div>
                                        <div class="toast-body">
                                            <div class="alert alert-warning mb-0">You need to verify your account to create a post</div>
                                        </div>
                                    </div>
                                @else
                                    <a class="new-post-handler d-flex" title="login" href="{{route('login')}}">
                                        <div class="create-button-icon mr-1">
                                            <span class="fas fa-plus-circle icon-create"></span>
                                        </div>
                                        <div class="create-bottom-caption">create a post</div>
                                    </a>
                                @endif

                                <form action="" id="form_create_post" enctype="multipart/form-data" novalidate>
                                    @csrf
                                <!-- The Modal -->
                                <div class="modal fade" id="modalNewPost">
                                    <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Create a Post</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">

                                            <div class="row form-group">
                                                <label for="titleLabel" class="col-sm-2 col-form-label input-label">Title
                                                </label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="title" id="titleLabel" required placeholder="title" >
                                                    </div>
                                                    <small class="errorMessage" id="titleError" style="display:none; color:red;">
                                                    </small>
                                                </div>
                                            </div>
                                            <!-- thể loại  -->
                                            <div class="row form-group">
                                                <label for="categories" class="col-sm-2 col-form-label input-label">Categories</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="categories" name="category">
                                                        @foreach ($allTerms as $category)
                                                        @if ($category->type== 'category' && $category->parent!=99 )
                                                        <option value="{{$category->id}}" @if($category->id == 99) selected @endif>{{$category->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- image -->
                                            <div class="row form-group">
                                                <label class="col-sm-2 col-form-label input-label">Image</label>
                                                    <div class="col-sm-10">
                                                        <div class="media align-items-center">
                                                            <label class="imagePost mr-3" for="avatarUploader">
                                                                <img class="imagePost" id="avatar-info" src="{{asset('admin_asset/image/upload/defaultimage.jpg')}}" alt="">
                                                            </label>
                                                        <div class="media-body">
                                                        <div class="btn btn-sm btn-primary file-attachment-btn mb-2 mb-sm-0 mr-2">Upload Image
                                                            <input type="file" class="file-attachment-btn-label" id="avt-info" name="img" onchange="showPreview(event);">
                                                        </div>
                                                            <a class="btn btn-sm btn-white mb-2 mb-sm-0" onclick="deleteAvt()" >Delete</a>
                                                        </div>
                                                    </div>
                                                    <small class="errorMessage" id="imgError" style="display:none; color:red;"></small>
                                                </div>
                                            </div>
                                            <!-- content -->
                                            <div class="row form-group">
                                                <label for="editor" class="col-sm-2 col-form-label input-label">Content</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <textarea class="form-control ckeditor" id="editor" rows="5" name="content" placeholder="content..."></textarea>
                                                    </div>
                                                    <small class="errorMessage" id="contentError" style="display:none; color:red;"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" id="close-modal" data-dismiss="modal">Close</button>
                                            <button type="submit" id="button_insert" class="btn btn-success" data-url="{{route('create_post')}}">Create</button>
                                        </div>

                                    </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="col-lg-4 filter">
                                {{-- <form action="{{route('category_details',['key'=>'none'])}}" id="bulkActions" class="d-flex" method="GET"> --}}
                                    <div class="form-group">
                                        <select class="form-control" name="filterCategory" id="actions" onchange="location = this.value;">
                                            <option value="">-- fillter category --</option>
                                            @foreach ($allTerms as $value)
                                                @if ($value->type == "category" && $value->parent!=99)
                                                    <option value="{{route('category_details',['key'=>$value->slug])}}">
                                                        {{$value->name}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>

                                {{-- </form> --}}
                                {{-- <form action="{{route('limitCategories')}}" method="GET" class="d-flex">
                                    <div class="form-group mb-0 mr-2">
                                        <select class="form-control " id="sel1" name="showData" onchange="this.form.submit()">
                                            <option value="10" @if (session()->has('limit')&& session('limit')==10) {{'selected'}}@endif>10</option>
                                            <option value="20" @if (session()->has('limit')&& session('limit')==20) {{'selected'}}@endif>20</option>
                                            <option value="50" @if (session()->has('limit')&& session('limit')==50) {{'selected'}}@endif>50</option>
                                        </select>
                                    </div>
                                </form>
                                <form action="{{route('listPosts')}}" method="GET" >
                                    <div class="form-group mr-2">
                                        <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                                            <option value="">Any</option>
                                            <option value="asc" @if (session()->has('sort')&& session('sort')=="asc") {{'selected'}}@endif>Name A-Z</option>
                                            <option value="desc" @if (session()->has('sort')&& session('sort')=="desc") {{'selected'}}@endif>Name Z-A</option>
                                        </select>
                                    </div>
                                </form> --}}
                            </div>
                            <div class="col-lg-6 mb-3 ml-0">
                                <form method="GET" action="{{route('listPosts')}}">
                                <!-- Search -->
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch" type="search" class="form-control" name="search" placeholder="Search posts">
                                </div>
                                <!-- End Search -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container container-changelog">
                <div class="board-top-block">
                    <h1 class="board-block-header">Posts</h1>
                </div>
                @foreach ($posts as $post)
                    @if (Auth::check() && Auth::user()->role==2)
                        @if ($post->status != 'pending')
                        <div class="card-post-wrap py-3">
                            <div class="card-post mb-5">
                                <div class="post-content">
                                    <div class="d-flex">
                                        <div class="details-post-votes mr-2">
                                            <div class="details-voting-box">
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
                                                    <button type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                </form>
                                                @endif
                                                <div class="vote-count text-center" data-toggle="tooltip" data-placement="bottom" title="Votes for Post: {{$post->vote_count}}">{{$post->vote_count}}</div>
                                            </div>
                                        </div>
                                        <h3 class="post-title">
                                            <a href="{{route('postDetail',['id'=>$post->id])}}">{{$post->title}}
                                                <sup class="post-comments-count"><i class="far fa-comment"></i>{{' '.$post->comment_count}}</sup>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="post-meta mb-1 ml-5">
                                        <a class="raven-post-meta-item raven-post-date" href="javascrip:0;" rel="bookmark">{{$post->created_at}}</a>
                                        @foreach ($post->categories as $category)
                                        <span class="px-2">|</span>
                                        <span class="raven-post-meta-item raven-post-categories">
                                            <a href="{{route('category_details',['key'=>$category->slug])}}" rel="tag">
                                                {{$category->name}}
                                            </a>
                                        </span>
                                        @endforeach
                                    </div>
                                    <div class="post-excerpt mb-3 ml-5">
                                        {!!Str::substr($post->content, 0, 200).'...'!!}
                                        <a class="raven-post-title-link" href="{{route('postDetail',['id'=>$post->id])}}">See More</a>
                                    </div>
                                </div>
                                <div class="post-image-wrap ml-5">
                                    <a class="post-image" href="{{route('postDetail',['id'=>$post->id])}}">
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
                    @else
                        @if ($post->status == 'public')
                            <div class="card-post-wrap py-3">
                                <div class="card-post mb-5">
                                    <div class="post-content">
                                        <div class="d-flex">
                                            <div class="details-post-votes mr-2">
                                                <div class="details-voting-box">
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
                                                            <button type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                        </form>
                                                        @endif
                                                    @else
                                                        <form action="{{route('up_vote')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="postId" value="{{$post->id}}">
                                                            <button type="submit" class="vote-button fas fa-sort-up upvote" data-toggle="tooltip" data-placement="top" title="Upvote" ></button>
                                                        </form>
                                                    @endif

                                                    <div class="vote-count text-center" data-toggle="tooltip" data-placement="bottom" title="Votes for Post: {{$post->vote_count}}">{{$post->vote_count}}</div>
                                                </div>
                                            </div>
                                            <h3 class="post-title">
                                                <a class="raven-post-title-link" href="{{route('postDetail',['id'=>$post->id])}}">{{$post->title}}
                                                <sup class="post-comments-count"><i class="far fa-comment"></i>{{' '.$post->comment_count}}</sup>
                                            </h3>
                                        </div>
                                        <div class="post-meta mb-1 ml-5">
                                            <a class="raven-post-meta-item raven-post-date" href="javascrip:0;" rel="bookmark">{{$post->created_at}}</a>
                                            @foreach ($post->categories as $category)
                                            <span class="px-2">|</span>
                                            <span class="raven-post-meta-item raven-post-categories">
                                                <a href="{{route('category_details',['key'=>$category->slug])}}" rel="tag">
                                                    {{$category->name}}
                                                </a>
                                            </span>
                                            @endforeach
                                        </div>
                                        <div class="post-excerpt mb-3 ml-5">
                                            {!!Str::substr($post->content, 0, 200).'...'!!}
                                            <a class="raven-post-title-link" href="{{route('postDetail',['id'=>$post->id])}}">See More</a>
                                        </div>
                                    </div>
                                    <div class="post-image-wrap ml-5">
                                        <a class="post-image" href="{{route('postDetail',['id'=>$post->id])}}">
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
                @endforeach
            </div>
            <div class="pagination justify-content-center">
                {{$posts->links()}}
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection
