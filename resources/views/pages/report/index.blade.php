@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">
            <i class="fa fa-clipboard mr-3"></i>Laporan
        </h2>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <a data-toggle="collapse" href="#laporan-data-produk" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-cube mr-2"></i>Data Produk</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-address-book-o mr-2"></i>Data Pelanggan</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-truck mr-2"></i>Data Supplier</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-id-card mr-2"></i>Data Karyawan</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-shopping-cart mr-2"></i>Data Belanja</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-google-wallet mr-2"></i>Data Gaji Karyawan</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-database mr-2"></i>Data Operasional</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-shopping-bag mr-2"></i>Data Penjualan</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="collapse" id="laporan-data-produk">
                <div class="card card-body p-0">
                    <ul class="list-group list-group-flush">
                        <a href="" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-list mr-2"></i>Data Produk</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                        <a data-toggle="collapse" aria-expanded="true" href="#laporan-stok-produk" class="text-dark text-decoration-none">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><i class="fa fa-cubes mr-2"></i>Stok Produk</span>
                                <span class="fa fa-angle-right py-1"></span>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="collapse" id="laporan-data-produk-aksi">
                <div class="card">
                    <div class="card-header">Data Produk</div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <a href="" class="text-dark text-decoration-none">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fa fa-print mr-2"></i>Cetak Dokumen</span>
                                    <span class="fa fa-angle-right py-1"></span>
                                </li>
                            </a>
                            <a href="" class="text-dark text-decoration-none">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fa fa-file-excel-o mr-2"></i>Export to Excel</span>
                                    <span class="fa fa-angle-right py-1"></span>
                                </li>
                            </a>
                            <a href="" class="text-dark text-decoration-none">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fa fa-file-pdf-o mr-2"></i>Export to PDF</span>
                                    <span class="fa fa-angle-right py-1"></span>
                                </li>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="collapse" id="laporan-stok-produk">
                <div class="card">
                    <div class="card-header">Stok Produk</div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <a href="" class="text-dark text-decoration-none">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fa fa-print mr-2"></i>Cetak Dokumen</span>
                                    <span class="fa fa-angle-right py-1"></span>
                                </li>
                            </a>
                            <a href="" class="text-dark text-decoration-none">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fa fa-file-excel-o mr-2"></i>Export to Excel</span>
                                    <span class="fa fa-angle-right py-1"></span>
                                </li>
                            </a>
                            <a href="" class="text-dark text-decoration-none">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fa fa-file-pdf-o mr-2"></i>Export to PDF</span>
                                    <span class="fa fa-angle-right py-1"></span>
                                </li>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection