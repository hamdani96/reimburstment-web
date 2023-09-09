
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Login</title>
        <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
        <meta content="Themesdesign" name="author" />

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">

    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="home-btn d-none d-sm-block">
                {{-- <a href="#!" class="text-white"><i class="fas fa-home h2"></i></a> --}}
            </div>
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">

                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                            {{-- <a href="#!" class="logo logo-admin"><img src="{{ asset('media/logo/logo-indohomecare.png') }}" alt="" height="24"></a> --}}
                        </div>
                        <h5 class="font-18 text-center">Masuk Untuk Melanjutkan</h5>
                        {{-- <h6 class="font-14 text-center">Website Customer Service Indohomecare</h6> --}}

                        <form class="form-horizontal m-t-30" autocomplete="off" action="{{ route('authenticate') }}" method="POST"> @csrf

                            <div class="form-group">
                                <div class="col-12">
                                    <label>NIP</label>
                                    <input type="number" name="nip" class="form-control form-control-lg @error('nip') is-invalid @enderror" id="nip" placeholder="NIP">
                                    @error('nip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/waves.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

    </body>

</html>
