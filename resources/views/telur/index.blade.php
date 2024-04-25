@extends('layouts.base')
@section('title')
    Data Telur
@endsection
@section('content')
    <div class="content-body mt-2">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Jenis Telur</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <a href="{{ route('telur.create') }}">
                                    <button type="button" class="btn btn-info btn-min-width mr-1 mb-1">+ Tambah
                                        Data</button>
                                </a>
                                <table class="table table-striped table-bordered zero-configuration" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Telur</th>
                                            <th>Harga rata-rata per butir</th>
                                            @role('admin')
                                            <th>Kelola</th>
                                            @endrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($telur as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->harga }}</td>
                                                @role('admin')
                                                <td class="d-flex">
                                                    <a href="{{ route('telur.edit', $item->id) }}">
                                                        <button type="button" class="btn btn-icon btn-warning mr-1"><i
                                                                class="fa fa-pencil"></i></button>
                                                    </a>

                                                    <button class="btn btn-icon btn-danger mr-1 delete" data-url="{{ route('telur.destroy', $item->id) }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                                @endrole
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
