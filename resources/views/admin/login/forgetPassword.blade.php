@section('title')
    For Get Password
@endsection
@extends('admin.login.layoutlogin')
@section('content')
<div class="card-body">
    <form method="POST" novalidate action="{{route('forget-password')}}">
        @csrf
        <!-- title log -->
        @if (session('message'))
        <div class="alert alert-warning">
                {{session('message')}}
        </div>
        @endif
        @if (session('message_error'))
        <div class="alert alert-danger">
                {{session('message_error')}}
        </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="text-center">
            <div class="mb-5">
                <h1 class="display-4">Forgot your password</h1>
                <p>Already have an account? <a href="{{route('login')}}">Sign in here</a></p>
            </div>
            <a class="btn btn-lg btn-block btn-white mb-4" href="#">
            <span class="d-flex justify-content-center align-items-center">
                <img class="avatar avatar-gg mr-2" src="./public/img/logos/gg.png" alt="">
                Sign up with Google
            </span>
            </a>
        </div>
        <div class="form-group">
            <label class="input-label" for="signupEmail">EMAIL ADDRESS</label>
            <input type="email" class="form-control form-control-log" name="email" id="signupEmail" placeholder="Markwilliams@example.com" required="">
        </div>
        <button type="submit" class="btn btn-lg btn-block btn-primary mb-2" name="submit">Reset password</button>

    </form>


</div>
@endsection
