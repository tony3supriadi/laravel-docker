@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-industry mr-3"></i>PERUSAHAAN
            </h2>
            <div class="col-md-6 text-right">
                <a href="{{ url('perusahaan/'.encrypt($company->id).'/edit') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle mr-2"></i> Ubah
                </a>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<?php use Illuminate\Support\Facades\DB; ?>
<section class="p-4">
    <table class="table table-striped">
        <tr>
            <th width="20%" class="text-right">Nama Perusahaan</th>
            <th width="10px">:</th>
            <td>{{ $company->name }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Alamat</th>
            <th width="10px">:</th>
            <td>
                {{ $company->address ? $company->address : '-' }}{{ $company->regency_id ? ', '.DB::table('regencies')->where('id', '=', $company->regency_id)->first()->name : '' }}{{ $company->province_id ? ', '.DB::table('provinces')->where('id', '=', $company->province_id)->first()->name : '' }}{{ $company->postcode ? ', '.$company->postcode : '' }}
            </td>
        </tr>
        <tr>
            <th width="20%" class="text-right">HP/WA</th>
            <th width="10px">:</th>
            <td>{{ $company->phone ? $company->phone : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Telphone</th>
            <th width="10px">:</th>
            <td>{{ $company->telp ? $company->telp : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">E-Mail</th>
            <th width="10px">:</th>
            <td>{{ $company->email ? $company->email : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Website</th>
            <th width="10px">:</th>
            <td>{{ $company->website ? $company->website : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Facebook</th>
            <th width="10px">:</th>
            <td>{{ $company->facebook ? $company->facebook : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Twitter</th>
            <th width="10px">:</th>
            <td>{{ $company->twitter ? $company->twitter : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Instagram</th>
            <th width="10px">:</th>
            <td>{{ $company->instagram ? $company->instagram : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Deskripsi</th>
            <th width="10px">:</th>
            <td>{{ $company->description ? $company->description : '-' }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Jumlah Cabang</th>
            <th width="10px">:</th>
        <td>
            {{ count(DB::table('branchs')->where('company_id', '=', $company->id)->get()) < 10 
                    ? '0'. count(DB::table('branchs')->where('company_id', '=', $company->id)->get()) 
                    : count(DB::table('branchs')->where('company_id', '=', $company->id)->get()) }} Cabang
            
            (<a href="{{ url('/cabang') }}">Lihat Daftar</a>)
        </td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Terdaftar Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse($company->created_at)->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Diperbarui Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse($company->updated_at)->format('d M Y H:i:s') }}</td>
        </tr>
    </table>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
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