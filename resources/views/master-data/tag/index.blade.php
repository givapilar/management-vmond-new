@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">  </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tag</li>
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
                @include('components.form-message')
            </div>
          </div>

          <div class="row">
            <div class="col-6 mt-1">
              <span class="tx-bold text-lg text-white" style="font-size:16px;">
                <h4 class="card-title">{{ $page_title }}</h4>
              </span>
            </div>
  
            @can('restaurant-create')
            <div class="col-6 text-right">
              <a class="btn btn-sm btn-danger btn-lg" href="{{ route('master-data.index') }}">
                <i class="fa-solid fa-arrow-left fa-beat-fade"></i>
                Kembali
              </a>
              <button class="btn btn-sm btn-success btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-menu-tag">
                <i class="fa fa-plus"></i> 
                Tambah
              </button>
            </div>
            @endcan
          </div>

        <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
            <th class="th-sm">No</th>
            <th class="th-sm">Tag Name</th>
            <th class="th-sm">Action</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td class="table-head">{{ $loop->iteration }}</td>
                        <td class="table-head">{{ $tag->tag_name }}</td>
                        @if(auth()->user()->can('restaurant-delete') || auth()->user()->can('restaurant-edit'))
                        <td>
                            <div class="btn-group-sm">
                              @can('restaurant-edit')
                              <a class="btn btn-warning f-12" href="{{ route('tag.edit', $tag->id) }}">
                                <i class="fa fa-edit"></i> 
                                Edit
                              </a>
                              @endcan

                              @can('restaurant-delete')
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Tag', '{{ $tag->nama }}', '/tag/' + {{ $tag->id }}, '/tag/')">
                                <i class="far fa-trash-alt"></i>
                                Delete
                              </a>
                              @endcan
                              
                            </div>
                          </td>
                          @endif
                        </tr>
                @endforeach
            
            </tbody>
        
        </table>

        </div>
      </div>
    </div>
  </div>
</div>
@include('master-data.tag.create')
@endsection
