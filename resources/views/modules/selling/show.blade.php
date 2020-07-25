@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-shopping-cart mr-3"></i>Data Penjualan
        </h2>
    </div>
</header>
@endsection

@section('content')
<?php use Illuminate\Support\Facades\DB; ?>
<section class="p-4">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="py-2 border-bottom">
                <a href="{{ url('/penjualan/riwayat') }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                DETAIL PENJUALAN
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tr>
                            <th class="text-right" width="25%">PELANGGAN</th>
                            <th width="5px">:</th>
                            <td>{{ $sale->customer_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right" width="25%">TOTAL</th>
                            <th width="5px">:</th>
                            <td>Rp{{ number_format($sale->price_total, 0, ',', '.') }},-</td>
                        </tr>
                        <tr>
                            <th class="text-right" width="25%">STATUS</th>
                            <th width="5px">:</th>
                            <td>
                                <span class="badge badge-pill {{ (($sale->status == 'Lunas') ? 'badge-success' : (($sale->status == 'Piutang') ? 'badge-danger text-white' : 'badge-secondary')) }}">
                                    {{ $sale->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right" width="25%">DESKRIPSI</th>
                            <th width="5px">:</th>
                            <td>{{ $sale->description }}</td>
                        </tr>
                    </table>    
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">DAFTAR PRODUK :</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <?php $num = 1; ?>
                        @foreach($sale['items'] as $item)
                        <tr>
                            <td width="10px">{{$num}}.</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">{{ $item->qty }}xRp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($item->sub_total, 0, ',', '.') }},-</td>
                        </tr>
                        <?php $num++; ?>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    BUKTI PEMBAYARAN

                    <a href="javascript:" data-toggle="modal" data-target="#cetak" class="float-right btn btn-sm btn-outline-primary rounded-pill">
                        <i class="fa fa-print mr-1"></i> PRINT
                    </a>

                    @if ($sale->status == 'Piutang')
                    <a href="javascript:" data-toggle="modal" data-target="#payment-create" class="float-right btn btn-sm btn-outline-primary rounded-pill mx-2">
                        <i class="fa fa-plus-circle mr-1"></i> PELUNASAN
                    </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <?php $num = 1; ?>
                        <?php $payment = 0; ?>
                        <?php $last = []; ?>
                        @foreach($sale['payments'] as $item)
                        <?php $last = $item; ?>
                        <tr>
                            <td width="5px">{{ $num }}.</td>
                            <td width="20%">{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                            <td width="50%">{{ $item->description }}</td>
                            <td class="text-right">{{ number_format($item->debit, 0, ',', '.') }}</td>
                        </tr>
                        <?php $payment = $item->payment ?>
                        <?php $num++; ?>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">TOTAL :</th>
                                <td class="text-right">{{ number_format($payment, 0, ',', '.') }}</td>
                            </tr>

                            @if($last->payment > $last->billing)
                            <tr>
                                <th colspan="3" class="text-right">UANG KEMBALIAN :</th>
                                <td class="text-right">
                                    {{ number_format(($last->payment - $last->billing), 0, ',', '.') }}
                                </td>
                            </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payment-create" tabindex="-1" role="dialog" aria-labelledby="payment-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/penjualan/create-payments') }}" method="post" class="modal-content">
            @csrf
            <?php $last = DB::table('sale_payments')
                            ->where('sale_id', '=', $sale->id)
                            ->orderBy('id', 'DESC')
                            ->first(); ?>
            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
            <input type="hidden" name="customer_id" value="{{ $last->customer_id }}">
            <input type="hidden" name="billing" value="{{ $last->billing }}">
            <input type="hidden" name="payment" value="{{ $last->payment }}">
            
            <div class="modal-header">
                <h5 class="modal-title" id="payment-create-label">
                    <i class="fa fa-clipboard mr-2"></i>CATATAN PEMBAYARAN PIUTANG
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="20%" class="text-right">TAGIHAN</th>
                        <th width="5px">:</th>
                        <td class="text-right">Rp{{ number_format($last->billing, 0, ',', '.') }},-</td>
                    </tr>
                    <tr>
                        <th width="20%" class="text-right">TERBAYAR</th>
                        <th width="5px">:</th>
                        <td class="text-right">Rp{{ number_format($last->payment, 0, ',', '.') }},-</td>
                    </tr>
                    <tr>
                        <th width="20%" class="text-right">KEKURANGAN</th>
                        <th width="5px">:</th>
                        <td class="text-right">Rp{{ number_format(($last->billing - $last->payment), 0, ',', '.') }},-</td>
                    </tr>

                    <tr>
                        <th class="align-middle text-right">PEMBAYARAN</th>
                        <th class="align-middle">:</th>
                        <td><input type="text" name="debit" placeholder="0" class="form-control text-right" autocomplete="off" required /></td>
                    </tr>
                    <tr>
                        <th class="align-middle text-right">DESKRIPSI</th>
                        <th class="align-middle">:</th>
                        <td><textarea name="description" class="form-control"></textarea></td>
                    </tr>
                </table>
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

<div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="cetak-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment-create-label">
                    <i class="fa fa-print mr-2"></i>CETAK BUKTI PEMBAYARAN
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="nota-print" class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <h4 class="m-0 p-0"><strong>{{ $company->name }}</strong></h4>
                            <p class="m-0 p-0" id="perusahaan-info" style="line-height: 15px"><small>{{ $company->address }} <br />{!! $company->telp ? 'Telp.'.$company->telp .' <br /> WA.'.$company->phone : 'HP/WA.'.$company->phone !!}<br />E-Mail:{{ $company->email ? $company->email : '-' }}</small></p>
                        </td>
                        <td width="40%" valign="bottom">
                            <table width="100%" id="pelanggan">
                                <tr>
                                   <td><p class="p-0 m-0" style="line-height: 15px"><small>Nota<br />Tanggal<br/>Nama</small></p></td>
                                   <td><p class="p-0 m-0" style="line-height: 15px"><small>:<br />:<br />:</small></p></td>
                                   <td><p class="p-0 m-0" style="line-height: 15px"><small>{{ $sale->invoice }}<br />{{ Carbon\Carbon::parse($sale->created_at)->format('d/m/Y') }}<br />{{ $sale->customer_name }}</small></p></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr class="my-1" style="border:1px solid #666" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="tabel-produk" class="table table-bordered table-sm" width="100%">
                                <thead>
                                <tr class="bg-dark text-light">
                                    <th>NAMA PRODUK</th>
                                    <th width="10%" class="text-center">QTY</th>
                                    <th width="25%" class="text-right">HARGA</th>
                                    <th width="25%" class="text-right">JUMLAH</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $total = 0; ?>
                                @foreach($sale['items'] as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-right">{{ number_format($item->price, 0, ',','.') }}</td>
                                    <td class="text-right">{{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                </tr>
                                <?php $total =  $total + $item->sub_total; ?>
                                @endforeach

                                @if($sale->is_barter)
                                <tr>
                                    <td colspan="4">
                                        {{ $sale->description }}
                                    </td>
                                </tr>
                                @endif

                                @if(count($sale['items']) < 10) 
                                    @for($i = 0; $i < (10 - count($sale['items'])); $i++) 
                                        <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                                    @endfor
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">TOTAL :</th>
                                    <th class="text-right">{{ number_format($total, 0,',','.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right" style="border:0px">PEMBAYARAN :</th>
                                    <th class="text-right">{{ number_format($last->payment, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right" style="border:0px">UANG KEMBALIAN :</th>
                                    <th class="text-right">{{ $sale->status == "Lunas" ? number_format(($last->payment - $last->billing), 0, ',', '.') : 0 }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">HUTANG :</th>
                                    <th class="text-right">{{ ($last->billing <= $last->payment) ? 0 : number_format(($last->billing - $last->payment), 0, ',', '.') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr id="keterangan">
                        <td width="70%" class="pt-3">
                             <div class="border p-2 mr-4" style="line-height:14px">
                                 <small>Terima kasih atas kunjungan Anda. <br />
                                 Harap periksa barang sebelum dibayar. <br />
                                 Barang yang sudah dibeli tidak dapat ditukar.</small>
                             </div>
                        </td>
                        <td width="30%" class="text-center pt-3">
                            <small>Hormat Kami, <br /><br /><br />
                            (...................................)</small>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer text-center">
                <a href="javascript:"
                    onclick="
                        var printContents = document.getElementById('nota-print').innerHTML;
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                        " class="btn btn-outline-primary btn-sm rounded-pill">
                    <i class="fa fa-print mr-2"></i>Cetak
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">

<style type="text/css">
@media print {
    h4 {
        color: #000 !important;
        font-size: 48px;
    }
    #perusahaan-info, #pelanggan p, #keterangan, #keterangan div {
        font-size: 30px;
        line-height: 30px !important;
    }
    #tabel-produk {
        font-size: 30px;
    }
}
</style>
@endsection

@section('script')
@if(Session::get('backPayment'))
<form id="simpanTabungan" action="{{ url('penjualan/'.encrypt($sale->customer_id).'/simpanTabungan') }}" method="post">
    @csrf
    <input type="hidden" name="saldo_tabungan" value="{{ ($last->payment - $last->billing) }}">
</form>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
<script type="text/javascript">
Swal.fire({
  title: 'UANG KEMBALIAN',
  text: "{{ number_format(($last->payment - $last->billing), 0, ',', '.') }}",
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'DISIMPAN',
  cancelButtonText: 'TUTUP',
}).then((result) => {
  if (result.value) {
    event.preventDefault();
    document.getElementById('simpanTabungan').submit();
  }
})
</script>
@endif
@endsection