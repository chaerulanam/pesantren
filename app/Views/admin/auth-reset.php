<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>AL-ISHLAH | Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <img src="assets/images/logo-dark.png" alt="" height="50" class="logo logo-dark">
                            <img src="assets/images/logo-light.png" alt="" height="50" class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-gradient-light">

                        <div class="card-body p-4">

                            <div class="text-center mt-2">
                                <h5 class="text-primary"><?= lang('Auth.resetYourPassword') ?></h5>
                                <p class="text-muted">
                                    <?= lang('Auth.enterCodeEmailPassword') ?></p>
                            </div>
                            <div class="p-2 mt-4">
                                <?= view('Myth\Auth\Views\_message_block') ?>

                                <form action="<?= route_to('reset-password') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <div class="mb-3">
                                        <label for="token"><?= lang('Auth.token') ?></label>
                                        <input type="text"
                                            class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>"
                                            name="token" placeholder="<?= lang('Auth.token') ?>"
                                            value="<?= old('token', $token ?? '') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.token') ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email"><?= lang('Auth.email') ?></label>
                                        <input type="email"
                                            class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                            name="email" aria-describedby="emailHelp"
                                            placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.email') ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password"><?= lang('Auth.newPassword') ?></label>
                                        <input type="password"
                                            class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                            name="password">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pass_confirm"><?= lang('Auth.newPasswordRepeat') ?></label>
                                        <input type="password"
                                            class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                            name="pass_confirm">
                                        <div class="invalid-feedback">
                                            <?= session('errors.pass_confirm') ?>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit"
                                            class="btn btn-primary btn-block"><?= lang('Auth.resetPassword') ?></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p class="text-white">© <script>
                            document.write(new Date().getFullYear())
                            </script> Al-Ishlah. Dikembangkan oleh <i class="mdi mdi-heart text-danger"></i><a
                                href="https://www.anakkendali.com" class="link-light"> anakkendali.com</p></a>
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