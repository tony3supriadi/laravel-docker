@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-share-alt mr-3"></i>Data Cabang
            </h2>
            <div class="col-md-6 text-right">
                @can('branch-create')
                <a href="{{ url('cabang/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle mr-2"></i> Tambah
                </a>
                @endcan
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="py-2 mb-2 border-bottom">
        <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
            <i class="fa fa-arrow-left"></i>
        </a>
        UBAH CABANG
    </div>

    <form action="{{ url('cabang/'.encrypt($branch->id)) }}" method="post">
        @csrf
        @method('put')
        <input type="hidden" value="1" name="company_id">

        <div class="form-group row">
            <label for="name" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> Nama Cabang :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="name" value="{{ old('name') ? old('name') : $branch->name }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

                @error('name')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="address" class="col-md-3 py-2 text-right">
                Alamat :
            </label>

            <div class="col-md-6">
                <textarea name="address" class="form-control">{{ old('address') ? old('address') : $branch->address }}</textarea>

                @error('address')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span> 
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="province_id" class="col-md-3 text-right">
                Provinsi :
            </label>

            <div class="col-md-6">
                <select name="province_id" data-placeholder="Pilih Provinsi" class="form-control select2">
                    <option value=""></option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov->id }}" {{ $branch->province_id == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
                    @endforeach  
                </select>
            
                @error('province_id')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span> 
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="regency_id" class="col-md-3 text-right">
                Kota/Kabupaten :
            </label>

            <div class="col-md-6">
                <select name="regency_id" data-placeholder="Pilih Kota/Kabupaten" class="form-control select2">
                    <option value=""></option>
                    @foreach($regencies as $regency)
                        <option value="{{ $regency->id }}" {{ $branch->regency_id == $regency->id ? 'selected' : '' }}>{{ $regency->name }}</option>
                    @endforeach  
                </select>
            
                @error('regency_id')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span> 
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="postcode" class="col-md-3 py-2 text-right">
                Kode Pos :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="postcode" value="{{ old('postcode') ? old('postcode') : $branch->postcode }}" class="form-control @error('postcode') is-invalid @enderror" autocomplete="off">

                @error('postcode')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-3 py-2 text-right">
                E-Mail :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="email" value="{{ old('email') ? old('email') : $branch->email }}" class="form-control @error('email') is-invalid @enderror" autocomplete="off">

                @error('email')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="phone" class="col-md-3 py-2 text-right">
                HP/WA :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="phone" value="{{ old('phone') ? old('phone') : $branch->phone }}" class="form-control @error('phone') is-invalid @enderror" autocomplete="off">

                @error('phone')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="telp" class="col-md-3 py-2 text-right">
                Telephone
            </label>
            
            <div class="col-md-6">
                <input type="text" name="telp" value="{{ old('telp') ? old('telp') : $branch->telp }}" class="form-control @error('telp') is-invalid @enderror" autocomplete="off">

                @error('telp')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-3 py-2 text-right">
                Deskripsi
            </label>
            
            <div class="col-md-6">
                <textarea name="description" class="form-control">{{ old('description') ? old('description') : $branch->description }}</textarea>

                @error('description')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <hr />

        <div class="form-group text-right row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="reset" class="btn btn-secondary">
                    <i class="fa fa-undo mr-2"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </form>
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