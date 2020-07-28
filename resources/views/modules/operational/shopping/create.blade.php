@extends('layouts.app')

@section('header')
<div class="row position-fixed p-0 m-0 w-100">
    <div class="col-md-12 m-0 p-0">
        <div class="py-2 px-3 mb-2 border-bottom">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                TAMBAH DATA BELANJA
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="px-4 py-0">
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-info">
                <small class="d-block">TANGGAL BELANJA :</small>
                {{ Carbon\Carbon::now()->format('d M Y, H:i:s') }}
            </div>

            <div class="card">
                <div class="card-header">
                    Cari Produk
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <select data-placeholder="Kode atau nama produk"
                            class="form-control select2"
                            onchange="
                                var id = $(this).val();
                                $.get('/api/produk/' + id, function(data) {
                                    if (!data.id) {
                                        $('#product-not-found').addClass('d-block');
                                    } else {
                                        $('#detail-text-code').html(data.code);
                                        $('#detail-text-name').html(data.name);
                                        $('#detail-text-stock').html(data.stock);
                                        $('#detail-text-unit').html(data.unit_name + ' (' + data.unit_symbol + ')');

                                        $('#detail-value-id').val(data.id);
                                        $('#detail-value-code').val(data.code);
                                        $('#detail-value-name').val(data.name);

                                        $('#detail-product').removeClass('d-none');
                                        $('#empty-detail-product').addClass('d-none');
                                    }
                                });
                            ">

                            <option value=""></option>
                            @foreach($products as $item)
                            <option value="{{ $item->id }}">
                                <small class="text-mutted d-block">{{ $item->code }}</small> - 
                                <p class="no-border-bottom">{{ $item->name }}</p>
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>  

            <div class="card">
                <div class="card-header">
                    Detail Produk
                </div>
                <div class="card-body p-0">
                    <div id="detail-product" class="d-none">
                        <table id="" class="table table-sm">
                            <tr>
                                <th width="35%" class="text-right">Kode</th>
                                <th width="1px">:</th>
                                <td id="detail-text-code">1209346209</td>
                            </tr>
                            <tr>
                                <th width="30%" class="text-right">Nama Produk</th>
                                <th width="1px">:</th>
                                <td id="detail-text-name">Konsentrat</td>
                            </tr>
                            <tr>
                                <th width="30%" class="text-right">Saldo Stok</th>
                                <th width="1px">:</th>
                                <td id="detail-text-stock">20</td>
                            </tr>
                            <tr>
                                <th width="30%" class="text-right">Satuan</th>
                                <th width="1px">:</th>
                                <td id="detail-text-unit">Kilogram (kg)</td>
                            </tr>
                        </table>

                        <hr />
                        
                        <form action="{{ url('belanja/add-to-cart') }}" method="post" class="px-3">
                            @csrf 

                            <input type="hidden" name="id" id="detail-value-id">
                            <input type="hidden" name="code" id="detail-value-code">
                            <input type="hidden" name="name" id="detail-value-name">

                            <div class="form-group">
                                <label for="count_item">Qty</label>
                                <input type="text" name="quantity" value="1" class="form-control text-right" autofocus="off">
                            </div>

                            <div class="form-group">
                                <label for="price">Harga Beli</label>
                                <input type="text" name="price" value="0" class="form-control text-right" autofocus="off">
                            </div>

                            <div class="form-group">
                                <label for="price">Deskripsi</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block">
                                    <i class="fa fa-plus-circle mr-2"></i>
                                    TAMBAH PRODUK BELANJA
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="empty-detail-product" class="p-3"></div>
                </div>
            </div>  
        </div>
        <div class="col-md-8">
            <h3 class="text-right p-3 border">
                TOTAL : Rp{{ number_format(Cart::getTotal(), 0, ',', '.') }},-
            </h3>
            <div class="card">
                <div class="card-header">
                    Rincian Belanja
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th width="10%">KODE</th>
                                <th>NAMA PRODUK</th>
                                <th width="10%">QTY</th>
                                <th width="20%" class="text-right">HARGA BELI</th>
                                <th width="20%" class="text-right">SUB TOTAL</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @if(Cart::getContent())
                                @foreach(Cart::getContent() as $item)
                                <tr>
                                    <td>
                                        <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                            <i class="fa fa-trash-o"></i>
                                        </a>

                                        <form id="delete-item-{{ md5($item->id) }}"
                                            action="{{ url('belanja/destroy-cart/'.$item->id) }}"
                                            method="post"
                                            style="display: none;"
                                        >    
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                    <td>{{ $item->attributes->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format(($item->quantity * $item->price), 0, ',', '.') }},-</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    Daftar belanja belum ditambahkan.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <hr />

                    <form action="{{ url('/belanja') }}" method="post" class="row px-4 mb-2">
                        @csrf
                    
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="supplier_id" class="mb-0">
                                    Penyuplai
                                </label>
                                <a href="javascript:" class="text-decoration-none float-right" data-toggle="modal" data-target="#supplier-create">
                                    <small>
                                        <i class="fa fa-plus-circle mr-1"></i>
                                        Tambah
                                    </small>
                                </a>    
                                <select name="supplier_id" data-placeholder="" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($suppliers as $item)
                                        <option value="{{ $item->id }}" @if(Session::get('id') == $item->id) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="total" class="mb-0">Total</label>
                                <input type="text" name="total" value="{{ Cart::getTotal() }}" class="form-control text-right" readonly />
                            </div>

                            <div class="form-group mb-1">
                                <label for="status" class="mb-0">Status Pembayaran</label>
                                <select name="status" class="form-control select2"
                                    onchange="
                                        if ($(this).val() == 'Uang Muka') {
                                            $('#payment').removeClass('d-none');
                                            $('input[name=payment]').val(0);
                                        } else
                                        if ($(this).val() == 'Lunas') {
                                            $('#payment').addClass('d-none');
                                            $('input[name=payment]').val(<?= Cart::getTotal() ?>);
                                        } else
                                        if ($(this).val() == 'Hutang') {
                                            $('#payment').addClass('d-none');
                                            $('input[name=payment]').val(0);
                                        }
                                    ">
                                    <option value="Lunas">Lunas</option>
                                    <option value="Hutang">Hutang</option>
                                    <option value="Uang Muka">Uang Muka</option>
                                </select>
                            </div>

                            <div id="payment" class="form-group mb-1 d-none">
                                <label for="payment" class="mb-0">Jumlah Pembayaran</label>
                                <input type="text" name="payment" value="{{ Cart::getTotal() }}" class="form-control text-right" />
                            </div>

                            <div class="form-group">
                                <label for="payment" class="mb-0">Deskripsi</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-paper-plane"></i> SIMPAN
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="supplier-create" tabindex="-1" role="dialog" aria-labelledby="supplier-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/belanja/create-supplier') }}" method="post" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="supplier-create-label">
                    <i class="fa fa-truck mr-2"></i>TAMBAH SUPPLIER BARU
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Supplier :</label> <br />
                    <input type="radio" name="companies" value="1" class="mr-2" autocomplete="off" checked /> Perusahaan <br />
                    <input type="radio" name="companies" value="0" class="mr-2" autocomplete="off" /> Perorangan
                </div>

                <div class="form-group">
                    <label for="name">Nama Supplier :</label>
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
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('js/init/sweetalert2.init.js') }}"></script>
@endsection