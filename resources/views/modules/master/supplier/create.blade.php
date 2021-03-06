<?php use Illuminate\Support\Facades\DB; ?>
@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-truck mr-3"></i>Supplier
        </h2>
        <div class="col-md-6 text-right">
            @can('supplier-create')
            <a href="{{ url('supplier/create') }}" class="btn btn-primary btn-sm">
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
                TAMBAH SUPPLIER
            </div>

            <form action="{{ url('supplier') }}" method="post">
                @csrf

                @if (Auth::user()->branch_id != 0)
                    <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                @elseif(count($branchs) == 1)
                    <input type="hidden" name="branch_id" value="1">
                @else
                <div class="form-group">
                    <label for="branch_id">CABANG</label>
                    <select name="branch_id" data-placeholder="" class="form-control select2 @error('branch_id') is-invalid @enderror">
                        <option value=""></option>
                        @foreach($branchs as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    @error('name')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                </div>     
                @endif

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        SUPPLIER :
                    </label>
                    
                    <div class="col-md-6 py-2">
                        <input type="radio" value="1" name="companies" class="mr-1" checked onclick="
                            if ($(this).is(':checked')) {
                                $('#cari_pelanggan').addClass('d-none');
                            } 
                        "> PERUSAHAAN
                        <span class="mx-2 text-gray">|</span>
                        <input type="radio" value="0" name="companies" class="mr-1" onclick="
                            if ($(this).is(':checked')) {
                                $('#cari_pelanggan').addClass('d-none');
                            } 
                        "> PERORANGAN
                        <span class="mx-2 text-gray">|</span>
                        <input type="radio" value="0" name="companies" class="mr-1" onclick="
                            if ($(this).is(':checked')) {
                                $('#cari_pelanggan').removeClass('d-none');
                            } 
                        "> PELANGGAN
                    </div>
                </div>

                <div class="form-group row d-none" id="cari_pelanggan">
                    <label for="car-plenggan" class="col-md-3 py-2 text-right">
                        CARI PELANGGAN
                    </label>

                    <div class="col-md-6">
                        <select name="customer_id" data-placeholder="" class="form-control select2"
                            onchange="
                                $.get('/api/customer/' + $(this).val(), function(data) {
                                    $('input[name=name]')
                                        .val(data.name)
                                        .attr('readonly', '');
                                });
                            "
                        >
                            <option value=""></option>
                            @foreach(DB::table('customers')->orderBy('name', 'ASC')->get() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> NAMA SUPPLIER :
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
                    <label for="telp" class="col-md-3 py-2 text-right">
                        TELEPHONE :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="telp" value="{{ old('telp') }}" class="form-control @error('telp') is-invalid @enderror" autofocus autocomplete="off">

                        @error('telp')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="faxmail" class="col-md-3 py-2 text-right">
                        FAX MAIL :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="faxmail" value="{{ old('faxmail') }}" class="form-control @error('faxmail') is-invalid @enderror" autofocus autocomplete="off">

                        @error('faxmail')
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
                    <label for="postcode" class="col-md-3 py-2 text-right">
                        KODE POS :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="postcode" value="{{ old('postcode') }}" class="form-control @error('postcode') is-invalid @enderror" autofocus autocomplete="off">

                        @error('postcode')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bank_id" class="col-md-3 py-2 text-right">
                        <span class="text-red">*</span> BANK :
                    </label>

                    <div class="col-md-6">
                        <select name="bank_id" class="form-control select2">
                            @foreach($banks as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bank_number" class="col-md-3 py-2 text-right">
                        NO.REKENING :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="bank_number" value="{{ old('bank_number') }}" class="form-control @error('bank_number') is-invalid @enderror" autofocus autocomplete="off">

                        @error('bank_number')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bank_account" class="col-md-3 py-2 text-right">
                        NAMA PEMILIK REKENING :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="bank_account" value="{{ old('bank_account') }}" class="form-control @error('bank_account') is-invalid @enderror" autofocus autocomplete="off">

                        @error('bank_account')
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
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>
@endsection