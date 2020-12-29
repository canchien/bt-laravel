@section('title')
    Add Category
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row justify-content-lg-center">
                    <div class="col-lg-8 col-md-12 mt-5">

                        @if (session('message'))
                        <div class="alert alert-success">
                                {{session('message')}}
                                <a href="{{route('list-categories')}}">Quay lại list categories</a>
                        </div>
                        @endif
                        <div id="addUserProfile" class="card card-lg">
                        <!-- Body -->
                        <form action="{{route('add-category')}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="card-header">
                                <h3>Add new category</h3>
                            </div>
                            <div class="card-body">
                                <!-- name  -->
                                <div class="row form-group mt-4">
                                    <label for="fullNameLabel" class="col-sm-2 col-form-label input-label">Name
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name" id="fullNameLabel" required placeholder="name category" >
                                        </div>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- parent --}}
                                <div class="row form-group">
                                    <label for="fullNameLabel" class="col-sm-2 col-form-label input-label">Parent (Optional)
                                    </label>
                                    <div class="col-sm-10">
                                        <select name="parent" class="custom-select">
                                            <option value="0" selected>no</option>
                                            @foreach ($categories as $category)
                                            @if ($category->type =="category" && $category->parent != 99)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- username -->
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label input-label">Image</label>
                                        <div class="col-sm-10">
                                            <div class="media align-items-center">
                                                <label class="imagePost mr-3" for="avatarUploader">
                                                    <img class="imagePost" id="avatar-info" src="{{asset('admin_asset/image/upload/defaultimage.jpg')}}">
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
                                <!-- status -->
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label input-label">Access type</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-md-down-break">
                                            <div class="form-control">
                                                <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="status" id="public" value="public" checked>

                                                <label class="custom-control-label" for="public">Public</label>
                                                </div>
                                            </div>

                                            <div class="form-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="status" id="verified" value="verified">

                                                    <label class="custom-control-label" for="verified">Verified</label>
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="status" id="private" value="private">

                                                    <label class="custom-control-label" for="private">Private</label>
                                                </div>
                                            </div>
                                        </div>
                                        <small>User access to this boards.</small>
                                    </div>
                                </div>
                                {{-- showonpage --}}
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label input-label"></label>
                                    <div class="col-sm-10">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="showon" name="showon">
                                            <label class="custom-control-label" for="showon">Show on homepage</label>
                                            <p><small>Show link to this board on homepage.</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary"> Create </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
</div>
@endsection

