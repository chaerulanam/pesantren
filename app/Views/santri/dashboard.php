<!doctype html>
<html lang="id">

<head>

    <?= $title_meta ?>

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

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1">Rp<span
                                            data-plugin="counterup"><?= str_replace('Rp', '', $biaya); ?></span></h4>
                                    <p class="text-muted mb-0">Biaya Pendidikan</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="/santri/tagihan"><span
                                            class="text-success me-1"><i
                                                class="mdi mdi-arrow-right-bold me-1"></i>Selengkapnya</span> </a>
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
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $mapel; ?></span></h4>
                                    <p class="text-muted mb-0">Total Pelajaran</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="/santri/kehadiran"><span
                                            class="text-success me-1"><i
                                                class="mdi mdi-arrow-right-bold me-1"></i>Selengkapnya</span> </a>
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
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $tagihan; ?></span></h4>
                                    <p class="text-muted mb-0">Total Tagihan</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="/santri/tagihan"><span
                                            class="text-success me-1"><i
                                                class="mdi mdi-arrow-right-bold me-1"></i>Selengkapnya</span> </a>
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
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $pelanggaran; ?></span>
                                    </h4>
                                    <p class="text-muted mb-0">Total Pelanggaran</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><a href="/santri/pelanggaran"><span
                                            class="text-success me-1"><i
                                                class="mdi mdi-arrow-right-bold me-1"></i>Selengkapnya</span> </a>
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Pembayaran Terakhir</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
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
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <?= $this->include('santri/partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('santri/partials/right-sidebar') ?>

<?= $this->include('santri/partials/vendor-scripts') ?>

<!-- apexcharts -->
<script src="<?= base_url(); ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="<?= base_url(); ?>/assets/js/pages/dashboard.init.js"></script>

<script src="<?= base_url(); ?>/assets/js/app.js"></script>

<script>
$.ajax({
    url: "/admin/chart",
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

</body>

</html>