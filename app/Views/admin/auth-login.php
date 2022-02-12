<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>AL-ISHLAH | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Penerimaan Santri Baru Pesantren Al-Ishlah Tajug" name="description" />
    <meta content="anakkendali.com" name="author" />
    <link rel="shortcut icon" href="/assets/images/logo-sm.png">

    <?= view('admin/partials/head-css') ?>

</head>

<body class="authentication-bg">

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="/" class="mb-5 d-block auth-logo">
                            <img src="assets/images/logo-dark.png" alt="" height="32" class="logo logo-dark">
                            <img src="assets/images/logo-light.png" alt="" height="32" class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-gradient-light">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Selamat Datang !</h5>
                                <p class="text-muted">Silakan masuk dengan menggunakan kredensial yang sudah diberikan.
                                </p>
                            </div>
                            <div class="p-2 mt-4">
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <form action="<?= route_to('login') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <?php if ($config->validFields === ['email']) : ?>
                                    <div class="mb-3">
                                        <label for="login"><?= lang('Auth.email') ?></label>
                                        <input type="email"
                                            class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                            name="login" placeholder="<?= lang('Auth.email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.login') ?>
                                        </div>
                                    </div>
                                    <?php else : ?>
                                    <div class="mb-3">
                                        <label for="login"><?= lang('Auth.emailOrUsername') ?></label>
                                        <input type="text"
                                            class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                            name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.login') ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <?php if ($config->activeResetter) : ?>
                                        <div class="float-end">
                                            <a
                                                href="<?= route_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                                        </div>
                                        <?php endif; ?>
                                        <label for="password"><?= lang('Auth.password') ?></label>
                                        <input type="password" name="password"
                                            class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                            placeholder="<?= lang('Auth.password') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    </div>


                                    <?php if ($config->allowRemembering) : ?>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="remember" class="form-check-input"
                                                <?php if (old('remember')) : ?> checked <?php endif ?>>
                                            <?= lang('Auth.rememberMe') ?>
                                        </label>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-secondary w-sm waves-effect waves-light"
                                            type="submit">Log
                                            In</button>
                                    </div>


                                    <!--
                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="font-size-14 mb-3 title">Sign in with</h5>
                                        </div>


                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="javascript:void()" class="social-list-item bg-primary text-white border-primary">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void()" class="social-list-item bg-info text-white border-info">
                                                    <i class="mdi mdi-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void()" class="social-list-item bg-danger text-white border-danger">
                                                    <i class="mdi mdi-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                        -->
                                    <div class="mt-4 text-center">
                                        <!-- <p class="mb-0">Don't have an account ? <a href="auth-register" class="fw-medium text-primary"> Signup now </a> </p> -->
                                        <?php if ($config->allowRegistration) : ?>
                                        <p class="mb-0">Belum punya akun ? <u><a class="link-dark"
                                                    href="<?= route_to('register') ?>">
                                                    Daftar Sekarang !</a></u></p>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p class="text-white">© <script>
                            document.write(new Date().getFullYear())
                            </script> Al-Ishlah. Dikembangkan oleh <i class="mdi mdi-heart text-danger"></i><a
                                class="link-warning" href="https://www.anakkendali.com" class="link-light">
                                anakkendali.com</p></a>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <?= view('admin/partials/vendor-scripts') ?>

    <script src="assets/js/app.js"></script>

</body>

</html>