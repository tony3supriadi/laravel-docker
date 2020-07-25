@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-database mr-3"></i>Operasional Lainnya
        </h2>

        <div class="col-md-6 text-right">
            <a href="?exportTo=excel{{ isset($_GET['m']) ? '&m='.$_GET['m'] : '' }}{{ isset($_GET['y']) ? '&y='.$_GET['y'] : '' }}" class="btn btn-primary btn-sm">
                <i class="fa fa-file-excel-o mr-2"></i>Export
            </a>
            @can('operational-create')
            <a href="{{ url('operasional/lainnya/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>INPUT DATA
            </a>
            @endcan
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
                    <div class="col-3 px-0">
                        <?php $months = [
                            [ 'id' => '01', 'name' => "Januari" ],
                            [ 'id' => '02', 'name'  => "Februari" ],
                            [ 'id' => '03', 'name'  => "Maret" ],
                            [ 'id' => '04', 'name'  => "April" ],
                            [ 'id' => '05', 'name'  => "Mei" ],
                            [ 'id' => '06', 'name'  => "Juni" ],
                            [ 'id' => '07', 'name'  => "Juli" ],
                            [ 'id' => '08', 'name'  => "Agustus" ],
                            [ 'id' => '09', 'name'  => "September" ],
                            [ 'id' => '10', 'name'  => "Oktober" ],
                            [ 'id' => '11', 'name'  => "November" ],
                            [ 'id' => '12', 'name'  => "Desember" ],
                        ]; ?>
                        <select name="m" class="form-control form-control-sm">
                            @foreach($months as $m) 
                                <option value="{{ $m['id'] }}"
                                    @if(isset($_GET['m'])) @if($_GET['m'] == $m['id']) selected @endif
                                    @elseif($m['id'] == date('m')) selected @endif
                                    >{{ $m['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 px-0">
                        <select name="y" class="form-control form-control-sm">
                            @for($i = date('m') != 1 ? date('Y') : (date('Y') - 1); 
                                $i > ((date('m') != 1 ? date('Y') : (date('Y') - 1)) - 5); 
                                $i--)
                            <option value="{{ $i }}"
                                @if(isset($_GET['y']) && $_GET['y'] == $i) selected @endif
                                >{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-3 pr-0">
                        <button type="submit" class="btn btn-sm btn-primary btn-block">
                            TAMPIL
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 offset-md-2">
            <div class="border py-2 px-3 mb-2 text-right">
                <small class="text-secondary">TOTAL BULAN {{ strtoupper(array_filter($months, function($var) { return ($var['id'] == (isset($_GET['m']) ? $_GET['m'] : date('m'))); })[(isset($_GET['m']) ? $_GET['m'] : date('m')) - 1]['name']) }} :</small>
                <h3 class="no-margin-bottom">Rp{{ number_format($total, 0, ',', '.') }},-</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table datatable no-ordering">
                <thead>
                    <tr>
                        <th width="10px">#</th>
                        <th>DESKRIPSI</th>
                        <th width="20%" class="text-right">NOMINAL</th>
                        <th width="15%" class="text-center">TANGGAL</th>
                        <th width="8%" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    @foreach($operationals as $item) 
                    <tr>
                        <td>{{ $num }}.</td>
                        <td>{{ $item->description ? $item->description : '-' }}</td>
                        <td class="text-right">Rp{{ number_format($item->nominal, 0, ',', '.') }},-</td>
                        <td class="text-center">{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td class="text-center">
                            @can('operational-edit')
                            <a href="{{ url('/operasional/lainnya/'.encrypt($item->id).'/edit') }}" class="text-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endcan
                            
                            @can('operational-delete')
                            <a href="javascript:" onclick="_deleted('{{ md5($item->id) }}')" class="no-decoration text-danger mx-1">
                                <i class="fa fa-trash-o"></i>
                            </a>

                            <form id="delete-item-{{ md5($item->id) }}"
                                action="{{ url('operasional/lainnya/'.encrypt($item->id)) }}"
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

<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>

<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>

<script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('js/init/sweetalert2.init.js') }}"></script>
@endsection