<div class="position-fixed">
    <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
                <img src="{{ asset('img/avatar.jpg') }}" alt="logo" class="img-fluid rounded-circle">
            </div>
            <div class="title">
                <h1 class="h4">{{ Auth::user()->name }}</h1>
                <p>{{ '@'.Auth::user()->username }}</p>
            </div>
        </div>

        <div class="slimscroll-sidebar">
        <!-- Sidebar Navidation Menus-->
        <ul class="list-unstyled">
            <li class="<?= $actived == "dashboard" ? 'active' : '' ?>">
                <a href="{{ url('/dashboard') }}">
                    <i class="fa fa-home"></i> Dashboard 
                </a>
            </li>
            <li class="<?= $actived == "akun" ? 'active' : '' ?>">
                <a href="{{ url('/akun') }}">
                    <i class="fa fa-user-circle"></i> Akunku 
                </a>
            </li>

            @can('company-list')
            <li class="<?= $actived == "perusahaan" ? 'active' : '' ?>">
                <a href="{{ url('/perusahaan') }}">
                    <i class="fa fa-industry"></i> Perusahaan 
                </a>
            </li>
            @endcan

            @if (Auth::user()->can('user-list') || 
                 Auth::user()->can('role-list') ||
                 Auth::user()->can('permission-list'))
            <li class="<?= $actived == "users" ? 'active' : '' ?>">
                <a href="#users-dropdown" aria-expanded="<?= $actived == "users" ? 'true' : 'false' ?>" data-toggle="collapse" class="<?= $actived == "users" ? '' : 'collapsed' ?>">
                    <i class="fa fa-user"></i>
                    Users
                </a>

                <ul id="users-dropdown" class="collapse list-unstyled <?= $actived == "users" ? 'show' : '' ?>">
                    @can('user-list')
                    <li>
                        <a href="{{ url('users') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Data User
                        </a>
                    </li>
                    @endcan

                    @can('role-list')
                    <li>
                        <a href="{{ url('hak-akses') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Hak Akses
                        </a>
                    </li>
                    @endcan

                    @can('permission-list')
                    <li>
                        <a href="{{ url('module') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Module
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif

            
            <!-- <li class="<?= $actived == "laporan" ? 'active' : '' ?>">
                <a href="{{ url('/laporan') }}">
                    <i class="fa fa-clipboard"></i> Laporan 
                </a>
            </li> -->
            
        </ul>

        

        <span class="heading">DATA MASTER</span>
        <ul class="list-unstyled">
            @if(Auth::user()->can('produk-list')
                || Auth::user()->can('produk-categiry-list')
                || Auth::user()->can('produk-price-list')
                || Auth::user()->can('produk-stock-list')
                || Auth::user()->can('produk-unit-list')
                || Auth::user()->can('produk-barcode-list'))
            <li class="<?= $actived == "master-produk" ? 'active' : '' ?>">
                <a href="#produkMaster" aria-expanded="<?= $actived == "master-produk" ? 'true' : 'false' ?>" data-toggle="collapse" class="<?= $actived == "master-produk" ? '' : 'collapsed' ?>">
                    <i class="fa fa-cube"></i>
                    Produk
                </a>
                <ul id="produkMaster" class="collapse list-unstyled <?= $actived == "master-produk" ? 'show' : '' ?>">
                    @can('produk-list')
                    <li>
                        <a href="{{ url('produk') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Data Produk
                        </a>
                    </li>
                    @endcan

                    @can('produk-category-list')
                    <li>
                        <a href="{{ url('produk/kategori') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Kategori
                        </a>
                    </li>
                    @endcan

                    @can('produk-price-list')
                    <li>
                        <a href="{{ url('produk/harga') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Atur Harga
                        </a>
                    </li>
                    @endcan

                    @can('produk-stock-list')
                    <li>
                        <a href="{{ url('produk/stok') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Atur Stok
                        </a>
                    </li>
                    @endcan

                    @can('produk-unit-list')
                    <li>
                        <a href="{{ url('produk/satuan') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Satuan
                        </a>
                    </li>
                    @endcan

                    @can('produk-barcode-list')
                    <!-- <li>
                        <a href="{{ url('produk/barcode') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Barcode
                        </a>
                    </li> -->
                    @endcan
                </ul>
            </li>
            @endif

            @if(Auth::user()->can('pelanggan-list')
                || Auth::user()->can('pelanggan-group-list'))
            <li class="<?= $actived == "master-pelanggan" ? 'active' : '' ?>">
                <a href="#pelangganMaster" aria-expanded="<?= $actived == "master-pelanggan" ? 'true' : 'false' ?>" data-toggle="collapse" class="<?= $actived == "master-pelanggan" ? '' : 'collapsed' ?>">
                    <i class="fa fa-address-book-o"></i>
                    Pelanggan
                </a>
                <ul id="pelangganMaster" class="collapse list-unstyled <?= $actived == "master-pelanggan" ? 'show' : '' ?>"">
                    @can('pelanggan-list')
                    <li>
                        <a href="{{ url('pelanggan') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Daftar Pelanggan
                        </a>
                    </li>
                    @endcan

                    @can('pelanggan-group-list')
                    <li>
                        <a href="{{ url('pelanggan/grup') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Grup Pelanggan
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif
            
            @can('supplier-list')
            <li class="<?= $actived == "master-supplier" ? 'active' : '' ?>">
                <a href="{{ url('/supplier') }}">
                    <i class="fa fa-truck"></i> Supplier 
                </a>
            </li>
            @endcan

            @can('employee-list')
            <li class="<?= $actived == "master-karyawan" ? 'active' : '' ?>">
                <a href="{{ url('/karyawan') }}">
                    <i class="fa fa-id-card"></i> Karyawan 
                </a>
            </li>
            @endcan
        </ul>

        <span class="heading">DATA OPERASIONAL</span>
        <ul class="list-unstyled">
            @if(Auth::user()->can('belanja-create') || 
                Auth::user()->can('belanja-list'))
            <li class="<?= $actived == "op-belanja" ? 'active' : '' ?>">
                <a href="#belanjaOp" aria-expanded="aria-expanded="<?= $actived == "op-belanja" ? 'true' : 'false' ?>" data-toggle="collapse" class="<?= $actived == "op-belanja" ? '' : 'collapsed' ?>">
                    <i class="fa fa-shopping-cart"></i>
                    Belanja
                </a>
                <ul id="belanjaOp" class="collapse list-unstyled <?= $actived == "op-belanja" ? 'show' : '' ?>">
                    @can('belanja-create')
                    <li>
                        <a href="{{ url('belanja/create') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Tambah Baru
                        </a>
                    </li>
                    @endcan

                    @can('belanja-list')
                    <li>
                        <a href="{{ url('belanja') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Riwayat
                        </a>
                    </li>
                    @endcan   

                    <!-- @can('belanja-hutang')
                    <li>
                        <a href="{{ url('belanja/hutang') }}">
                            <i class="fa fa-angle-double-right"></i>
                            Hutang
                        </a>
                    </li>
                    @endcan                     -->
                </ul>
            </li>
            @endif

            @can('sallary-list')
            <li class="<?= $actived == "op-sallary" ? 'active' : '' ?>">
                <a href="{{ url('/gaji-karyawan') }}">
                    <i class="fa fa-google-wallet"></i> Gaji Karyawan 
                </a>
            </li>
            @endcan
            
            <li class="<?= $actived == "op-lainnya" ? 'active' : '' ?>">
                <a href="{{ url('operasional/lainnya') }}">
                    <i class="fa fa-database"></i> Lainnya 
                </a>
            </li>
        </ul>

        <span class="heading">DATA PENJUALAN</span>
        <ul class="list-unstyled">
            @can('penjualan')
            <li class="<?= $actived == "penjualan" ? 'active' : '' ?>">
                <a href="{{ url('/penjualan') }}">
                    <i class="fa fa-shopping-bag"></i> Penjualan
                </a>
            </li>
            @endcan

            @can('penjualan-riwayat')
            <li class="<?= $actived == "penjualan-riwayat" ? 'active' : '' ?>">
                <a href="{{ url('/penjualan/riwayat') }}">
                    <i class="fa fa-history"></i> Riwayat
                </a>
            </li>
            @endcan

            <!-- @can('penjualan-piutang')
            <li class="<?= $actived == "penjualan-piutang" ? 'active' : '' ?>">
                <a href="{{ url('/penjualan/piutang') }}">
                    <i class="fa fa-bank"></i> Piutang
                </a>
            </li>
            @endcan -->
        </ul>

        <span class="heading">LABA / RUGI</span>
        <ul class="list-unstyled">
            <li class="<?= $actived == "laporan" ? 'active' : '' ?>">
                <a href="{{ url('/laporan') }}">
                    <i class="fa fa-line-chart"></i> Laporan 
                </a>
            </li>
        </ul>
        </div>
    </nav>
</div>
