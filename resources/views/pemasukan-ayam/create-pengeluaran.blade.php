@extends('layouts.base')
@section('title')
    Data Ayam Baru
@endsection
@section('content')
    <div class="content-body mt-2">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
            <div class="row match-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form-center">Tambah Data Pengeluaran Ayam</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div> --}}

                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form class="form" id="form" action="{{ route('pengeluaran-ayam.store-new-data-keluar') }}" enctype="multipart/form-data"
                                    method="POST">
                                    @csrf
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="eventInput1">Kandang</label>
                                                    <select name="kandang_id" class="form-control @error('kandang_id')
                                                        is-invalid
                                                    @enderror">
                                                        <option value="" selected disabled>Pilih Kandang</option>
                                                        @foreach ($kandang as $item)
                                                            <option value="{{ $item->id }}">{{ $item->kode_kandang }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('kandang_id')
                                                        <span class="text-danger">{{ $errors->first('kandang_id') }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="eventInput1">Tanggal Keluar</label>
                                                    <input type="date" id="eventInput1" class="form-control @error('tanggal_keluar')
                                                        is-invalid
                                                    @enderror" name="tanggal_keluar" value="{{ old('tanggal_keluar', date('Y-m-d')) }}">
                                                
                                                    @error('tanggal_keluar')
                                                        <span class="text-danger">{{ $errors->first('tanggal_keluar') }}</span>
                                                    @enderror
                                                </div>                                                
                                                <div class="form-group">
                                                    <h5>Jumlah Ayam</h5>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control touchspin @error('jumlah_keluar')
                                                                is-invalid
                                                            @enderror" name="jumlah_keluar"  />

                                                        </div>
                                                        @error('jumlah_keluar')
                                                            <span class="text-danger">{{ $errors->first('jumlah_keluar') }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="eventInput1">Keterangan</label>
                                                    <select name="keterangan" class="form-control @error('keterangan')
                                                        is-invalid
                                                    @enderror">
                                                        <option value="" selected disabled>Pilih Keterangan</option>
                                                        <option value="mati">Mati</option>
                                                        <option value="terjual">Terjual</option>
                                                    </select>

                                                    @error('keterangan')
                                                        <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions center">
                                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                                            <i class="fa fa-check-square-o"></i> Simpan
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic form layout section end -->
    </div>
@endsection
