@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-shopping-cart mr-3"></i>Data Belanja
        </h2>

        <div class="col-md-6 text-right">
            <a href="?exportTo=excel{{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}{{ isset($_GET['start']) ? '&start='.$_GET['start'] : '' }}{{ isset($_GET['end']) ? '&end='.$_GET['end'] : '' }}" class="btn btn-primary btn-sm">
                <i class="fa fa-file-excel-o mr-2"></i>Export
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    @if(isset($_GET['status']) && ($_GET['status'] == 'lunas' || $_GET['status'] == 'piutang'))
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <div class="border py-2 px-3 text-right">
                <small class="text-secondary">TOTAL {{ $_GET['status'] == 'lunas' ? 'BELANJA' : 'PIUTANG' }} :</small>
                <h3 class="no-margin-bottom">Rp{{ number_format($total, 0, ',', '.') }},-</h3>
            </div>
        </div>
    </div>
    @endif
    <div class="row mb-0">
        <div class="col-md-1 py-1">
            FILTER : 
        </div>
        <div class="col-md-6">
            <form action="" method="get">
                @if(isset($_GET['status']))
                <input type="hidden" name="status" value="{{ $_GET['status'] }}">
                @endif
                <div class="form-group row">
                    <div class="col-4 px-0">
                        <input type="date" name="start" value="{{ isset($_GET['start']) ? $_GET['start'] : date('Y').'-'.date('m').'-01' }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-4 px-0">
                        <input type="date" name="end" value="{{ isset($_GET['end']) ? $_GET['end'] : date('Y-m-d') }}" timezone="Asia/Jakarta" class="form-control form-control-sm">
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-sm btn-primary btn-block">
                            TAMPIL
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-5 text-center text-lg-right pt-1">
            <a href="{{ isset($_GET['start']) ? '?status=semua&start='.$_GET['start'].'&end='.$_GET['end'] : '?status=semua' }}"
                class="{{ isset($_GET['status']) ? $_GET['status'] == 'semua' ? 'text-primary' : 'text-secondary' : 'text-primary'  }}">
                Semua
            </a> 
            <span class="mx-2 text-gray">|</span> 
            <a href="{{ isset($_GET['start']) ? '?status=lunas&start='.$_GET['start'].'&end='.$_GET['end'] : '?status=lunas' }}"
                class="{{ isset($_GET['status']) && $_GET['status'] == 'lunas' ? 'text-primary' : 'text-secondary' }}">
                Lunas
            </a> 
            <span class="mx-2 text-gray">|</span>
            <a href="{{ isset($_GET['start']) ? '?status=piutang&start='.$_GET['start'].'&end='.$_GET['end'] : '?status=piutang' }}"
                class="{{ isset($_GET['status']) && $_GET['status'] == 'piutang' ? 'text-primary' : 'text-secondary' }}">
                Piutang</a> 
            <span class="mx-2 text-gray">|</span> 
            <a href="{{ isset($_GET['start']) ? '?status=batal&start='.$_GET['start'].'&end='.$_GET['end'] : '?status=batal' }}"
                class="{{ isset($_GET['status']) && $_GET['status'] == 'batal' ? 'text-primary' : 'text-secondary' }}">
                Batal</a>
        </div>
    </div>

    <hr class="mt-0" />

    <table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th width="10%">INVOICE</th>
                <th>PELANGGAN</th>
                <th width="18%" class="text-right">TOTAL PEMBAYARAN</th>
                <th width="12%" class="text-center">STATUS</th>
                <th width="18%">TANGGAL BELANJA</th>

                <th width="80px" class="text-center">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($sales as $item)
            <tr>
                <td class="text-center">
                    <input type="checkbox">
                </td>
                <td>INV{{ substr($item->invoice, 0, 8) }}</td>
                <td>{{ $item->customer_name }}</td>
                <td class="text-right">Rp{{ number_format($item->price_total, 0, ',', '.') }},-</td>
                <td class="text-center">
                    <span class="badge badge-pill {{ (($item->status == 'Lunas') ? 'badge-success' : (($item->status == 'Piutang') ? 'badge-danger text-white' : 'badge-secondary')) }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-y H:i:s') }}</td>

                <td class="text-center">
                    <a href="{{ url('penjualan/'.encrypt($item->id)) }}" class="text-primary mx-1">
                        <i class="fa fa-search"></i>
                    </a>

                    @can('penjualan')
                        <a href="javascript:" 
                            <?php if ($item->status == 'Piutang') : ?>
                                onclick="_cancel('{{ md5($item->id) }}')"
                            <?php endif; ?>
                            class="no-decoration @if($item->status == 'Piutang') text-danger @else text-secondary @endif mx-1">
                            <i class="fa fa-close"></i>
                        </a>

                        <form id="cancel-item-{{ md5($item->id) }}"
                            action="{{ url('penjualan/'.encrypt($item->id)) }}"
                            method="post"
                            style="display: none;"
                        >    
                            @csrf
                            @method('delete')
                        </form>
                    @endcan
                </td>
            </tr>
            <?php $num++; ?>
            @endforeach
        </tbody>
    </table>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>

<script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('js/init/sweetalert2.init.js') }}"></script>

<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/init/daterange.init.js') }}"></script>

@if(Session::get('success'))
<script type="text/javascript">
Swal.fire({
    title: 'Berhasil!',
    icon: 'success',
    timer: 2000,
    timerProgressBar: true,
    showConfirmButton: false
})
</script>
@endif
@endsection