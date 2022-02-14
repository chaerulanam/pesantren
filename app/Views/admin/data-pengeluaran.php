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
                                                    id="entri" data-bs-toggle="modal" data-bs-target=".entri">
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
                                            <th>Nama Penerima</th>
                                            <th>Nominal</th>
                                            <th>Deskripsi</th>
                                            <th>Bukti</th>
                                            <th>Tahun Ajaran</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="modal fade entri" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Form master classes
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group c_form_group mb-3">
                                                    <label>Nama Penerima</label>
                                                    <input type="text" class="form-control email" id="Nama-Penerima"
                                                        name="" placeholder="Nama Penerima">
                                                </div>
                                                <div class="form-group c_form_group mb-3">
                                                    <label>Deskripsi</label>
                                                    <input type="text" class="form-control" id="Deskripsi"
                                                        placeholder="Deskripsi">
                                                </div>
                                                <div class="form-group c_form_group mb-3">
                                                    <label>Nominal</label>
                                                    <input type="text" class="form-control" id="Nominal"
                                                        placeholder="Nominal">
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

                            <div class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Update data pengeluaran
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input type="hidden" id="id">
                                                <div class="form-group c_form_group mb-3">
                                                    <label>Nama Penerima</label>
                                                    <input type="text" class="form-control" id="Nama-Penerima-Edit"
                                                        name="" placeholder="Nama Penerima" disabled>
                                                </div>
                                                <div class="form-group c_form_group mb-3">
                                                    <label>Deskripsi</label>
                                                    <input type="text" class="form-control" id="Deskripsi-Edit"
                                                        placeholder="Deskripsi" disabled>
                                                </div>
                                                <div class="form-group c_form_group mb-3">
                                                    <label>Nominal</label>
                                                    <input type="text" class="form-control" id="Nominal-Edit"
                                                        placeholder="Nominal" disabled>
                                                </div>
                                                <label>Bukti</label>
                                                <div class="form-group c_form_group mb-3">
                                                    <img src="<?= base_url(); ?>/assets/images/users/default.png" alt=""
                                                        class="avatar-lg rounded img-thumbnail" id="preview">
                                                    <input type="file" class="form-control-file" id="foto"
                                                        onchange="ambil_gambar()">
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
function ambil_gambar() {
    var file = $("input[type=file]").get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function() {
            $("#preview").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}

function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('admin/data-expenditure-datatable') ?>",
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
        'nama_penerima': $('#Nama-Penerima').val(),
        'nominal': $('#Nominal').val(),
        'deskripsi': $('#Deskripsi').val(),
    }

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/add-data-expenditure') ?>",
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
            if (data.nama_penerima != undefined) {
                toastr.error(data.nama_penerima);
            } else if (data.nominal != undefined) {
                toastr.error(data.nominal);
            } else if (data.deskripsi != undefined) {
                toastr.error(data.deskripsi);
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
                url: "<?= route_to('admin/remove-data-expenditure') ?>",
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
        url: "<?= route_to('admin/detail-data-expenditure') ?>",
        type: "GET",
        data: data,
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            $('#Nama-Penerima-Edit').val(data.nama_penerima);
            $('#Deskripsi-Edit').val(data.deskripsi);
            $('#Nominal-Edit').val(data.nominal);
            $('#id').val(data.id);
        }
    });
});

$(document).on('click', '#button-update', function(e) {
    let foto = $('#foto').prop('files')[0];
    let fd = new FormData();
    fd.append('foto', foto);
    fd.append('id', $('#id').val());

    // console.log(data);
    $.ajax({
        url: "<?= route_to('admin/update-data-expenditure') ?>",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
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
            } else if (data.foto != undefined) {
                toastr.error(data.foto);
            } else if (data.success != undefined) {
                toastr.success(data.success);
                $('.edit').modal('hide');
                ambil_data();
            }
        }
    });
});
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

<script src="<?= base_url() ?>/assets/js/app.js"></script>

</body>

</html>