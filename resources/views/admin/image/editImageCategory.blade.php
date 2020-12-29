@section('title')
Edit Category
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row justify-content-lg-center">
                    <div class="col-lg-8 col-md-12 mt-5">
                        @if (session('message'))
                        <div class="alert alert-success">
                                {{session('message')}}
                                <a href="{{route('listImages')}}">Quay lại list images</a>
                        </div>
                        @endif
                        <div id="addUserProfile" class="card card-lg">

                        <!-- Body -->
                        <form action="{{route('postEditCategory')}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="id" value="{{$category->id}}">
                            <div class="card-header">
                                <h3>Image Category</h3>
                            </div>
                            <!-- name  -->
                            <div class="row form-group mt-4">
                                <label for="fullNameLabel" class="col-sm-2 col-form-label input-label">Name
                                </label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="name" id="fullNameLabel" required placeholder="name category" value="{{$category->name}}" readonly>

                                    </div>
                                </div>
                            </div>
                            <!-- image -->

                            <div class="row form-group">
                                <label class="col-sm-2 col-form-label input-label">Image</label>
                                    <div class="col-sm-10">
                                        <div class="media align-items-center">
                                            <label class="imagePost mr-3" for="avatarUploader">
                                                <img class="imagePost" id="avatar-info" src=@if($category->image !== "")
                                                {!!asset('admin_asset/image/upload/'.$category->image)!!}

                                                @else
                                                    {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                                                @endif alt="">
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
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary" name="submit"> Update </button>
                            </div>
                        </form>


                        </div>
                    </div>
                </div>
</div>
@endsection
