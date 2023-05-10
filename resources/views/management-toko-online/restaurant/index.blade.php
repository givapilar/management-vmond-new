@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">  </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('management-toko-online.index') }}">Master Data</a></li>
        <li class="breadcrumb-item active" aria-current="page">restaurant</li>
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
  
            @can('restaurant-create')
            <div class="col-6 text-right">
              <a class="btn btn-sm btn-danger btn-lg" href="{{ route('management-toko-online.index') }}">
                <i class="fa-solid fa-arrow-left fa-beat-fade"></i>
                Kembali
              </a>
              <button class="btn btn-sm btn-success btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-menu">
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
            <th class="th-sm">Nama</th>
            <th class="th-sm">Category</th>
            <th class="th-sm">Harga</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">Image</th>
            <th class="th-sm">Action</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($restaurants as $restaurant)
                    <tr>
                        <td class="table-head">{{ $loop->iteration }}</td>
                        <td class="table-head">{{ $restaurant->nama }}</td>
                        <td class="table-head">{{ $restaurant->category }}</td>
                        <td class="table-head">{{ $restaurant->harga }}</td>
                        <td class="table-head">{{ $restaurant->status }}</td>
                        <td class="table-head">
                          <img src="{{ asset('assets/images/restaurant/'.($restaurant->image ?? 'user.png')) }}" width="110px" class="image img" />
                        </td>
                        @if(auth()->user()->can('restaurant-delete') || auth()->user()->can('restaurant-edit'))
                        <td>
                            <div class="btn-group-sm">
                              @can('restaurant-edit')
                              <a class="btn btn-warning f-12" href="{{ route('restaurant.edit', $restaurant->id) }}">
                                <i class="fa fa-edit"></i> 
                                Edit
                              </a>
                              @endcan

                              @can('restaurant-delete')
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Restaurant', '{{ $restaurant->nama }}', '/restaurant/' + {{ $restaurant->id }}, '/restaurant/')">
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
@include('management-toko-online.restaurant.create')
@endsection
