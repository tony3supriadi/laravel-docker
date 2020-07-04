@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">
            <i class="fa fa-dashboard mr-3"></i>Dashboard
        </h2>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
  <div class="row">
    <div class="col-md-12">
      <h1>Selamat datang {{ Auth::user()->name }}.</h1>
      <p>Sistem Informasi Management Keuangan (SIMKEU).</p>
      <small>Copyright &copy; {{ date('Y') }}. Dikembangkan oleh <a href="">Techno Media Solution</a>.</small>
    </div>
  </div>
</section>
@endsection

@section('style')
@endsection

@section('script')
@endsection
