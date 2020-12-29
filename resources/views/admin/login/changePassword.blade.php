@section('title')
    Change password
@endsection
@extends('admin.login.layoutlogin')
@section('content')
<div class="card-body">
    <form method="POST" novalidate action="{{route('change-password')}}">
        @csrf
        <!-- title log -->
        @if (session('message_email'))
        <div class="alert alert-warning">
                {{session('message_email')}}
        </div>
        @endif
        <div class="text-center">
            <div class="mb-5">
                <h1 class="display-4">Change your password</h1>
            </div>
        </div>
        <!-- end form name -->
        <input type="hidden" name="id" value="{{$user->id}}">
        <div class="form-group">
            <label class="input-label" for="signupEmail">Your email</label>
            <input type="email" class="form-control form-control-log" name="email" id="signupEmail" value="{{$user->email}}" required="" readonly>
        </div>

        <div class="form-group">
            <label class="input-label" for="signupEmail">New password</label>
            <div class="input-group">
                <input type="password" class="form-control form-control-log form-control-pass" name="password" id="checkPass" placeholder="8+ characters required" required="">
                <div class="show-pass d-flex align-items-center">
                    <a class="pr-3" href="javascript:0;" onclick="showPassword('checkPass')"><i class="far fa-eye-slash"></i></a>
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="form-group">
            <label class="input-label" for="signupEmail">Confirm new password</label>
            <div class="input-group">
                <input type="password" class="form-control form-control-log form-control-pass" name="repassword" id="reCheckPass" placeholder="8+ characters required" required="">
                <div class="show-pass d-flex align-items-center">
                        <a class="pr-3" href="javascript:0;" onclick="showPassword('reCheckPass')"><i class="far fa-eye-slash" ></i></a>
                </div>
                @error('repassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-lg btn-block btn-primary mb-2" name="submit">Create an account</button>
        <div class="text-center">
            <a href="#"> or Start your 30-day trial<i class="fas fa-angle-right ml-2"></i></a>
        </div>
    </form>


</div>
@endsection
