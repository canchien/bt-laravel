
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="http://localhost/BT-mvc/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="https://htmlstream.com/front-dashboard/favicon.ico">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <div class="main">
        <div class="bg-img">

        </div>
        <div class="container py-5" >
            <a class="d-flex justify-content-center mb-5 position-relative" href="#">
                <img class="" src="./public/img/logos/logo.svg" alt="" style="width: 8rem;">
            </a>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card card-sign mb-5">
                        @yield('content')
                    </div>
                    <div class="text-center">
                        <small class="text-footer">Trusted by the world's best teams</small>
                        <div class="w-85 mt-4">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <img class="img-fluid" src="https://htmlstream.com/front-dashboard/assets/svg/brands/gitlab-gray.svg" alt="">
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="https://htmlstream.com/front-dashboard/assets/svg/brands/fitbit-gray.svg" alt="">
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="https://htmlstream.com/front-dashboard/assets/svg/brands/flow-xo-gray.svg" alt="">
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="https://htmlstream.com/front-dashboard/assets/svg/brands/layar-gray.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="./public/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
