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

            @can('material-create')
            <div class="col-6 text-right">
              <a class="btn btn-sm btn-danger btn-lg" href="{{ route('master-data.index') }}">
                <i class="fa-solid fa-arrow-left fa-beat-fade"></i>
                Kembali
              </a>
              <button class="btn btn-sm btn-success btn-lg btn-open-modal" data-toggle="modal" data-target="#modal-fullscreen-xl">
                <i class="fa fa-plus"></i>
                Tambah
              </button>
              {{-- <form action="{{ route('import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="import_file" class="form-control">
                  @error('import_file')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                <button type="submit" class="btn btn-primary mt-2">Import</button>
              </form> --}}

            </div>
            @endcan

          <div>
            <table id="example" class="table table-striped" style="width:100%">
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
                  <td class="table-head">{{ $loop->iteration }}</td>
                  <td class="table-head">{{ $material->code }}</td>
                  <td class="table-head">{{ $material->nama }}</td>
                  <td class="table-head">{{ $material->unit }}</td>
                  <td class="table-head">{{ $material->description ?? 'N/A' }}</td>
                  @if(auth()->user()->can('material-delete') || auth()->user()->can('material-edit'))
                  <td>
                    <div class="btn-group-sm">
                      @can('material-edit')
                      <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#modal-fullscreen-xl-edit{{ $material->id }}">
                        <i class="fa fa-edit"></i>
                        Edit
                      </button>
                      @endcan
                      @can('material-edit')
                      <a href="#" class="btn btn-danger f-12" onclick="modalDelete('material', '{{ $material->nams }}', '/material/' + {{ $material->id }}, '/material/')">
                        <i class="far fa-trash-alt"></i>
                        Hapus
                      </a>
                      @endcan
                    </div>
                  </td>
                  @endif
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
