@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-address-book-o mr-3"></i>CATATAN TABUNGAN
        </h2>
        <div class="col-md-6 text-right">
            <a href="{{ url('pelanggan/catatan-tabungan/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>Tambah
            </a>
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
                TAMBAH CATATAN TABUNGAN
            </div>

            <form action="{{ url('pelanggan/catatan-tabungan') }}" method="post">
                @csrf

                <input type="hidden" name="code" value="{{ time() }}">

                <div class="form-group row">
                    <label for="pelanggan" class="col-md-3 py-2 text-right">
                        CARI PELANGGAN
                    </label>

                    <div class="col-md-6">
                        <select data-placeholder="" name="customer_id" class="form-control select2"
                            onchange="
                                $.get('/api/customer/' + $(this).val(), function(data) {
                                    $('input[name=saldo_saat_ini]').val(data.saldo_tabungan);
                                    $('#formInput').removeClass('d-none');
                                });
                            "
                        >
                            <option value=""></option>
                            @foreach($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="formInput" class="d-none">
                    <div class="form-group row">
                        <label for="saldo_saat_ini" class="col-md-3 py-2 text-right">
                            SALDO SAAT INI
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="saldo_saat_ini" class="form-control" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 py-2 text-right">
                            DESKRIPSI
                        </label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 py-2 text-right">
                            STATUS
                        </label>
                        <div class="col-md-6 py-2">
                            <input type="radio" name="status" class="mr-2" value="Kredit" checked> Kredit
                            <span class="mx-2 text-light">|</span>
                            <input type="radio" name="status" class="mr-2" value="Debit"> Debit
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nominal" class="col-md-3 py-2 text-right">
                            NOMINAL
                        </label>

                        <div class="col-md-4">
                            <input type="number" name="nominal" class="form-control" required>
                        </div>
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

<div class="modal fade" id="group-create" tabindex="-1" role="dialog" aria-labelledby="group-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/pelanggan/create-group') }}" method="post" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="group-create-label">
                    <i class="fa fa-truck mr-2"></i>TAMBAH GRUP BARU
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nama Grup :</label>
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
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>
@endsection