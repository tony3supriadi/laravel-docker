@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">
            <i class="fa fa-cubes mr-3"></i>Satuan
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
                UBAH SATUAN
            </div>

            <form action="{{ url('produk/satuan/'.encrypt($unit->id)) }}" method="post">
                @csrf
                @method('put')

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> NAMA SATUAN :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="name" value="{{ old('name') ? old('name') : $unit->name }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

                        @error('name')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="symbol" class="col-md-3 py-2 text-right">
                        SIMBOL SATUAN :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="symbol" value="{{ old('symbol') ? old('symbol') : $unit->symbol }}" class="form-control @error('symbol') is-invalid @enderror" autofocus autocomplete="off">

                        @error('symbol')
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
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $unit->description }}</textarea>
                        
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
                            <i class="fa fa-edit mr-2"></i>Ubah
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection