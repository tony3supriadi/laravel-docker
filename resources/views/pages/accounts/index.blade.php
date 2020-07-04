@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-user-circle mr-3"></i>Akunku
            </h2>
            <div class="col-md-6 text-right">
                <a href="{{ url('akun/'.encrypt(Auth::user()->id).'/edit') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle mr-2"></i> Ubah
                </a>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <table class="table table-striped">
        <tr>
            <th width="20%" class="text-right">Nama User</th>
            <th width="10px">:</th>
            <td>{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">E-Mail</th>
            <th width="10px">:</th>
            <td>{{ Auth::user()->email }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Username</th>
            <th width="10px">:</th>
            <td>{{ '@'.Auth::user()->username }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Hak Akses</th>
            <th width="10px">:</th>
            <td>{{ $userRole[0] }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Terdaftar Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Diperbarui Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse(Auth::user()->updated_at)->format('d M Y H:i:s') }}</td>
        </tr>
    </table>
</section>
@endsection