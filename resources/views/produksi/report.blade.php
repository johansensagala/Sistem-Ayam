@extends('layouts.base')
@section('title')
    Data Telur
@endsection
@section('content')
    <div class="card mt-2">
        <div class="card-content collapse show">
            <div class="card-body">
                <form action="{{ route('laporan-produksi-telur.data') }}" class="form-horizontal"
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
                            <label for="status" class="label-control">
                                Keterangan
                            </label>

                            <select name="status" class="form-control" id="status">
                                <option value="" selected>Pilih Keterangan</option>
                                <option value="Normal"
                                    {{ request()->status ? (request()->status == 'Normal' ? 'selected' : '') : '' }}>Normal
                                </option>
                                <option value="Busuk"
                                    {{ request()->status ? (request()->status == 'Busuk' ? 'selected' : '') : '' }}>Busuk
                                </option>
                                <option value="Pecah"
                                    {{ request()->status ? (request()->status == 'Pecah' ? 'selected' : '') : '' }}>Pecah
                                </option>
                                <option value="Terjual"
                                    {{ request()->status ? (request()->status == 'Terjual' ? 'selected' : '') : '' }}>
                                    Terjual</option>
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

                        <div class="col-md-2 col-sm-12">
                            <label for="telur_id" class="label-control">
                                Jenis Telur
                            </label>

                            <select name="telur_id" class="form-control" id="telur_id">
                                <option value="" selected>
                                    Pilih Jenis Telur
                                </option>

                                @foreach ($telur as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request()->telur_id ? (request()->telur_id == $item->id ? 'selected' : '') : '' }}>
                                        {{ $item->nama }}
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
                                
                                        @foreach ($telur as $item)
                                            @if(isset($total[$item->nama]))
                                                @php
                                                    $totalBiayaPemasukan += $item->harga * $total[$item->nama];
                                                @endphp
                                            @endif
                                
                                            @if(isset($totalPengeluaran[$item->nama]))
                                                @php
                                                    $totalBiayaPengeluaran += $item->harga * $totalPengeluaranHarga[$item->nama];
                                                @endphp
                                            @endif
                                        @endforeach
                          
                                        {{-- <tr>
                                            <th>Total Biaya Pemasukan</th>
                                            <td>Rp{{ $totalBiayaPemasukan }}</td>
                                        </tr> --}}
                                        <tr>
                                            <th>Total Pendapatan</th>
                                            <td>Rp{{ $totalBiayaPengeluaran }}</td>
                                        </tr>
                                        {{-- <tr>
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
        {{-- <section id="stock">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4 class="card-title">Stok saat ini: {{ $stok }} butir</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </section> --}}
        <section id="stok">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <h4 class="card-title mb-1">Stok Telur</h4>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Telur</th>
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telur as $item)
                                            @if(isset($stok[$item->nama]))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $stok[$item->nama] }} butir</td>
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
        <!-- Zero configuration table -->
        <section id="stok">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <h4 class="card-title mb-1">Total Pemasukan Telur</h4>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Telur</th>
                                            <th>Total Pemasukan</th>
                                            {{-- <th>Total Harga</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telur as $item)
                                            @if(isset($total[$item->nama]))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $total[$item->nama] }} butir</td>
                                                {{-- <td>Rp{{ $totalPengeluaranHarga[$item->nama] * $item->harga }}</td> --}}
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
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Produksi</h4>
                            {{-- <div class="card-title mt-2">Total: {{ $total }} butir</div>
                            <div class="card-title mt-2">Total Biaya: RpRp{{ $total * $harga_telur }}</div> --}}
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
                                            <th>Kandang</th>
                                            <th>Jenis Telur</th>
                                            <th>Tanggal</th>
                                            <th>Kuantitas</th>
                                            <th>Keterangan</th>
                                            {{-- <th>Biaya</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produksi as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kandang->kode_kandang }}</td>
                                            <td>{{ $item->telur->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                            <td>{{ $item->kuantitas }}</td>
                                            <td>{{ $item->status }}</td>
                                            {{-- <td>Rp{{ $item->kuantitas * $item->telur->harga }}</td> --}}
                                            {{-- <td class="d-flex">
                                                <a href="{{ route('kelola-pemasukan-inventaris.edit-pemasukan-inventaris', $item->id) }}">
                                                    <button type="button" class="btn btn-icon btn-warning mr-1"><i
                                                            class="fa fa-pencil"></i></button>
                                                </a>

                                                <form action="{{ route('kelola-pemasukan-inventaris.destroy-pemasukan-inventaris', $item->id) }}" method="POST">
                                                    @method('DELETE')
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-icon btn-danger mr-1"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            </td> --}}
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
        <section id="stok">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <h4 class="card-title mb-1">Total Pengeluaran Telur</h4>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Telur</th>
                                            <th>Total Telur Keluar</th>
                                            <th>Total Pendapatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telur as $item)
                                            @if(isset($totalPengeluaran[$item->nama]))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $totalPengeluaran[$item->nama] }} butir</td>
                                                <td>Rp{{ $totalPengeluaranHarga[$item->nama] * $item->harga }}</td>
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
        <section id="pengeluaran">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Pengeluaran</h4>
                            {{-- <div class="card-title mt-2">Total: {{ $totalPengeluaran }} butir</div>
                            <div class="card-title mt-2">Total Biaya: Rp{{ $totalPengeluaran * $harga_telur }}</div> --}}
                            <button onclick="printTable5()" class="btn btn-primary mt-2">Cetak Tabel</button>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <li class="list-inline mb-0">
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
                                            <th>Kandang</th>
                                            <th>Jenis Telur</th>
                                            <th>Tanggal</th>
                                            <th>Kuantitas</th>
                                            <th>Keterangan</th>
                                            <th>Pendapatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengeluaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kandang->kode_kandang }}</td>
                                            <td>{{ $item->telur->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                            <td>{{ $item->kuantitas }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                @if ($item->status == "Terjual")
                                                    Rp{{ $item->kuantitas * $item->telur->harga }}                                 
                                                @else
                                                    -                                                    
                                                @endif
                                            </td>
                                            {{-- <td class="d-flex">
                                                <a href="{{ route('kelola-pemasukan-inventaris.edit-pemasukan-inventaris', $item->id) }}">
                                                    <button type="button" class="btn btn-icon btn-warning mr-1"><i
                                                        class="fa fa-pencil"></i></button>
                                                </a>
                                                
                                                <form action="{{ route('kelola-pemasukan-inventaris.destroy-pemasukan-inventaris', $item->id) }}" method="POST">
                                                    @method('DELETE')
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-icon btn-danger mr-1"><i
                                                        class="fa fa-trash"></i></button>
                                                </form>
                                            </td> --}}
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
    </script>
    <script>
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
                url: '/laporan-produksi-telur/getChartData',
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
