<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.desc').' - '.config('app.desc2') }}">
    <meta name="keywords" content="{{ config('app.keywords') }}">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="theme/viho/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="theme/viho/assets/images/favicon.png" type="image/x-icon">
    <title>{{ config('app.name').' - '.config('app.desc') }}</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/style.css">
    <link id="color" rel="stylesheet" href="theme/viho/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="theme/viho/assets/css/responsive.css">
</head>
<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="theme/viho/assets/images/login/1.jpg" alt="looginpage"></div>
            <div class="col-xl-7 p-0">
                <div class="login-card">
                    <form class="theme-form login-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h4>Forgot your password?</h4>
                        <h6>{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </h6>
                        @if (session('status'))
                            <div class="alert alert-primary">
                                {{ session('status') }}
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


                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                <input class="form-control" type="email" name="email" id="email" :value="old('email')" autofocus  required="" placeholder="ipms@tie-co.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block col-12" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page-wrapper end-->
<!-- latest jquery-->
<script src="theme/viho/assets/js/jquery-3.5.1.min.js"></script>
<!-- feather icon js-->
<script src="theme/viho/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="theme/viho/assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="theme/viho/assets/js/sidebar-menu.js"></script>
<script src="theme/viho/assets/js/config.js"></script>
<!-- Bootstrap js-->
<script src="theme/viho/assets/js/bootstrap/popper.min.js"></script>
<script src="theme/viho/assets/js/bootstrap/bootstrap.min.js"></script>
<!-- Plugins JS start-->
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="theme/viho/assets/js/script.js"></script>
<!-- login js-->
<!-- Plugin used-->
</body>
</html>
