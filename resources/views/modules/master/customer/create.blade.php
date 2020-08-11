@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-address-book-o mr-3"></i>Pelanggan
        </h2>
        <div class="col-md-6 text-right">
            @can('pelanggan-create')
            <a href="{{ url('pelanggan/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>Tambah
            </a>
            @endcan
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="py-2 mb-2 border-bottom">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                TAMBAH PELANGGAN
            </div>

            <form action="{{ url('pelanggan') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> NAMA PELANGGAN :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

                        @error('name')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="category_id" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> PILIH GRUP :
                    </label>

                    <div class="col-md-6">
                        <select name="group_id" data-placeholder="" class="form-control select2">
                            <option value=""></option>
                            @foreach($groups as $item)
                                <option value="{{ $item->id }}"
                                    @if($item->id == Session::get('group_id')) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:" class="py-2" data-toggle="modal" data-target="#group-create">
                            <i class="fa fa-plus-circle"></i> Grup Baru
                        </a>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-3 py-2 text-right">
                        E-MAIL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autofocus autocomplete="off">

                        @error('email')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-3 py-2 text-right">
                        NO HP / WA :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" autofocus autocomplete="off">

                        @error('phone')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-3 py-2 text-right">
                        ALAMAT :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" autofocus autocomplete="off">

                        @error('address')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="regency_id" class="col-md-3 py-2 text-right">
                        KOTA / KABUPATEN :
                    </label>

                    <div class="col-md-6">
                        <select name="regency_id" class="form-control select2">
                            @foreach($regencies as $item)
                                <option value="{{ $item->id }}" {{ $item->id == '3303' ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="province_id" class="col-md-3 py-2 text-right">
                        PROVINSI :
                    </label>

                    <div class="col-md-6">
                        <select name="province_id" class="form-control select2">
                            @foreach($provinces as $item)
                                <option value="{{ $item->id }}" {{ $item->id == '33' ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        DESKRIPSI :
                    </label>
                    
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        
                        @error('description')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="saldo_tabungan" class="col-md-3 text-right" style="line-height: 16px;padding:5px 0">
                        SALDO TABUNGAN/HUTANG :
                        <small class="text-muted">Hutang = nilai minus</small>
                    </label>
                    
                    <div class="col-md-6">
                        <input type="number" name="saldo_tabungan" value="{{ old('saldo_tabungan') ? old('saldo_tabungan') : 0 }}" class="form-control @error('saldo_tabungan') is-invalid @enderror" autofocus autocomplete="off">

                        @error('saldo_tabungan')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="text-right col-md-9">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fa fa-undo mr-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="group-create" tabindex="-1" role="dialog" aria-labelledby="group-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/pelanggan/create-group') }}" method="post" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="group-create-label">
                    <i class="fa fa-truck mr-2"></i>TAMBAH GRUP BARU
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nama Grup :</label>
                    <input type="text" name="name" class="form-control" autocomplete="off" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-plus-circle mr-1"></i>Tambah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>
@endsection