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
                    <form class="theme-form login-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <h4>Register New User</h4>
                        <h6>Welcome to IPMS.</h6>
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
                            <label>{{ __('Name') }}</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="name" id="name" :value="old('name')" required autofocus  autocomplete="name" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="lastname" id="lastname" :value="old('lastname')" required autofocus  autocomplete="lastname" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>User Level</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="level" id="level" :value="old('level')" required autofocus  autocomplete="level" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>User Department</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="department" id="department" :value="old('department')" required autofocus  autocomplete="department" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>User Branch</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="branch" id="branch" :value="old('branch')" required autofocus  autocomplete="branch" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>User Private Identification Digit</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="pid" id="pid" :value="old('pid')" required autofocus  autocomplete="pid" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Mobile</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-mobile"></i></span>
                                <input class="form-control" type="text" name="mobile" id="mobile" :value="old('mobile')" required autofocus  autocomplete="mobile" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>National Code</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="nacode" id="nacode" :value="old('nacode')" required autofocus  autocomplete="nacode" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Extension</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-mobile"></i></span>
                                <input class="form-control" type="text" name="ext" id="ext" :value="old('ext')" required autofocus  autocomplete="ext" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                <input class="form-control" type="text" name="email" id="email" :value="old('email')" required autofocus  autocomplete="email" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                <input class="form-control" type="password" name="password" id="password" :value="old('password')" required autofocus  autocomplete="password" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required  autocomplete="password" />
                            </div>
                        </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block col-12" value="Register">
                        </div>
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
