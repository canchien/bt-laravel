@section('title')
    Add User
@endsection

@extends('admin.layout.index')

@section('content')
    <div class="main-content">
        <div class="row justify-content-lg-center">
            <div class="col-lg-8 col-md-12 mt-5">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                        <a href="{{ route('listUsers') }}">Quay lại list users</a>
                    </div>
                @endif
                <div class="message">
                </div>
                <div id="addUserProfile" class="card card-lg">
                    <!-- Body -->
                    <form action="" method="POST" enctype="multipart/form-data" novalidate id="addForm">
                        @csrf
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label input-label">Profile photo</label>
                            <div class="col-sm-9">
                                <div class="media align-items-center">
                                    <label class="avatar-info mr-3" for="avatarUploader">
                                        <img class="avatar-img" id="avatar-info"
                                            src="https://htmlstream.com/front-dashboard/assets/img/160x160/img1.jpg" alt="">
                                    </label>
                                    <div class="media-body">
                                        <div class="btn btn-sm btn-primary file-attachment-btn mb-2 mb-sm-0 mr-2">Upload
                                            Photo
                                            <input type="file" class="file-attachment-btn-label" id="avt-info" name="img"
                                                onchange="showPreview(event);">
                                        </div>
                                        <a class="btn btn-sm btn-white mb-2 mb-sm-0" onclick="deleteAvt()">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- name  -->
                        <div class="row form-group">
                            <label for="fullNameLabel" class="col-sm-3 col-form-label input-label">name
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="fullNameLabel" required
                                        placeholder="Mark">
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="alert alert-danger errorMessage" id="nameError" style="display:none">
                                </div>
                            </div>
                        </div>
                        <!-- email -->
                        <div class="row form-group">
                            <label for="emaiLable" class="col-sm-3 col-form-label input-label">email</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="emaiLable" required
                                        placeholder="BTdEg@gmail.com">
                                </div>
                                <div class="alert alert-danger" id="nameError" style="display:none">
                                </div>
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="alert alert-danger errorMessage" id="emailError" style="display:none">
                                </div>
                            </div>
                        </div>
                        {{-- role --}}
                        <div class="row form-group">
                            <label for="role" class="col-sm-3 col-form-label">
                                role @if (Auth::User()->role !== 1)
                                    {!! "(<small style='color: red;'>x</small>)" !!}
                                @endif
                            </label>
                            <div class="col-sm-9">

                                <select class="form-control" id="role" name="role" @if (Auth::User()->role !== 2)
                                    disabled
                                    @endif>
                                    <option value="0" selected>User</option>
                                    <option value="1">Admin</option>
                                    <option value="2">super admin</option>
                                </select>
                            </div>
                        </div>
                        <!-- phone -->
                        <div class="row form-group">
                            <label for="phoneLabel" class="col-sm-3 col-form-label input-label">Phone
                                <span class="input-label-secondary">(Optional)</span>
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group align-items-center">
                                    <input type="text" class="js-masked-input form-control" name="phone" id="phoneLabel"
                                        required placeholder="+x(xxx)xxx-xx-xx" value="">
                                </div>
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="alert alert-danger errorMessage" id="phoneError" style="display:none">
                                </div>
                            </div>
                        </div>
                        <!-- address -->
                        <div class="row form-group">
                            <label for="addressLable" class="col-sm-3 col-form-label input-label">Address</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="address" id="addressLable"
                                        placeholder="Your adress" required>
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
                                            <input type="radio" class="custom-control-input" name="status" id="active"
                                                value="1" checked>

                                            <label class="custom-control-label" for="active">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="status" id="deactive"
                                                value="0">
                                            <label class="custom-control-label" for="deactive">Deactive</label>
                                        </div>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- password -->
                        <div class="row form-group">
                            <label for="passLabel" class="col-sm-3 col-form-label input-label">password
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="passLabel" required
                                        placeholder="password">

                                </div>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="alert alert-danger errorMessage" id="passwordError" style="display:none">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary" name="submit"> Create </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#addForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData($("#addForm")[0]);
                console.log(formData);
                var url = '{{ route('
                postAddUser ') }}';
                $.ajax({
                    url: url,
                    dataType: 'json',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response.errors);
                        if (response.status == 1) {
                            $(".message").html(response.message + "<a href=" +
                                "{{ route('listUsers') }}" + "> Quay lại list users</a>");
                            $(".message").addClass(response.class);
                            $("#addForm")[0].reset();
                        } else {
                            $(".errorMessage").css("display", "none");
                            $.each(response.errors, function(key, value) {
                                if (key == "name") {
                                    $("#nameError").css('display', 'block');
                                    $("#nameError").html(value);
                                }
                                if (key == "phone") {
                                    $("#phoneError").css('display', 'block');
                                    $("#phoneError").html(value);
                                }
                                if (key == "password") {
                                    $("#passwordError").css('display', 'block');
                                    $("#passwordError").html(value);
                                }
                                if (key == "email") {
                                    $("#emailError").css('display', 'block');
                                    $("#emailError").html(value);
                                }
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });


        });

    </script>
    {{-- <script>
        $(document).ready(function() {
            alert("aaasdsadf");


        });

    </script> --}}
@endsection
