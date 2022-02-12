<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>AL-ISHLAH | Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Penerimaan Santri Baru Pesantren Al-Ishlah Tajug" name="description" />
    <meta content="anakkendali.com" name="author" />
    <link rel="shortcut icon" href="/assets/images/logo-sm.png">

    <?= $this->include('admin/partials/head-css') ?>

</head>

<body class="authentication-bg">

    <div class="account-pages my-5  pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div>

                        <a href="/" class="mb-5 d-block auth-logo">
                            <img src="assets/images/logo-dark.png" alt="" height="50" class="logo logo-dark">
                            <img src="assets/images/logo-light.png" alt="" height="50" class="logo logo-light">
                        </a>
                        <div class="card">

                            <div class="card-body p-4">

                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Reset Password</h5>
                                    <?= view('Myth\Auth\Views\_message_block') ?>
                                    <div class="alert alert-success text-center mb-4" role="alert">
                                        <p><?= lang('Auth.enterEmailForInstructions') ?></p>
                                    </div>
                                </div>
                                <div class="p-2 mt-4">

                                    <form action="<?= route_to('forgot') ?>" method="post">
                                        <?= csrf_field() ?>


                                        <div class="mb-3">
                                            <label for="email"><?= lang('Auth.emailAddress') ?></label>
                                            <input type="email"
                                                class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                                name="email" aria-describedby="emailHelp"
                                                placeholder="<?= lang('Auth.email') ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.email') ?>
                                            </div>
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button type="submit"
                                                class="btn btn-primary btn-block"><?= lang('Auth.sendInstructions') ?></button>
                                        </div>


                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Remember It ? <a href="login"
                                                    class="fw-medium text-primary"> Signin </a></p>
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
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <?= $this->include('admin/partials/vendor-scripts') ?>

    <script src="assets/js/app.js"></script>

</body>

</html>