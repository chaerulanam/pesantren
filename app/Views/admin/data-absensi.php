<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <!-- plugin css -->
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
                                    <div class="col-md-4 mb-2">
                                        <label for="tahun">Filter Tahun Ajaran</label>
                                        <select id="tahun" class="form-select" onchange="ambil_data();">
                                            <option value=>-Pilih Tahun-</option>
                                            <?php foreach ($alltahun as $key) : ?>
                                            <option><?= $key->tahun; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="kelas">Filter Kelas</label>
                                        <select id="kelas" class="form-control select2" onchange="getnama()">
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="nama_lengkap">Filter Nama Lengkap</label>
                                        <select id="nama_lengkap" class="form-control select2" onchange="getmapel();">
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="mapel">Filter Mata Pelajaran</label>
                                        <select id="mapel" class="form-control select2" onchange="ambil_data();">
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="tanggal">Filter Tanggal</label>
                                        <input type="date" id="tanggal" class="form-control" onchange="ambil_data();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap & Kelas</th>
                                            <th>Nama Pelajaran</th>
                                            <th>Jadwal Pelajaran</th>
                                            <th>Total Masuk</th>
                                            <th>Status</th>
                                            <th>Waktu</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                </div>

                <div class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="absen" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Status Kehadiran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="kelas">Kelas</label>
                                        <input type="text" class="form-control" id="edit-kelas" disabled>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="edit-nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="edit-nama_lengkap" disabled>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="edit-mapel">Mata Pelajaran</label>
                                        <input type="text" class="form-control" id="edit-mapel" disabled>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="edit-tanggal">Tanggal</label>
                                        <input type="date" id="edit-tanggal" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="state">Status</label>
                                        <select class="form-select" id="state">
                                            <option>Hadir</option>
                                            <option>Izin</option>
                                            <option>Tidak Hadir</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary theme-bg gradient button-update"
                                    id="button-update">Update</button>
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

<!-- Sweet Alerts js -->
<script src="<?= base_url(); ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- jquery step -->
<script src="<?= base_url(); ?>/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<!-- toastr plugin -->
<script src="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.js"></script>
<!-- Datatable init js -->
<!-- plugins -->
<script src="<?= base_url(); ?>/assets/libs/select2/js/select2.min.js"></script>
<!-- init js -->
<script>
! function($) {
    "use strict";

    var AdvancedForm = function() {};

    AdvancedForm.prototype.init = function() {

            // Select2
            $(".select2").select2({
                // dropdownParent: $('.entri')
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

    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'tahun': $('#tahun').val(),
        'kelas': $('#kelas').val(),
        'nama_lengkap': $('#nama_lengkap').val(),
        'mapel': $('#mapel').val(),
        'tanggal': $('#tanggal').val(),
    }
    console.log(data);
    $.ajax({
        url: "<?= route_to('admin/data-presences-datatable') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: data,
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
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
    getclass();
});
</script>

<script>
function getclass() {
    $('#kelas').find('option').remove().end();

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
            $('#kelas').append('<option value=>-Select-</option>');
            for (let i = 0; i < data.kelas.length; i++) {
                $('#kelas').append('<option value="' + data.kelas[i].id + '">' + data.kelas[i]
                    .kelas + '  (' +
                    data.kelas[i].deskripsi + ')</option>');

            }
        }
    });
}

function getnama() {
    $('#nama_lengkap').find('option').remove().end();
    $.ajax({
        url: "<?= route_to('admin/getnama') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'kelas': $('#kelas').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#nama_lengkap').append('<option value=>-Select-</option>');
            for (let i = 0; i < data.nama.length; i++) {
                $('#nama_lengkap').append('<option value="' + data.nama[i].userid + '">' + data.nama[i]
                    .nama_lengkap + '</option>');
            }
        }
    });
}

function getmapel() {
    $('#mapel').find('option').remove().end();
    $.ajax({
        url: "<?= route_to('admin/mapel-data-presences') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'userid': $('#nama_lengkap').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#mapel').append('<option value=>-Select-</option>');
            for (let i = 0; i < data.mapel.length; i++) {
                $('#mapel').append('<option value="' + data.mapel[i].pelajaranid + '">' + data
                    .mapel[i]
                    .nama_pelajaran + '</option>');
            }
        }
    });
}
</script>

<script>
$(document).on('click', '#edit', function(e) {

    $('#id').val($(this).attr('data-id'));
    $('#edit-kelas').val($(this).attr('data-kelas'));
    $('#edit-nama_lengkap').val($(this).attr('data-nama'));
    $('#edit-mapel').val($(this).attr('data-mapel'));
    $('#edit-tanggal').val($(this).attr('data-tanggal'));
});

$(document).on('click', '#button-update', function(e) {
    var data = {
        'id': $('#id').val(),
        'nama': $('#edit-nama_lengkap').val(),
        'status': $('#state').val(),
    };

    console.log(data);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, update it!"
    }).then(function(result) {
        if (result.value) {

            // console.log(data);
            $.ajax({
                url: "<?= route_to('admin/update-data-presences') ?>",
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
                        Swal.fire("Updated!", data.success, "success");
                        $('.edit').modal('hide');
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