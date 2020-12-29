@section('title')
    register
@endsection
@extends('admin.login.layoutlogin')
@section('content')
<div class="card-body">
    <form method="POST" novalidate action="{{route('signup')}}">
        @csrf
        <!-- title log -->
        @if (session('message_email'))
        <div class="alert alert-warning">
                {{session('message_email')}}
        </div>
        @endif
        <div class="text-center">
            <div class="mb-5">
                <h1 class="display-4">Create your account</h1>
                <p>Already have an account? <a href="{{route('login')}}">Sign in here</a></p>
            </div>
            <a class="btn btn-lg btn-block btn-white mb-4" href="{{route('loginGoogle')}}">
            <span class="d-flex justify-content-center align-items-center">
                <img class="avatar avatar-gg mr-2" src="./public/img/logos/gg.png" alt="">
                Sign up with Google
            </span>
            </a>
            <span class="line-or text-muted mb-4">OR</span>
        </div>
        <!-- end title log -->

        <!-- form name -->
        <div class="form-group">
            <label class="input-label" for="signupEmail">Name</label>
            <input type="text" class="form-control form-control-log" name="name" id="signupEmail" placeholder="Mark Williams" required="">

            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- end form name -->

        <div class="form-group">
            <label class="input-label" for="signupEmail">Your email</label>
            <input type="email" class="form-control form-control-log" name="email" id="signupEmail" placeholder="Markwilliams@example.com" required="">

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="input-label" for="signupEmail">Password</label>
            <div class="input-group">
                <input type="password" class="form-control form-control-log form-control-pass" name="password" id="checkPass" placeholder="8+ characters required" required="">
                <div class="show-pass d-flex align-items-center">
                    <a class="pr-3" href="javascript:0;" onclick="showPassword('checkPass')"><i class="far fa-eye-slash"></i></a>
                </div>
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="input-label" for="signupEmail">Confirm password</label>
            <div class="input-group">
                <input type="password" class="form-control form-control-log form-control-pass" name="repassword" id="reCheckPass" placeholder="8+ characters required" required="">
                <div class="show-pass d-flex align-items-center">
                        <a class="pr-3" href="javascript:0;" onclick="showPassword('reCheckPass')"><i class="far fa-eye-slash" ></i></a>
                </div>
            </div>
            @error('repassword')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required="">
                <label class="custom-control-label text-muted" for="termsCheckbox"> I accept the <a href="#">Terms and Conditions</a></label>
            </div>
        </div>
        <div class="text-right mb-3">
            <a href="{{route('get-forget-password')}}">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-lg btn-block btn-primary mb-2" name="submit">Create an account</button>
        <div class="text-center">
            <a href="#"> or Start your 30-day trial<i class="fas fa-angle-right ml-2"></i></a>
        </div>
    </form>


</div>
@endsection
