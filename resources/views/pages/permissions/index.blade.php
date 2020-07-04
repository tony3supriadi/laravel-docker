@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-window-restore mr-3"></i>Daftar Module
            </h2>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th class="no-sort">NAMA MODULE</th>
                <th class="no-sort" width="30%">KODE</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($permissions as $item)
                <tr>
                    <td class="text-right">{{ $num }}.</td>
                    <td>{{ $item->name_string }}</td>
                    <td>{{ $item->name }}</td>
                </tr>
                <?php $num++; ?>

                @foreach($item->childs as $child)
                    <tr>
                        <td></td>
                        <td><i class="fa fa-angle-double-right mr-2"></i>{{ $child->name_string }}</td>
                        <td>{{ $child->name }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/init/datatable.init.js')}}"></script>
@endsection