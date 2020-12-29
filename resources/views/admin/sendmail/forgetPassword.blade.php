
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{asset('https://htmlstream.com/front-dashboard/favicon.ico')}}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css')}}">


    <link rel="stylesheet" href="{{asset('https://use.fontawesome.com/releases/v5.6.3/css/all.css')}}">

    <link href="{{asset('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin_asset/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('admin_asset/css/styleNews.css')}}">
</head>
<body>
    <h3>Hi,</h3>
    <h3 style="padding:0; font-size:30px; color:#218838; margin-bottom: 20px;">Reset your password</h3>
    <a href="{{$data['content']}}" style="color: #fff; background-color: #218838; width: auto; padding: 1rem; font-size:15px; text-decoration: none; margin-bottom: 20px">Reset password</a>

    <script src="{{asset('admin_asset/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('https://code.jquery.com/jquery-3.5.1.slim.min.js')}}" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="{{asset('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js')}}" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="{{asset('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{asset('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('admin_asset/js/main.js')}}"></script>
    <script>
    </script>
    @yield('script')
</body>
</html>
