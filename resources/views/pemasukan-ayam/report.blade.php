@extends('layouts.base')
@section('title')
    Data Ayam
@endsection
@section('content')
    <div class="card mt-2">
        <div class="card-content collapse show">
            <div class="card-body">
                <form action="{{ route('laporan-pemasukan-ayam.data-pemasukan-ayam') }}" class="form-horizontal"
                    style="padding-bottom: 10px;border-bottom: 1px solid #d7d6d6; margin-bottom: 20px;">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-sm-12">
                            <label for="startDate" class="label-control">
                                Tanggal Awal
                            </label>

                            <input type="date" class="form-control" name="startDate" id="startDate"
                                   value="{{ old('startDate', isset(request()->startDate) ? request()->startDate : $startDate->format('Y-m-d')) }}"
                                   placeholder="Tanggal Awal">
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <label for="endDate" class="label-control">
                                Tanggal Akhir
                            </label>

                            <input type="date" class="form-control" name="endDate" id="endDate"
                                   value="{{ old('endDate', isset(request()->endDate) ? request()->endDate : $endDate->format('Y-m-d')) }}"
                                   placeholder="Tanggal Akhir">
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <label for="kandang_id" class="label-control">
                                Kandang
                            </label>

                            <select name="kandang_id" class="form-control" id="kandang_id">
                                <option value="" selected>
                                    Pilih Kandang
                                </option>

                                @foreach ($kandang as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request()->kandang_id ? (request()->kandang_id == $item->id ? 'selected' : '') : '' }}>
                                        {{ $item->kode_kandang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 d-flex mt-auto">
                            <button type="submit" class="btn btn-info btn-block">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="content-body mt-2">
        <section id="stock">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                {{-- <h4 class="card-title mb-1">Rincian Biaya</h4> --}}
                                <table class="table table-striped table-bordered zero-configuration">
                                    <tbody>    
                                        <tr>
                                            <th>Total Pendapatan</th>
                                            <td>Rp{{ $totalPengeluaran * $hargaAyam }}</td>
                                            <th>Total Ayam Keluar</th>
                                            <td>{{ $totalPengeluaran }}</td>
                                        </tr>                            
                                        <tr>
                                            <th>Total Biaya</th>
                                            <td>Rp{{ $total * $hargaAyam }}</td>
                                            <th>Total Ayam Masuk</th>
                                            <td>{{ $total }}</td>
                                        </tr>
                                        <tr>
                                            <th>Selisih</th>
                                            <td>Rp{{ $totalPengeluaran * $hargaAyam - $total * $hargaAyam }}</td>
                                            <th>Selisih</th>
                                            <td>{{ $totalPengeluaran - $total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>    
        </section>
        <section id="stock">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4 class="card-title">Stok saat ini: {{ $stok }} ekor</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </section>
        <section id="google-bar-charts">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Grafik Tahunan</h4>
                            <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div id="stacked-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Pemasukan Ayam</h4>
                            <div class="card-title mt-2">Total: {{ $total }} ekor</div>
                            <div class="card-title mt-2">Total Biaya: Rp{{ $total * $hargaAyam }}</div>
                            <button onclick="printTable()" class="btn btn-primary mt-2">Cetak Tabel</button>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div> --}}
                            
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kandang</th>
                                            {{-- <th>Jenis Ayam</th> --}}
                                            <th>Tanggal Masuk</th>
                                            <th>Kuantitas</th>
                                            <th>Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pemasukanAyam as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kandang->kode_kandang }}</td>
                                            {{-- <td>{{ $item->kandang->ayam->jenis }}</td> --}}
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}
                                                <td>{{ $item->kuantitas }}</td>
                                            </td>
                                            <td>Rp{{ $item->kuantitas * $hargaAyam }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="pengeluaran">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Pengeluaran Ayam</h4>
                            <div class="card-title mt-2">Total: {{ $totalPengeluaran }} ekor</div>
                            <div class="card-title mt-2">Total Biaya: Rp{{ $totalPengeluaran * $hargaAyam }}</div>
                            <button onclick="printTablePengeluaran()" class="btn btn-primary mt-2">Cetak Tabel</button>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div> --}}
                            
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration" id="myTable2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kandang</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Kuantitas</th>
                                            <th>Keterangan</th>
                                            <th>Pendapatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengeluaranAyam as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kandang->kode_kandang }}</td>
                                            {{-- <td>{{ $item->kandang->ayam->jenis }}</td> --}}
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d F Y') }}
                                                <td>{{ $item->jumlah_keluar }}</td>
                                            </td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                @if ($item->keterangan == "terjual")
                                                    Rp{{ $item->jumlah_keluar * $hargaAyam }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
@section('script')
@parent
<script>
        function printTable() {
            var printContents = document.getElementById("myTable").outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function printTablePengeluaran() {
            var printContents = document.getElementById("myTable2").outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    <script type="text/javascript">
        google.load('visualization', '1.0', {
            'packages': ['corechart']
        });

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(loadChartData);

        // Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
        function drawBarStacked(data, max) {
            // Create the data table using the fetched data.
            var chartData = google.visualization.arrayToDataTable(data);

            var ticksStep = Math.ceil(max / 10)

            // Set chart options
            var options_bar_stacked = {
                height: 400,
                fontSize: 12,
                colors: ['#99B898', '#FECEA8', '#FF847C', '#E84A5F', '#474747', '#4287f5'],
                chartArea: {
                    left: '5%',
                    width: '90%',
                    height: 350
                },
                isStacked: true,
                hAxis: {
                    gridlines: {
                        color: '#e9e9e9',
                        count: 10
                    },
                    ticks: [],
                    // minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        fontSize: 12
                    }
                }
            };

            for(var i = 0; i < max + ticksStep; i += ticksStep) {
                options_bar_stacked.hAxis.ticks.push(i)
            }

            // Instantiate and draw our chart, passing in some options.
            var bar = new google.visualization.BarChart(document.getElementById('stacked-bar-chart'));
            bar.draw(chartData, options_bar_stacked);
        }

        function loadChartData() {
            $.ajax({
                url: '/laporan-pemasukan-ayam/getChartData',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    drawBarStacked(response.data, response.maxLength);
                    console.log(response.data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Resize chart
        // ------------------------------

        $(function() {

            // Resize chart on menu width change and window resize
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);

            // Resize function
            function resize() {
                drawBarStacked();
            }
        });
    </script>
@endsection
