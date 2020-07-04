@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-user-circle mr-3"></i>Akunku
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
        UBAH AKUN
    </div>

    <form action="{{ url('users/'.encrypt(Auth::user()->id)) }}" method="post">
        @csrf
        @method('put')

        <div class="form-group row">
            <label for="name" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> Nama User :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="name" value="{{ old('name') ? old('name') : $user->name }}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off">

                @error('name')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> E-Mail :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="email" value="{{ old('email') ? old('email') : $user->email }}" class="form-control @error('email') is-invalid @enderror" autocomplete="off">

                @error('email')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="username" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> Username :
            </label>
            
            <div class="col-md-6">
                <input type="text" name="username" value="{{ old('username') ? old('username') : $user->username }}" class="form-control @error('username') is-invalid @enderror" autocomplete="off" readonly>

                @error('username')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> Kata Sandi :
            </label>
            
            <div class="col-md-6">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

                @error('password')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>    
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3 py-2 text-right">
                <span class="text-red">*</span> Konfirmasi Kata Sandi :
            </label>
            
            <div class="col-md-6">
                <input type="password" name="confirm-password" class="form-control">
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