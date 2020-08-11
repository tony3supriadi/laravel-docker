@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-clipboard mr-3"></i>Laporan Laba / Rugi
        </h2>

        <div class="col-md-6 text-right">
            <a href="javascript:void(0)" onclick="onEventPrint()" class="btn btn-sm rounded-pill btn-outline-primary">
                <i class="fa fa-print mr-1"></i>
                Print
            </a>
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
            <form id="filter" action="" method="get">
                <input type="hidden" name="m"> 
            </form>
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
                    <select name="month" class="form-control form-control-sm">
                        @foreach($months as $m) 
                            <option value="{{ $m['id'] }}"
                                @if(isset($_GET['m'])) @if(explode('-', $_GET['m'])[1] == $m['id']) selected @endif
                                @elseif($m['id'] == date('m')) selected @endif
                                >{{ $m['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 px-0">
                    <select name="year" class="form-control form-control-sm">
                        @for($i = date('m') != 1 ? date('Y') : (date('Y') - 1); 
                            $i > ((date('m') != 1 ? date('Y') : (date('Y') - 1)) - 5); 
                            $i--)
                        <option value="{{ $i }}"
                            @if(isset($_GET['m']) && explode('-', $_GET['m'])[0] == $i) selected @endif
                            >{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-3 pr-0">
                    <button type="button"
                        onclick="
                            var month = $('select[name=month]').val();
                            var years = $('select[name=year]').val();
                            $('input[name=m]').val(years + '-' + month);

                            event.preventDefault();
                            document.getElementById('filter').submit();
                        "
                        class="btn btn-sm btn-primary btn-block">
                        TAMPIL
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body" id="reportContent">
                <h1 class="mb-1 text-center">Laporan Bulan : 
                    @foreach($months as $mon) 
                        @if(isset($_GET['m']))
                        @if($mon['id'] == explode('-', $_GET['m'])[1]) {{ $mon['name'] }} @endif
                        @else
                        @if($mon['id'] == date('m')) {{ $mon['name'] }} @endif
                        @endif
                    @endforeach</h1>
                <p class="border-bottom text-center pb-2">UPDATE PADA : {{ date('d/m/Y H:i:s') }}</p>

                <h4>A. OPERASIONAL</h4>
                
                <div class="ml-3">
                    <h5>1. BELANJA</h5>

                    <div class="ml-3">
                        <h5>a. TELOR</h5>
                        
                        <div class="ml-3">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30px" class="text-center">NO</th>
                                        <th>NAMA SUPPLIER</th>
                                        <th width="10%" class="text-center">QTY</th>
                                        <th width="20%" class="text-right">HARGA</th>
                                        <th width="20%" class="text-right">SUB TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $num = 1; ?>
                                    <?php $total_belanja_telor = 0; ?>
                                    @if(isset($reports['operational']['belanja'][0]['data_belanja']['telor']['items']))
                                    @foreach($reports['operational']['belanja'][0]['data_belanja']['telor']['items'] as $item)
                                    <tr>
                                        <td class="text-center">{{ $num }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-center">{{ $item['stok_pembelian'] }}</td>
                                        <td class="text-right">Rp{{ number_format($item['harga_pembelian'], 0, ',', '.') }},-</td>
                                        <td class="text-right">Rp{{ number_format(($item['stok_pembelian'] * $item['harga_pembelian']), 0, ',', '.') }},-</td>
                                    </tr>
                                    <?php $total_belanja_telor += ($item['stok_pembelian'] * $item['harga_pembelian']); ?>
                                    <?php $num++; ?>
                                    @endforeach
                                    @endif

                                    <tr>
                                        <th colspan="2" class="text-right">TOTAL</th>
                                        <th class="text-center">{{ $reports['operational']['belanja'][0]['data_belanja']['telor']['total_stok_pembelian'] }}</th>
                                        <th class="text-right">Rp{{ number_format($reports['operational']['belanja'][0]['data_belanja']['telor']['total_harga_pembelian'], 0, ',', '.') }},-</th>
                                        <th class="text-right">Rp{{ number_format($total_belanja_telor, 0, ',', '.') }},-</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5>b. OBAT</h5>

                        <div class="ml-3">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30px" class="text-center">NO</th>
                                        <th>NAMA</th>
                                        <th width="10%" class="text-center">QTY</th>
                                        <th width="20%" class="text-right">HARGA</th>
                                        <th width="20%" class="text-right">SUB TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $num = 1; ?>
                                    <?php $total_belanja_obat = 0; ?>
                                    @foreach($reports['operational']['belanja'][1]['data_belanja']['products']['items'] as $item)
                                    <tr>
                                        <td class="text-center">{{ $num }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-center">{{ $item['stok_pembelian'] }}</td>
                                        <td class="text-right">Rp{{ number_format($item['harga_pembelian'], 0, ',', '.') }},-</td>
                                        <td class="text-right">Rp{{ number_format(($item['stok_pembelian'] * $item['harga_pembelian']), 0, ',', '.') }},-</td>
                                    </tr>
                                    <?php $num++; ?>
                                    <?php $total_belanja_obat += ($item['stok_pembelian'] * $item['harga_pembelian']); ?>
                                    @endforeach

                                    <tr>
                                        <th colspan="2" class="text-right">TOTAL</th>
                                        <th class="text-center">{{ $reports['operational']['belanja'][1]['data_belanja']['products']['total_stok_pembelian'] }}</th>
                                        <th class="text-right">Rp{{ number_format($reports['operational']['belanja'][1]['data_belanja']['products']['total_harga_pembelian'], 0, ',', '.') }},-</th>
                                        <th class="text-right">Rp{{ number_format($total_belanja_obat, 0, ',', '.') }},-</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5>c. PAKAN</h5>

                        <div class="ml-3">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30px" class="text-center">NO</th>
                                        <th>NAMA</th>
                                        <th width="10%" class="text-center">QTY</th>
                                        <th width="20%" class="text-right">HARGA</th>
                                        <th width="20%" class="text-right">SUB TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $num = 1; ?>
                                    <?php $total_belanja_pakan = 0; ?>
                                    @foreach($reports['operational']['belanja'][2]['data_belanja']['products']['items'] as $item)
                                    <tr>
                                        <td class="text-center">{{ $num }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-center">{{ $item['stok_pembelian'] }}</td>
                                        <td class="text-right">Rp{{ number_format($item['harga_pembelian'], 0, ',', '.') }},-</td>
                                        <td class="text-right">Rp{{ number_format(($item['stok_pembelian'] * $item['harga_pembelian']), 0, ',', '.') }},-</td>
                                    </tr>
                                    <?php $num++; ?>
                                    <?php $total_belanja_pakan += ($item['stok_pembelian'] * $item['harga_pembelian']); ?>
                                    @endforeach

                                    <tr>
                                        <th colspan="2" class="text-right">TOTAL</th>
                                        <th class="text-center">{{ $reports['operational']['belanja'][2]['data_belanja']['products']['total_stok_pembelian'] }}</th>
                                        <th class="text-right">Rp{{ number_format($reports['operational']['belanja'][2]['data_belanja']['products']['total_harga_pembelian'], 0, ',', '.') }},-</th>
                                        <th class="text-right">Rp{{ number_format($total_belanja_pakan, 0, ',', '.') }},-</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h5>2. GAJI KARYAWAN</h5>

                    <div class="ml-3">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">NO</th>
                                    <th>NAMA</th>
                                    <th width="22%" class="text-right">POKOK</th>
                                    <th width="22%" class="text-right">TAMBAHAN</th>
                                    <th width="22%" class="text-right">TOTAL GAJI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @if(isset($reports['operational']['gaji_karyawan']['items']))
                                @foreach($reports['operational']['gaji_karyawan']['items'] as $item)
                                <tr>
                                    <td class="text-center">{{ $num }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-right">Rp{{ number_format($item['salary'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['salary_extra'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['salary_total'], 0, ',', '.') }},-</td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                                @endif

                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <th class="text-right">Rp{{ number_format($reports['operational']['gaji_karyawan']['total_gaji_pokok'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['operational']['gaji_karyawan']['total_gaji_tambahan'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['operational']['gaji_karyawan']['total_gaji_total'], 0, ',', '.') }},-</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5>3. LAINNYA</h5>

                    <div class="ml-3">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">NO</th>
                                    <th>DESKRIPSI</th>
                                    <th width="30%" class="text-right">NOMINAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @if(isset($reports['operational']['other']['items']))
                                @foreach($reports['operational']['other']['items'] as $item)
                                <tr>
                                    <td class="text-center">{{ $num }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td class="text-right">Rp{{ number_format($item['nominal'], 0, ',', '.') }},-</td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                                @endif

                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <th class="text-right">Rp{{ number_format($reports['operational']['other']['total_nominal'], 0, ',', '.') }},-</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5>4. RINGKASAN</h5>

                    <div class="ml-3">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>1. TOTAL BELANJA</th>
                                <td class="text-right">
                                    <?php $total_belanja = $total_belanja_telor
                                                            + $total_belanja_pakan
                                                            + $total_belanja_obat; ?>
                                    Rp{{ number_format($total_belanja, 0, ',', '.') }},-
                                </td>
                            </tr>
                            <tr>
                                <th>2. TOTAL GAJI KARYAWAN</th>
                                <td class="text-right">Rp{{ number_format($reports['operational']['gaji_karyawan']['total_gaji_total'], 0, ',', '.') }},-</td>
                            </tr>
                            <tr>
                                <th>3. TOTAL LAINNYA</th>
                                <td class="text-right">Rp{{ number_format($reports['operational']['other']['total_nominal'], 0, ',', '.') }},-</td>
                            </tr>
                            <tr>
                                <th>TOTAL OPERASIONAL</th>
                                <th class="text-right">
                                    <?php $total_operasional = $total_belanja 
                                                    + $reports['operational']['gaji_karyawan']['total_gaji_total']
                                                    + $reports['operational']['other']['total_nominal']; ?>
                                    Rp{{ number_format($total_operasional, 0, ',', '.') }},-
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>

                <h4>B. PENJUALAN</h4>

                <div class="ml-3">
                    <h5>1. TELOR</h5>
                    
                    <div class="ml-3">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">NO</th>
                                    <th>NAMA PELANGGAN</th>
                                    <th width="10%" class="text-center">QTY</th>
                                    <th width="18%" class="text-right">HARGA MODAL</th>
                                    <th width="18%" class="text-right">OMSET</th>
                                    <th width="18%" class="text-right">PROFIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @if(isset($reports['penjualan'][0]['data_penjualan']['telor']['items']))
                                @foreach($reports['penjualan'][0]['data_penjualan']['telor']['items'] as $item)
                                <tr>
                                    <td class="text-center">{{ $num }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['stok_terjual'] }}</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_modal'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_omset'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_profit'], 0, ',', '.') }},-</td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                                @endif
                                
                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <th class="text-center">{{ $reports['penjualan'][0]['data_penjualan']['telor']['total_stok_terjual'] }}</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][0]['data_penjualan']['telor']['total_harga_modal'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][0]['data_penjualan']['telor']['total_harga_omset'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][0]['data_penjualan']['telor']['total_harga_profit'], 0, ',', '.') }},-</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5>2. OBAT</h5>

                    <div class="ml-3">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">NO</th>
                                    <th>NAMA</th>
                                    <th width="10%" class="text-center">QTY</th>
                                    <th width="18%" class="text-right">HARGA MODAL</th>
                                    <th width="18%" class="text-right">OMSET</th>
                                    <th width="18%" class="text-right">PROFIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @foreach($reports['penjualan'][1]['data_penjualan']['products']['items'] as $item)
                                <tr>
                                    <td class="text-center">{{ $num }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['stok_terjual'] }}</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_modal'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_omset'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_profit'], 0, ',', '.') }},-</td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                                
                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <th class="text-center">{{ $reports['penjualan'][1]['data_penjualan']['products']['total_stok_terjual'] }}</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][1]['data_penjualan']['products']['total_harga_modal'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][1]['data_penjualan']['products']['total_harga_omset'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][1]['data_penjualan']['products']['total_harga_profit'], 0, ',', '.') }},-</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5>3. PAKAN</h5>

                    <div class="ml-3">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">NO</th>
                                    <th>NAMA</th>
                                    <th width="10%" class="text-center">QTY</th>
                                    <th width="18%" class="text-right">HARGA MODAL</th>
                                    <th width="18%" class="text-right">OMSET</th>
                                    <th width="18%" class="text-right">PROFIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @foreach($reports['penjualan'][2]['data_penjualan']['products']['items'] as $item)
                                <tr>
                                    <td class="text-center">{{ $num }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['stok_terjual'] }}</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_modal'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_omset'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_profit'], 0, ',', '.') }},-</td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                                
                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <th class="text-center">{{ $reports['penjualan'][2]['data_penjualan']['products']['total_stok_terjual'] }}</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][2]['data_penjualan']['products']['total_harga_modal'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][2]['data_penjualan']['products']['total_harga_omset'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][2]['data_penjualan']['products']['total_harga_profit'], 0, ',', '.') }},-</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5>4. KONSENTRAT</h5>

                    <div class="ml-3">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">NO</th>
                                    <th>NAMA</th>
                                    <th width="10%" class="text-center">QTY</th>
                                    <th width="18%" class="text-right">HARGA MODAL</th>
                                    <th width="18%" class="text-right">OMSET</th>
                                    <th width="18%" class="text-right">PROFIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @foreach($reports['penjualan'][3]['data_penjualan']['products']['items'] as $item)
                                <tr>
                                    <td class="text-center">{{ $num }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['stok_terjual'] }}</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_modal'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_omset'], 0, ',', '.') }},-</td>
                                    <td class="text-right">Rp{{ number_format($item['harga_profit'], 0, ',', '.') }},-</td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                                
                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <th class="text-center">{{ $reports['penjualan'][3]['data_penjualan']['products']['total_stok_terjual'] }}</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][3]['data_penjualan']['products']['total_harga_modal'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][3]['data_penjualan']['products']['total_harga_omset'], 0, ',', '.') }},-</th>
                                    <th class="text-right">Rp{{ number_format($reports['penjualan'][3]['data_penjualan']['products']['total_harga_profit'], 0, ',', '.') }},-</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5>5. RINGKASAN</h5>

                    <div class="ml-3">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>1. TOTAL PENJUALAN TELOR</th>
                                <td class="text-right">
                                    Rp{{ number_format($reports['penjualan'][0]['data_penjualan']['telor']['total_harga_modal'], 0, ',', '.') }},-
                                </td>
                            </tr>
                            <tr>
                                <th>2. TOTAL PENJUALAN OBAT</th>
                                <td class="text-right">
                                    Rp{{ number_format($reports['penjualan'][1]['data_penjualan']['products']['total_harga_modal'], 0, ',', '.') }},-
                                </td>
                            </tr>
                            <tr>
                                <th>3. TOTAL PENJUALAN PAKAN</th>
                                <td class="text-right">
                                    Rp{{ number_format($reports['penjualan'][2]['data_penjualan']['products']['total_harga_modal'], 0, ',', '.') }},-
                                </td>
                            </tr>
                            <tr>
                                <th>4. TOTAL PENJUALAN KONSENTRAT</th>
                                <td class="text-right">
                                    Rp{{ number_format($reports['penjualan'][3]['data_penjualan']['products']['total_harga_modal'], 0, ',', '.') }},-
                                </td>
                            </tr>
                            <tr>
                                <th>TOTAL PENJUALAN</th>
                                <th class="text-right">
                                    <?php $total_penjualan = $reports['penjualan'][0]['data_penjualan']['telor']['total_harga_modal']
                                                    + $reports['penjualan'][1]['data_penjualan']['products']['total_harga_modal']
                                                    + $reports['penjualan'][2]['data_penjualan']['products']['total_harga_modal']
                                                    + $reports['penjualan'][3]['data_penjualan']['products']['total_harga_modal']; ?>
                                    Rp{{ number_format($total_penjualan, 0, ',', '.') }},-
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>

                <h4>C. RINGKASAN</h4>

                <div class="ml-3">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>PENJUALAN</th>
                            <td class="text-right">
                                Rp{{ number_format($total_penjualan, 0, ',', '.') }},-
                            </td>
                        </tr>
                        <tr>
                            <th>OPERASIONAL</th>
                            <td class="text-right">
                                Rp{{ number_format($total_operasional, 0, ',', '.') }},-
                            </td>
                        </tr>
                        <tr>
                            <th>OMSET</th>
                            <th class="text-right">
                                Rp{{ number_format($total_penjualan - $total_operasional, 0, ',', '.') }},-
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>

<script>
function onEventPrint() {
    var printContents = document.getElementById('reportContent').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
@endsection