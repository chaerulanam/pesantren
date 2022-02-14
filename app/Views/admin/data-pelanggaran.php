<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mt-2 col-6">
                                            <select class="form-select" id="tahun" onchange="ambil_data()">
                                                <option value="">-Filter Tahun-</option>
                                                <?php foreach ($alltahun as $key) : ?>
                                                <option><?= $key->tahun; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-2">
                                        <div class="float-end btn-group">
                                            <a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus"
                                                data-bs-toggle="modal" data-bs-target=".entri">
                                                Tambah Pelanggaran</a>
                                        </div>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap & Kelas</th>
                                            <th>Nama Pelanggaran</th>
                                            <th>Hukuman</th>
                                            <th>Status</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div><!-- end card-body -->
                        </div><!-- end card -->

                        <div class="modal fade entri" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Pelanggaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Plih Kelas</label>
                                                        <select class="form-select" id="Kelas" onchange="getnama();">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <select class="form-control select2" id="Nama-Lengkap">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Pelanggaran</label>
                                                        <input type="text" class="form-control" id="Nama-Pelanggaran">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Hukuman</label>
                                                        <input type="text" class="form-control" id="Hukuman">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary theme-bg gradient"
                                            id="button-entri">Submit</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Pelanggaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas</label>
                                                        <input type="text" class="form-control" id="Kelas-Edit"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" id="Nama-Lengkap-Edit" class="form-control"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Pelanggaran</label>
                                                        <input type="text" class="form-control"
                                                            id="Nama-Pelanggaran-Edit" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-select" id="state" onchange="getnama();">
                                                            <option value="0">Sudah Selesai</option>
                                                            <option value="1">Belum Selesai</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="id">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary theme-bg gradient"
                                            id="button-update">Submit</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
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

<!-- Sweet Alerts js -->
<script src="<?= base_url(); ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- jquery step -->
<script src="<?= base_url(); ?>/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<!-- toastr plugin -->
<script src="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.js"></script>

<!-- plugins -->
<script src="<?= base_url(); ?>/assets/libs/select2/js/select2.min.js"></script>

<script>
! function($) {
    "use strict";

    var AdvancedForm = function() {};

    AdvancedForm.prototype.init = function() {

            // Select2
            $(".select2").select2({
                dropdownParent: $('.entri')
            });

            $(".select2-limiting").select2({
                maximumSelectionLength: 2
            });

            $(".select2-search-disable").select2({
                minimumResultsForSearch: Infinity
            });
        },
        //init
        $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),


//Datepicker
function($) {
    "use strict";
    $.AdvancedForm.init();
}(window.jQuery);
</script>

<script>
function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('admin/data-violation-datatable') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'tahun': $('#tahun').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
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
                        "emptyTable": "Tidak ada data"
                    },
                    "buttons": [{
                            extend: 'copy',
                            text: 'Copy to clipboard'
                        },
                        'excel',
                        'pdf'
                    ],
                    "buttons": ["csv", "excel", "pdf"]
                }).buttons().container().appendTo(
                    '#datatable_wrapper .col-md-6:eq(0)');
            } else {

            }
        }
    });
}

$(document).ready(function() {
    getclass();
    ambil_data();
});
</script>

<script>
function getclass() {
    $('#Kelas').find('option').remove().end();

    $.ajax({
        url: "<?= route_to('admin/getclass') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            for (let i = 0; i < data.kelas.length; i++) {
                $('#Kelas').append('<option value="' + data.kelas[i].id + '">' + data.kelas[i]
                    .kelas + '  (' +
                    data.kelas[i].deskripsi + ')</option>');
                $('#Kelas-Perindividu').append('<option value="' + data.kelas[i].id + '">' + data.kelas[i]
                    .kelas + '  (' +
                    data.kelas[i].deskripsi + ')</option>');
            }

            for (let i = 0; i < data.tagihan.length; i++) {

                $('#Tagihan-Perkelas').append('<option value="' + data.tagihan[i].id + '">' + data.tagihan[
                        i]
                    .nama_tagihan + '  (' +
                    data.tagihan[i].deskripsi + ')</option>');
                $('#Tagihan-Perindividu').append('<option value="' + data.tagihan[i].id + '">' + data
                    .tagihan[
                        i]
                    .nama_tagihan + '  (' +
                    data.tagihan[i].deskripsi + ')</option>');
            }
        }
    });
}

function getnama() {
    $('#Nama-Lengkap').find('option').remove().end();
    $.ajax({
        url: "<?= route_to('admin/getnama') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'kelas': $('#Kelas').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            for (let i = 0; i < data.nama.length; i++) {
                $('#Nama-Lengkap').append('<option value="' + data.nama[i].profilid + '">' + data.nama[i]
                    .nama_lengkap + '</option>');
            }
        }
    });
}
</script>

<script type="text/javascript">
var rupiah = document.getElementById('Nominal');
rupiah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, 'Rp ');
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
}
</script>

<script>
$(document).on('click', '#button-entri', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'kelas': $('#Kelas').val(),
        'profil': $('#Nama-Lengkap').val(),
        'nama_pelanggaran': $('#Nama-Pelanggaran').val(),
        'hukuman': $('#Hukuman').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/add-data-violation') ?>",
        type: "POST",
        data: data,
        // global: false,
        // async: false,
        beforeSend: function() {
            $('#button-entri').removeAttr('disable');
            $('#button-entri').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function(e) {
            $('#button-entri').prop('disable', 'disable');
            $('#button-entri').html('Submit');
        },
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.profil != undefined) {
                toastr.error(data.profil);
            } else if (data.nama_pelanggaran != undefined) {
                toastr.error(data.nama_pelanggaran);
            } else if (data.hukuman != undefined) {
                toastr.error(data.hukuman);
            } else if (data.error != undefined) {
                toastr.error(data.error);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.entri').modal('hide');
                ambil_data();
            }
        }
    });
});

$(document).on('click', '#button-delete', function(e) {
    var data = {
        'id': $(this).attr('data-id'),
        'csrf_token_name': $('input[name=csrf_token_name]').val()
    };
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

            // console.log(data);
            $.ajax({
                url: "<?= route_to('admin/remove-data-violation') ?>",
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

$(document).on('click', '#edit', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'id': $(this).attr("data-id"),
    }

    $.ajax({
        url: "<?= route_to('admin/detail-data-violation') ?>",
        type: "GET",
        data: data,
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#Kelas-Edit').val(data.kelas);
            $('#Nama-Lengkap-Edit').val(data.nama_lengkap);
            $('#Nama-Pelanggaran-Edit').val(data.nama_pelanggaran);
            $('#id').val(data.id);
            $('#state').val(data.status);
        }
    });
});

$(document).on('click', '#button-update', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'id': $('#id').val(),
        'status': $('#state').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/update-data-violation') ?>",
        type: "POST",
        data: data,
        // global: false,
        // async: false,
        beforeSend: function() {
            $('#button-update').removeAttr('disable');
            $('#button-update').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function(e) {
            $('#button-update').prop('disable', 'disable');
            $('#button-update').html('Update');
        },
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.error != undefined) {
                toastr.error(data.error);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.edit').modal('hide');
                ambil_data();
            }
        }
    });
});
</script>

<script src="<?= base_url(); ?>/assets/js/app.js"></script>

</body>

</html>