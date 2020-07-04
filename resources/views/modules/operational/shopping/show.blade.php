@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-shopping-cart mr-3"></i>Data Belanja
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
                <a href="{{ url('/belanja') }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                DETAIL BELANJA
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tr>
                            <th class="text-right" width="25%">SUPPLIER</th>
                            <th width="5px">:</th>
                            <td>{{ $shopping->supplier_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right" width="25%">TOTAL</th>
                            <th width="5px">:</th>
                            <td>Rp{{ number_format($shopping->price_total, 0, ',', '.') }},-</td>
                        </tr>
                        <tr>
                            <th class="text-right" width="25%">STATUS</th>
                            <th width="5px">:</th>
                            <td>
                                <span class="badge badge-pill {{ (($shopping->status == 'Lunas') ? 'badge-success' : (($shopping->status == 'Hutang') ? 'badge-danger text-white' : 'badge-secondary')) }}">
                                    {{ $shopping->status }}
                                </span>
                            </td>
                        </tr>
                    </table>    
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">DAFTAR PRODUK :</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <?php $num = 1; ?>
                        @foreach($shopping['items'] as $item)
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
                    RIWAYAT PEMBAYARAN

                    @if ($shopping->status == 'Hutang')
                    <a href="javascript:" data-toggle="modal" data-target="#payment-create" class="float-right rounded-pill">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <?php $num = 1; ?>
                        <?php $payment = 0; ?>
                        @foreach($shopping['payments'] as $item)
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
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payment-create" tabindex="-1" role="dialog" aria-labelledby="payment-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/belanja/create-payments') }}" method="post" class="modal-content">
            @csrf
            <?php $last = DB::table('shopping_payments')
                            ->where('shopping_id', '=', $shopping->id)
                            ->orderBy('id', 'DESC')
                            ->first(); ?>
            <input type="hidden" name="shopping_id" value="{{ $shopping->id }}">
            <input type="hidden" name="supplier_id" value="{{ $last->supplier_id }}">
            <input type="hidden" name="billing" value="{{ $last->billing }}">
            <input type="hidden" name="payment" value="{{ $last->payment }}">
            
            <div class="modal-header">
                <h5 class="modal-title" id="payment-create-label">
                    <i class="fa fa-clipboard mr-2"></i>CATATAN PEMBAYARAN HUTANG
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
@endsection