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
        <li class="breadcrumb-item active" aria-current="page">Stok Keluar</li>
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
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-stok-keluar">
                <i class="fa fa-plus"></i>
                Tambah Stok Keluar
              </button>
            </div>
            <div class="row">
              <div class="col-6">
                  @include('components.flash-message')
              </div>
          </div>
          </div>

        <table id="dtBasicExample" class="table" width="100%">
        <thead>
            <tr>
            <th class="th-sm">No</th>
            <th class="th-sm">Nama</th>
            <th class="th-sm">Stok keluar</th>
            <th class="th-sm">Description</th>
            <th class="th-sm">Action</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($stok_keluars as $stok_keluar)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stok_keluar->material->nama }}</td>
                        <td>{{ $stok_keluar->material_keluar }}</td>
                        <td>{{ $stok_keluar->description }}</td>
                        <td>
                            <div class="btn-group-sm">
                              <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-stok-keluar{{ $stok_keluar->id }}">
                                <i class="fa fa-edit"></i>
                                Edit Stok Keluar
                              </button>
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Stok keluar', '{{ $stok_keluar->material->nama }}', '/stok-keluar/' + {{ $stok_keluar->id }}, '/stok-keluar/')">
                                <i class="far fa-trash-alt"></i>
                                Delete
                              </a>
                            </div>
                        </td>
                    </tr>
                    @include('inventory.stok-keluar.edit')
                @endforeach

            </tbody>

        </table>

        </div>
      </div>
    </div>
  </div>
</div>
@include('inventory.stok-keluar.create')
@endsection
