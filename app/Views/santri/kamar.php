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

                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>

                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kamar</th>
                                            <th>Wali Kamar</th>
                                            <th>No HP</th>
                                            <th>Tahun Ajaran</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $no = 0;
                                        foreach ($kamar as $key) : $no++; ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $key->nama_kamar . ' ' . $key->nama_gedung; ?></td>
                                            <td><?= $key->nama_wali; ?></td>
                                            <td><?= $key->no_hp; ?></td>
                                            <td><?= $key->tahun_ajaran; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
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

<script>
function ambil_data() {
    $("#datatable").DataTable({
        "destroy": true,
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
}
$(document).ready(function() {
    ambil_data();
});
</script>

<script src="<?= base_url() ?>/assets/js/app.js"></script>

</body>

</html>