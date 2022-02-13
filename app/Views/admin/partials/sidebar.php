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
                <img src="<?= base_url(); ?>/assets/images/logo-sm-light.png" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url(); ?>/assets/images/logo-light.png" alt="" height="50" width="180">
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

                <li class="menu-title"><?= lang('Files.Users') ?></li>
                <li>
                    <a href="/admin/data-users" class="waves-effect">
                        <i class="uil-user"></i>
                        <span><?= lang('Files.Users') ?></span>
                    </a>
                </li>
                <li>
                    <a href="/admin/management-users" class="waves-effect">
                        <i class="fas fa-user-cog"></i>
                        <span><?= lang('Files.Management Users') ?></span>
                    </a>
                </li>

                <li class="menu-title"><?= lang('Files.Profile') ?></li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-user-square"></i>
                        <span><?= lang('Files.Profile') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <?php if (has_permission('manage.santri')) : ?>
                        <li><a href="/admin/data-students"><?= lang('Files.Students') ?></a></li>
                        <?php endif; ?>
                        <?php if (has_permission('manage.guru')) : ?>
                        <li><a href="/admin/data-teachers"><?= lang('Files.Teachers') ?></a></li>
                        <?php endif; ?>
                        <?php if (has_permission('manage.alumni')) : ?>
                        <li><a href="/admin/data-graduates"><?= lang('Files.Graduates') ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="menu-title"><?= lang('Files.Sections') ?></li>
                <?php if (has_permission('manage.bendahara')) : ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-money-stack"></i>
                        <span><?= lang('Files.Treasurer') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/data-billings"><?= lang('Files.Data Billings') ?></a></li>
                        <li><a href="/admin/data-payments"><?= lang('Files.Data Payments') ?></a></li>
                        <li><a href="/admin/master-billings"><?= lang('Files.Master Billings') ?></a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span><?= lang('Files.Transaction') ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/admin/top-up"><?= lang('Files.Top Up') ?></a></li>
                                <li><a href="/admin/request-top-up"><?= lang('Files.Request Top Up') ?></a></li>
                                <li><a href="/admin/transaction"><?= lang('Files.Transaction') ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (has_permission('manage.pengasuhan')) : ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-users-alt"></i>
                        <span><?= lang('Files.Parenting') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/data-breach"><?= lang('Files.Data Breach') ?></a></li>
                        <li><a href="/admin/data-permission"><?= lang('Files.Data Permission') ?></a></li>
                        <li><a href="/admin/data-visitation"><?= lang('Files.Data Visitation') ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (has_permission('manage.pengajaran')) : ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-comment-alt-info"></i>
                        <span><?= lang('Files.Instruction') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/data-classes"><?= lang('Files.Data Classes') ?></a></li>
                        <li><a href="/admin/master-classes"><?= lang('Files.Master Classes') ?></a></li>
                        <li><a href="/admin/data-lessons-schedules"><?= lang('Files.Data Lessons Schedules') ?></a></li>
                        <li><a href="/admin/master-lessons"><?= lang('Files.Master Lessons') ?></a></li>
                        <li><a href="/admin/master-schedules"><?= lang('Files.Master Schedules') ?></a></li>
                        <li><a href="/admin/data-attendences"><?= lang('Files.Data Attendences') ?></a></li>
                        <li><a href="/admin/data-values-ranks"><?= lang('Files.Data Values and Ranks') ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (has_permission('manage.kesehatan')) : ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-heartbeat"></i>
                        <span><?= lang('Files.Health') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/data-treasurer"><?= lang('Files.Treasurer') ?></a></li>
                        <li><a href="/admin/data-parenting"><?= lang('Files.Parenting') ?></a></li>
                        <li><a href="/admin/data-instruction"><?= lang('Files.Instruction') ?></a></li>
                        <li><a href="/admin/data-health"><?= lang('Files.Health') ?></a></li>
                        <li><a href="/admin/data-language"><?= lang('Files.Language') ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (has_permission('manage.guru')) : ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-tie"></i>
                        <span><?= lang('Files.Teachers') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/presences"><?= lang('Files.Attendances Schedules Lessons') ?></a>
                        </li>
                        <li><a href="/admin/values-lessons"><?= lang('Files.Values Lessons') ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (has_permission('manage.author')) : ?>
                <li class="menu-title"><?= lang('Files.Blog') ?></li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-pen"></i>
                        <span><?= lang('Files.Posts') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/data-posts"><?= lang('Files.Data Posts') ?></a>
                        </li>
                        <li><a href="/admin/add-new-posts"><?= lang('Files.Add New') ?></a></li>
                        <li><a href="/admin/categories"><?= lang('Files.Categories') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="far fa-copy"></i>
                        <span><?= lang('Files.Pages') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/data-pages"><?= lang('Files.Data Pages') ?></a>
                        </li>
                        <li><a href="/admin/add-new-pages"><?= lang('Files.Add New') ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/comments-posts" class="waves-effect">
                        <i class="uil-comments"></i>
                        <span><?= lang('Files.Comments') ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (has_permission('manage.admin')) : ?>
                <li class="menu-title"><?= lang('Files.Settings') ?></li>
                <li>
                    <a href="/admin/site-identity" class="waves-effect">
                        <i class="uil-globe"></i>
                        <span><?= lang('Files.Site Identity') ?></span>
                    </a>
                </li>
                <li>
                    <a href="/admin/school-years" class="waves-effect">
                        <i class="uil-clipboard-blank"></i>
                        <span><?= lang('Files.School Years') ?></span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->