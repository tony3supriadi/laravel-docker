@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-cube mr-3"></i>Produk
        </h2>
        <div class="col-md-6 text-right">
            @can('produk-create')
            <a href="{{ url('produk/create') }}" class="btn btn-primary btn-sm">
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
                TAMBAH PRODUK
            </div>

            <form action="{{ url('produk') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="code" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> BARCODE :
                    </label>

                    <div class="col-md-6">
                        <input type="text" name="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" autofocus autocomplete="off">

                        @error('code')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-3 py-2">
                        <input type="checkbox" 
                            onclick="
                                if ($(this).prop('checked')) {
                                    $('input[name=code]').attr('readonly', true);
                                    $('input[name=code]').val('<?= time() ?>');
                                } else {
                                    $('input[name=code]').removeAttr('readonly');
                                    $('input[name=code]').val('');
                                }
                            "> Auto
                    </div>
                </div>

                <div class="form-group row">
                    <label for="category_id" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> KATEGORI :
                    </label>

                    <div class="col-md-6">
                        <select name="category_id" data-placeholder="Pilih Kategori" class="form-control select2">
                            <option value=""></option>
                            @foreach($categories as $item)
                                <option value="{{ $item->id }}" <?= Session::get('category_id') == $item->id ? 'selected' : '' ?>>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:" class="py-2" data-toggle="modal" data-target="#category-create">
                            <i class="fa fa-plus-circle"></i> Kategori Baru
                        </a>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> NAMA PRODUK :
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
                    <label for="purchase_price" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> HARGA BELI :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="purchase_price" value="{{ old('purchase_price') ? old('purchase_price') : 0 }}" class="form-control @error('purchase_price') is-invalid @enderror" autofocus autocomplete="off">

                        @error('purchase_price')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> HARGA JUAL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="price" value="{{ old('price') ? old('price') : 0 }}" class="form-control @error('price') is-invalid @enderror" autofocus autocomplete="off">

                        @error('price')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stock" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> STOK AWAL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="stock" value="{{ old('stock') ? old('stock') : 0 }}" class="form-control @error('stock') is-invalid @enderror" autofocus autocomplete="off">

                        @error('stock')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stockmin" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> STOK MINIMAL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="stockmin" value="{{ old('stockmin') ? old('stockmin') : 0 }}" class="form-control @error('stockmin') is-invalid @enderror" autofocus autocomplete="off">

                        @error('stockmin')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="unit_id" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> SATUAN :
                    </label>

                    <div class="col-md-6">
                        <select name="unit_id" data-placeholder="Pilih Satuan" class="form-control select2">
                            <option value=""></option>
                            @foreach($units as $item)
                                <option value="{{ $item->id }}" <?= Session::get('unit_id') == $item->id ? 'selected' : '' ?>>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <a href="javascript:" class="py-2" data-toggle="modal" data-target="#unit-create">
                            <i class="fa fa-plus-circle"></i> Satuan Baru
                        </a>
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

<div class="modal fade" id="category-create" tabindex="-1" role="dialog" aria-labelledby="category-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/produk/create-category') }}" method="post" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="category-create-label">
                    <i class="fa fa-truck mr-2"></i>TAMBAH KATEGORI BARU
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nama Kategori :</label>
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

<div class="modal fade" id="unit-create" tabindex="-1" role="dialog" aria-labelledby="unit-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/produk/create-unit') }}" method="post" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="unit-create-label">
                    <i class="fa fa-truck mr-2"></i>TAMBAH SATUAN BARU
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nama Satuan :</label>
                    <input type="text" name="name" class="form-control" autocomplete="off" required />
                </div>

                <div class="form-group">
                    <label for="symbol">Simbol :</label>
                    <input type="text" name="symbol" class="form-control" autocomplete="off" required />
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