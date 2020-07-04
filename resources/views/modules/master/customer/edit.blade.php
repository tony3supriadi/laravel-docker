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
                UBAH PELANGGAN
            </div>

            <form action="{{ url('pelanggan/'.encrypt($customer->id)) }}" method="post">
                @csrf
                @method('put')

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> NAMA PELANGGAN :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="name" value="{{ old('name') ? old('name') : $customer->name }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

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
                        <select name="group_id" class="form-control select2">
                            @foreach($groups as $item)
                                <option value="{{ $item->id }}" <?= $item->id == $customer->group_id ? 'selected' : '' ?>>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('pelanggan/grup') }}" class="py-2">
                            <i class="fa fa-plus-circle"></i> Grup Baru
                        </a>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-3 py-2 text-right">
                        E-MAIL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="email" value="{{ old('email') ? old('email') : $customer->email }}" class="form-control @error('email') is-invalid @enderror" autofocus autocomplete="off">

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
                        <input type="text" name="phone" value="{{ old('phone') ? old('phone') : $customer->phone }}" class="form-control @error('phone') is-invalid @enderror" autofocus autocomplete="off">

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
                        <input type="text" name="address" value="{{ old('address') ? old('address') : $customer->address }}" class="form-control @error('address') is-invalid @enderror" autofocus autocomplete="off">

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
                                <option value="{{ $item->id }}" <?= $item->id == $customer->regency_id ? 'selected' : '' ?>>{{ $item->name }}</option>
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
                                <option value="{{ $item->id }}" <?= $item->id == $customer->province_id ? 'selected' : '' ?>>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        DESKRIPSI :
                    </label>
                    
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $customer->description }}</textarea>
                        
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