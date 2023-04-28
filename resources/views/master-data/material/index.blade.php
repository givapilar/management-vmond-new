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
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#modal-fullscreen-xl">
                <i class="fa fa-plus"></i> 
                Tambah Material
              </button>
            </div>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Code</th>
                  <th>Nama</th>
                  <th>Unit</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($materials as $material)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $material->code }}</td>
                  <td>{{ $material->nama }}</td>
                  <td>{{ $material->unit }}</td>
                  <td>{{ $material->description ?? 'N/A' }}</td>
                  <td>
                    <div class="btn-group-sm">
                      <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#modal-fullscreen-xl-edit{{ $material->id }}">
                        <i class="fa fa-edit"></i> 
                        Edit Material
                      </button>
                      {{-- <a href="{{ route('material.edit', $material->id) }}" class="btn btn-warning text-white">
                        <i class="far fa-edit"></i>
                        Edit
                      </a> --}}
                      <a href="#" class="btn btn-danger f-12" onclick="modalDelete('material', '{{ $material->nams }}', '/material/' + {{ $material->id }}, '/material/')">
                        <i class="far fa-trash-alt"></i>
                        Hapus
                      </a>
                    </div>
                  </td>
                </tr>
                @include('master-data.material.edit')
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('master-data.material.create')
@endsection
