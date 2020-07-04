@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-money mr-3"></i>Harga Produk
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
                UBAH HARGA PRODUK
            </div>

            <form action="{{ url('produk/harga/'.encrypt($product->id)) }}" method="post">
                @csrf
                @method('put')

                <div class="form-group row">
                    <label for="code" class="col-md-3 text-right">
                        BARCODE :
                    </label>

                    <div class="col-md-6">
                        {{ $product->product_code }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 text-right">
                        NAMA PRODUK :
                    </label>
                    
                    <div class="col-md-6">
                        {{ $product->product_name }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 text-right">
                        GRUP PELANGGAN :
                    </label>
                    
                    <div class="col-md-6">
                        {{ $product->group_name }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> HARGA JUAL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="price" value="{{ old('price') ? old('price') : $product->price }}" class="form-control @error('price') is-invalid @enderror" autofocus autocomplete="off">

                        @error('price')
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
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $product->description }}</textarea>
                        
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