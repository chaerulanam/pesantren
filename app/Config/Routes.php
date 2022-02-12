<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('admin', 'Dashboard::index', ['filter' => 'permission:dashboard.view']);

$routes->group('admin', function ($routes) {

	$routes->get('index', 'Dashboard::index', ['filter' => 'permission:dashboard.view']);
	$routes->get('data-users', 'Users::index', ['filter' => 'permission:manage.users']);
	$routes->get('data-users-datatable', 'Users::datatable', ['filter' => 'permission:manage.users']);
	$routes->get('data-users-detail', 'Users::get_detail', ['filter' => 'permission:manage.users']);
	$routes->post('data-users-add', 'Users::attemptRegister', ['filter' => 'permission:manage.users']);
	$routes->post('data-users-import', 'Users::import', ['filter' => 'permission:manage.users']);
	$routes->post('data-users-edit', 'Users::edit', ['filter' => 'permission:manage.users']);
	$routes->post('data-users-delete', 'Users::delete', ['filter' => 'permission:manage.users']);
	$routes->post('data-users-reset-password', 'Users::attemptReset', ['filter' => 'permission:manage.users']);

	$routes->get('management-users', 'ManagementUsers::index', ['filter' => 'role:superadmin']);
	$routes->get('management-users-datatable', 'ManagementUsers::datatable', ['filter' => 'role:superadmin']);
	$routes->post('management-users-add', 'ManagementUsers::addgroupstopermission', ['filter' => 'role:superadmin']);
	$routes->post('management-users-remove', 'ManagementUsers::removegroupstopermission', ['filter' => 'role:superadmin']);

	$routes->get('data-students', 'ProfileStudents::index', ['filter' => 'permission:manage.santri']);
	$routes->get('data-students-datatable', 'ProfileStudents::datatable', ['filter' => 'permission:manage.santri']);
	$routes->get('detail-students', 'ProfileDetails::index', ['filter' => 'permission:manage.santri']);
	$routes->post('add-students', 'ProfileStudents::add', ['filter' => 'permission:manage.santri']);
	$routes->post('setuser-students', 'ProfileStudents::setusersprofil', ['filter' => 'permission:manage.santri']);
	$routes->post('update-students', 'ProfileStudents::update', ['filter' => 'permission:manage.santri']);
	$routes->post('delete-students', 'ProfileStudents::delete', ['filter' => 'permission:manage.santri']);

	$routes->get('data-teachers', 'ProfileTeachers::index', ['filter' => 'permission:manage.guru']);
	$routes->get('data-teachers-datatable', 'ProfileTeachers::datatable', ['filter' => 'permission:manage.guru']);
	$routes->get('detail-teachers', 'ProfileDetails::index', ['filter' => 'permission:manage.guru']);
	$routes->post('add-teachers', 'ProfileTeachers::add', ['filter' => 'permission:manage.guru']);
	$routes->post('setuser-teachers', 'ProfileTeachers::setusersprofil', ['filter' => 'permission:manage.guru']);
	$routes->post('update-teachers', 'ProfileTeachers::update', ['filter' => 'permission:manage.guru']);
	$routes->post('delete-teachers', 'ProfileTeachers::delete', ['filter' => 'permission:manage.guru']);

	$routes->get('master-billings', 'MasterBillings::index', ['filter' => 'permission:manage.bendahara']);
	$routes->get('master-billings-datatable', 'MasterBillings::datatable', ['filter' => 'permission:manage.bendahara']);
	$routes->post('add-master-billings', 'MasterBillings::add', ['filter' => 'permission:manage.bendahara']);
	$routes->post('remove-master-billings', 'MasterBillings::delete', ['filter' => 'permission:manage.bendahara']);

	$routes->get('master-classes', 'MasterClasses::index', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('master-classes-datatable', 'MasterClasses::datatable', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('detail-master-classes', 'MasterClasses::get_detail', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('update-master-classes', 'MasterClasses::update', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('add-master-classes', 'MasterClasses::add', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('remove-master-classes', 'MasterClasses::delete', ['filter' => 'permission:manage.pengajaran']);

	$routes->get('master-schedules', 'MasterSchedules::index', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('master-schedules-datatable', 'MasterSchedules::datatable', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('add-master-schedules', 'MasterSchedules::add', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('remove-master-schedules', 'MasterSchedules::delete', ['filter' => 'permission:manage.pengajaran']);

	$routes->get('master-lessons', 'MasterLessons::index', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('master-lessons-datatable', 'MasterLessons::datatable', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('add-master-lessons', 'MasterLessons::add', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('remove-master-lessons', 'MasterLessons::delete', ['filter' => 'permission:manage.pengajaran']);

	$routes->get('school-years', 'MasterYears::index', ['filter' => 'permission:manage.admin']);
	$routes->get('master-years-datatable', 'MasterYears::datatable', ['filter' => 'permission:manage.admin']);
	$routes->get('detail-master-years', 'MasterYears::get_detail', ['filter' => 'permission:manage.admin']);
	$routes->post('add-master-years', 'MasterYears::add', ['filter' => 'permission:manage.admin']);
	$routes->post('remove-master-years', 'MasterYears::delete', ['filter' => 'permission:manage.admin']);
	$routes->post('update-master-years', 'MasterYears::update', ['filter' => 'permission:manage.admin']);

	$routes->get('data-billings', 'DataBillings::index', ['filter' => 'permission:manage.bendahara']);
	$routes->get('data-billings-datatable-perkelas', 'DataBillings::datatable_perkelas', ['filter' => 'permission:manage.bendahara']);
	$routes->get('detail-data-billings-perkelas', 'DataBillings::get_detailperkelas', ['filter' => 'permission:manage.bendahara']);
	$routes->post('add-data-billings-perkelas', 'DataBillings::add_perkelas', ['filter' => 'permission:manage.bendahara']);
	$routes->post('remove-data-billings-perkelas', 'DataBillings::delete_perkelas', ['filter' => 'permission:manage.bendahara']);
	$routes->post('update-data-billings-perkelas', 'DataBillings::update_perkelas', ['filter' => 'permission:manage.bendahara']);
	$routes->get('getclass', 'DataBillings::getclassandbillings', ['filter' => 'permission:manage.bendahara']);
	$routes->get('getnama', 'DataBillings::getnama', ['filter' => 'permission:manage.bendahara']);


	$routes->get('data-billings-datatable-perindividu', 'DataBillings::datatable_perindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->get('detail-data-billings-perindividu', 'DataBillings::get_detailperindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->post('add-data-billings-perindividu', 'DataBillings::add_perindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->post('remove-data-billings-perindividu', 'DataBillings::delete_perindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->post('update-data-billings-perindividu', 'DataBillings::update_perindividu', ['filter' => 'permission:manage.bendahara']);

	$routes->get('data-classes', 'DataClasses::index', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('data-classes-datatable', 'DataClasses::datatable', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('detail-data-classes', 'DataClasses::get_detail', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('add-data-classes', 'DataClasses::add', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('remove-data-classes', 'DataClasses::delete', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('update-data-classes', 'DataClasses::update', ['filter' => 'permission:manage.pengajaran']);

	$routes->get('data-lessons-schedules', 'DataScheduleLessons::index', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('data-lessons-schedules-datatable', 'DataScheduleLessons::datatable', ['filter' => 'permission:manage.pengajaran']);
	$routes->get('detail-data-lessons-schedules', 'DataScheduleLessons::get_detail', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('add-data-lessons-schedules', 'DataScheduleLessons::add', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('remove-data-lessons-schedules', 'DataScheduleLessons::delete', ['filter' => 'permission:manage.pengajaran']);
	$routes->post('update-data-lessons-schedules', 'DataScheduleLessons::update', ['filter' => 'permission:manage.pengajaran']);
});

$routes->group('santri', function ($routes) {
	$routes->get('/', 'Santri/Dashboard::index', ['filter' => 'permission:manage.santri']);
	$routes->get('profil', 'Santri/Dashboard::profil', ['filter' => 'permission:manage.santri']);
	$routes->post('profil-update', 'Santri/Dashboard::update', ['filter' => 'permission:manage.santri']);

	$routes->get('tagihan', 'Santri/Tagihan::index', ['filter' => 'permission:manage.santri']);
	$routes->get('tagihan-datatable', 'Santri/Tagihan::datatable', ['filter' => 'permission:manage.santri']);
	$routes->post('tagihan-bayar', 'Santri/Tagihan::pay', ['filter' => 'permission:manage.santri']);
	$routes->post('tagihan-invoice', 'Santri/Tagihan::invoice', ['filter' => 'permission:manage.santri']);
	$routes->get('tagihan-datatable-pembayaran', 'Santri/Tagihan::datatable_pembayaran', ['filter' => 'permission:manage.santri']);
	$routes->post('tagihan-add', 'Santri/Tagihan::add', ['filter' => 'permission:manage.santri']);
	$routes->post('tagihan-proses', 'Santri/Tagihan::proses', ['filter' => 'permission:manage.santri']);

	$routes->get('invoice', 'Santri/Invoice::index', ['filter' => 'permission:manage.santri']);
});

$routes->post('/update-notifikasi-midtrans', 'Santri/Tagihan::notifikasi');




$routes->get('/lang/{locale}', 'Language::index');

//Layout page routing
$routes->get('layouts-horizontal', 'Home::show_layouts_horizontal');
$routes->get('layouts-hori-topbar-dark', 'Home::show_layouts_hori_topbar_dark');
$routes->get('layouts-hori-boxed-width', 'Home::show_layouts_hori_boxed_width');
$routes->get('layouts-hori-preloader', 'Home::show_layouts_hori_preloader');
$routes->get('layouts-vertical', 'Home::show_layouts_vertical');
$routes->get('layouts-dark-sidebar', 'Home::show_layouts_dark_sidebar');
$routes->get('layouts-compact-sidebar', 'Home::show_layouts_compact_sidebar');
$routes->get('layouts-icon-sidebar', 'Home::show_layouts_icon_sidebar');
$routes->get('layouts-boxed', 'Home::show_layouts_boxed');
$routes->get('layouts-preloader', 'Home::show_layouts_preloader');
$routes->get('layouts-colored-sidebar', 'Home::show_layouts_colored_sidebar');

//App page routing
$routes->get('calendar', 'AppController::show_calendar');
$routes->get('chat', 'AppController::show_chat');

$routes->get('ecommerce-products', 'AppController::show_ecommerce_products');
$routes->get('ecommerce-product-detail', 'AppController::show_ecommerce_product_detail');
$routes->get('ecommerce-orders', 'AppController::show_ecommerce_orders');
$routes->get('ecommerce-customers', 'AppController::show_ecommerce_customers');
$routes->get('ecommerce-cart', 'AppController::show_ecommerce_cart');
$routes->get('ecommerce-checkout', 'AppController::show_ecommerce_checkout');
$routes->get('ecommerce-shops', 'AppController::show_ecommerce_shops');
$routes->get('ecommerce-add-product', 'AppController::show_ecommerce_add_product');

$routes->get('email-inbox', 'AppController::show_email_inbox');
$routes->get('email-read', 'AppController::show_email_read');
$routes->get('invoices-list', 'AppController::show_invoices_list');
$routes->get('invoices-detail', 'AppController::show_invoices_detail');
$routes->get('contacts-grid', 'AppController::show_contacts_grid');
$routes->get('contacts-list', 'AppController::show_contacts_list');
$routes->get('contacts-profile', 'AppController::show_contacts_profile');

//Pages section routing
$routes->get('auth-login', 'PageController::show_auth_login');
$routes->get('auth-register', 'PageController::show_auth_register');
$routes->get('auth-recoverpw', 'PageController::show_auth_recoverpw');
$routes->get('auth-lock-screen', 'PageController::show_auth_lock_screen');

$routes->get('pages-starter', 'PageController::show_pages_starter');
$routes->get('pages-maintenance', 'PageController::show_pages_maintenance');
$routes->get('pages-comingsoon', 'PageController::show_pages_comingsoon');
$routes->get('pages-timeline', 'PageController::show_pages_timeline');
$routes->get('pages-faqs', 'PageController::show_pages_faqs');
$routes->get('pages-pricing', 'PageController::show_pages_pricing');
$routes->get('pages-404', 'PageController::show_pages_404');
$routes->get('pages-500', 'PageController::show_pages_500');

//Component section routing
$routes->get('ui-alerts', 'ComponentController::show_ui_alerts');
$routes->get('ui-buttons', 'ComponentController::show_ui_buttons');
$routes->get('ui-cards', 'ComponentController::show_ui_cards');
$routes->get('ui-carousel', 'ComponentController::show_ui_carousel');
$routes->get('ui-dropdowns', 'ComponentController::show_ui_dropdowns');
$routes->get('ui-grid', 'ComponentController::show_ui_grid');
$routes->get('ui-images', 'ComponentController::show_ui_images');
$routes->get('ui-lightbox', 'ComponentController::show_ui_lightbox');
$routes->get('ui-modals', 'ComponentController::show_ui_modals');
$routes->get('ui-rangeslider', 'ComponentController::show_ui_rangeslider');
$routes->get('ui-session-timeout', 'ComponentController::show_ui_session_timeout');
$routes->get('ui-progressbars', 'ComponentController::show_ui_progressbars');
$routes->get('ui-sweet-alert', 'ComponentController::show_ui_sweet_alert');
$routes->get('ui-tabs-accordions', 'ComponentController::show_ui_tabs_accordions');
$routes->get('ui-typography', 'ComponentController::show_ui_typography');
$routes->get('ui-placeholders', 'ComponentController::show_ui_placeholders');
$routes->get('ui-toasts', 'ComponentController::show_ui_toasts');
$routes->get('ui-video', 'ComponentController::show_ui_video');
$routes->get('ui-general', 'ComponentController::show_ui_general');
$routes->get('ui-colors', 'ComponentController::show_ui_colors');
$routes->get('ui-rating', 'ComponentController::show_ui_rating');
$routes->get('ui-notifications', 'ComponentController::show_ui_notifications');
$routes->get('ui-offcanvas', 'ComponentController::show_ui_offcanvas');


$routes->get('form-elements', 'ComponentController::show_form_elements');
$routes->get('form-validation', 'ComponentController::show_form_validation');
$routes->get('form-advanced', 'ComponentController::show_form_advanced');
$routes->get('form-editors', 'ComponentController::show_form_editors');
$routes->get('form-uploads', 'ComponentController::show_form_uploads');
$routes->get('form-xeditable', 'ComponentController::show_form_xeditable');
$routes->get('form-repeater', 'ComponentController::show_form_repeater');
$routes->get('form-wizard', 'ComponentController::show_form_wizard');
$routes->get('form-mask', 'ComponentController::show_form_mask');

$routes->get('tables-basic', 'ComponentController::show_tables_basic');
$routes->get('tables-datatable', 'ComponentController::show_tables_datatable');
$routes->get('tables-responsive', 'ComponentController::show_tables_responsive');
$routes->get('tables-editable', 'ComponentController::show_tables_editable');

$routes->get('charts-apex', 'ComponentController::show_charts_apex');
$routes->get('charts-chartjs', 'ComponentController::show_charts_chartjs');
$routes->get('charts-flot', 'ComponentController::show_charts_flot');
$routes->get('charts-knob', 'ComponentController::show_charts_knob');
$routes->get('charts-sparkline', 'ComponentController::show_charts_sparkline');

$routes->get('icons-unicons', 'ComponentController::show_icons_unicons');
$routes->get('icons-boxicons', 'ComponentController::show_icons_boxicons');
$routes->get('icons-materialdesign', 'ComponentController::show_icons_materialdesign');
$routes->get('icons-dripicons', 'ComponentController::show_icons_dripicons');
$routes->get('icons-fontawesome', 'ComponentController::show_icons_fontawesome');

$routes->get('maps-google', 'ComponentController::show_maps_google');
$routes->get('maps-vector', 'ComponentController::show_maps_vector');
$routes->get('maps-leaflet', 'ComponentController::show_maps_leaflet');


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}