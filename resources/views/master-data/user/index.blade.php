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
                <h4 class="card-title">User</h4>
              </span>
            </div>
  
            <div class="col-6 text-right">
              <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-user">
                <i class="fa fa-plus"></i> 
                Tambah User
              </button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>no</th>
                  <th>Avatar</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <img src="{{ asset('assets/images/user/'.($user->avatar ?? 'user.png')) }}" width="40px" class="img-circle">
                  </td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username.'('. $user->getRoleNames()[0] .')'}}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    <div class="btn-group-sm">
                      <button class="btn btn-sm btn-warning btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-user{{ $user->id }}">
                        <i class="fa fa-edit"></i> 
                        Edit User
                      </button>
                      {{-- @if(auth()->user()->can('user-delete') && Auth::user()->id != $user->id) --}}
                      <a href="#" class="btn btn-danger f-12" onclick="modalDelete('User', '{{ $user->name }}', ' /users/' + {{ $user->id }}, '  /users/')">
                        <i class="far fa-trash-alt"></i>
                        Delete
                      </a>
                      {{-- @endif --}}
                    </div>
                  </td>
                </tr>
                @include('master-data.user.edit')
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@include('master-data.user.create')
@endsection
