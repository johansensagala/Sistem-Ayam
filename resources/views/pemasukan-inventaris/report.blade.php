@extends('layouts.base')
@section('title')
Data Inventaris
@endsection
@section('content')
<div class="card mt-2">
    <div class="card-content collapse show">
            <div class="card-body">
                <form action="{{ route('laporan-pemasukan-inventaris.report-pemasukan-inventaris') }}" class="form-horizontal"
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
                            <label for="inventaris_id" class="label-control">
                                Inventaris
                            </label>
                            
                            <select name="inventaris_id" class="form-control" id="inventaris_id">
                                <option value="" selected>
                                    Pilih Inventaris
                                </option>
                                
                                @foreach ($inventaris as $item)
                                <option value="{{ $item->id }}"
                                    {{ request()->inventaris_id ? (request()->inventaris_id == $item->id ? 'selected' : '') : '' }}>
                                    {{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
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
                            <div class="card-body card-dashboard col-md-6">
                                {{-- <h4 class="card-title mb-1">Rincian Biaya</h4> --}}
                                <table class="table table-striped table-bordered zero-configuration">
                                    <tbody>
                                        @php
                                            $totalBiayaPemasukan = 0;
                                            $totalBiayaPengeluaran = 0;
                                        @endphp
                                
                                        @foreach ($inventaris as $item)
                                            @if(isset($totalPerInventaris[$item->nama]))
                                                @php
                                                    $totalBiayaPemasukan += $item->harga * $totalPerInventaris[$item->nama];
                                                @endphp
                                            @endif
                                
                                            @if(isset($totalPengeluaranPerInventaris[$item->nama]))
                                                @php
                                                    $totalBiayaPengeluaran += $item->harga * $totalPengeluaranPerInventaris[$item->nama];
                                                @endphp
                                            @endif
                                        @endforeach
                                
                                        <tr>
                                            <th>Total Biaya</th>
                                            <td>Rp{{ $totalBiayaPemasukan }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Total Biaya Pengeluaran</th>
                                            <td>Rp{{ $totalBiayaPengeluaran }}</td>
                                        </tr>
                                        <tr>
                                            <th>Selisih</th>
                                            <td>Rp{{ $totalBiayaPemasukan - $totalBiayaPengeluaran }}</td>
                                        </tr> --}}
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
                        {{-- <div class="card-header">
                            <div>
                                <h4 class="card-title mb-1">Stok saat ini:</h4>
                                @foreach($inventaris as $item)
                                <div>
                                    @if(isset($stok[$item->nama]))
                                    <div>Stok {{ $item->nama }}: {{ $stok[$item->nama] }} {{ $item->satuan }}</div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div> --}}
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <h4 class="card-title mb-1">Stok Inventaris (Bahan Makanan/Obat)</h4>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Inventaris</th>
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventaris as $item)
                                            @if(isset($stok[$item->nama]))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $stok[$item->nama] }} {{ $item->satuan }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
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
        <section id="total">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <div>
                                <h4 class="card-title mb-1">Daftar Pemasukan Inventaris (Bahan Makanan/Obat)</h4>
                                @foreach($inventaris as $item)
                                <div>
                                    @if(isset($totalPerInventaris[$item->nama]))
                                        <div>Total {{ $item->nama }}: {{ $totalPerInventaris[$item->nama] }} {{ $item->satuan }}</div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div> --}}
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <h4 class="card-title mb-1">Total Pemasukan Inventaris (Bahan Makanan/Obat)</h4>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Inventaris</th>
                                            <th>Total pemasukan</th>
                                            <th>Total Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventaris as $item)
                                            @if(isset($totalPerInventaris[$item->nama]))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $totalPerInventaris[$item->nama] }} {{ $item->satuan }}</td>
                                                <td>Rp{{ $item->harga * $totalPerInventaris[$item->nama] }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>

                                </table>
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
                            <h4 class="card-title mb-1">Daftar Pemasukan Inventaris (Bahan Makanan/Obat)</h4>
                            <button onclick="printTable3()" class="btn btn-primary mt-2">Cetak Tabel</button>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div> --}}

                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration" id="myTable3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu</th>
                                            <th>Bahan Makanan/Obat</th>
                                            <th>Kandang</th>
                                            <th>Kuantitas</th>
                                            <th>Satuan</th>
                                            <th>Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pemasukanInventaris as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->waktu)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ $item->inventaris->nama }}</td>
                                                <td>{{ $item->kandang->kode_kandang }}</td>
                                                <td>{{ $item->kuantitas }}</td>
                                                <td>{{ $item->satuan }}</td>
                                                <td>Rp{{ $item->kuantitas * $item->inventaris->harga }}</td>
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
        <section id="totalPengeluaran">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <div>
                                <h4 class="card-title mb-1">Daftar Pemasukan Inventaris (Bahan Makanan/Obat)</h4>
                                @foreach($inventaris as $item)
                                <div>
                                    @if(isset($totalPerInventaris[$item->nama]))
                                        <div>Total {{ $item->nama }}: {{ $totalPerInventaris[$item->nama] }} {{ $item->satuan }}</div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div> --}}
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <h4 class="card-title mb-1">Total Pengeluaran Inventaris (Bahan Makanan/Obat)</h4>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Inventaris</th>
                                            <th>Total Pengeluaran</th>
                                            {{-- <th>Biaya</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventaris as $item)
                                            @if(isset($totalPengeluaranPerInventaris[$item->nama]))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $totalPengeluaranPerInventaris[$item->nama] }} {{ $item->satuan }}</td>
                                                {{-- <td>Rp{{ $item->harga * $totalPengeluaranPerInventaris[$item->nama] }}</td> --}}
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>    
        </section>
        <!-- Zero configuration table -->
        <section id="pengeluaran">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-1">Daftar Pengeluaran Inventaris (Bahan Makanan/Obat)</h4>
                            <button onclick="printTable5()" class="btn btn-primary mt-2">Cetak Tabel</button>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div> --}}

                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered zero-configuration" id="myTable5">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu</th>
                                            <th>Bahan Makanan/Obat</th>
                                            <th>Kandang</th>

                                            <th>Kuantitas</th>
                                            <th>Satuan</th>
                                            {{-- <th>Total Harga</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengeluaranInventaris as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->waktu)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ $item->inventaris->nama }}</td>
                                                <td>{{ $item->kandang->kode_kandang }}</td>
                                                <td>{{ $item->kuantitas }}</td>
                                                <td>{{ $item->satuan }}</td>
                                                {{-- <td>Rp{{ $item->kuantitas * $item->inventaris->harga }}</td> --}}
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
        function printTable3() {
            var printContents = document.getElementById("myTable3").outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        function printTable5() {
            var printContents = document.getElementById("myTable5").outerHTML;
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
        function drawBarStacked(data) {
            // Create the data table using the fetched data.
            var chartData = google.visualization.arrayToDataTable(data);

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
                    minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        fontSize: 12
                    }
                }
            };

            // Instantiate and draw our chart, passing in some options.
            var bar = new google.visualization.BarChart(document.getElementById('stacked-bar-chart'));
            bar.draw(chartData, options_bar_stacked);
        }

        function loadChartData() {
            $.ajax({
                url: '/laporan-pemasukan-inventaris/getChartData',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    drawBarStacked(response.data);
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
