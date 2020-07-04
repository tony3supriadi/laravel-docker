@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">
            <i class="fa fa-cubes mr-3"></i>Kategori
        </h2>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        @can('produk-category-create')
        <div class="col-md-5">
            <div class="py-2 mb-2 border-bottom">
                <button class="btn btn-default btn-sm rounded-circle mr-2">
                    <i class="fa fa-plus-circle"></i>
                </button>
                TAMBAH KATEGORI
            </div>

            <form action="{{ url('/produk/kategori') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="name">NAMA KATEGORI</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autocomplete="off">

                    @error('name')
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
        <div class="@if (Auth::user()->can('produk-category-create')) col-md-7 @else col-md-12 @endif">
            <table class="table datatable no-ordering">
                <thead>
                    <tr>
                        <th width="10px" class="text-center no-sort">#</th>
                        <th>NAMA KATEGORI</th>
                        <th width="100px" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    @foreach($categories as $item)
                        <tr>
                            <td class="text-center">{{ $num }}.</td>
                            <td>{{ $item->name }}</td>

                            <td class="text-center">
                                <a href="{{ url('produk/kategori/'.encrypt($item->id)) }}" class="no-decoration text-primary mx-1">
                                    <i class="fa fa-search"></i>
                                </a>

                                @can('produk-category-edit')
                                <a href="{{ url('produk/kategori/'.encrypt($item->id).'/edit') }}" class="no-decoration text-dark mx-1">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endcan

                                @can('produk-category-delete')
                                <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                    <i class="fa fa-trash-o"></i>
                                </a>

                                <form id="delete-item-{{ md5($item->id) }}"
                                    action="{{ url('produk/kategori/'.encrypt($item->id)) }}"
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