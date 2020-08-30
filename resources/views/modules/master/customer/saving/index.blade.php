@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-address-book-o mr-3"></i>Catatan Tabungan
        </h2>
        <div class="col-md-6 text-right">
            <a href="?exportTo=excel{{ isset($_GET['start']) ? '&start='.$_GET['start'] : '' }}{{ isset($_GET['end']) ? '&end='.$_GET['end'] : '' }}" class="btn btn-primary btn-sm">
                <i class="fa fa-file-excel-o mr-2"></i>Export
            </a>
            <a href="{{ url('pelanggan/catatan-tabungan/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>Tambah
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
<div class="row mb-0">
        <div class="col-md-1 py-1">
            FILTER : 
        </div>
        <div class="col-md-6">
            <form action="" method="get">
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

    <hr class="mt-0" />

    <table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th width="10%">TANGGAL</th>
                <th width="18%">PELANGGAN</th>
                <th>DESKRIPSI</th>
                <th width="8%" class="text-center">STATUS</th>
                <th width="12%" class="text-right">NOMINAL</th>
                <th width="12%" class="text-right">SALDO</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($savings as $item)
                <tr>
                    <td>#</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ url('/pelanggan/'.encrypt($item->customer_id).'/tabungan') }}">
                            {{ $item->name }}
                        </a>
                    </td>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">
                        <span class="badge {{ $item->status == 'Kredit' ? 'badge-success' : 'badge-secondary' }} rounded-pill">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="text-right">
                    {{ $item->status == 'Debit' ? '-' : '' }}{{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($item->saldo, 0, ',', '.') }}
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