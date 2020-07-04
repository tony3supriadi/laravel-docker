@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-share-alt mr-3"></i>Data Cabang
            </h2>
            <div class="col-md-6 text-right">
                @can('branch-create')
                <a href="{{ url('cabang/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle mr-2"></i> Tambah
                </a>
                @endcan
            </div>
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
                <th width="25%">NAMA CABANG</th>
                <th>ALAMAT</th>
                <th width="22%">TELP</th>

                @if (Auth::user()->can('branch-edit') || Auth::user()->can('branch-delete'))
                <th width="80px" class="text-center">AKSI</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($branchs as $item)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->name}}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->telp ? $item->telp : '-' }}</td>
                    
                    @if (Auth::user()->can('branch-edit') || Auth::user()->can('branch-delete'))
                    <td class="text-center">
                        <a href="{{ url('cabang/'.encrypt($item->id)) }}" class="no-decoration text-dark mx-1">
                            <i class="fa fa-search"></i>
                        </a>

                        @can('branch-edit')
                        <a href="{{ url('cabang/'.encrypt($item->id).'/edit') }}" class="no-decoration text-dark mx-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan

                        @if($item->id != 1)
                            @can('branch-delete')
                            <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                <i class="fa fa-trash-o"></i>
                            </a>

                            <form id="delete-item-{{ md5($item->id) }}"
                                action="{{ url('cabang/'.encrypt($item->id)) }}"
                                method="post"
                                style="display: none;"
                            >    
                                @csrf
                                @method('delete')
                            </form>
                            @endcan
                        @endif
                    </td>
                    @endif
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