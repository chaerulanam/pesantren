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

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if ($myprofil != null) : ?>
                    <?php if ($myprofil->foto == "") : ?>
                    <img class="rounded-circle header-profile-user"
                        src="<?= base_url(); ?>/assets/images/users/default.png" alt="Header Avatar">
                    <?php else : ?>
                    <img class="rounded-circle header-profile-user"
                        src="<?= base_url(); ?>/assets/images/users/<?= $myprofil->foto; ?>" alt=" Header Avatar">
                    <?php endif; ?>
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
                    <a class="dropdown-item" href="/santri/profil"><i
                            class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span
                            class="align-middle"><?= lang('Files.View Profile') ?></span></a>
                    <a class="dropdown-item" href="/logout"><i
                            class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span
                            class="align-middle"><?= lang('Files.Sign out') ?></span></a>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <div class="topnav">

            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="/admin">
                                <i class="uil-home-alt me-2"></i> <?= lang('Files.Dashboard') ?>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button">
                                <i class="uil-user me-2"></i>Pengguna<div class="arrow-down">
                                </div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-sm"
                                aria-labelledby="topnav-uielement">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="/santri/profil" class="dropdown-item">Profil</a>
                                            <a href="/santri/kelas" class="dropdown-item">Kelas</a>
                                            <a href="/santri/kamar" class="dropdown-item">Kamar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button">
                                <i class="uil-money-stack me-2"></i>Keuangan<div class="arrow-down">
                                </div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-sm"
                                aria-labelledby="topnav-uielement">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="/santri/tagihan" class="dropdown-item">Tagihan</a>
                                            <a href="/santri/emoney" class="dropdown-item">E-Money</a>
                                            <a href="/santri/isisaldo" class="dropdown-item">Isi Saldo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                <i class="uil-sort-amount-down me-2"></i>Akademik<div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-sm"
                                aria-labelledby="topnav-uielement">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="/santri/kehadiran" class="dropdown-item">Kehadiran</a>
                                            <a href="/santri/nilai" class="dropdown-item">Nilai dan Rangking</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                <i class="uil-clipboard-notes me-2"></i>Non Akademik<div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-sm"
                                aria-labelledby="topnav-uielement">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="/santri/kunjungan" class="dropdown-item">Kunjungan</a>
                                            <a href="/santri/perizinan" class="dropdown-item">Perizinan</a>
                                            <a href="/santri/pelanggaran" class="dropdown-item">Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </div>

</header>