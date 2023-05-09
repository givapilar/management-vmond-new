@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">  </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('management-toko-online.index') }}">Toko Online</a></li>
        <li class="breadcrumb-item active" aria-current="page"></li>
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
  
            @can('meeting-room-create')
            <div class="col-6 text-right">
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-meeting-room">
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
            <th class="th-sm">No Meja</th>
            <th class="th-sm">Harga</th>
            <th class="th-sm">Status</th>
            <th class="th-sm">image</th>
            <th class="th-sm">Description</th>
            <th class="th-sm">Action</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($meeting_rooms as $meeting_room)
                    <tr>
                        <td class="table-head">{{ $loop->iteration }}</td>
                        <td class="table-head">{{ $meeting_room->nama }}</td>
                        <td class="table-head">{{ $meeting_room->no_meja }}</td>
                        <td class="table-head">{{ $meeting_room->harga }}</td>
                        <td class="table-head">{{ $meeting_room->status }}</td>
                        <td class="table-head">
                          <img src="{{ asset('assets/images/meeting-room/'.($meeting_room->image ?? 'user.png')) }}" width="110px" class="image img" />
                        </td>
                        <td class="table-head">{{ $meeting_room->description }}</td>
                        @if(auth()->user()->can('meeting-room-delete') || auth()->user()->can('meeting-room-edit'))
                        <td>
                            <div class="btn-group-sm">
                              @can('meeting-room-edit')
                              <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-meeting_room{{ $meeting_room->id }}">
                                <i class="fa fa-edit"></i> 
                                Edit
                              </button>
                              @endcan
                              
                              @can('meeting-room-delete')
                              <a href="#" class="btn btn-danger f-12" onclick="modalDelete('Meeting Room', '{{ $meeting_room->nama }}', '/meeting-room/' + {{ $meeting_room->id }}, '/meeting-room/')">
                                <i class="far fa-trash-alt"></i>
                                Delete
                              </a>
                              @endcan
                            </div>
                          </td>
                          @endif
                        </tr>
                        @include('management-toko-online.meeting-room.edit')
                @endforeach
            
            </tbody>
        
        </table>

        </div>
      </div>
    </div>
  </div>
</div>
@include('management-toko-online.meeting-room.create')
@endsection
