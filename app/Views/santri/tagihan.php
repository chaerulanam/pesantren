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

                <!--  Large modal example -->
                <input type="hidden" id="no">
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
                                        <div class="float-end div-button-update">
                                            <div class="div-button-checkout">
                                            </div>
                                        </div>
                                    </div>

                                    <table id="datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th><input class="form-check-input" type="checkbox" id="allcheck"></th>
                                                <th>Nama & Kelas</th>
                                                <th>No Tagihan</th>
                                                <th>Nominal</th>
                                                <th>Nama Tagihan</th>
                                                <th>Status</th>
                                                <th>Tahun Ajaran</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal fade invoice" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Invoice Tagihan
                                                Santri
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="invoice-title">
                                                    <h4 class="float-end font-size-16" id="no_invoice"><span
                                                            class="badge bg-danger font-size-12 ms-2">Not
                                                            Paid</span></h4>
                                                    <div class="mb-4">
                                                        <img src="/assets/images/logo-dark.png" alt="logo"
                                                            height="20" />
                                                    </div>
                                                    <div class="text-muted">
                                                        <p class="mb-1">Jl Raya Sudimampir-Balongan, Indramayu, Jawa
                                                            Barat</p>
                                                        <p class="mb-1"><i class="uil uil-envelope-alt me-1">
                                                                al_ishlahtajug@yahoo.co.id</i> </p>
                                                        <p><i class="uil uil-phone me-1"></i> 0811 642 512</p>
                                                    </div>
                                                </div>

                                                <hr class="my-4">

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="text-muted">
                                                            <h5 class="font-size-16 mb-3">Tagihan untuk:</h5>
                                                            <h5 class="font-size-15 mb-2 nama_lengkap"></h5>
                                                            <p class="mb-1 alamat_lengkap"></p>
                                                            <p class="no_hp"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="text-muted text-sm-end">
                                                            <div>
                                                                <h5 class="font-size-16 mb-1">Invoice No:</h5>
                                                                <p class="no_invoice">INV</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <h5 class="font-size-16 mb-1">Invoice Date:</h5>
                                                                <p><?= date('d - m - Y') ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="py-2">
                                                    <h5 class="font-size-15">Rincian Pembayaran</h5>

                                                    <table id="table-invoice"
                                                        class="table table-striped table-bordered dt-responsive nowrap"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Tagihan</th>
                                                                <th>Deskripsi</th>
                                                                <th>Nominal</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        </tbody>
                                                    </table>

                                                    <div class="table-responsive">
                                                        <table class="table table-nowrap table-centered mb-0">
                                                            <thead>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" colspan="4"
                                                                        class="border-0 text-start">Total</th>
                                                                    <td class="border-0 text-end">
                                                                        <h4 class="m-0" id="total"></h4>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary theme-bg gradient button-entri"
                                                id="button-entri">Submit</button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row mb">
                                    <div class="col-md-4">
                                        <h4 class="card-title">Data Pembayaran</h4>
                                        <p class="card-title-desc">
                                        </p>
                                    </div>

                                    <table id="datatable-pembayaran"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Invoice</th>
                                                <th>Nominal</th>
                                                <th>Tipe Pembayaran</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->
                </div>
            </div>
        </div>

        <?= $this->include('santri/partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('santri/partials/right-sidebar') ?>

<?= $this->include('santri/partials/vendor-scripts') ?>

<!-- Required datatable js -->
<script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js">
</script>
<script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js">
</script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
</script>


<!-- toastr plugin -->
<script src="<?= base_url() ?>/assets/libs/toastr/build/toastr.min.js"></script>
<!-- Sweet Alerts js -->
<script src="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<Set your ClientKey here>">
</script>
<script type="text/javascript">
$(document).on('click', '#button-bayar', function(e) {
    var id = $(this).attr('data-id');
    console.log(id);
    $.ajax({
        url: "<?= route_to('santri/tagihan-bayar') ?>",
        type: "POST",
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'id': id,
        },
        // global: false,
        // async: false,
        success: function(data) {
            console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    var data = {
                        'payment_type': result.payment_type,
                        'order_id': result.order_id,
                        'status': result.transaction_status,
                        'bank': result.va_numbers[0].bank,
                        'va_number': result.va_numbers[0].va_number,
                        'pdf_link': result.pdf_url,
                        'gross_amount': result.gross_amount,
                        'csrf_token_name': $('input[name=csrf_token_name]')
                            .val()
                    }

                    $.ajax({
                        type: "post",
                        url: "<?= route_to('santri/tagihan-proses') ?>",
                        data: data,
                        // processData: false,
                        // contentType: false,
                        success: function(data) {
                            console.log(data);
                            $('input[name=csrf_token_name]').val(
                                data.csrf_token_name);
                            if (data.success != undefined) {
                                toastr.success(data.success);
                            }
                            location.reload();
                        },
                        error: function(error) {
                            console.log("Error:");
                            console.log(error);
                        }
                    });
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    var data = {
                        'payment_type': result.payment_type,
                        'order_id': result.order_id,
                        'status': result.transaction_status,
                        'bank': result.va_numbers[0].bank,
                        'va_number': result.va_numbers[0].va_number,
                        'pdf_link': result.pdf_url,
                        'gross_amount': result.gross_amount,
                        'csrf_token_name': $('input[name=csrf_token_name]')
                            .val()
                    }

                    $.ajax({
                        type: "post",
                        url: "<?= route_to('santri/tagihan-proses') ?>",
                        data: data,
                        // processData: false,
                        // contentType: false,
                        success: function(data) {
                            console.log(data);
                            $('input[name=csrf_token_name]').val(
                                data.csrf_token_name);
                            if (data.success != undefined) {
                                toastr.success(data.success);
                            }
                            location.reload();
                        },
                        error: function(error) {
                            console.log("Error:");
                            console.log(error);
                        }
                    });
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON
                        .stringify(result, null,
                            2);
                }
            });
        }
    });
    // SnapToken acquired from previous step

});
</script>

<script>
function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $('input:checkbox').prop('checked', this.value = 0);

    $.ajax({
        url: "<?= route_to('santri/tagihan-datatable') ?>",
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
                        "emptyTable": "Tidak ada data kelas"
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


    $("#datatable-pembayaran").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('santri/tagihan-datatable-pembayaran') ?>",
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
            $('#no').val(data.posts.length);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.responce == "success") {
                $("#datatable-pembayaran").DataTable({
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
                        "emptyTable": "Tidak ada data kelas"
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
                    '#datatable-pembayaran_wrapper .col-md-6:eq(0)');
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
        'id': tagihan_id,
        'invoice': $('.no_invoice').text(),
    }

    $.ajax({
        url: "<?= route_to('santri/tagihan-add') ?>",
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
            if (data.success != undefined) {
                toastr.success(data.success);
                $('.invoice').modal('hide');
                ambil_data();

                snap.pay(data.snap_token, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        var data = {
                            'payment_type': result.payment_type,
                            'order_id': result.order_id,
                            'status': result.transaction_status,
                            'bank': result.va_numbers[0].bank,
                            'va_number': result.va_numbers[0].va_number,
                            'pdf_link': result.pdf_url,
                            'gross_amount': result.gross_amount,
                            'csrf_token_name': $(
                                    'input[name=csrf_token_name]')
                                .val()
                        }

                        $.ajax({
                            type: "post",
                            url: "<?= route_to('santri/tagihan-proses') ?>",
                            data: data,
                            // processData: false,
                            // contentType: false,
                            success: function(data) {
                                console.log(data);
                                $('input[name=csrf_token_name]')
                                    .val(
                                        data.csrf_token_name);
                                if (data.success != undefined) {
                                    toastr.success(data.success);
                                }
                                location.reload();
                            },
                            error: function(error) {
                                console.log("Error:");
                                console.log(error);
                            }
                        });
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        var data = {
                            'payment_type': result.payment_type,
                            'order_id': result.order_id,
                            'status': result.transaction_status,
                            'bank': result.va_numbers[0].bank,
                            'va_number': result.va_numbers[0].va_number,
                            'pdf_link': result.pdf_url,
                            'gross_amount': result.gross_amount,
                            'csrf_token_name': $(
                                    'input[name=csrf_token_name]')
                                .val()
                        }

                        $.ajax({
                            type: "post",
                            url: "<?= route_to('santri/tagihan-proses') ?>",
                            data: data,
                            // processData: false,
                            // contentType: false,
                            success: function(data) {
                                console.log(data);
                                $('input[name=csrf_token_name]')
                                    .val(
                                        data.csrf_token_name);
                                if (data.success != undefined) {
                                    toastr.success(data.success);
                                }
                                location.reload();
                            },
                            error: function(error) {
                                console.log("Error:");
                                console.log(error);
                            }
                        });
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON
                            .stringify(result, null,
                                2);
                    }
                });
            }
        }
    });

});
</script>

<script src="<?= base_url() ?>/assets/js/app.js"></script>

<script>
var tagihan_id = [];
var lu;
var no = 0;
$(document).ready(function() {
    $(document).on('change', '#allcheck', function() {
        $('input:checkbox').prop('checked', this.checked);
        no = $('#no').val();

        let lc = $('#check:checked').length;
        let t = $('#check:checked').attr('data-no');

        if ($(this).prop("checked") == true) {
            no = no - 1;
            lu = lc;
            if (lc > 0) {
                $('.div-button-checkout').html(
                    '<a href="javascript:void(0);" class="btn btn-outline-success uil-money-insert" id="invoice" data-bs-toggle="modal" data-bs-target=".invoice" > Checkout </a>'
                );
            }
            lc = lc + parseInt(t);
            for (let i = t; i < lc; i++) {
                tagihan_id[i - 1] = $('.check' + (i) + ':checked').attr('data-id');
            }
        } else {
            no = 1;
            $('.div-button-checkout').html(
                ''
            );

            for (let i = 1; i <= lu; i++) {
                tagihan_id[i - 1] = null;
            }

            // console.log(tagihan_id);
        }
    });

    $(document).on('change', 'input[type="checkbox"]', function() {
        $idtagihan = $(this).attr('data-id');
        $no = $(this).attr('data-no');

        if (this.checked) {
            no++;
            tagihan_id[$no - 1] = $idtagihan;
            $('.div-button-checkout').html(
                '<a href="javascript:void(0);" class="btn btn-outline-success uil-money-insert" id="invoice" data-bs-toggle="modal" data-bs-target=".invoice"> Checkout </a>'
            );
        } else {
            no--;
            if (no <= 0) {
                $('input:checkbox').prop('checked', this.value = 0);
                $('.div-button-checkout').html(
                    ''
                );
            }
            tagihan_id[$no - 1] = null;
        }
        console.log(tagihan_id);
    });
});

$(document).on('click', '#invoice', function(e) {
    $("#table-invoice").DataTable({
        "destroy": true,
    }).clear();

    var data = {
        'id': tagihan_id,
        'csrf_token_name': $('input[name=csrf_token_name]').val()
    };

    console.log(data);

    $.ajax({
        url: "<?= route_to('santri/tagihan-invoice') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: data,
        type: "post",
        dataType: "json",
        method: "post",
        success: function(data) {
            console.log(data);
            $('#total').text(data.total);
            $('#total-pembayaran').text(data.total);
            $('.nama_lengkap').text(data.profil.nama_lengkap);
            $('.alamat_lengkap').text(data.profil.alamat);
            $('.no_hp').text(data.profil.no_hp);
            $('.no_invoice').text('INV<?= date('dmhis') ?>' + data.profil.profilid);
            $('#no_invoice').text('Invoice #<?= date('dmhis') ?>' + data.profil
                .profilid);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.responce == "success") {
                $("#table-invoice").DataTable({
                    "destroy": true,
                    "data": data.posts,
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "paging": false,
                    "ordering": false,
                    "searching": false,
                    "columnDefs": [{
                        "targets": [0],
                        "orderable": false,
                    }],
                    "language": {
                        "emptyTable": "Tidak ada data tagihan"
                    },
                });
            } else {

            }
        }
    });
});
</script>

</body>

</html>