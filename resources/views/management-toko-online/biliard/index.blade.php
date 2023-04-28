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
        <li class="breadcrumb-item active" aria-current="page">Biliard</li>
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
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-biliard">
                <i class="fa fa-plus"></i> 
                Tambah Menu
              </button>
            </div>
          </div>

        <table id="dtBasicExample" class="table" width="100%">
        <thead>
            <tr>
            <th class="th-sm">No</th>
            <th class="th-sm">Nama</th>
            <th class="th-sm">No Meja</th>
            <th class="th-sm">Harga</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">image</th>
            <th class="th-sm">Description</th>
            <th class="th-sm">Action</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($biliards as $biliard)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $biliard->nama }}</td>
                        <td>{{ $biliard->no_meja }}</td>
                        <td>{{ $biliard->harga }}</td>
                        <td>{{ $biliard->status }}</td>
                        <td>{{ $biliard->image }}</td>
                        <td>{{ $biliard->description }}</td>
                        <td>
                            <div class="btn-group-sm">
                              <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-biliard{{ $biliard->id }}">
                                <i class="fa fa-edit"></i> 
                                Edit
                              </button>
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Biliard', '{{ $biliard->nama }}', '/biliard/' + {{ $biliard->id }}, '/biliard/')">
                                <i class="far fa-trash-alt"></i>
                                Delete
                              </a>
                            </div>
                          </td>
                        </tr>
                        @include('management-toko-online.biliard.edit')
                @endforeach
            
            </tbody>
        
        </table>

        </div>
      </div>
    </div>
  </div>
</div>
@include('management-toko-online.biliard.create')
@endsection
