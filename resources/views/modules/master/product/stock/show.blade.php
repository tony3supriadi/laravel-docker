@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-money mr-3"></i>Harga Produk
        </h2>

        <div class="col-md-6 text-right">
            <a href="?exportTo=excel{{ isset($_GET['start']) ? '&start='.$_GET['start'] : '' }}{{ isset($_GET['end']) ? '&end='.$_GET['end'] : '' }}" class="btn btn-sm btn-outline-primary">
                <i class="fa fa-file-excel-o mr-1"></i>
                Export
            </a>
            
            <a href="{{ url('produk/stok') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-cubes mr-1"></i>
                Atur Stock
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="py-2 border-bottom mb-3">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                RIWAYAT STOK {{ $product->name }}
            </div>

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
            </div>

            <table class="table table-hover datatable no-ordering">
                <thead>
                    <tr>
                        <th width="5px">#</th>
                        <th width="12%">TANGGAL</th>
                        <th>Deskripsi</th>
                        <th width="10%" class="text-right">Status</th>
                        <th width="15%" class="text-right">Nominal</th>
                        <th width="15%" class="text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    @foreach($products as $item)
                    <tr>
                        <td>{{ $num }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ $item->stock_status }}</td>
                        <td class="text-right">
                            @if($item->stock_status == "Masuk")
                                <span class="text-green">+</span>
                            @elseif($item->stock_status == "Keluar" || $item->stock_status == "Transfer")
                                <span class="text-red">-</span>
                            @else
                            @endif
                            {{ $item->stock_nominal }}
                        </td>
                        <td class="text-right">{{ $item->stock_saldo }}</td>
                    </tr>
                    <?php $num++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>

<script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('js/init/sweetalert2.init.js') }}"></script>

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