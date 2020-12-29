@section('title')
Login
@endsection
@extends('admin.login.layoutlogin')
@section('content')
<div class="card-body">
    <form method="POST" action="{{ route('signin') }}" novalidate>
        @csrf
        <!-- title log -->
        @if (session('message'))
        <div class="alert alert-success">
                {{session('message')}}
        </div>
        @endif
        @if (session('message_error'))
        <div class="alert alert-danger">
                {{session('message_error')}}
        </div>
        @endif
        @if (session('message_email'))
        <div class="alert alert-warning">
                {{session('message_email')}}
        </div>
        @endif
        <div class="text-center">
            <div class="mb-5">
                <h1 class="display-4">Sign in</h1>
                <p>Don't have an account yet? <a href="{{route('get-signup')}}">Sign up here</a></p>
            </div>
            <a class="btn btn-lg btn-block btn-white mb-4" href="{{route('loginGoogle')}}">
            <span class="d-flex justify-content-center align-items-center">
                <img class="avatar avatar-gg mr-2" src="{{asset('admin_asset/image/logos/gg.png')}}" alt="">
                Sign in with Google
            </span>
            </a>
            <span class="line-or text-muted mb-4">OR</span>
        </div>
        <!-- end title log -->

        <div class="form-group">
            <label class="input-label" for="signinEmail">Your email</label>
            <input type="email" class="form-control form-control-log" name="email" id="signupEmail" placeholder="email@adress.com" required="" >
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="input-label" for="signinEmail">Password</label>
            <div class="input-group">
                <input type="password" class="form-control form-control-log form-control-pass" name="password" id="checkPass" placeholder="8+ characters required" required="">
                <div class="show-pass d-flex align-items-center mr-3">
                    <a class="" href="javascript:0;" onclick="showPassword('checkPass')"><i class="far fa-eye-slash"></i></a>
                </div>
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox">
                <label class="custom-control-label text-muted" for="termsCheckbox">Remmember me</label>
            </div>
        </div>

        <div class="text-right mb-3">
            <a href="{{route('get-forget-password')}}">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-lg btn-block btn-primary mb-2" name="submit">Sign in</button>

    </form>


</div>
@endsection

