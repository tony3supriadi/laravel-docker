@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-cubes mr-3"></i>Stok Produk
        </h2>
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
                ATUR STOK {{ strtoupper($product->name) }}
            </div>

            <form action="{{ url('produk/stok/'.encrypt($product->id)) }}" method="post">
                @csrf
                @method('put')

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="form-group row">
                    <label for="code" class="col-md-3 text-right">
                        BARCODE :
                    </label>

                    <div class="col-md-6">
                        {{ $product->code }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 text-right">
                        NAMA PRODUK :
                    </label>
                    
                    <div class="col-md-6">
                        {{ $product->name }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span>  CABANG :
                    </label>
                    
                    <div class="col-md-6">
                        @if ($branch == null) 
                            <select name="branch_id" class="form-control select2 @error('branch_id') is-invalid @enderror">
                                @foreach($branchs as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            @error('branch_id')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>    
                            @enderror
                        @else 
                            {{ $branch->name }}
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stock_status" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> STATUS STOK :
                    </label>
                    
                    <div class="col-md-6">
                        <select name="stock_status"
                            onchange="
                                if ($(this).val() == 'Transfer') {
                                    $('.branchTo').removeClass('d-none')
                                }
                            "
                            class="form-control select2 @error('branch_id') is-invalid @enderror">
                            
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                            <option value="Opnam">Stok Opnam</option>
                            @if (count($branchs) > 1)
                            <option value="Transfer">Transfer</option>
                            @endif
                        </select>

                        @error('stock_status')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row branchTo d-none">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span>  CABANG TUJUAN :
                    </label>
                    
                    <div class="col-md-6">
                        @if ($branch == null) 
                            <select name="branch_to" class="form-control select2 @error('branch_to') is-invalid @enderror">
                                @foreach($branchs as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            @error('branch_to')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>    
                            @enderror
                        @else 
                            {{ $branch->name }}
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stock_nominal" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> JUMLAH PRODUK :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="stock_nominal" value="{{ old('stock_nominal') ? old('stock_nominal') : 0 }}" class="form-control @error('stock_nominal') is-invalid @enderror" autofocus autocomplete="off">

                        @error('stock_nominal')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        DESKRIPSI :
                    </label>
                    
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                        
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
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>
@endsection