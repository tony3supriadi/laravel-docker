@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">
            <i class="fa fa-cubes mr-3"></i>Satuan
        </h2>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        @can('produk-unit-create')
        <div class="col-md-5">
            <div class="py-2 mb-2 border-bottom">
                <button class="btn btn-default btn-sm rounded-circle mr-2">
                    <i class="fa fa-plus-circle"></i>
                </button>
                TAMBAH SATUAN
            </div>

            <form action="{{ url('/produk/satuan') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="name">NAMA SATUAN</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autocomplete="off">

                    @error('name')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="symbol">SIMBOL SATUAN</label>
                    <input type="text" name="symbol" value="{{ old('symbol') }}" class="form-control @error('symbol') is-invalid @enderror" autocomplete="off">

                    @error('symbol')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">DESKRIPSI</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    
                    @error('description')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
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
        <div class="@if (Auth::user()->can('produk-unit-create')) col-md-7 @else col-md-12 @endif">
            <table class="table datatable no-ordering">
                <thead>
                    <tr>
                        <th width="10px" class="text-center no-sort">#</th>
                        <th>NAMA SATUAN</th>
                        <th>SIMBOL</th>

                        @if (Auth::user()->can('produk-unit-edit') || Auth::user()->can('produk-unit-delete'))
                        <th width="100px" class="text-center">AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    @foreach($units as $item)
                        <tr>
                            <td class="text-center">{{ $num }}.</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->symbol }}</td>

                            @if (Auth::user()->can('produk-unit-edit') || Auth::user()->can('produk-unit-delete'))
                            <td class="text-center">
                                <a href="{{ url('produk/satuan/'.encrypt($item->id)) }}" class="no-decoration text-primary mx-1">
                                    <i class="fa fa-search"></i>
                                </a>

                                @can('produk-unit-edit')
                                <a href="{{ url('produk/satuan/'.encrypt($item->id).'/edit') }}" class="no-decoration text-dark mx-1">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endcan

                                @can('produk-unit-delete')
                                <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                    <i class="fa fa-trash-o"></i>
                                </a>

                                <form id="delete-item-{{ md5($item->id) }}"
                                    action="{{ url('produk/satuan/'.encrypt($item->id)) }}"
                                    method="post"
                                    style="display: none;"
                                >    
                                    @csrf
                                    @method('delete')
                                </form>
                                @endcan
                            </td>
                            @endif
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