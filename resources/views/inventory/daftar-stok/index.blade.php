@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">  </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
        <li class="breadcrumb-item active" aria-current="page">Material</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          
          <div class="row">
            <div class="col-12">
                @include('components.flash-message')
            </div>
          </div>

          <div class="row">
            <div class="col-6 mt-1">
              <span class="tx-bold text-lg text-white" style="font-size:16px;">
                <h4 class="card-title">{{ $page_title }}</h4>
              </span>
            </div>

            <div class="col-6 text-right">
              <a class="btn btn-sm btn-info btn-lg" href="{{ route('management-toko-online.index') }}">
                <i class="fa-solid fa-arrow-left fa-beat-fade"></i>
                Stok Masuk
              </a>
              <button class="btn btn-sm btn-success btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-banner">
                <i class="fa fa-plus"></i> 
                Stok Keluar
              </button>
            </div>
           
          </div>

        <table id="dtBasicExample" class="table" width="100%">
        <thead>
            <tr>
            <th class="th-sm">No</th>
            <th class="th-sm">Nama</th>
            <th class="th-sm">Total Stok</th>
            <th class="th-sm">Stok Masuk</th>
            <th class="th-sm">Stok Keluar</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($materials as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->nama }}</td>
                        <td>{{ $material->stokMasuk->sum('material_masuk') - $material->stokKeluar->sum('material_keluar') }}</td>
                        <td>{{ $material->stokMasuk->sum('material_masuk') }}</td>
                        <td>{{ $material->stokKeluar->sum('material_keluar') }}</td>
                        
                    </tr>
                @endforeach
            
            </tbody>
        
        </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
