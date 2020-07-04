@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-id-card mr-3"></i>Karyawan
        </h2>
        <div class="col-md-6 text-right">
            @can('employee-create')
            <a href="{{ url('karyawan/create') }}" class="btn btn-primary btn-sm">
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
                UBAH KARYAWAN
            </div>

            <form action="{{ url('karyawan/'.encrypt($employee->id)) }}" method="post">
                @csrf
                @method('put')

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
                            <option value="{{ $item->id }}" {{ $item->branch_id == $employee->branch_id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                        <span class="text-red">*</span> NAMA KARYAWAN :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="name" value="{{ old('name') ? old('name') : $employee->name }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

                        @error('name')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="birthplace" class="col-md-3 py-2 text-right">
                        TEMPAT LAHIR :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="birthplace" value="{{ old('birthplace') ? old('birthplace') : $employee->birthplace }}" class="form-control @error('birthplace') is-invalid @enderror" autofocus autocomplete="off">

                        @error('birthplace')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>  

                <div class="form-group row">
                    <label for="birthdate" class="col-md-3 py-2 text-right">
                        TANGGAL LAHIR :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="date" name="birthdate" value="{{ old('birthdate') ? old('birthdate') : $employee->birthdate }}" class="form-control @error('birthdate') is-invalid @enderror" autofocus autocomplete="off">

                        @error('birthdate')
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
                        <input type="text" name="email" value="{{ old('email') ? old('email') : $employee->email }}" class="form-control @error('email') is-invalid @enderror" autofocus autocomplete="off">

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
                        <input type="text" name="phone" value="{{ old('phone') ? old('phone') : $employee->phone }}" class="form-control @error('phone') is-invalid @enderror" autofocus autocomplete="off">

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
                        <input type="text" name="address" value="{{ old('address') ? old('address') : $employee->address }}" class="form-control @error('address') is-invalid @enderror" autofocus autocomplete="off">

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
                                <option value="{{ $item->id }}" <?= $item->id == $employee->regency_id ? 'selected' : '' ?>>{{ $item->name }}</option>
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
                                <option value="{{ $item->id }}" <?= $item->id == $employee->province_id ? 'selected' : '' ?>>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postcode" class="col-md-3 py-2 text-right">
                        KODE POS :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="postcode" value="{{ old('postcode') ? old('postcode') : $employee->postcode }}" class="form-control @error('postcode') is-invalid @enderror" autofocus autocomplete="off">

                        @error('postcode')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="salary" class="col-md-3 py-2 text-right">
                        GAJI POKOK :
                    </label>
                    
                    <div class="col-md-6">
                        <input type="text" name="salary" value="{{ old('salary') ? old('salary') : $employee->salary }}" class="form-control @error('salary') is-invalid @enderror" autofocus autocomplete="off">

                        @error('salary')
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
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $employee->description }}</textarea>
                        
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