<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/admin" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?= base_url(); ?>/assets/images/logo-sm.png" alt="" height="20">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url(); ?>/assets/images/logo-dark.png" alt="" height="22">
            </span>
        </a>

        <a href="/admin" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?= base_url(); ?>/assets/images/logo-sm-light.png" alt="" height="20">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url(); ?>/assets/images/logo-light.png" alt="" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title"><?= lang('Files.Menu') ?></li>

                <li>
                    <a href="/admin">
                        <i class="uil-home-alt"></i><span class="badge rounded-pill bg-primary float-end">01</span>
                        <span><?= lang('Files.Dashboard') ?></span>
                    </a>
                </li>

                <li class="menu-title">Pengguna</li>
                <li>
                    <a href="/santri/profil" class="waves-effect">
                        <i class="uil-user"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li>
                    <a href="/santri/kelas" class="waves-effect">
                        <i class="uil-home"></i>
                        <span>Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="/santri/kamar" class="waves-effect">
                        <i class="uil-building"></i>
                        <span>Kamar</span>
                    </a>
                </li>
                <li class="menu-title">Keungan</li>

                <li>
                    <a href="/santri/tagihan" class="waves-effect">
                        <i class="uil-money-stack"></i>
                        <span>Tagihan</span>
                    </a>
                </li>

                <li class="menu-title">Akademik</li>

                <li>
                    <a href="/santri/kehadiran" class="waves-effect">
                        <i class="uil-list-ul"></i>
                        <span>Kehadiran</span>
                    </a>
                </li>

                <li>
                    <a href="/santri/nilai" class="waves-effect">
                        <i class="uil-sort-amount-down"></i>
                        <span>Nilai</span>
                    </a>
                </li>

                <li>
                    <a href="/santri/rangking" class="waves-effect">
                        <i class="uil-trophy"></i>
                        <span>Rangking</span>
                    </a>
                </li>

                <li class="menu-title">Non Akademik</li>

                <li>
                    <a href="/santri/kunjungan" class="waves-effect">
                        <i class="uil-navigator"></i>
                        <span>Kunjungan</span>
                    </a>
                </li>

                <li>
                    <a href="/santri/perizinan" class="waves-effect">
                        <i class="uil-clipboard-notes"></i>
                        <span>Perizinan</span>
                    </a>
                </li>

                <li>
                    <a href="/santri/pelanggaran" class="waves-effect">
                        <i class="uil-minus-circle"></i>
                        <span>Pelanggaran</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->