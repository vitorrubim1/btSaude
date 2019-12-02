<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>BT Profissionais | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app-modern.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-modern-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body class="auth-fluid-pages pb-0">

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-left">
                            <a href="{{url("/")}}">
                                <span><img src="https://brasiltelemedicina.com.br/wp-content/uploads/2016/07/brasiltelemedicina.png" alt="" height="100"></span>
                            </a>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0">Entrar</h4>
                        {{-- <p class="text-muted mb-4">Enter your email address and password to access account.</p> --}}

                        <!-- form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="emailaddress">Email</label>
                                <input class="form-control" type="email" id="emailaddress" required="" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <a href="{{ route('password.request') }}" class="text-muted float-right"><small>Esqueceu sua senha?</small></a>
                                <label for="password">Senha</label>
                                <input name="password" class="form-control" type="password" required="" id="password" placeholder="Senha">
                            </div>
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="checkbox-signin">
                                    <label class="custom-control-label" for="checkbox-signin">Lembrar-me</label>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-login"></i> Entrar </button>
                            </div>
                            <!-- social-->
                            
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">
                            <p class="text-muted">Não tem uma conta? <a href="{{url('register')}}" class="text-muted ml-1"><b>Cadastrar</b></a></p>
                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <h2 class="mb-3">A tecnologia que avança nós usamos para aproximar!</h2>
                    {{-- <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent templete. I love it very much! . <i class="mdi mdi-format-quote-close"></i> --}}
                    </p>
                    <p>
                        {{-- - Hyper Admin User --}}
                    </p>
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>

    </body>

</html>
