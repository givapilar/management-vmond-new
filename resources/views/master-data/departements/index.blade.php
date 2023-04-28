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
        <li class="breadcrumb-item active" aria-current="page">User</li>
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
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-departement">
                <i class="fa fa-plus"></i> 
                Tambah Departement
              </button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width='40%'>Name</th>
                        <th width='35%'>Permission</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($departements as $departement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $departement->name }}</td>
                        <td>
                            <button onclick="detailModal('Permission User', 'departement/' + {{ $departement->id }}, 'small')" class="btn btn-sm btn-primary">
                                <i class="fa fa-info-circle"></i>Show Permissions
                            </button>
                        </td>
                        <td>
                            <div class="btn-group-sm">
                                <a href="{{ route('departement.edit', $departement->id) }}"
                                    class="btn btn-warning text-white">
                                    <i class="far fa-edit"></i>
                                    Edit
                                </a>

                                <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Departement', '{{ $departement->name }}', '/departement/' + {{ $departement->id }}, '/departement/')">
                                    <i class="far fa-trash-alt"></i>
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@include('master-data.departements.create')
@endsection
