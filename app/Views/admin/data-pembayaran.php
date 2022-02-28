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
                                                Bayarkan Tagihan</a>
                                        </div>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Invoice</th>
                                            <th>Nama Lengkap & Kelas</th>
                                            <th>Metode</th>
                                            <th>Nominal</th>
                                            <th>Penerima</th>
                                            <th>Status</th>
                                            <th>Tahun Ajaran</th>
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
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Bayar Tagihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="hidden" id="total-harga">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Plih Kelas</label>
                                                        <select class="form-select" id="Kelas" onchange="getnama()">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <select class="form-select " id="Nama-Lengkap"
                                                            onchange="tabeltagihan()">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row div-tabel-tagihan">
                                                    <table id="datatable_tagihan"
                                                        class="table table-striped table-bordered dt-responsive nowrap"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <div
                                                                        class="btn-group d-flex justify-content-center">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="allcheck">
                                                                    </div>
                                                                </th>
                                                                <th>No Tagihan</th>
                                                                <th>Nama Tagihan</th>
                                                                <th>Nominal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-11 mt-4">
                                                    <h4 class="font-size-16 float-end total">
                                                    </h4>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary theme-bg gradient button-update"
                                            id="button-entri">Submit</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
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
var tagihan_id = [];
var nominal = [];
var lu;
var no = 0;

function ambil_data_tagihan() {
    $("#datatable_tagihan").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('admin/data-payments-billings-datatable') ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: {
            'csrf_token_name': $('input[name=csrf_token_name]').val(),
            'tahun': $('#tahun').val(),
            'id': $('#Nama-Lengkap').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
            $('#no').val(data.posts.length);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            if (data.responce == "success") {
                $("#datatable_tagihan").DataTable({
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
                });
            } else {

            }
        }
    });
}

function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
    }).clear();

    $.ajax({
        url: "<?= route_to('admin/data-payments-datatable') ?>",
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
    $('.div-tabel-tagihan').hide();
});
</script>

<script>
function getclass() {
    $('#Kelas').find('option').remove().end();
    $('#Kelas-Perindividu').find('option').remove().end();

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
            'kelas': $('#Kelas-Perindividu').val()
        },
        type: "get",
        dataType: "json",
        method: "get",
        success: function(data) {
            // console.log(data);
            $('input[name=csrf_token_name]').val(data.csrf_token_name);
            for (let i = 0; i < data.nama.length; i++) {
                $('#Nama-Lengkap').append('<option value="' + data.nama[i].userid + '">' + data.nama[i]
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
            $('#Nama-Lengkap').append('<option value=>-Select-</option>');
            for (let i = 0; i < data.nama.length; i++) {
                $('#Nama-Lengkap').append('<option value="' + data.nama[i].userid + '">' + data.nama[i]
                    .nama_lengkap + '</option>');
            }
        }
    });
}

function tabeltagihan() {
    $('.div-tabel-tagihan').show();
    ambil_data_tagihan();
    $('input:checkbox').prop('checked', this.value = 0);
    tagihan_id = [];
    nominal = [];

}
</script>

<script>
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
                nominal[i - 1] = $('.check' + (i) + ':checked').attr('data-nominal');
            }
        } else {
            no = 1;
            $('.div-button-checkout').html(
                ''
            );

            tagihan_id = [];
            nominal = [];
            total = 0;
            // console.log(tagihan_id);
        }

    });

    $(document).on('change', 'input[type="checkbox"]', function() {
        let total = 0;
        $idtagihan = $(this).attr('data-id');
        $nominal = $(this).attr('data-nominal');

        $no = $(this).attr('data-no');

        if (this.checked) {
            no++;
            nominal[$no - 1] = $nominal;
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
            nominal[$no - 1] = null;
        }

        for (let i = 0; i < nominal.length; i++) {
            if (nominal[i] != null) {
                total += parseInt(nominal[i]);
            }
        }

        $('#total-harga').val(total);
        total = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(total);

        $('.total').text('Total : ' + total)
        // console.log(tagihan_id);
    });
});
</script>

<script>
$(document).on('click', '#button-entri', function(e) {
    var data = {
        'csrf_token_name': $('input[name=csrf_token_name]').val(),
        'id': tagihan_id,
        'invoice': 'INV<?= date('dmhis') ?>' + $('#Nama-Lengkap').val(),
        'nominal': $('#total-harga').val(),
    }
    // console.log(data);
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
            $.ajax({
                url: "<?= route_to('admin/add-data-payments') ?>",
                type: "POST",
                data: data,
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    if (data.error != undefined) {
                        Swal.fire("Failed!", data.error, "error");
                    } else if (data.success != undefined) {
                        Swal.fire("Submited!", data.success, "success");
                        $('.entri').modal('hide');
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