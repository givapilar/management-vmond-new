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
                                <i class="fa-solid fa-users" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                                Kembali
                            </a>
                            @can('user-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-user">
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
                                <th class="th-sm text-white" width="10%">Photo Profile</th>
                                <th class="th-sm text-white">Name</th>
                                <th class="th-sm text-white">Role</th>
                                <th class="th-sm text-white">Email</th>
                                <th class="th-sm text-white" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">
                                    <img src="{{ asset('assets/images/user/'.($user->avatar ?? 'user.png')) }}" width="40px" class="img-circle">
                                </td>
                                <td class="table-head text-white">{{ $user->name }}</td>
                                <td class="table-head text-white">{{ $user->getRoleNames()[0]}}</td>
                                <td class="table-head text-white">{{ $user->email }}</td>
                                @if(auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                    <a class="btn btn-warning f-12 p-2" href="{{ route('users.edit', $user->id) }}">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    @if(auth()->user()->can('user-delete') && Auth::user()->id != $user->id)
                                    <a href="#" class="btn btn-danger f-12 p-2" onclick="modalDelete('User', '{{ $user->name }}', ' /users/' + {{ $user->id }}, '  /users/')">
                                        <i class="far fa-trash-alt"></i>
                                        Delete
                                    </a>
                                    @endif
                                    </div>
                                </td>
                                @endif
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
@include('master-data.user.create')
@endsection
