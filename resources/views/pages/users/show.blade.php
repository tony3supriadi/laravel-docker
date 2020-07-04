@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-users mr-3"></i>Data Users
            </h2>
            <div class="col-md-6 text-right">
                @can('user-edit')
                <a href="{{ url('users/'.encrypt($user->id).'/edit') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-edit mr-2"></i> Ubah
                </a>
                @endcan
                @can('user-create')
                <a href="{{ url('users/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle mr-2"></i> Tambah
                </a>
                @endcan
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="py-2 border-bottom">
        <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
            <i class="fa fa-arrow-left"></i>
        </a>
        DETAIL USER
    </div>

    <table class="table table-striped">
        <tr>
            <th width="20%" class="text-right">Nama User</th>
            <th width="10px">:</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">E-Mail</th>
            <th width="10px">:</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Username</th>
            <th width="10px">:</th>
            <td>{{ '@'.$user->username }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Hak Akses</th>
            <th width="10px">:</th>
            <td>{{ $userRole[0] }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Terdaftar Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse($user->created_at)->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
            <th width="20%" class="text-right">Diperbarui Pada</th>
            <th width="10px">:</th>
            <td>{{ Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i:s') }}</td>
        </tr>
    </table>
</section>
@endsection