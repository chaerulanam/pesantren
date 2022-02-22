<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
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
                        <!-- <div class="card h-90">
                            <div class="card-body"> -->
                        <div class="invoice-title">
                            <h4 class="float-end font-size-16">#<?= $invoice[0]->invoice ?>
                                <span class="badge bg-success font-size-12 ms-2">Sudah Dibayar</span>
                            </h4>
                            <div class="mb-4">
                                <img src="/assets/images/logo-dark.png" alt="logo" height="35" />
                            </div>
                            <div class="text-muted">
                                <p class="mb-1">Jl Raya Sudimampir-Balongan, Indramayu, Jawa Barat</p>
                                <p class="mb-1"><i class="uil uil-envelope-alt me-1">
                                        al_ishlahtajug@yahoo.co.id</i> </p>
                                <p><i class="uil uil-phone me-1"></i> 0811 642 512</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-4">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Tagihan untuk:</h5>
                                    <h5 class="font-size-15 mb-2"><?= $invoice[0]->nama_lengkap; ?></h5>
                                    <p class="mb-1"><?= $invoice[0]->alamat_lengkap; ?></p>
                                    <p><?= $invoice[0]->no_hp; ?></p>
                                </div>
                            </div>
                            <div class="col-5"></div>
                            <div class="col-3 float-end">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-16 mb-1">Invoice No:</h5>
                                        <p class="no_invoice"><?= $invoice[0]->invoice ?></p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-16 mb-1">Invoice Date:</h5>
                                        <p><?= $invoice[0]->updated_at ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="py-2">
                            <h5 class="font-size-15">Rincian Pembayaran</h5>

                            <table id="table-invoice" class="table table-striped table-borderless dt-responsive nowrap"
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
                                    <?php $no = 0;
                                    $total = 0;
                                    foreach ($invoice as $key) : $no++; ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $key->nama_tagihan; ?></td>
                                        <td><?= $key->desc; ?></td>
                                        <td><?= number_to_currency($key->nominal, 'IDR', null); ?></td>
                                    </tr>
                                    <?php
                                        $total += $key->nominal;
                                    endforeach; ?>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="font-size-16 float-end">Total :
                                        <?= number_to_currency($total, 'IDR', null); ?>
                                    </h4>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <table id="table-invoice"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="d-flex justify-content-center">Metode </div>
                                            </th>
                                            <th>
                                                <div class="d-flex justify-content-center">Nama Bank </div>
                                            </th>
                                            <th>
                                                <div class="d-flex justify-content-center">Nomor Virtual Account </div>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <?= $invoice[0]->payment_type; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center"><?= $invoice[0]->bank; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <?= $invoice[0]->va_number; ?></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-print-none mt-4">
                                        <div class="float-start">
                                            <a href="javascript:window.print()"
                                                class="btn btn-success waves-effect waves-light me-1"><i
                                                    class="fa fa-print"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="m-5 pb-5 px-3">
                                        <div class="float-end">
                                            <p class="text-center text-justify">Penerima
                                                <br><br><br><?= $invoice[0]->nama_penerima; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page-content -->


            <?= $this->include('admin/partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?= $this->include('admin/partials/right-sidebar') ?>

    <?= $this->include('admin/partials/vendor-scripts') ?>

    <script src="<?= base_url(); ?>/assets/js/app.js"></script>

    <script>
    $(window).ready(function(e) {
        window.print();
    });
    </script>

    </body>

</html>