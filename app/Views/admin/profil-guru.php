<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <!-- plugin css -->
    <link href="<?= base_url(); ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.css">
    <!-- Sweet Alert-->
    <link href="<?= base_url(); ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="<?= base_url(); ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url(); ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url(); ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

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

                <!--  Large modal example -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title"><?= $title_table ?></h4>
                                        <p class="card-title-desc">
                                        </p>
                                    </div>
                                    <?php if (has_permission('manage.admin')) : ?>
                                    <div class="col-md-8">
                                        <div class="float-end btn-group">
                                            <a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus"
                                                id="entri" data-bs-toggle="modal" data-bs-target=".entri">
                                                Tambah Guru</a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary fas fa-upload"
                                                id="entricsv" data-bs-toggle="modal" data-bs-target=".entricsv">
                                                Upload</a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Jenjang Pendidikan</th>
                                            <th>TTL</th>
                                            <th>Foto</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Jenjang Pendidikan</th>
                                            <th>TTL</th>
                                            <th>Foto</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div class="modal fade entri" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form teachers</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <?= view('App\Views\admin\form-teachers'); ?>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!--  Large modal example -->
                <div class="modal fade entricsv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Import Guru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6>Import Dengan CSV</h6>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input file" id="file">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary theme-bg gradient" id="button-import">Yes,
                                    Import!</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!--  Large modal example -->
                <div class="modal fade setusername" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Set Username</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="profil_id">
                                <select class="form-select select2" id="user_set">
                                    <option value=>-Select-</option>
                                    <?php foreach ($users as $key) : ?>
                                    <option value="<?= $key->userid; ?>"><?= $key->username; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary theme-bg gradient"
                                    id="button-setusername">Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

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

<!-- Required datatable js -->
<script src="<?= base_url(); ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url(); ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="<?= base_url(); ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- select2 -->
<script src="<?= base_url(); ?>/assets/libs/select2/js/select2.min.js"></script>

<!-- Init js -->
<script src="<?= base_url(); ?>/assets/js/pages/form-advanced.init.js"></script>
<!-- Sweet Alerts js -->
<script src="<?= base_url(); ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- jquery step -->
<script src="<?= base_url(); ?>/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<!-- toastr plugin -->
<script src="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.js"></script>


<!-- Datatable init js -->
<script>
function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('admin/data-teachers-datatable') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            console.log(data);
            $('#no').val(data.posts.length);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.responce == "success") {
                $("#datatable").DataTable({
                    "destroy": true,
                    "data": data.posts,
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "columnDefs": [{
                        "targets": [0],
                        "orderable": false,
                    }],
                    "language": {
                        "emptyTable": "Tidak ada data tagihan"
                    },
                    "buttons": [{
                            extend: 'copy',
                            text: 'Copy to clipboard'
                        },
                        'excel',
                        'pdf'
                    ],
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo(
                    '#datatable_wrapper .col-md-6:eq(0)');
            } else {

            }
        }
    });
}
$(document).ready(function() {
    ambil_data();
});
</script>

<script>
$(document).ready(function() {
    function add() {
        console.log($('#user_id').val());
        let foto = $('#foto').prop('files')[0];
        let fd = new FormData();
        fd.append('user_id', $('#user_id').val());
        fd.append('nama_lengkap', $('#nama_lengkap').val());
        fd.append('sekolah_asal', $('#sekolah_asal').val());
        fd.append('jenis_kelamin', $('#jenis_kelamin').val());
        fd.append('nisn', $('#nisn').val());
        fd.append('nik', $('#nik').val());
        fd.append('no_kk', $('#no_kk').val());
        fd.append('jenjang_pendidikan', $('#jenjang_pendidikan').val());
        fd.append('tempat_lahir', $('#tempat_lahir').val());
        fd.append('tanggal_lahir', $('#tanggal_lahir').val());
        fd.append('alamat', $('#alamat').val());
        fd.append('desa', $('#desa :selected').text());
        fd.append('kecamatan', $('#kecamatan :selected').text());
        fd.append('kabupaten', $('#kabupaten :selected').text());
        fd.append('provinsi', $('#provinsi :selected').text());
        fd.append('no_hp', $('#no_hp').val());
        fd.append('foto', foto);
        fd.append('nama_ayah', $('#nama_ayah').val());
        fd.append('pendidikan_ayah', $('#pendidikan_ayah').val());
        fd.append('pekerjaan_ayah', $('#pekerjaan_ayah').val());
        fd.append('penghasilan_ayah', $('#penghasilan_ayah').val());
        fd.append('nama_ibu', $('#nama_ibu').val());
        fd.append('pekerjaan_ibu', $('#pekerjaan_ibu').val());
        fd.append('pendidikan_ibu', $('#pendidikan_ibu').val());
        fd.append('penghasilan_ibu', $('#penghasilan_ibu').val());
        fd.append('nama_wali', $('#nama_wali').val());
        fd.append('hubungan_sosial', $('#hubungan_sosial').val());
        fd.append('pekerjaan_wali', $('#pekerjaan_wali').val());
        fd.append('penghasilan_wali', $('#penghasilan_wali').val());
        fd.append('csrf_token_name', $('input[name=csrf_token_name]').val());
        $.ajax({
            type: "post",
            url: "<?= route_to('admin/add-teachers') ?>",
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                $('input[name=csrf_token_name]').val(data.csrf_token_name);
                if (data.user_id != undefined) {
                    toastr.error(data.user_id);
                } else if (data.nama_lengkap != undefined) {
                    toastr.error(data.nama_lengkap);
                } else if (data.sekolah_asal != undefined) {
                    toastr.error(data.sekolah_asal);
                } else if (data.jenis_kelamin != undefined) {
                    toastr.error(data.jenis_kelamin);
                } else if (data.tempat_lahir != undefined) {
                    toastr.error(data.tempat_lahir);
                } else if (data.tanggal_lahir != undefined) {
                    toastr.error(data.tanggal_lahir);
                } else if (data.alamat != undefined) {
                    toastr.error(data.alamat);
                } else if (data.desa != undefined) {
                    toastr.error(data.desa);
                } else if (data.kecamatan != undefined) {
                    toastr.error(data.kecamatan);
                } else if (data.kabupaten != undefined) {
                    toastr.error(data.kabupaten);
                } else if (data.provinsi != undefined) {
                    toastr.error(data.provinsi);
                } else if (data.no_hp != undefined) {
                    toastr.error(data.no_hp);
                } else if (data.foto != undefined) {
                    toastr.error(data.foto);
                } else if (data.nama_ayah != undefined) {
                    toastr.error(data.nama_ayah);
                } else if (data.pendidikan_ayah != undefined) {
                    toastr.error(data.pendidikan_ayah);
                } else if (data.pekerjaan_ayah != undefined) {
                    toastr.error(data.pekerjaan_ayah);
                } else if (data.penghasilan_ayah != undefined) {
                    toastr.error(data.penghasilan_ayah);
                } else if (data.nama_ibu != undefined) {
                    toastr.error(data.nama_ibu);
                } else if (data.pendidikan_ibu != undefined) {
                    toastr.error(data.pendidikan_ibu);
                } else if (data.pekerjaan_ibu != undefined) {
                    toastr.error(data.pekerjaan_ibu);
                } else if (data.penghasilan_ibu != undefined) {
                    toastr.error(data.penghasilan_ibu);
                } else if (data.error != undefined) {
                    Swal.fire("Failed!", data.error, "error");
                    location.reload();
                } else if (data.success != undefined) {
                    Swal.fire("Submited!", data.success, "success");
                    location.reload();
                }
            },
            error: function(error) {
                console.log("Error:");
                console.log(error);
            }
        });
    }
    $("#mystep").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        preloadContent: true,
        labels: {
            finish: "Submit",
        },
        onFinished: function() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, submit it!"
            }).then(function(result) {
                if (result.value) {
                    add();
                }
            });
        },
    });
});
</script>

<script>
function preview() {
    var file = $("input[type=file]").get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function() {
            $("#preview").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}
$(document).ready(function() {


});
</script>

<script>
$(document).ready(function() {
    $.ajax({
        method: "get",
        url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
        success: function(data) {
            // console.log(data[1]);
            ldata = data.length;
            for (let i = 0; i < ldata; i++) {
                $('#provinsi').append('<option value=' + data[i].id + '>' + data[i].name +
                    '</option>')
            }
        }
    });


});

function getKabupaten() {
    $('#kabupaten').find('option').remove().end()
    $('#kecamatan').find('option').remove().end()
    var idprov = $('#provinsi').val();
    // console.log($('#provinsi :selected').text());
    $.ajax({
        method: "get",
        url: "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/" + idprov + ".json",
        success: function(data) {
            $('#kabupaten').append('<option value=>Select</option>');
            ldata = data.length;
            for (let i = 0; i < ldata; i++) {
                $('#kabupaten').append('<option value=' + data[i].id + '>' + data[i].name + '</option>')
            }
        }
    });
}

function getkecamatan() {
    var idkota = $('#kabupaten').val();
    $('#kecamatan').find('option').remove().end()
    $.ajax({
        method: "get",
        url: "https://www.emsifa.com/api-wilayah-indonesia/api/districts/" + idkota + ".json",
        success: function(data) {
            $('#kecamatan').append('<option value=>Select</option>');
            ldata = data.length;
            for (let i = 0; i < ldata; i++) {
                $('#kecamatan').append('<option value=' + data[i].id + '>' + data[i].name + '</option>')
            }
        }
    });
}

function getdesa() {
    var idkec = $('#kecamatan').val();
    $('#desa').find('option').remove().end()
    $.ajax({
        method: "get",
        url: "https://www.emsifa.com/api-wilayah-indonesia/api/villages/" + idkec + ".json",
        success: function(data) {
            $('#desa').append('<option value=>Select</option>');
            ldata = data.length;
            for (let i = 0; i < ldata; i++) {
                $('#desa').append('<option value=' + data[i].id + '>' + data[i].name + '</option>')
            }
        }
    });
}
</script>

<script>
$(document).on('click', '#delete', function(e) {
    var data = {
        'profilid': $(this).attr('data-id'),
        'userid': $(this).attr('data-userid')
    }
    console.log(data);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, delete it!"
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: "<?= route_to('admin/delete-teachers') ?>",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: data,
                type: "post",
                dataType: "json",
                method: "post",
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    if (data.error != undefined) {
                        Swal.fire("Failed!", data.error, "error");
                    } else if (data.success != undefined) {
                        Swal.fire("Deleted!", data.success, "success");
                        ambil_data();
                    }
                }
            });
        }
    });
});
</script>

<script>
$(document).on('click', '#setusername', function(e) {
    $('#profil_id').val($(this).attr('data-id'));
});

$(document).on('click', '#button-setusername', function(e) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, submit it!"
    }).then(function(result) {
        if (result.value) {
            var data = {
                'user_id': $('#user_set').val(),
                'profil_id': $('#profil_id').val(),
                'csrf_token_name': $('input[name=csrf_token_name]').val()
            };
            console.log(data);
            $.ajax({
                url: "<?= route_to('admin/setuser-teachers') ?>",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: data,
                type: "post",
                dataType: "json",
                method: "post",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    if (data.error != undefined) {
                        Swal.fire("Failed!", data.error, "error");
                    } else if (data.success != undefined) {
                        Swal.fire("Deleted!", data.success, "success");
                        $('.setusername').modal('hide');
                        ambil_data();
                    }
                }
            });
        }
    });
});
</script>

<script src="<?= base_url(); ?>/assets/js/app.js"></script>

</body>

</html>