@extends('layouts.base')
@section('title')
    Data Kandang
@endsection
@section('content')
    <div class="content-body mt-2">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Kandang</h4>
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
                                            <th>Kode Kandang</th>
                                            <th>Jenis Ayam</th>
                                            <th>Kapasitas</th>
                                            <th>Kelola</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kandang as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_kandang }}</td>
                                            <td>{{ $item->ayam->jenis }}</td>
                                            <td>{{ $item->kapasitas }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('pengeluaran.barang-inventaris', $item->id) }}">
                                                    <button type="button" class="btn btn-icon btn-primary mr-1"><i
                                                            class="fa fa-book"></i></button>
                                                </a>
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
