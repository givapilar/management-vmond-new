@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card card rounded-20 p-2">
        <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
          <div class="row">
              <div class="col-6 mt-1 px-4">
                  <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                      <i class="fa-solid fa-clipboard-list" style="font-size: 20px;"></i>
                      {{-- <i class="fa-regular fa-clipboard-list"></i> --}}
                      <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                  </span>
              </div>

              <div class="col-6 text-right px-4">
                  <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                      Kembali
                  </a>
                  @can('user-create')
                  <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-asset">
                      Tambah
                  </button>
                  @endcan
              </div>
          </div>
      </div>
          <div class="card-body bg-gray-800 rounded-20 p-3">
            <div class="row">
                <div class="col-12">
                    @include('components.flash-message')
                </div>
            </div>

            <table id="mytable" class="table table-striped" style="width:100%">
              <thead>
                  <tr>
                    <th class="th-sm text-white">No</th>
                    <th class="th-sm text-white">Nama</th>
                    <th class="th-sm text-white">Quantity</th>
                    <th class="th-sm text-white" width="15%">Action</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($asset_managements as $asset_management)
                    <tr>
                        <td class="table-head text-white">{{ $loop->iteration }}</td>
                        <td class="table-head text-white">{{ $asset_management->nama }}</td>
                        <td class="table-head text-white">{{ $asset_management->quantity }}</td>
                        @if(auth()->user()->can('restaurant-delete') || auth()->user()->can('restaurant-edit'))
                        <td>
                            <div class="btn-group-sm">
                              @can('restaurant-edit')
                              <a class="btn btn-warning f-12" href="{{ route('asset-management.edit', $asset_management->id) }}">
                                <i class="fa fa-edit"></i> 
                                Edit
                              </a>
                              @endcan

                              @can('restaurant-delete')
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Asset Management', '{{ $asset_management->nama }}', '/asset-management/' + {{ $asset_management->id }}, '/asset-management/')">
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
@include('master-data.asset-management.create')
@endsection
