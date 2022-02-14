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
                        <div class="float-end mb-2 btn-group div-button-update">
                            <a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus" id="entri"
                                data-bs-toggle="modal" data-bs-target=".entri">
                                Tambah Kelas Santri</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" role="tab"
                                            onclick="ambil_data('SMP')">
                                            <span class="d-block d-sm-none">SMP</span>
                                            <span class="d-none d-sm-block">SMP</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" role="tab"
                                            onclick="ambil_data('SMA')">
                                            <span class="d-block d-sm-none">SMA</span>
                                            <span class="d-none d-sm-block">SMA</span>
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active mt-2" id="SMP" role="tabpanel">
                                        <table id="datatable"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="btn-group d-flex justify-content-center"><input
                                                                type="checkbox" class="form-check-input" id="allcheck">
                                                        </div>
                                                    </th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Kelas</th>
                                                    <th>NISN</th>
                                                    <th>Tahun Ajaran</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        <div class="btn-group d-flex justify-content-center"><input
                                                                type="checkbox" class="form-check-input" id="allcheck">
                                                        </div>
                                                    </th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Kelas</th>
                                                    <th>NISN</th>
                                                    <th>Tahun Ajaran</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                </div>

                <div class="modal fade entri" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Data Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <input type="hidden" id="no">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap</label>
                                                <select class="form-control select2" id="Username">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Plih Kelas</label>
                                                <select class="form-control select2" id="Kelas">
                                                    <?php foreach ($kelas as $key) : ?>
                                                    <option value="<?= $key->id ?>">
                                                        <?= $key->kelas . ' (' . $key->deskripsi . ')'; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary theme-bg gradient button-entri"
                                    id="button-entri">Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div class="modal fade editmodal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Data Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Plih Kelas</label>
                                                <select class="form-select" id="Kelas-Update">
                                                    <?php foreach ($kelas as $key) : ?>
                                                    <option value="<?= $key->id ?>">
                                                        <?= $key->kelas . ' (' . $key->deskripsi . ')'; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
function ambil_data(jenjang = null) {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $('#Username').find('option').remove().end();

    $('input:checkbox').prop('checked', this.value = 0);
    $('.div-button-update').html(
        '<a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus" id="entri" data-bs-toggle="modal" data-bs-target=".entri"> Tambah Kelas Santri</a>'
    );

    $.ajax({
        url: "<?= route_to('admin/data-classes-datatable') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'jenjang': jenjang
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
            $('#no').val(data.posts.length);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);

            for (let i = 0; i < data.profil.length; i++) {
                $('#Username').append('<option value="' + data.profil[i].profilid + '">' + data.profil[i]
                    .nama_lengkap + '  (' + data.profil[i].nisn + ')</option>')
            }
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
    ambil_data("SMP");
});
</script>

<script>
var santri_id = [];
var lu;
var no = 0;
$(document).ready(function() {
    $(document).on('change', '#allcheck', function() {
        $('input:checkbox').prop('checked', this.checked);
        no = $('#no').val();

        var lc = $('#check:checked').length;

        if ($(this).prop("checked") == true) {
            no = no - 1;
            lu = lc;
            if (lc > 0) {
                $('.div-button-update').html(
                    '<a href="javascript:void(0);" class="btn btn-outline-success fas fa-edit" id="editmodal" data-bs-toggle="modal" data-bs-target=".editmodal">Update Kelas Santri </a><a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus" id="entri" data-bs-toggle="modal" data-bs-target=".entri"> Tambah Kelas Santri</a>'
                );
            }

            for (let i = 1; i <= lc; i++) {
                santri_id[i - 1] = $('.check' + (i) + ':checked').attr('data-santri-id');
            }

            // console.log(santri_id);
        } else {
            no = 1;
            $('.div-button-update').html(
                '<a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus" id="entri" data-bs-toggle="modal" data-bs-target=".entri"> Tambah Kelas Santri</a>'
            );

            for (let i = 1; i <= lu; i++) {
                santri_id[i - 1] = null;
            }


        }
        console.log(santri_id);


    });

    $(document).on('change', 'input[type="checkbox"]', function() {
        $idsantri = $(this).attr('data-santri-id');
        $no = $(this).attr('data-no');

        if (this.checked) {
            no++;
            santri_id[$no - 1] = $idsantri;
            $('.div-button-update').html(
                '<a href="javascript:void(0);" class="btn btn-outline-success fas fa-edit" id="editmodal" data-bs-toggle="modal" data-bs-target=".editmodal">Update Kelas Santri </a><a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus" id="entri" data-bs-toggle="modal" data-bs-target=".entri"> Tambah Kelas Santri</a>'
            );
        } else {
            no--;
            if (no <= 0) {
                $('input:checkbox').prop('checked', this.value = 0);
                $('.div-button-update').html(
                    '<a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus" id="entri" data-bs-toggle="modal" data-bs-target=".entri"> Tambah Kelas Santri</a>'
                );
            }
            santri_id[$no - 1] = null;
        }
        console.log(santri_id);
        console.log(no);
    });
});
</script>

<script>
$(document).on('click', '#button-entri', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'userid': $('#Username').val(),
        'kelasid': $('#Kelas').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/add-data-classes') ?>",
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
            console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.error != undefined) {
                toastr.error(data.error);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.entri').modal('hide');
                ambil_data("SMP");
            }
        }
    });
});
</script>

<script>
$(document).on('click', '#button-update', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'santriid': santri_id,
        'kelasid': $('#Kelas-Update').val(),
    }

    console.log(data);
    $.ajax({
        url: "<?= route_to('admin/update-data-classes') ?>",
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
            $('#button-update').html('Submit');
        },
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.error != undefined) {
                toastr.error(data.error);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.editmodal').modal('hide');
                ambil_data();
            }
        }
    });
});
</script>

<script>
$(document).on('click', '#delete', function(e) {
    var data = {
        'profilid': $(this).attr('data-id'),
        'userid': $(this).attr('data-userid'),
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
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
                url: "<?= route_to('admin/delete-students') ?>",
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

<script src="<?= base_url(); ?>/assets/js/app.js"></script>

</body>

</html>