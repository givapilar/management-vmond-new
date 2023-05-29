<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top p-2">
      <a class="sidebar-brand brand-logo" href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/logo/logo-vmond.png') }}" class="d-block mx-auto h-auto" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini" href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/icon/logo-v.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
    <hr class="mt-2 mb-2" style="background: #cdcdcd !important;">
    <li class="nav-item profile">
        <div class="profile-desc justify-content-center">
          <div class="profile-name">
                <h6 class="text-center" style="color:#6c7293 !important;">INFORMATION</h6>
          </div>
        </div>
    </li>
    <hr class="mt-1 mb-1" style="background: #cdcdcd !important;">
      <li class="nav-item profile">
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="count-indicator text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="12" class="h-auto"  fill="currentColor" aria-hidden="true" style="color:#838383 !important;"><path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16z"/></svg>
            </div>
            <div class="profile-name">
              <span class="mb-0 font-weight-normal" style="font-size: 14px;">VMOND Cafe</span>
            </div>
          </div>
        </div>
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="count-indicator text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"  width="12" class="h-auto"  fill="currentColor" aria-hidden="true" style="color:#838383 !important;"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
            </div>
            <div class="profile-name">
              <span class="mb-0 font-weight-normal" style="font-size: 14px;">Tanggerang Selatan</span>
            </div>
          </div>
        </div>
      </li>
      <hr class="mt-2 mb-1" style="background: #cdcdcd !important;">
      <li class="nav-item nav-category">
        <span class="nav-link">Navigation</span>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      @can('inventory')
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-icon">
            <i class="mdi mdi-archive"></i>
          </span>
          <span class="menu-title">Inventory</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('inventory.daftar-stok.index') }}">Daftar Stok</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('stok-masuk.index') }}">Stok Masuk</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('stok-keluar.index') }}">Stok Keluar</a></li>
          </ul>
        </div>
      </li>
      @endcan

      @can('master-data')
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('master-data.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-folder-outline"></i>
          </span>
          <span class="menu-title">Master Data</span>
        </a>
      </li>
      @endcan

      @can('toko-online')
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('management-toko-online.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-basket"></i>
          </span>
          <span class="menu-title">Toko Online</span>
        </a>
      </li>
      @endcan

      @can('history-log-list')
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('history-log.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-history"></i>
          </span>
          <span class="menu-title">History Log</span>
        </a>
      </li>
      @endcan

      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('permit.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-history"></i>
          </span>
          <span class="menu-title">Permit Admin</span>
        </a>
      </li>

    </ul>
  </nav>
<!-- partial -->
