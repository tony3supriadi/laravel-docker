@extends('layouts.app')

@section('header')
<div class="row position-fixed p-0 m-0 w-100">
    <div class="col-md-12 m-0 p-0">
        <div class="py-2 px-3 mb-2 border-bottom">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                TAMBAH DATA PENJUALAN
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="px-4 py-0">
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-info">
                <small class="d-block">TANGGAL PENJUALAN :</small>
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
                                        if (data.stock <= data.stockmin) {
                                            $('#detail-text-stock').addClass('text-danger');
                                        }
                                        $('#detail-text-stock').html(data.stock);
                                        $('#detail-text-price').html(data.price);
                                        $('#detail-text-unit').html(data.unit_name + ' (' + data.unit_symbol + ')');

                                        $('#detail-value-id').val(data.id);
                                        $('#detail-value-code').val(data.code);
                                        $('#detail-value-name').val(data.name);
                                        $('#detail-value-price').val(data.price);
                                        $('#detail-value-purchase_price').val(data.purchase_price);
                                        
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
                            <tr>
                                <th width="30%" class="text-right">Harga Jual</th>
                                <th width="1px">:</th>
                                <td id="detail-text-price">1000</td>
                            </tr>
                        </table>

                        <hr />
                        
                        <form action="{{ url('penjualan/add-to-cart') }}"
                            onsubmit="
                                var stock = $('#detail-text-stock').html();
                                var qty = $('#qty').val();

                                if (parseInt(qty) > parseInt(stock)) {
                                    $('#qty').addClass('is-invalid');
                                    $('#qtyError').addClass('d-block');
                                    $('#qtyError #message').html('Qty melebihi jumlah stok.');
                                    return false;
                                }

                                if (!qty) {
                                    $('#qty').addClass('is-invalid');
                                    $('#qtyError').addClass('d-block');
                                    $('#qtyError #message').html('Qty minimal 1.');
                                    return false;
                                }
                            "
                            method="post" class="px-3">
                            @csrf 

                            <input type="hidden" name="id" id="detail-value-id">
                            <input type="hidden" name="code" id="detail-value-code">
                            <input type="hidden" name="name" id="detail-value-name">
                            <input type="hidden" name="price" id="detail-value-price">
                            <input type="hidden" name="purchase_price" id="detail-value-purchase_price">

                            <div class="form-group">
                                <label for="count_item">Qty</label>
                                <input type="text" id="qty" name="quantity" value="1" class="form-control text-right" autocomplete="off">

                                <span id="qtyError" class="invalid-feedback">
                                    <strong id="message"></strong>
                                </span>  
                            </div>

                            <div class="form-group">
                                <label for="price">Deskripsi</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block">
                                    <i class="fa fa-plus-circle mr-2"></i>
                                    TAMBAH PRODUK PENJUALAN
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
                    Rincian Penjualan
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th width="10%">KODE</th>
                                <th>NAMA PRODUK</th>
                                <th width="10%">QTY</th>
                                <th width="20%" class="text-right">HARGA JUAL</th>
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
                                            action="{{ url('penjualan/destroy-cart/'.$item->id) }}"
                                            method="post"
                                            style="display: none;"
                                        >    
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                    <td>{{ $item->attributes->code }}</td>
                                    <td>{{ explode("-", $item->name)[0] }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format(($item->quantity * $item->price), 0, ',', '.') }},-</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    Daftar penjualan belum ditambahkan.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <hr />

                    <form action="{{ url('/penjualan') }}" method="post" class="row px-4 mb-2">
                        @csrf
                    
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="customer_id" class="mb-0">
                                    Pelanggan
                                </label>
                                <a href="javascript:" class="text-decoration-none float-right" data-toggle="modal" data-target="#customer-create">
                                    <small>
                                        <i class="fa fa-plus-circle mr-1"></i>
                                        Tambah
                                    </small>
                                </a>    
                                <select name="customer_id" 
                                    onchange="
                                        window.location.href='{{ url('penjualan/update-to-cart/') }}/' + $(this).val()" data-placeholder="" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($customers as $item)
                                        <option value="{{ $item->id }}" @if(Session::get('id') == $item->id) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="total" class="mb-0">Total</label>
                                <input type="text" name="total" value="{{ Cart::getTotal() }}" class="form-control text-right" readonly />
                            </div>
                            
                            <div class="form-group">
                                <label for="metode-pembayaran">Metode Pembayaran</label>
                                <select name="metodePembayaran" id="metodePembayaran"
                                    onchange="
                                        var value = $(this).val();
                                        if (value == 'tunai') {
                                            $('#payment').removeClass('d-none');
                                            $('#barter').addClass('d-none');
                                            $('#tabunganText').addClass('d-none');

                                            $('input[name=payment]').val(0).removeAttr('readonly');
                                        } else
                                        if (value == 'tabungan') {
                                            $('#payment').removeClass('d-none');
                                            $('#barter').addClass('d-none');
                                            $('#tabunganText').removeClass('d-none');

                                            $('input[name=payment]').attr('readonly', '');
                                            
                                            var id = $('select[name=customer_id]').val();
                                            $.get('<?= url('api/customer') ?>/' + id, function(data) {
                                                $('input[name=payment]').val(data.saldo_tabungan);
                                            });
                                        } else
                                        if (value == 'barter') {
                                            $('#payment').addClass('d-none');
                                            $('#barter').removeClass('d-none');
                                            $('#tabunganText').addClass('d-none');

                                            $('input[name=payment]').val(0).removeAttr('readonly');
                                        }
                                    "
                                    class="form-control select2">
                                    <option value="tunai">Uang Tunai</option>
                                    <option value="tabungan">Tabungan</option>
                                    <option value="barter">Barter</option>
                                </select>
                            </div>
                            <div id="payment" class="form-group mb-2">
                                <label for="payment" class="mb-0">Jumlah Pembayaran</label>
                                <input type="text" name="payment" value="0" class="form-control text-right" autofocus="off" />
                            </div>
                            
                            <div id="barter" class="d-none">
                                <div class="form-group mb-1">
                                    <label for="barang_barter" class="mb-0">Barang Barter</label>
                                    <input type="text" value="TELOR" class="form-control" readonly>
                                    <input type="hidden" name="barang_barter" value="1">
                                </div>

                                <div class="form-group mb-1">
                                    <label for="payment" class="mb-0">Jumlah Barang</label>
                                    <input type="text" name="jumlah_barang_barter" value="0" class="form-control text-right" autofocus="off" />
                                </div>
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

<div class="modal fade" id="customer-create" tabindex="-1" role="dialog" aria-labelledby="customer-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/penjualan/create-customer') }}" method="post" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="customer-create-label">
                    <i class="fa fa-truck mr-2"></i>TAMBAH PELANGGAN BARU
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nama Pelanggan :</label>
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