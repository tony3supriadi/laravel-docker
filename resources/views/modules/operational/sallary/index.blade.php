@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-google-wallet mr-3"></i>Gaji Karyawan
        </h2>
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
                @if(isset($_GET['status']))
                <input type="hidden" name="status" value="{{ $_GET['status'] }}">
                @endif
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
                    <div class="col-4">
                        @can('sallary-create')
                        <a href="{{ url('gaji-karyawan/create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit mr-1"></i>INPUT GAJI
                        </a>
                        @endcan

                        <a href="javascript:" 
                            onclick="
                                $.get('{{ url('gaji-karyawan/print'.(isset($_GET['m']) ? '?m='.$_GET['m'].'&y='.$_GET['y'] : '' )) }}',
                                    function(html) {
                                        var w = document.createElement('iframe');
                                        document.body.appendChild(w);
                                        w.contentDocument.write(html);
                                        w.focus();
                                        w.contentWindow.print();
                                        w.parentNode.removeChild(w) ;
                                    })
                            "
                            class="btn btn-outline-primary btn-sm">
                            
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 offset-md-2">
            <div class="border py-2 px-3 mb-2 text-right">
                <small class="text-secondary">TOTAL GAJI BULAN {{ strtoupper(array_filter($months, function($var) { return ($var['id'] == (isset($_GET['m']) ? $_GET['m'] : date('m'))); })[(isset($_GET['m']) ? $_GET['m'] : date('m')) - 1]['name']) }} :</small>
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
                        <th width="20%">NAMA KARYAWAN</th>
                        <th width="15%" class="text-right">GAJI POKOK</th>
                        <th width="15%" class="text-right">GAJI TAMBAHAN</th>
                        <th width="15%" class="text-right">TOTAL GAJI</th>
                        <th>DESKRIPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    @foreach($salaries as $item) 
                    <tr>
                        <td>{{ $num }}.</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-right">{{ number_format($item->salary, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->salary_extra, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->salary_total, 0, ',', '.') }}</td>
                        <td>{{ $item->description ? $item->description : '-' }}</td>
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