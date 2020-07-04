@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-users mr-3"></i>Data Users
            </h2>
            <div class="col-md-6 text-right">
                @can('user-create')
                <a href="{{ url('users/create') }}" class="btn btn-primary btn-sm">
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
                <th>NAMA USER</th>
                <th width="15%">USERNAME</th>
                <th width="18%">E-MAIL</th>
                <th width="20%">TERDAFTAR PADA</th>

                @if (Auth::user()->can('user-edit') || Auth::user()->can('user-delete'))
                <th width="80px" class="text-center">AKSI</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($users as $item)
                @if($item->id != 1)
                <tr>
                    <td class="text-center">{{ $num }}.</td>
                    <td>{{ $item->name}}</td>
                    <td>{{ '@'.$item->username }}</td>
                    <td>{{ $item->email ? $item->email : '-' }}</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y H:i:s') }}</td>
                    
                    @if (Auth::user()->can('user-edit') || Auth::user()->can('user-delete'))
                    <td class="text-center">
                        @if(Auth::user()->id != 1)
                            <a href="{{ url('users/'.encrypt($item->id)) }}" class="no-decoration text-dark mx-1">
                                <i class="fa fa-search"></i>
                            </a>

                            @can('user-edit')
                            <a href="{{ url('users/'.encrypt($item->id).'/edit') }}" class="no-decoration text-dark mx-1">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endcan

                            @can('user-delete')
                            <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                <i class="fa fa-trash-o"></i>
                            </a>

                            <form id="delete-item-{{ md5($item->id) }}"
                                action="{{ url('users/'.encrypt($item->id)) }}"
                                method="post"
                                style="display: none;"
                            >    
                                @csrf
                                @method('delete')
                            </form>
                            @endcan
                        @endif

                        @if($item->username != 'administrator')
                            <a href="{{ url('users/'.encrypt($item->id)) }}" class="no-decoration text-dark mx-1">
                                <i class="fa fa-search"></i>
                            </a>

                            @can('user-edit')
                            <a href="{{ url('users/'.encrypt($item->id).'/edit') }}" class="no-decoration text-dark mx-1">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endcan

                            @can('user-delete')
                            <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                <i class="fa fa-trash-o"></i>
                            </a>

                            <form id="delete-item-{{ md5($item->id) }}"
                                action="{{ url('users/'.encrypt($item->id)) }}"
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
                @endif
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