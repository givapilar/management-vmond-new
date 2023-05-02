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
        <li class="breadcrumb-item active" aria-current="page">stok_masuk</li>
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
                {{-- <h4 class="card-title">{{ $page_title }}</h4> --}}
              </span>
            </div>
  
            <div class="col-6 text-right">
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-stok-masuk">
                <i class="fa fa-plus"></i> 
                Tambah Stok Masuk
              </button>
            </div>
          </div>

        <table id="dtBasicExample" class="table" width="100%">
        <thead>
            <tr>
            <th class="th-sm">No</th>
            <th class="th-sm">Nama</th>
            <th class="th-sm">Stok Masuk</th>
            <th class="th-sm">Description</th>
            <th class="th-sm">Action</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($stok_masuks as $stok_masuk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stok_masuk->material->nama }}</td>
                        <td>{{ $stok_masuk->material_masuk }}</td>
                        <td>{{ $stok_masuk->description }}</td>
                        <td>
                            <div class="btn-group-sm">
                              {{-- <a href="{{ route('material.edit', $stok_masuk->id) }}" class="btn btn-warning text-white">
                                <i class="far fa-edit"></i>
                                Edit
                              </a> --}}
                              <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-stok-masuk{{ $stok_masuk->id }}">
                                <i class="fa fa-edit"></i> 
                                Edit Stok Masuk
                              </button>
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Stok Masuk', '{{ $stok_masuk->material->nama }}', '/stok-masuk/' + {{ $stok_masuk->id }}, '/stok-masuk/')">
                                <i class="far fa-trash-alt"></i>
                                Delete
                              </a>
                            </div>
                          </td>
                        </tr>
                        @include('inventory.stok-masuk.edit')
                @endforeach
            
            </tbody>
        
        </table>

        </div>
      </div>
    </div>
  </div>
</div>
@include('inventory.stok-masuk.create')
@endsection
