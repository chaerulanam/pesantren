<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <!-- plugin css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <?= $this->include('admin/partials/head-css') ?>

</head>

<?= $this->include('admin/partials/body') ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('admin/partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <?= $page_title ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="row mb-4">
                        <div class="col-xl-3">
                            <div class="card h-90">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="clearfix"></div>
                                        <div>
                                            <img src="/assets/images/users/<?= $profil->foto ?>" alt=""
                                                class="img-thumbnail rounded" height="100" width="150">
                                        </div>
                                        <h5 class="mt-3 mb-1"></h5>

                                    </div>

                                    <hr class="my-4">

                                    <div class="text-muted">
                                        <div class="table-responsive mt-4">
                                            <div>
                                                <p class="mb-1">Tentang Saya</p>
                                                <textarea class="form-control"
                                                    id="deskripsi"> <?= $profil->deskripsi ?> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-muted">
                                        <div class="table-responsive mt-2">
                                            <div>
                                                <p class="mb-1">username</p>
                                                <input type="tentang saya" class="form-control"
                                                    value="<?= $profil->username ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-muted">
                                        <div class="table-responsive mt-2">
                                            <div>
                                                <p class="mb-1">email</p>
                                                <input type="tentang saya" class="form-control"
                                                    value="<?= $profil->email ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-muted">
                                        <div class="table-responsive mt-4">
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light me-1"
                                                    id="button-update">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-print-none mt-4">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">Nama Lengkap</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->nama_lengkap ?>"
                                                                    placeholder="Nama Lengkap" id="nama_lengkap"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">Sekolah Asal</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->sekolah_asal ?>"
                                                                    id="sekolah_asal" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Jenis
                                                                Kelamin</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->jenis_kelamin ?>"
                                                                    id="jenis_kelamin" disabled>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">NISN</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="number"
                                                                    value="<?= $profil->nisn ?>" placeholder="NIK"
                                                                    id="nisn" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="tempat_lahir"
                                                                class="col-md-12 col-form-label">Tempat
                                                                Lahir</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    placeholder="Tempat Lahir"
                                                                    value="<?= $profil->tempat_lahir ?>"
                                                                    id="tempat_lahir" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="tanggal_lahir"
                                                                class="col-md-12 col-form-label">Tanggal
                                                                Lahir</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->tanggal_lahir ?>"
                                                                    id="tanggal_lahir" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">NIK</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="number"
                                                                    value="<?= $profil->nik ?>" placeholder=" NIK"
                                                                    id="nik" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">No
                                                                KK</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="number"
                                                                    value="<?= $profil->kk ?>" placeholder=" No KK"
                                                                    id="nokk" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Jenjang
                                                                Pendidikan</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->jenjang_pendidikan ?>"
                                                                    id="jenjang_pendidikan" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="basicpill-address-input">Alamat Lengkap</label>
                                                    <input id="basicpill-address-input" class="form-control"
                                                        value="<?= $profil->alamat_lengkap ?>" rows="2" id="alamat"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">Nama Ayah</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->nama_ayah ?>"
                                                                    placeholder="Nama Ayah" id="nama_ayah" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Pendidikan
                                                                Terakhir</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->pendidikan_ayah ?>"
                                                                    id="pendidikan_ayah" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Penghasilan Per
                                                                Bulan</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->penghasilan_ayah ?>"
                                                                    id="penghasilan_ayah" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Pekerjaan</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->pekerjaan_ayah ?>"
                                                                    id="pekerjaan_ayah" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">Nama Ibu</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->nama_ibu ?>"
                                                                    placeholder="Nama Ibu" id="nama_ibu" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Pendidikan
                                                                Terakhir</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->pendidikan_ibu ?>"
                                                                    id="pendidikan_ibu" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Penghasilan Per
                                                                Bulan</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->penghasilan_ibu ?>"
                                                                    id="penghasilan_ibu" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Pekerjaan</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->pekerjaan_ibu ?>"
                                                                    id="pekerjaan_ibu" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label">Nama Wali</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->nama_wali ?>" id="nama_wali"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Hubungan
                                                                Sosial</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->hubungan_sosial ?>"
                                                                    id="hubungan_sosial" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Penghasilan Per
                                                                Bulan</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->penghasilan_wali ?>"
                                                                    id="penghasilan_wali" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <div class="d-flex align-items-start mt-2">
                                                        <div class="mb-3 row">
                                                            <label class="col-md-12 col-form-label">Pekerjaan</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control" type="text"
                                                                    value="<?= $profil->pekerjaan_wali ?>"
                                                                    id="pekerjaan_wali" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?= $this->include('admin/partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?= $this->include('admin/partials/right-sidebar') ?>

    <?= $this->include('admin/partials/vendor-scripts') ?>

    <script src="<?= base_url(); ?>/assets/js/app.js"></script>

    </body>

</html>