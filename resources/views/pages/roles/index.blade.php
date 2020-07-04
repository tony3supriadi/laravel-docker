@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-universal-access mr-3"></i>Hak Akses
            </h2>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        @can('role-create')
        <div class="col-md-5">
            <div class="py-2 mb-2 border-bottom">
                <button class="btn btn-default btn-sm rounded-circle mr-2">
                    <i class="fa fa-plus-circle"></i>
                </button>
                TAMBAH AKSES
            </div>

            <form action="{{ url('/hak-akses') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="name">NAMA AKSES</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autocomplete="off">

                    @error('name')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="permission">PILIH MODULE</label>
                    
                    @error('permission')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div style="height:300px;overflow-y:scroll;">
                        @foreach($permissions as $item)
                            
                            @can($item->name)
                                <div class="py-1"><input type="checkbox" name="permission[]" value="{{ $item->id}}"> {{ $item->name_string }}</div>
                            @endcan

                            @foreach($item->childs as $child)
                            
                                @can($child->name)
                                    <div class="py-1 pl-3"><input type="checkbox" name="permission[]" value="{{ $child->id}}"> {{ $child->name_string }}</div>
                                @endcan
                            
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fa fa-undo mr-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
        @endcan
        <div class="@if (Auth::user()->can('role-create')) col-md-7 @else col-md-12 @endif">
            <table class="table datatable no-ordering">
                <thead>
                    <tr>
                        <th width="10px" class="text-center no-sort">#</th>
                        <th>NAMA AKSES</th>

                        @if (Auth::user()->can('role-edit') || Auth::user()->can('role-delete'))
                        <th width="80px" class="text-center">AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    @foreach($roles as $item)
                        @if ($item->id != 1)
                        <tr>
                            <td class="text-center">{{ $num }}.</td>
                            <td>{{ $item->name }}</td>

                            @if (Auth::user()->can('role-edit') || Auth::user()->can('role-delete'))
                            <td class="text-center">

                                @if($item->name != 'Administrator')
                                    @can('role-edit')
                                    <a href="{{ url('hak-akses/'.encrypt($item->id).'/edit') }}" class="no-decoration text-dark mx-1">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @endcan

                                    @can('role-delete')
                                    <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                        <i class="fa fa-trash-o"></i>
                                    </a>

                                    <form id="delete-item-{{ md5($item->id) }}"
                                        action="{{ url('hak-akses/'.encrypt($item->id)) }}"
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