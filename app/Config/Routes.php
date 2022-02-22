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
	$routes->get('/', 'Dashboard::index', ['filter' => 'permission:dashboard.view']);
	$routes->get('index', 'Dashboard::index', ['filter' => 'permission:dashboard.view']);
	$routes->get('chart', 'Dashboard::chart', ['filter' => 'permission:dashboard.view']);
	$routes->get('datatable-pembayaran', 'Dashboard::chart', ['filter' => 'permission:dashboard.view']);
	$routes->get('datatable-pelanggar', 'Dashboard::chart', ['filter' => 'permission:dashboard.view']);
	$routes->get('datatable-absen', 'Dashboard::chart', ['filter' => 'permission:dashboard.view']);

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
	$routes->get('get-detail-students', 'ProfileStudents::get_detail', ['filter' => 'permission:manage.santri']);
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

	$routes->get('presences', 'Presences::index', ['filter' => 'permission:manage.guru']);
	$routes->get('presences-datatable', 'Presences::datatable', ['filter' => 'permission:manage.guru']);
	$routes->get('presences-datatable-absen', 'Presences::datatable_absen', ['filter' => 'permission:manage.guru']);
	// $routes->post('detail-presences', 'Presences::get_detail', ['filter' => 'permission:manage.guru']);
	$routes->post('add-presences', 'Presences::add', ['filter' => 'permission:manage.guru']);

	$routes->get('values', 'Values::index', ['filter' => 'permission:manage.guru']);
	$routes->get('values-datatable', 'Values::datatable', ['filter' => 'permission:manage.guru']);
	$routes->get('values-datatable-nilai', 'Values::datatable_nilai', ['filter' => 'permission:manage.guru']);
	// $routes->post('detail-values', 'Values::get_detail', ['filter' => 'permission:manage.guru']);
	$routes->post('add-values', 'Values::add', ['filter' => 'permission:manage.guru']);


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

	$routes->get('data-payments', 'DataPayments::index', ['filter' => 'permission:manage.bendahara']);
	$routes->get('data-payments-datatable', 'DataPayments::datatable', ['filter' => 'permission:manage.bendahara']);

	$routes->get('invoice', 'Invoice::index', ['filter' => 'permission:manage.bendahara']);

	$routes->get('data-billings-datatable-perindividu', 'DataBillings::datatable_perindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->get('detail-data-billings-perindividu', 'DataBillings::get_detailperindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->post('add-data-billings-perindividu', 'DataBillings::add_perindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->post('remove-data-billings-perindividu', 'DataBillings::delete_perindividu', ['filter' => 'permission:manage.bendahara']);
	$routes->post('update-data-billings-perindividu', 'DataBillings::update_perindividu', ['filter' => 'permission:manage.bendahara']);

	$routes->get('data-expenditure', 'DataExpenditures::index', ['filter' => 'permission:manage.bendahara']);
	$routes->get('data-expenditure-datatable', 'DataExpenditures::datatable', ['filter' => 'permission:manage.bendahara']);
	$routes->get('detail-data-expenditure', 'DataExpenditures::get_detail', ['filter' => 'permission:manage.bendahara']);
	$routes->post('add-data-expenditure', 'DataExpenditures::add', ['filter' => 'permission:manage.bendahara']);
	$routes->post('remove-data-expenditure', 'DataExpenditures::delete', ['filter' => 'permission:manage.bendahara']);
	$routes->post('update-data-expenditure', 'DataExpenditures::update', ['filter' => 'permission:manage.bendahara']);

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

	$routes->get('data-permission', 'DataPermissions::index', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('data-permission-datatable', 'DataPermissions::datatable', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('detail-data-permission', 'DataPermissions::get_detail', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('add-data-permission', 'DataPermissions::add', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('remove-data-permission', 'DataPermissions::delete', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('update-data-permission', 'DataPermissions::update', ['filter' => 'permission:manage.pengasuhan']);

	$routes->get('data-visitation', 'DataVisitations::index', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('data-visitation-datatable', 'DataVisitations::datatable', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('detail-data-visitation', 'DataVisitations::get_detail', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('add-data-visitation', 'DataVisitations::add', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('remove-data-visitation', 'DataVisitations::delete', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('update-data-visitation', 'DataVisitations::update', ['filter' => 'permission:manage.pengasuhan']);

	$routes->get('data-violation', 'DataViolations::index', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('data-violation-datatable', 'DataViolations::datatable', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('detail-data-violation', 'DataViolations::get_detail', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('add-data-violation', 'DataViolations::add', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('remove-data-violation', 'DataViolations::delete', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('update-data-violation', 'DataViolations::update', ['filter' => 'permission:manage.pengasuhan']);

	$routes->get('master-room', 'MasterRooms::index', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('master-room-datatable', 'MasterRooms::datatable', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('detail-master-room', 'MasterRooms::get_detail', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('add-master-room', 'MasterRooms::add', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('remove-master-room', 'MasterRooms::delete', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('update-master-room', 'MasterRooms::update', ['filter' => 'permission:manage.pengasuhan']);

	$routes->get('data-room', 'DataRooms::index', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('data-room-datatable', 'DataRooms::datatable', ['filter' => 'permission:manage.pengasuhan']);
	$routes->get('detail-data-room', 'DataRooms::get_detail', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('add-data-room', 'DataRooms::add', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('remove-data-room', 'DataRooms::delete', ['filter' => 'permission:manage.pengasuhan']);
	$routes->post('update-data-room', 'DataRooms::update', ['filter' => 'permission:manage.pengasuhan']);
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