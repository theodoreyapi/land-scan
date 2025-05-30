<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="AptioTalent - permet d'avoir des talents en toute sécurité">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="AptioTech - www.aptiotech.com">
    <meta name="robots" content="noindex, nofollow">
    <title>AptioTalent - {{ __('messages.signin') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('') }}assets/img/favicon.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('') }}assets/img/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap.min.css">

    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/icons/feather/feather.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">

</head>

<body class="bg-white">

    <div id="global-loader" style="display: none;">
        <div class="page-loader"></div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
                <div class="row">
                    @include('auth.left')
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                            <div class="col-md-7 mx-auto vh-100">
                                <form action="{{ url('custom-login') }}" class="vh-100" method="POST" role="form">
                                    @csrf
                                    <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
                                        <div class=" mx-auto mb-5 text-center">
                                            <img src="{{ URL::asset('') }}assets/img/logo.svg" class="img-fluid"
                                                alt="Logo">
                                        </div>
                                        <div class="">
                                            <div class="text-center mb-3">
                                                <h2 class="mb-2">Se connecter</h2>
                                                <p class="mb-0">
                                                    Veuillez saisir vos coordonnées pour vous connecter
                                                </p>
                                            </div>
                                            @include('layouts.status')
                                            <div class="mb-3">
                                                <label class="form-label">Adresse email</label>
                                                <div class="input-group">
                                                    <input name="email" type="email" required
                                                        class="form-control border-end-0">
                                                    <span class="input-group-text border-start-0">
                                                        <i class="ti ti-mail"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mot de passe</label>
                                                <div class="pass-group">
                                                    <input name="password" required type="password"
                                                        class="pass-input form-control">
                                                    <span class="ti toggle-password ti-eye-off"></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-check-md mb-0">
                                                        <input name="souvenir" checked class="form-check-input"
                                                            id="remember_me" type="checkbox">
                                                        <label for="remember_me"
                                                            class="form-check-label mt-0">Souviens-toi de moi</label>
                                                    </div>
                                                </div>
                                                {{-- <div class="text-end">
                                                    <a href="{{ url('forgot') }}" class="link-danger">
                                                        Mot de passe oublié?
                                                    </a>
                                                </div> --}}
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    Se connecter
                                                </button>
                                            </div>
                                            {{-- <div class="text-center">
                                                <h6 class="fw-normal text-dark mb-0">
                                                    Vous n'avez pas de compte?
                                                    <a href="{{ url('register') }}" class="hover-a">
                                                        Créer un compte
                                                    </a>
                                                </h6>
                                            </div> --}}
                                        </div>
                                        @include('auth.footer')
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ URL::asset('') }}assets/js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ URL::asset('') }}assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Icon JS -->
    <script src="{{ URL::asset('') }}assets/js/feather.min.js"></script>

    ◊<!-- Select2 JS -->
    <script src="{{ URL::asset('') }}assets/plugins/select2/js/select2.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>

</body>

</html>
