<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <!-- plugin css -->
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Role</label>
                                        <select class="form-control select2" id="group" onchange="ambil_data();">
                                            <?php foreach ($role as $key) : ?>
                                            <option value="<?= $key->id; ?>"><?= $key->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                </div>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Permissions</th>
                                            <th>Description</th>
                                            <th>Select</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

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

<!-- plugins -->
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
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Sweet Alerts js -->
<script src="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'group_id': $('#group').val(),
    }

    $.ajax({
        url: "<?= route_to('admin/management-users-datatable') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: data,
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
                    "searching": false,
                    "autoWidth": false,
                    "columnDefs": [{
                        "targets": [0],
                        "orderable": false,
                    }],
                });
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
    $(document).on('change', 'input[type="checkbox"]', function() {
        if ($(this).prop("checked") == true) {
            // console.log($(this).attr("data-id"));
            var permission = $(this).attr('data-id');
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
                        'csrf_token_name': $('input[name=csrf_token_name]').val(),
                        'permission_id': permission,
                        'group_id': $('#group').val(),
                    }
                    console.log(data);
                    $.ajax({
                        url: "<?= route_to('admin/management-users-add') ?>",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        data: data,
                        type: "post",
                        dataType: "json",
                        method: "post",
                        success: function(data) {
                            console.log(data);
                            $('input[name=csrf_token_name]').val(data
                                .csrf_token_name);
                            if (data.error != undefined) {
                                Swal.fire("Failed!", data.error, "error");
                            } else if (data.success != undefined) {
                                Swal.fire("Updated!", data.success, "success");
                                ambil_data();
                            }
                        }
                    });
                }
            });
        } else if ($(this).prop("checked") == false) {
            // console.log($(this).attr("data-id"));
            var permission = $(this).attr('data-id');
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
                        'csrf_token_name': $('input[name=csrf_token_name]').val(),
                        'permission_id': permission,
                        'group_id': $('#group').val(),
                    }
                    console.log(data);
                    $.ajax({
                        url: "<?= route_to('admin/management-users-remove') ?>",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        data: data,
                        type: "post",
                        dataType: "json",
                        method: "post",
                        success: function(data) {
                            console.log(data);
                            $('input[name=csrf_token_name]').val(data
                                .csrf_token_name);
                            if (data.error != undefined) {
                                Swal.fire("Failed!", data.error, "error");
                            } else if (data.success != undefined) {
                                Swal.fire("Updated!", data.success, "success");
                                ambil_data();
                            }
                        }
                    });
                }
            });
        }
    });
});
</script>

<!-- select2 -->
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>

<!-- Init js -->
<!-- <script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script> -->

<script>
! function($) {
    "use strict";

    var AdvancedForm = function() {};

    AdvancedForm.prototype.init = function() {

            // Select2
            $(".select2").select2({});

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

<script src="<?= base_url() ?>/assets/js/app.js"></script>

</body>

</html>