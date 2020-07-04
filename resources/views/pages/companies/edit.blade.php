@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-industry mr-3"></i>PERUSAHAAN
            </h2>
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
        UBAH PERUSAHAAN
    </div>

    <form action="{{ url('perusahaan/'.encrypt(1)) }}" method="post">
        @csrf
        @method('put')

        <div class="form-group row">
            <label for="name" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> Nama Perusahaan :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="name" value="{{ old('name') ? old('name') : $company->name }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

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
                <textarea type="text" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') ? old('address') : $company->address }}</textarea>

                @error('address')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <!-- <div class="form-group row">
            <label for="province_id" class="col-md-3 py-2 text-right">
                Provinsi :
            </label>
            
            <div class="col-md-6">
                <select name="province_id" data-placeholder="Pilih Provinsi" data-allow-clear="1" class="form-control w-100 select2 @error('province_id') is-invalid @enderror">
                    <option value=""></option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
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
            <label for="province_id" class="col-md-3 py-2 text-right">
                Kota / Kabupaten :
            </label>
            
            <div class="col-md-6">
                <select name="regency_id" readonly data-placeholder="Pilih Kota/Kabupaten" data-allow-clear="1" class="form-control w-100 select2 @error('regency_id') is-invalid @enderror">
                    <option value=""></option>
                    @foreach($regencies as $regency)
                        <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                    @endforeach
                </select>

                @error('province_id')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div> -->

        <!-- <div class="form-group row">
            <label for="postcode" class="col-md-3 py-2 text-right">
                Kode Pos :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="postcode" value="{{ old('postcode') ? old('postcode') : $company->postcode }}" class="form-control @error('postcode') is-invalid @enderror" autocomplete="off">

                @error('postcode')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div> -->

        <div class="form-group row">
            <label for="email" class="col-md-3 py-2 text-right">
                E-Mail :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="email" value="{{ old('email') ? old('email') : $company->email }}" class="form-control @error('email') is-invalid @enderror" autocomplete="off">

                @error('email')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="phone" class="col-md-3 py-2 text-right">
                HP / WA :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="phone" value="{{ old('phone') ? old('phone') : $company->phone }}" class="form-control @error('phone') is-invalid @enderror" autocomplete="off">

                @error('phone')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="telp" class="col-md-3 py-2 text-right">
                Telephone :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="telp" value="{{ old('telp') ? old('telp') : $company->telp }}" class="form-control @error('telp') is-invalid @enderror" autocomplete="off">

                @error('telp')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="website" class="col-md-3 py-2 text-right">
                Website :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="website" value="{{ old('website') ? old('website') : $company->website }}" class="form-control @error('website') is-invalid @enderror" autocomplete="off">

                @error('website')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="facebook" class="col-md-3 py-2 text-right">
                Facebook :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="facebook" value="{{ old('facebook') ? old('facebook') : $company->facebook }}" class="form-control @error('facebook') is-invalid @enderror" autocomplete="off">

                @error('facebook')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="twitter" class="col-md-3 py-2 text-right">
                Twitter :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="twitter" value="{{ old('twitter') ? old('twitter') : $company->twitter }}" class="form-control @error('twitter') is-invalid @enderror" autocomplete="off">

                @error('twitter')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="instagram" class="col-md-3 py-2 text-right">
                Instagram :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="instagram" value="{{ old('instagram') ? old('instagram') : $company->instagram }}" class="form-control @error('instagram') is-invalid @enderror" autocomplete="off">

                @error('instagram')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-3 py-2 text-right">
                Description :
            </label>
            
            <div class="col-md-6">
                <textarea type="text" rows="5" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $company->description }}</textarea>

                @error('description')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

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