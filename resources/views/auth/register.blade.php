<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>BT Profissionais | Cadastro</title>
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
                            <a href="index.html">
                                <span><img src="https://brasiltelemedicina.com.br/wp-content/uploads/2016/07/brasiltelemedicina.png" alt="" height="50"></span>
                            </a>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0">Cadastro</h4>
                        {{-- <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute</p> --}}

                        <!-- form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="fullname">Nome</label>
                                <input name="name" class="form-control" type="text" id="fullname" placeholder="Nome" required>
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">Email</label>
                                <input name="email" class="form-control" type="email" id="emailaddress" required placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input name="password" class="form-control" type="password" required id="password" placeholder="Senha">
                            </div>
                            <div class="form-group">
                                <label for="password">Confirmar Senha</label>
                                <input name="password_confirmation" class="form-control" type="password" required id="password" placeholder="Confirmar Senha">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                    <label class="custom-control-label" for="checkbox-signup">Eu aceito os <a href="javascript: void(0);" class="text-muted">Termos e Condições</a></label>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-account-circle"></i> Cadastrar </button>
                            </div>
                            
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">
                            <p class="text-muted">Já possui uma conta? <a href="{{url("login")}}" class="text-muted ml-1"><b>Login</b></a></p>
                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <h2 class="mb-3">A solução para ampliar o acesso à saúde especializada!</h2>
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

