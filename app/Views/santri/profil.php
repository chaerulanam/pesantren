<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.css">

    <!-- plugin css -->
    <link href="<?= base_url(); ?>/assetslibs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assetslibs/toastr/build/toastr.min.css">
    <!-- Sweet Alert-->
    <link href="<?= base_url(); ?>/assetslibs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="<?= base_url(); ?>/assetslibs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url(); ?>/assetslibs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url(); ?>/assetslibs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <?= $this->include('santri/partials/head-css') ?>

</head>

<?= $this->include('santri/partials/body') ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('santri/partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <?= $page_title ?>
                <?= csrf_field() ?>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card h-90">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="clearfix"></div>
                                    <div>
                                        <?php if ($myprofil->foto == "") : ?>
                                        <img src="/assets/images/users/default.png" alt="" class="img-thumbnail rounded"
                                            height="100" width="150">
                                        <?php else : ?>
                                        <img src="/assets/images/users/default.png" alt="" class="img-thumbnail rounded"
                                            height="100" width="150">
                                        <?php endif; ?>
                                    </div>
                                    <h5 class="mt-3 mb-1"></h5>

                                </div>

                                <hr class="my-4">

                                <div class="text-muted">
                                    <div class="table-responsive mt-4">
                                        <div>
                                            <p class="mb-1">Tentang Saya</p>
                                            <textarea class="form-control"
                                                id="deskripsi"> <?= $myprofil->deskripsi ?> </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-muted">
                                    <div class="table-responsive mt-2">
                                        <div>
                                            <p class="mb-1">username</p>
                                            <input type="tentang saya" class="form-control"
                                                value="<?= $myprofil->username ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-muted">
                                    <div class="table-responsive mt-2">
                                        <div>
                                            <p class="mb-1">email</p>
                                            <input type="tentang saya" class="form-control"
                                                value="<?= $myprofil->email ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-muted">
                                    <div class="table-responsive mt-4">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1"
                                                id="button-update">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
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
                                                                value="<?= $myprofil->nama_lengkap ?>"
                                                                placeholder="Nama Lengkap" id="nama_lengkap" disabled>
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
                                                                value="<?= $myprofil->sekolah_asal ?>" id="sekolah_asal"
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
                                                        <label class="col-md-12 col-form-label">Jenis
                                                            Kelamin</label>
                                                        <div class="col-md-10">
                                                            <input class="form-control" type="text"
                                                                value="<?= $myprofil->jenis_kelamin ?>"
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
                                                                value="<?= $myprofil->nisn ?>" placeholder="NIK"
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
                                                                value="<?= $myprofil->tempat_lahir ?>" id="tempat_lahir"
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
                                                        <label for="tanggal_lahir"
                                                            class="col-md-12 col-form-label">Tanggal
                                                            Lahir</label>
                                                        <div class="col-md-10">
                                                            <input class="form-control" type="text"
                                                                value="<?= $myprofil->tanggal_lahir ?>"
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
                                                                value="<?= $myprofil->nik ?>" placeholder=" NIK"
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
                                                                value="<?= $myprofil->kk ?>" placeholder=" No KK"
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
                                                                value="<?= $myprofil->jenjang_pendidikan ?>"
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
                                                    value="<?= $myprofil->alamat_lengkap ?>" rows="2" id="alamat"
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
                                                                value="<?= $myprofil->nama_ayah ?>"
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
                                                                value="<?= $myprofil->pendidikan_ayah ?>"
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
                                                                value="<?= $myprofil->penghasilan_ayah ?>"
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
                                                                value="<?= $myprofil->pekerjaan_ayah ?>"
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
                                                                value="<?= $myprofil->nama_ibu ?>"
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
                                                                value="<?= $myprofil->pendidikan_ibu ?>"
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
                                                                value="<?= $myprofil->penghasilan_ibu ?>"
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
                                                                value="<?= $myprofil->pekerjaan_ibu ?>"
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
                                                                value="<?= $myprofil->nama_wali ?>" id="nama_wali"
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
                                                                value="<?= $myprofil->hubungan_sosial ?>"
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
                                                                value="<?= $myprofil->penghasilan_wali ?>"
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
                                                                value="<?= $myprofil->pekerjaan_wali ?>"
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


        <?= $this->include('santri/partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('santri/partials/right-sidebar') ?>

<?= $this->include('santri/partials/vendor-scripts') ?>

<!-- toastr plugin -->
<script src="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.js"></script>

<script>
$(document).on('click', '#button-update', function(e) {

    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'id': <?= $myprofil->profilid; ?>,
        'deskripsi': $('#deskripsi').val(),
    }

    console.log(data);

    $.ajax({
        url: "<?= route_to('santri/profil-update') ?>",
        type: "POST",
        data: data,
        // global: false,
        // async: false,
        beforeSend: function() {
            $('#button-reset').removeAttr('disable');
            $('#button-reset').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function(e) {
            $('#button-reset').prop('disable', 'disable');
            $('#button-reset').html('Reset Password');
        },
        success: function(data) {
            // console.log(data);
            $('.password-edit').val('');
            $('.pass_confirm-edit').val('');
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.error != undefined) {
                toastr.error(data.error);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.passmodal').modal('hide');
                // ambil_data();
            }
        }

    });
});
</script>

<script src="<?= base_url(); ?>/assets/js/app.js"></script>

</body>

</html>