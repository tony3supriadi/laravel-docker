@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid row">
        <h2 class="no-margin-bottom col-md-6">
            <i class="fa fa-truck mr-3"></i>Karyawan
        </h2>
        <div class="col-md-6 text-right">
            @can('employee-edit')
            <a href="{{ url('karyawan/'.encrypt($employee->id).'/edit') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-edit mr-2"></i>Ubah
            </a>
            @endcan
            
            @can('employee-create')
            <a href="{{ url('karyawan/create') }}" class="btn btn-primary btn-sm">
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
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                DETAIL KARYAWAN
            </div>

            <table class="table">
                <tr>
                    <th width="20%" class="text-right">Nama Karyawan</th>
                    <th width="10px">:</th>
                    <td>{{ $employee->name }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Tempat, Tanggal Lahir</th>
                    <th width="10px">:</th>
                    <td>
                        {{ $employee->birthplace ? $employee->birthplace : '-' }},
                        {{ $employee->birthdate ? Carbon\Carbon::parse($employee->birtdate)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">E-Mail</th>
                    <th width="10px">:</th>
                    <td>{{ $employee->email ? $employee->email : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">No HP / WA</th>
                    <th width="10px">:</th>
                    <td>{{ $employee->phone ? $employee->phone : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Alamat</th>
                    <th width="10px">:</th>
                    <td>
                        {{ $employee->address ? $employee->address : '-' }}, 
                        {{ $employee->regency_id ? $employee->regency_name : '-' }},
                        {{ $employee->province_id ? $employee->province_name : '-' }}.
                        {{ $employee->postcode ? $employee->postcode : '-' }}.
                    </td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Gaji Pokok</th>
                    <th width="10px">:</th>
                    <td>{{ $employee->salary ? 'Rp'.number_format($employee->salary, 0, ',', '.').',-' : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Deskripsi</th>
                    <th width="10px">:</th>
                    <td>{{ $employee->description ? $employee->description : '-' }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Terdaftar Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($employee->created_at)->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th width="20%" class="text-right">Diperbarui Pada</th>
                    <th width="10px">:</th>
                    <td>{{ Carbon\Carbon::parse($employee->updated_at)->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection