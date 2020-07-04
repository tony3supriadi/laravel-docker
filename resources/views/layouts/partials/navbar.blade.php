<header class="header fixed-top w-100">
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <a href="{{ url('/') }}" target="_blank" class="navbar-brand d-none d-sm-inline-block">
                        <div class="brand-text d-none d-lg-inline-block">
                            <i class="fa fa-google-wallet mr-2"></i>
                            <span>SIMKEU</span><strong>-APP</strong>
                        </div>
                        <div class="brand-text d-none d-sm-inline-block d-lg-none">
                            <strong>SK</strong>
                        </div>
                    </a>
                    <a id="toggle-btn" href="#" class="menu-btn active">
                        <span></span><span></span><span></span>
                    </a>
                </div>
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <li class="nav-item">
                        <a href="{{ url('penjualan') }}" class="nav-link">
                            <i class="fa fa-shopping-bag mr-2"></i>Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:"
                            onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();"
                            class="nav-link logout">
                            
                            <span class="d-none d-sm-inline">Logout</span>
                            <i class="fa fa-sign-out"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>