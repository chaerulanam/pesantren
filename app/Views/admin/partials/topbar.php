<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= base_url(); ?>/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url(); ?>/assets/images/logo-dark.png" alt="" height="20">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url(); ?>/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url(); ?>/assets/images/logo-light.png" alt="" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="<?= lang('Files.Search') ?>">
                    <span class="uil-search"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?= lang('Files.Search') ?>"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if ($myprofil != null) : ?>
                    <img class="rounded-circle header-profile-user"
                        src="<?= base_url(); ?>/assets/images/users/<?= $myprofil->foto; ?>" alt="Header Avatar">
                    <span
                        class="d-none d-xl-inline-block ms-1 fw-medium font-size-15"><?= $myprofil->nama_lengkap; ?></span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                    <?php else : ?>
                    <img class="rounded-circle header-profile-user"
                        src="<?= base_url(); ?>/assets/images/users/default.png" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15"><?= user()->username; ?></span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                    <?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="detail-teachers?username=<?= user()->username; ?>"><i
                            class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span
                            class="align-middle"><?= lang('Files.View Profile') ?></span></a>
                    <a class="dropdown-item" href="#"><i
                            class="uil uil-wallet font-size-18 align-middle me-1 text-muted"></i> <span
                            class="align-middle"><?= lang('Files.My Wallet') ?></span></a>
                    <a class="dropdown-item" href="/auth-lock-screen"><i
                            class="uil uil-lock-alt font-size-18 align-middle me-1 text-muted"></i> <span
                            class="align-middle"><?= lang('Files.Lock screen') ?></span></a>
                    <a class="dropdown-item" href="/logout"><i
                            class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span
                            class="align-middle"><?= lang('Files.Sign out') ?></span></a>
                </div>
            </div>

        </div>
    </div>
</header>