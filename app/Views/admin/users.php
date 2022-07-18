<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

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
                                    <div class="col-md-8">
                                        <div class="float-end button-checkout">
                                            <div class="btn-group">
                                                <a href="javascript:void(0);" class="btn btn-outline-info fas fa-plus"
                                                    id="entrimanual" data-bs-toggle="modal"
                                                    data-bs-target=".entrimanual">
                                                    Entri</a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-outline-primary fas fa-upload" id="entricsv"
                                                    data-bs-toggle="modal" data-bs-target=".entricsv">
                                                    Upload</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade entrimanual" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Registration Users
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group c_form_group">
                                        <label for="email"><?= lang('Auth.email') ?></label>
                                        <input type="email" class="form-control email" id="email" name="email"
                                            placeholder="<?= lang('Auth.email') ?>">
                                    </div>
                                    <div class="form-group c_form_group">
                                        <label for="username"><?= lang('Auth.username') ?></label>
                                        <input type="text" class="form-control username" name="username"
                                            placeholder="<?= lang('Auth.username') ?>">
                                    </div>
                                    <div class="form-group c_form_group">
                                        <label for="password"><?= lang('Auth.password') ?></label>
                                        <input type="password" name="password" class="form-control password"
                                            placeholder="<?= lang('Auth.password') ?>">
                                    </div>
                                    <div class="form-group c_form_group">
                                        <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                                        <input type="password" name="pass_confirm" class="form-control pass_confirm"
                                            placeholder="<?= lang('Auth.repeatPassword') ?>">
                                    </div>
                                    <div class="form-group c_form_group">
                                        <label class="col-md-2 col-form-label">Role</label>
                                        <div class="col-md-10">
                                            <select class="form-select group" id="group">
                                                <?php foreach ($role as $key) : ?>
                                                <option><?= $key->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
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

                <div class="modal fade passmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Edit Password User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group c_form_group">
                                        <label for="password-edit">Kata sandi baru</label>
                                        <input type="password" name="password-edit" class="form-control password-edit"
                                            placeholder="<?= lang('Auth.password') ?>">
                                    </div>
                                    <div class="form-group c_form_group">
                                        <label for="pass_confirm-edit"><?= lang('Auth.repeatPassword') ?></label>
                                        <input type="password" name="pass_confirm-edit"
                                            class="form-control pass_confirm-edit"
                                            placeholder="<?= lang('Auth.repeatPassword') ?>">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary theme-bg gradient button-reset"
                                    id="button-reset">Reset Password</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div class="modal fade editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Update Users
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group c_form_group">
                                        <label for="email"><?= lang('Auth.email') ?></label>
                                        <input type="email" class="form-control email" id="email-edit" name="email"
                                            placeholder="<?= lang('Auth.email') ?>" disabled>
                                    </div>
                                    <div class="form-group c_form_group">
                                        <label for="username"><?= lang('Auth.username') ?></label>
                                        <input type="text" class="form-control username" id="username-edit"
                                            name="username" placeholder="<?= lang('Auth.username') ?>" disabled>
                                    </div>

                                    <input type="hidden" id="id">
                                    <input type="hidden" id="role">
                                    <div class="form-group c_form_group">
                                        <label class="col-md-2 col-form-label">Role</label>
                                        <div class="col-md-10">
                                            <select class="form-select" id="role-edit">
                                                <?php foreach ($role as $key) : ?>
                                                <option><?= $key->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary theme-bg gradient button-update"
                                    id="button-update">Update</button>
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
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Import Users</h5>
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
<script src="<?= base_url(); ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
</script>


<!-- toastr plugin -->
<script src="<?= base_url(); ?>/assets/libs/toastr/build/toastr.min.js"></script>
<!-- jquery step -->
<script src="<?= base_url(); ?>/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>

<!-- Sweet Alerts js -->
<script src="<?= base_url(); ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
function ambil_data() {
    // $("#datatable").DataTable({
    //     "destroy": true,
    // }).clear();
    $("#datatable").DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "autoWidth": false,
        "dom": 'Blfrtip',
        "order": [],
        "ajax": {
            "data": {
                'csrf_token_name': $('input[name=csrf_token_name]').val()
            },
            "url": "<?= route_to('admin/data-users-datatable') ?>",
            "type": "POST"
        },
        "columnDefs": [{
                'targets': 0,
                'checkboxes': {
                    'seletRow': true
                }
            },
            {
                "targets": [4],
                "orderable": false,
            }
        ],
        "select": {
            'style': 'multi'
        },
        'order': [
            [1, 'asc']
        ],
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
}
$(document).ready(function() {
    ambil_data();
});
</script>

<script>
$(document).on('click', '#button-import', function(e) {
    let file = $('#file').prop('files')[0];
    let fd = new FormData();
    fd.append('file', file);
    fd.append('csrf_token_name', $('input[name=csrf_token_name]').val());
    $.ajax({
        url: "<?= route_to('admin/data-users-import') ?>",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        // global: false,
        // async: false,
        beforeSend: function() {
            $('#button-import').removeAttr('disable');
            $('#button-import').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function(e) {
            $('#button-import').prop('disable', 'disable');
            $('#button-import').html('Yes, Import!');
        },
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.username != undefined) {
                toastr.error(data.username);
            } else if (data.email != undefined) {
                toastr.error(data.email);
            } else if (data.file != undefined) {
                toastr.error(data.file);
            } else if (data.message != undefined) {
                toastr.success(data.message);
                $('.entricsv').modal('hide');
                ambil_data();
            }
        }
    });
});

$(document).on('click', '#button-entri', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'email': $('.email').val(),
        'username': $('.username').val(),
        'password': $('.password').val(),
        'pass_confirm': $('.pass_confirm').val(),
        'group': $('.group').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/data-users-add') ?>",
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
            if (data.email != undefined) {
                toastr.error(data.email);
            } else if (data.username != undefined) {
                toastr.error(data.username);
            } else if (data.password != undefined) {
                toastr.error(data.password);
            } else if (data.group != undefined) {
                toastr.error(data.group);
            } else if (data.message != undefined) {
                toastr.success(data.message);
                $('.entrimanual').modal('hide');
                ambil_data();
            }
        }
    });
});

$(document).on('click', '#editmodal', function(e) {

    var data = {
        'id': $(this).attr('data-id'),
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
    }

    // console.log(data);

    $.ajax({
        url: "<?= route_to('admin/data-users-detail') ?>",
        type: "GET",
        data: data,
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#username-edit').val(data.username);
            $('#email-edit').val(data.email);
            $('#id').val(data.id);
            $('#role').val(data.role);
            $('#role-edit').val(data.role);
        }

    });
});

$(document).on('click', '#button-update', function(e) {

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

            var data = {
                'id': $('#id').val(),
                'username': $('#username-edit').val(),
                'email': $('#email-edit').val(),
                'role_s': $('#role').val(),
                'role': $('#role-edit').val(),
                'csrf_token_name': $('input[name=csrf_token_name]').val(),
            }

            $.ajax({
                url: "<?= route_to('admin/data-users-edit') ?>",
                type: "POST",
                data: data,
                // global: false,
                // async: false,
                beforeSend: function() {
                    $('#button-update').removeAttr('disable');
                    $('#button-update').html(
                        '<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function(e) {
                    $('#button-update').prop('disable', 'disable');
                    $('#button-update').html('Update');
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#id').val('');
                    if (data.error != undefined) {
                        Swal.fire("Failed!", data.error, "error");
                    } else if (data.success != undefined) {
                        Swal.fire("Updated!", data.success, "success");
                        $('.editmodal').modal('hide');
                        ambil_data();
                    }
                }
            });
        }
    });
});

$(document).on('click', '#button-delete', function(e) {
    var data = {
        'id': $(this).attr('data-id'),
        'csrf_token_name': $('input[name=csrf_token_name]').val()
    };
    // console.log(data);
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
                url: "<?= route_to('admin/data-users-delete') ?>",
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

$(document).on('click', '#passmodal', function(e) {

    var data = {
        'id': $(this).attr('data-id'),
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
    }

    $.ajax({
        url: "<?= route_to('admin/data-users-detail') ?>",
        type: "GET",
        data: data,
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#id').val(data.id);
        }
    });
});

$(document).on('click', '#button-reset', function(e) {

    var data = {
        'id': $('#id').val(),
        'password': $('.password-edit').val(),
        'pass_confirm': $('.pass_confirm-edit').val(),
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
    }

    // console.log(data);

    $.ajax({
        url: "<?= route_to('admin/data-users-reset-password') ?>",
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
                ambil_data();
            }
        }

    });
});
</script>

<script src="<?= base_url(); ?>/assets/js/app.js"></script>

</body>

</html>