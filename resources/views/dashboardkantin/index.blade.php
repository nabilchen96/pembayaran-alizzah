<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-white p-2">
                    <div class="inner">
                        <?php
                            $hari = DB::table('transaksi_uang_sakus')->where('created_at', '>=', date('Y-m-d'))
                                            ->where(function ($query) {
                                                $query->where('keterangan', '=', 'jajan harian')
                                                        ->orWhere('keterangan', '=', 'kebutuhan khusus');
                                            })
                                            ->sum('jumlah');
                        ?>
                        <h4>Rp. {{ number_format($hari) }}</h4>
                        <p>Pendapatan Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-white p-2">
                    <div class="inner">
                        <?php
                            $date = \Carbon\Carbon::today()->subDays(7);
                            $minggu = DB::table('transaksi_uang_sakus')->where('created_at', '>=', $date)
                                            ->where(function ($query) {
                                                $query->where('keterangan', '=', 'jajan harian')
                                                        ->orWhere('keterangan', '=', 'kebutuhan khusus');
                                            })
                                            ->sum('jumlah');
                        ?>
                        <h4>Rp. {{ number_format($minggu) }}</h4>

                        <p>Pendapatan Minggu Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div>

                </div>
            </div>


            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-white p-2">
                    <div class="inner">
                        <?php
                            $bulansekarang = date('m');
                            $bulan = DB::table('transaksi_uang_sakus')
                                            ->whereRaw('MONTH(created_at) = ?',[$bulansekarang])
                                            ->where(function ($query) {
                                                $query->where('keterangan', '=', 'jajan harian')
                                                        ->orWhere('keterangan', '=', 'kebutuhan khusus');
                                            })
                                            ->sum('jumlah');
                        ?>
                        <h4>Rp. {{ number_format($bulan) }}</h4>

                        <p>Pendapatan Bulan Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-white p-2">
                    <div class="inner">
                        <?php
                        
                            $tahun = DB::table('transaksi_uang_sakus')
                                            ->whereYear('created_at', date('Y'))
                                            ->where(function ($query) {
                                                $query->where('keterangan', '=', 'jajan harian')
                                                        ->orWhere('keterangan', '=', 'kebutuhan khusus');
                                            })
                                            ->sum('jumlah');

                        ?>
                        <h4>Rp. {{ number_format($tahun) }}</h4>

                        <p>Pendapatan tahun Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-1">
                <div class="d-flex justify-content-end">
                    <select name="" style="width: fit-content;" class="form-control" id="">
                        {{-- <option value="">&#128197;	Hari Ini</option> --}}
                        <option value="">&#128197;	Minggu Ini</option>
                        {{-- <option value="">&#128197;	Bulan Ini</option>
                        <option value="">&#128197;	Tahun Ini</option> --}}
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="small-box bg-white p-2">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        // === include 'setup' then 'config' above ===
        const labels = [
            <?php

            $date = \Carbon\Carbon::today()->subDays(7);
            $tgl = DB::table('transaksi_uang_sakus')->where('created_at', '>=', $date)
                            ->where(function ($query) {
                                $query->where('keterangan', '=', 'jajan harian')
                                        ->orWhere('keterangan', '=', 'kebutuhan khusus');
                            })
                            ->selectRaw("SUM(jumlah) jumlah, DATE_FORMAT(created_at, '%Y %m %e') date")
                            ->groupBy('date')
                            ->get();

                foreach($tgl as $item){
                    echo '"'.$item->date.'",';
                }
            ?>
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Pendapatan Seminggu',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [
                    <?php
                    
                    foreach($tgl as $t){
                        echo $t->jumlah.',';
                    }

                    ?>
                ],
            }]
        };

        const config = {
            type: 'line',
            plugins: [ChartDataLabels],
            data: data,
            options: {
                // indexAxis: 'y',
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@endpush
