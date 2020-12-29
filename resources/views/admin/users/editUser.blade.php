@section('title')
    Edit User
@endsection

@extends('admin.layout.index')

@section('content')
<div class="main-content">
    <div class="row justify-content-lg-center">
        <div class="col-lg-8 col-md-12 mt-5">
            @if (session('message'))
            <div class="alert alert-success">
                {{session('message')}}
                <a href="{{route('listUsers')}}">Quay lại list users</a>
            </div>
            @endif
            <div id="addUserProfile" class="card card-lg">
            <!-- Body -->

            <form action="{{route('postEditUser')}}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="getImg" id="getImg" value="{{$user->avatar}}">
                <input type="hidden" name="id" id="" value="{{$user->id}}">
                <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label">Profile photo</label>
                        <div class="col-sm-9">
                            <div class="media align-items-center">
                                <label class="avatar-info mr-3" for="avatarUploader">
                                    <img class="avatar-img" id="avatar-info" src=@if($user->avatar !== "" && isset($user->avatar))
                                    {!!asset('admin_asset/image/upload/'.$user->avatar)!!}

                                    @else
                                        {!!'https://htmlstream.com/front-dashboard/assets/img/160x160/img1.jpg'!!}
                                    @endif alt="">
                                </label>
                            <div class="media-body">
                            <div class="btn btn-sm btn-primary file-attachment-btn mb-2 mb-sm-0 mr-2">Upload Photo
                                <input type="file" class="file-attachment-btn-label" id="avt-info" name="img" onchange="showPreview(event);">
                            </div>
                                <a class="btn btn-sm btn-white mb-2 mb-sm-0" onclick="deleteAvt()" >Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fullname  -->
                <div class="row form-group">
                    <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Name <i class="far fa-question-circle text-body ml-1" data-toggle="tooltip" data-placement="top" title=""></i></label>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" id="firstNameLabel" placeholder="Clarice" required value="{{$user->name}}">
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                </div>

                <!-- email -->
                <div class="row form-group">
                    <label for="emailLabel" class="col-sm-3 col-form-label input-label">email
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" id="emailLabel" required placeholder="BTdEg@gmail.com"  value="{{$user->email}}">

                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- role --}}
                <div class="row form-group">
                    <label for="role" class="col-sm-3 col-form-label">
                        role @if (Auth::User()->role!==2)
                                {!! "(<small style='color: red;'>x</small>)" !!}
                            @endif
                    </label>
                    <div class="col-sm-9">

                        <select class="form-control" id="role" name="role"
                        @if (Auth::User()->role!==2)
                            disabled
                        @endif>
                            <option value="0" @if($user->role == 0) selected @endif>User</option>
                            <option value="1" @if($user->role == 1) selected @endif>Admin</option>
                            <option value="2" @if($user->role == 2) selected @endif>Super admin</option>
                        </select>
                    </div>
                </div>
                <!-- phone -->
                <div class="row form-group">
                    <label for="phoneLabel" class="col-sm-3 col-form-label input-label">Phone
                        <span class="input-label-secondary">(Optional)</span>
                    </label>

                    <div class="col-sm-9">
                        <div class="input-group align-items-center mb-3">
                            <input type="text" class="js-masked-input form-control" name="phone" id="phoneLabel" required placeholder="+x(xxx)xxx-xx-xx"  value="{{$user->phone}}">

                        </div>
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- address -->
                <div class="row form-group">
                    <label for="addressLable" class="col-sm-3 col-form-label input-label">Address</label>

                    <div class="col-sm-9">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="address" id="addressLable" placeholder="Your adress" required value="{{$user->address}}">

                        </div>
                    </div>
                </div>

                <!-- status -->
                <div class="row form-group">
                    <label class="col-sm-3 col-form-label input-label">Status</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-md-down-break">
                                <div class="form-control">
                                    <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" id="active" value="1" @if($user->status == "1") checked @endif>

                                    <label class="custom-control-label" for="active">Active</label>
                                    </div>
                                </div>

                                <div class="form-control">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="status" id="deactive" value="0" @if($user->status == "0") checked @endif>

                                        <label class="custom-control-label" for="deactive">Deactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- password -->
                <div class="row form-group">
                    <label for="passwordLabel" class="col-sm-3 col-form-label input-label">New password</label>
                    <div class="col-sm-9">
                        <div class="input-group align-items-center">
                            <input type="password" class="form-control" name="password" id="passwordLabel" required placeholder="new password"  value="{{$user->phone}}">
                        </div>
                        @error('password')
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
