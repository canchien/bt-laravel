@section('title')
Edit Post
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row justify-content-lg-center">
        <div class="col-lg-12 mt-5">
            @if (session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                    <a href="{{route('posts.list_posts')}}">Quay lại list posts</a>
                </div>
            @endif
            <div id="addUserProfile" class="card card-lg">
            <!-- Body -->
            <form action="{{route('edit-post')}}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="id" id="" value="{{ $post->id }}">
                <input type="hidden" name="post_type" id="" value="{{ $post->post_type }}">
                <div class="card-header">
                    <h3>Edit post</h3>
                </div>
                <div class="card-body">
                    <!-- title  -->
                    <div class="row form-group">
                        <label for="titleLabel" class="col-sm-2 col-form-label input-label">Title
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" name="title" id="titleLabel" required placeholder="title" value="{{ $post->title }}" >
                            </div>
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- content -->
                    <div class="row form-group">
                        <label for="contentLabel" class="col-sm-2 col-form-label input-label">Content
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <textarea class="form-control ckeditor" rows="5" name="content" placeholder="content..." >{{ $post->content}}</textarea>
                            </div>
                            @error('content')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- author  -->
                    <input type="hidden" class="form-control" name="author" id="authorLabel" value="" >

                    <!-- image -->
                    <input type="hidden" name="getImg" id="getImg" value="@foreach ($post->postmeta as $postmeta)
                        @if($postmeta->meta_key== "meta_image" && $postmeta->meta_value !== null)
                            {!!$postmeta->meta_value!!}
                        @endif
                    @endforeach">
                    <div class="row form-group">
                        <label class="col-sm-2 col-form-label input-label">Image</label>
                            <div class="col-sm-10">
                                <div class="media align-items-center">
                                    <label class="imagePost mr-3" for="avatarUploader">
                                        <img class="imagePost" id="avatar-info" src=@if(!$post->postmeta->isEmpty())
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
                                    </label>
                                <div class="media-body">
                                <div class="btn btn-sm btn-primary file-attachment-btn mb-2 mb-sm-0 mr-2">Upload Image
                                    <input type="file" class="file-attachment-btn-label" id="avt-info" name="img" onchange="showPreview(event);">
                                </div>
                                    <a class="btn btn-sm btn-white mb-2 mb-sm-0" onclick="deleteAvt()" >Delete</a>
                                </div>
                            </div>
                            @error('img')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- statuses  -->
                    <div class="row form-group">
                        <label for="statusCheck" class="col-sm-2 col-form-label input-label">Statuses</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="statusCheck" name="statuses">
                                @foreach ($status as $category)
                                    <option value="{{$category->id}}"
                                        @foreach($post->categories AS $value)
                                            @if($category->id == $value->id)
                                                selected
                                            @endif
                                        @endforeach>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        @error('statuses')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                    <!-- thể loại  -->
                    <div class="row form-group">
                        <label for="statusCheck" class="col-sm-2 col-form-label input-label">Categories</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="statusCheck" name="category">
                                @foreach ($categories as $category)
                                    @if ($category->type=="category" && $category->parent!=99)
                                    <option value="{{$category->id}}"
                                        @foreach($post->categories AS $value)
                                            @if($category->id == $value->id)
                                                selected
                                            @endif
                                        @endforeach>
                                        {{$category->name}}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- tags --}}
                    <div class="row form-group">
                        <label for="tags" class="col-sm-2 col-form-label input-label">Tags
                        </label>
                        <div class="col-sm-10">
                            <select class="mul-select form-control" multiple="true" id="tags" name="tags[]">
                                <option value="Cambodia">Cambodia</option>
                                @foreach($tags as $value)
                                <option value="{{ $value->name }}"
                                    @foreach($post->categories AS $tag)
                                   @if($tag->id == $value->id) selected @endif
                                   @endforeach>
                                   {{ $value->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Post parent  -->
                    <div class="row form-group">
                        <label for="fullNameLabel" class="col-sm-2 col-form-label input-label">Post Parent
                        </label>
                        <div class="col-sm-10">
                            <select name="postParent" class="custom-select">
                                <option value="0">không</option>
                                @foreach($allPosts as $value)
                                <option value="{{ $value->id}}" @if($post->post_parent == $value->id) selected @endif>
                                   {{ $value->id.'-'.$value->title}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- status -->
                    <div class="row form-group">
                        <label class="col-sm-2 col-form-label input-label">Status</label>

                            <div class="col-sm-10">
                                <div class="input-group input-group-md-down-break">
                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="status" id="public" value="public" @if($post->status=="public") checked @endif >

                                        <label class="custom-control-label" for="public">Public</label>
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="status" id="pending" value="pending" @if($post->status=="pending") checked @endif>

                                            <label class="custom-control-label" for="pending">Pending</label>
                                        </div>
                                    </div>
                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="status" id="private" value="private" @if($post->status=="private") checked @endif>

                                            <label class="custom-control-label" for="private">Private</label>
                                        </div>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary" name="submit"> Update </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
