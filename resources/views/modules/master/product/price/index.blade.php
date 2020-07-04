@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-money mr-3"></i>Harga Produk
        </h2>

        <div class="col-md-6 text-right">
            <a href="{{ url('produk/harga/export-to-excel') }}" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-file-excel-o mr-2"></i>Export
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th width="10%">KODE</th>
                <th width="20%">NAMA PRODUK</th>
                <th width="10%">GRUP</th>
                <th width="12%">HARGA</th>
                <th>DESKRIPSI</th>

                <th width="80px" class="text-center">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($products as $item)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->group_name }}</td>
                    <td>Rp{{ number_format($item->price, 0, '', '.') }},-</td>
                    <td>{{ $item->description }}</td>

                    <td class="text-center">
                        <a href="{{ url('produk/harga/'.encrypt($item->id)) }}" class="text-primary mx-1">
                            <i class="fa fa-search"></i>
                        </a>

                        @can('produk-price-edit')
                        <a href="{{ url('produk/harga/'.encrypt($item->id).'/edit') }}" class="text-dark mx-1">
                            <i class="fa fa-edit"></i>
                        </a>
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