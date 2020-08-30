@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-address-book-o mr-3"></i>Pelanggan
        </h2>
        <div class="col-md-6 text-right">
            @can('pelanggan-edit')
            <a href="{{ url('pelanggan/'.encrypt($customer->id).'/edit') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-edit mr-2"></i>Ubah
            </a>
            @endcan
            
            @can('pelanggan-create')
            <a href="{{ url('pelanggan/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle mr-2"></i>Tambah
            </a>
            @endcan
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
<div class="row">
        <div class="col-md-12">
            <div class="py-2 border-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ url('pelanggan') }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        DETAIL PELANGGAN
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ url('pelanggan/'.encrypt($customer->id)) }}" class="btn btn-sm btn-outline-primary px-3 mx-1 rounded-pill">DETAIL</a>
                        <a href="{{ url('pelanggan/'.encrypt($customer->id).'/tabungan') }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">SALDO TABUNGAN</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-body d-flex justify-content-between">
                <span>SALDO TABUNGAN :</span>
                <h3>{{ number_format($customer->saldo_tabungan, 0, ',', '.') }}</h3>
            </div>

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
        <div class="col-md-5 text-right">
            <a href="?exportTo=excel{{ isset($_GET['start']) ? '&start='.$_GET['start'] : '' }}{{ isset($_GET['end']) ? '&end='.$_GET['end'] : '' }}" class="btn btn-primary btn-sm">
                <i class="fa fa-file-excel-o mr-2"></i>Export
            </a>
        </div>
    </div>

    <hr class="mt-0" />

            <table class="table datatable no-ordering">
                <thead>
                    <tr>
                        <th width="5px">#</th>
                        <th width="12%">KODE #REF</th>
                        <th width="10%">TANGGAL</th>
                        <th>DESKRIPSI</th>
                        <th width="5%" class="text-center">STATUS</th>
                        <th width="15%" class="text-right">NOMINAL</th>
                        <th width="15%" class="text-right">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savings as $item)
                    <tr>
                        <td>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#cetak" onclick="cetakItem('{{ json_encode($item) }}')">
                                <i class="fa fa-print"></i>
                            </a>
                        </td>
                        <td>{{ $item->code }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status == 'Kredit' ? 'badge-success' : 'badge-secondary' }} rounded-pill">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-right">{{ $item->status == 'Debit' ? '-' : '' }}{{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->saldo, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="cetak-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment-create-label">
                    <i class="fa fa-print mr-2"></i>CETAK BUKTI PEMBAYARAN
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="nota-print" class="modal-body">
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <h4 class="m-0 p-0"><strong>{{ $company->name }}</strong></h4>
                            <p class="m-0 p-0" id="perusahaan-info" style="line-height: 15px"><small>{{ $company->address }} <br />{!! $company->telp ? 'Telp.'.$company->telp .' <br /> WA.'.$company->phone : 'HP/WA.'.$company->phone !!}<br />E-Mail:{{ $company->email ? $company->email : '-' }}</small></p>
                        </td>
                        <td width="40%" valign="bottom">
                            <table width="100%" id="pelanggan">
                                <tr>
                                   <td><p class="p-0 m-0" style="line-height: 15px"><small>Nota<br />Tanggal<br/>Nama</small></p></td>
                                   <td><p class="p-0 m-0" style="line-height: 15px"><small>:<br />:<br />:</small></p></td>
                                   <td>
                                        <p class="p-0 m-0" style="line-height: 15px">
                                            <small>
                                                <span id="kodeRef"></span><br />
                                                <span id="tglRef"></span><br />
                                                <span id="tglCust"></span>
                                            </small>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr class="my-1" style="border:1px solid #666" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="tabel-produk" class="table table-bordered table-sm" width="100%">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>KETERANGAN</th>
                                        <th width="25%" class="text-right">JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SALDO TABUNGAN</td>
                                        <td id="saldoTabungan" class="text-right"></td>
                                    </tr>
                                    <tr>
                                        <td id="descTransaction"></td>
                                        <td id="nilaiTransaction" class="text-right"></td>
                                    </tr>
                                    <tr>
                                        <td>SISA TABUNGAN</td>
                                        <td id="sisaTabungan" class="text-right"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr id="keterangan">
                        <td width="70%" class="pt-3"></td>
                        <td width="30%" class="text-center pt-3">
                            <small>Hormat Kami, <br /><br /><br />
                            (...................................)</small>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer text-center">
                <a href="javascript:"
                    onclick="
                        var printContents = document.getElementById('nota-print').innerHTML;
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                        " class="btn btn-outline-primary btn-sm rounded-pill">
                    <i class="fa fa-print mr-2"></i>Cetak
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>

<script>
    function cetakItem(data) {
        var dataJSON = JSON.parse(data);
        var d = new Date(dataJSON.created_at);

        var saldo = 0;
        var nominal = 0;
        if (dataJSON.status == 'Kredit') {
            saldo = dataJSON.saldo - dataJSON.nominal;
            nominal = dataJSON.nominal;
        } else {
            nominal = - dataJSON.nominal;
            saldo = dataJSON.saldo + dataJSON.nominal;
        }

        $('#kodeRef').html(dataJSON.code);
        $('#tglRef').html(d.getDate() + '/' + d.getMonth() + '/' + d.getFullYear());
        $('#nilaiTransaction').html(nominal);
        $('#descTransaction').html(dataJSON.description);
        $('#saldoTabungan').html(saldo);
        $('#sisaTabungan').html(dataJSON.saldo);

        $.get('/api/customer/' + dataJSON.customer_id, 
            function(cust) {
                $('#tglCust').html(cust.name);
            });
        console.log();
    }
</script>
@endsection