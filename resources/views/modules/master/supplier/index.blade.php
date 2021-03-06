@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-truck mr-3"></i>Supplier
        </h2>
        <div class="col-md-6 text-right">
            @can('supplier-create')
            <a href="{{ url('supplier/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>Tambah
            </a>
            @endcan
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
                <th>NAMA SUPPLIER</th>
                <th width="18%">EMAIL</th>
                <th width="15%">NO HP/WA</th>
                <th width="15%">TELEPHONE</th>

                <th width="80px" class="text-center">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($suppliers as $item)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email ? $item->email : '-' }}</td>
                    <td>{{ $item->phone ? $item->phone : '-' }}</td>
                    <td>{{ $item->telp ? $item->telp : '-' }}</td>

                    <td class="text-center">
                        <a href="{{ url('supplier/'.encrypt($item->id)) }}" class="text-primary mx-1">
                            <i class="fa fa-search"></i>
                        </a>

                        @can('supplier-edit')
                        <a href="{{ url('supplier/'.encrypt($item->id).'/edit') }}" class="text-dark mx-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan

                        @can('supplier-delete')
                        <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                            <i class="fa fa-trash-o"></i>
                        </a>

                        <form id="delete-item-{{ md5($item->id) }}"
                            action="{{ url('supplier/'.encrypt($item->id)) }}"
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