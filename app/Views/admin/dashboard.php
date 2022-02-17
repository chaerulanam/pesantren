<!doctype html>
<html lang="id">

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
                <?php if (has_permission('manage.bendahara')) : ?>
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1">Rp<span
                                            data-plugin="counterup"><?= str_replace('Rp', '', $sisa_uang); ?></span>K
                                    </h4>
                                    <p class="text-muted mb-0">Sisa uang</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-payments"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart"> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1">Rp<span
                                            data-plugin="counterup"><?= str_replace('Rp', '', $uang_bulan_ini); ?></span>K
                                    </h4>
                                    <p class="text-muted mb-0">Pemasukan bulan Ini</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-payments"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="customers-chart"> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1">Rp<span
                                            data-plugin="counterup"><?= str_replace('Rp', '', $uang_tahun_ini); ?></span>K
                                    </h4>
                                    <p class="text-muted mb-0">Pemasukan tahun ini</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-payments"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="growth-chart"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1">Rp<span
                                            data-plugin="counterup"><?= str_replace('Rp', '', $pengeluaran); ?></span>K
                                    </h4>
                                    <p class="text-muted mb-0">Pengeluaran</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-expenditure"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $total_santri ?></span>
                                    </h4>
                                    <p class="text-muted mb-0">Total santri</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-students"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart"> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $total_guru; ?></span>
                                    </h4>
                                    <p class="text-muted mb-0">Total guru</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-teachers"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart"> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $pengunjung; ?></span>
                                    </h4>
                                    <p class="text-muted mb-0">Pengunjung bulan ini</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="admin/data-visitation"><span
                                            class="text-success me-1">
                                            <i class="mdi mdi-arrow-right-bold me-1"></i> Selengkapnya</span></a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
                <?php if (has_permission('manage.bendahara')) : ?>
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Laporan:</span> <span class="text-muted">Tahunan<i
                                                    class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Analisis Keuangan</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary">Rp<span
                                                    data-plugin="counterup"><?= str_replace('Rp', '', $uang_tahun_ini); ?></span>K<span
                                                    class="text-muted d-inline-block font-size-15 ms-3">Income</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3 class="text-danger">Rp<span
                                                    data-plugin="counterup"><?= str_replace('Rp', '', $pengeluaran_tahun); ?></span>K<span
                                                    class="text-muted d-inline-block font-size-15 ms-3">Outcome</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?= $rasio; ?></span>%<span
                                                    class="text-muted d-inline-block font-size-15 ms-3">
                                                    Ratio</span></h3>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-3">
                                    <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted">Semua<i
                                                    class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Pembayaran Terakhir</h4>

                                <div data-simplebar style="max-height: 400px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody>
                                                <?php foreach ($tabel_pembayaran as $key) : ?>
                                                <tr>
                                                    <td style="width: 20px;"><?= $key->order_id; ?></td>
                                                    <?php if ($key->status == "settlement") {
                                                                echo '<td><span class="badge bg-soft-success font-size-12">' . $key->status . '</span>
                                                        </td>';
                                                            } else if ($key->status == "pending") {
                                                                echo '<td><span class="badge bg-soft-warning font-size-12">' . $key->status . '</span>
                                                        </td>';
                                                            } else {
                                                                echo '<td><span class="badge bg-soft-danger font-size-12">' . $key->status . '</span>
                                                        </td>';
                                                            } ?>

                                                    <td class="text-muted fw-semibold text-end"><i
                                                            class="icon-xs icon me-2 text-success"
                                                            data-feather="trending-up"></i><?= number_to_currency($key->gross_amount, 'IDR', null); ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                </div> <!-- data-sidebar-->
                            </div><!-- end card-body-->
                        </div> <!-- end card-->
                    </div><!-- end col -->
                </div> <!-- end row-->
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Santri Absen Hari Ini</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 20px;">
                                                    No
                                                </th>
                                                <th>Nama Lengkap</th>
                                                <th>Kelas</th>
                                                <th>Pelajaran</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody><?php $no = 0;
                                                foreach ($absen as $key) : $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->nama_lengkap; ?>
                                                </td>
                                                <td><?= $key->kelas; ?>
                                                </td>
                                                <td><?= $key->nama_pelajaran; ?>
                                                </td>
                                                <td><?= $key->status; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Santri Pelanggar Hari Ini</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 20px;">
                                                    No
                                                </th>
                                                <th>Nama Lengkap</th>
                                                <th>Kelas</th>
                                                <th>Pelanggaran</th>
                                                <th>Hukuman</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0;
                                            foreach ($pelanggar as $key) : $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->nama_lengkap; ?>
                                                </td>
                                                <td><?= $key->kelas; ?>
                                                </td>
                                                <td><?= $key->nama_pelanggaran; ?>
                                                </td>
                                                <td><?= $key->hukuman; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/dashboard.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

<script>
$.ajax({
    url: "<?= route_to('admin/chart') ?>",
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
        console.log(data);
        if (data.responce == "success") {
            var chart2 = new ApexCharts(document.querySelector("#growth-chart"), options2);
            chart2.render();

            var options = {
                chart: {
                    height: 339,
                    type: 'line',
                    stacked: false,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: [0, 2, 4],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%'
                    }
                },
                colors: ['#EA431F', '#5b73e8'],
                series: [{
                    name: 'Pengeluaran',
                    type: 'bar',
                    data: data.keluar
                }, {
                    name: 'Pemasukan',
                    type: 'area',
                    data: data.masuk,
                }],
                fill: {
                    opacity: [0.85, 0.25, 1],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: "vertical",
                        opacityFrom: 0.85,
                        opacityTo: 0.55,
                        stops: [0, 100, 100, 100]
                    }
                },
                labels: data.tahun,
                markers: {
                    size: 0
                },

                xaxis: {
                    type: 'datetime'
                },
                yaxis: {
                    title: {
                        text: '',
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0) + "";
                            }
                            return y;

                        }
                    }
                },
                grid: {
                    borderColor: '#f1f1f1'
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#sales-analytics-chart"),
                options
            );

            chart.render();
        } else {

        }
    }
});
</script>

</html>