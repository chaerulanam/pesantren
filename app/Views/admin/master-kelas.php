<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/libs/toastr/build/toastr.min.css">
    <!-- Sweet Alert-->
    <link href="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
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
                                    <div class="col-md-6">
                                        <h4 class="card-title"><?= $title_table ?></h4>
                                        <p class="card-title-desc">
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="float-end button-checkout">
                                            <div class="btn-group">
                                                <a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus"
                                                    id="entrimanual" data-bs-toggle="modal"
                                                    data-bs-target=".entrimanual">
                                                    Tambah Baru</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kelas</th>
                                            <th>Deskripsi</th>
                                            <th>Wali Kelas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kelas</th>
                                            <th>Deskripsi</th>
                                            <th>Wali Kelas</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="modal fade entrimanual" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Tambah Master Kelas
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group c_form_group">
                                                    <label>Kelas</label>
                                                    <input type="text" class="form-control email" id="Kelas" name=""
                                                        placeholder="Kelas">
                                                </div>
                                                <div class="form-group c_form_group">
                                                    <label>Deskripsi</label>
                                                    <input type="text" class="form-control" id="Deskripsi"
                                                        placeholder="Deskripsi">
                                                </div>
                                                <div class="form-group c_form_group">
                                                    <label class="col-md-2 col-form-label">Wali Kelas</label>
                                                    <div class="col-md-10">
                                                        <select class="form-select" id="Wali-Kelas">
                                                            <?php foreach ($wali as $key) : ?>
                                                            <option value="<?= $key->profilid; ?>">
                                                                <?= $key->nama_lengkap; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary theme-bg gradient button-entri"
                                                id="button-entri">Submit</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <div class="modal fade editmodal" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Update Kelas
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input type="hidden" id="id">
                                                <div class="form-group c_form_group">
                                                    <label>Kelas</label>
                                                    <input type="text" class="form-control" id="Kelas-Edit" name=""
                                                        placeholder="Kelas" disabled>
                                                </div>
                                                <div class="form-group c_form_group">
                                                    <label>Deskripsi</label>
                                                    <input type="text" class="form-control" id="Deskripsi-Edit"
                                                        placeholder="Deskripsi" disabled>
                                                </div>
                                                <div class="form-group c_form_group">
                                                    <label class="col-md-2 col-form-label">Wali Kelas</label>
                                                    <div class="col-md-10">
                                                        <select class="form-select" id="Wali-Kelas-Edit">
                                                            <option value=>-Select-</option>
                                                            <?php foreach ($wali as $key) : ?>
                                                            <option value="<?= $key->profilid; ?>">
                                                                <?= $key->nama_lengkap; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button"
                                                class="btn btn-primary theme-bg gradient button-update"
                                                id="button-update">Update</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                        </div> <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->
                </div>

                <?= $this->include('admin/partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
    </div>
</div>
<!-- END layout-wrapper -->

<?= $this->include('admin/partials/right-sidebar') ?>

<?= $this->include('admin/partials/vendor-scripts') ?>

<!-- Required datatable js -->
<script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
</script>


<!-- toastr plugin -->
<script src="<?= base_url() ?>/assets/libs/toastr/build/toastr.min.js"></script>
<!-- Sweet Alerts js -->
<script src="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('admin/master-classes-datatable') ?>",
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
});
</script>

<script>
$(document).on('click', '#button-entri', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'kelas': $('#Kelas').val(),
        'wali': $('#Wali-Kelas').val(),
        'deskripsi': $('#Deskripsi').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/add-master-classes') ?>",
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
            if (data.kelas != undefined) {
                toastr.error(data.kelas);
            } else if (data.deskripsi != undefined) {
                toastr.error(data.deskripsi);
            } else if (data.error != undefined) {
                toastr.error(data.error);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.entrimanual').modal('hide');
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
                url: "<?= route_to('admin/remove-master-classes') ?>",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: data,
                type: "post",
                dataType: "json",
                method: "post",
                success: function(data) {
                    console.log(data);
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

$(document).on('click', '#editmodal', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'id': $(this).attr("data-id"),
    }

    $.ajax({
        url: "<?= route_to('admin/detail-master-classes') ?>",
        type: "GET",
        data: data,
        success: function(data) {
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#Kelas-Edit').val(data.kelas);
            $('#Deskripsi-Edit').val(data.deskripsi);
            $('#Wali-Kelas-Edit').val(data.wali_id);
            $('#id').val(data.id);
        }
    });
});

$(document).on('click', '#button-update', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'id': $('#id').val(),
        'wali': $('#Wali-Kelas-Edit').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/update-master-classes') ?>",
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
            console.log(data);
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

<script src="<?= base_url() ?>/assets/js/app.js"></script>

</body>

</html>