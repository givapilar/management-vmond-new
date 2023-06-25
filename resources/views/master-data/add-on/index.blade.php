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
                                <i class="fa-solid fa-address-card"  style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                                Kembali
                            </a>

                            @can('add-on-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-add-on">
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
                                <th class="th-sm text-white">Title</th>
                                <th class="th-sm text-white">Minimal Choice</th>
                                <th class="th-sm text-white" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($add_ons as $add_on)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $add_on->title }}</td>
                                <td class="table-head text-white">{{ $add_on->minimal_choice }}</td>
                                {{-- <td class="table-head text-white">
                                    <a class="btn btn-primary p-2" href="{{ route('add-on.show', $add_on->id) }}">
                                        <i class="fa fa-edit"></i> 
                                        Detail Add On
                                    </a>
                                </td> --}}

                                @if(auth()->user()->can('add-on-delete') || auth()->user()->can('add-on-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                    @can('add-on-edit')
                                    <a class="btn btn-warning p-2" href="{{ route('add-on.edit', $add_on->id) }}">
                                        <i class="fa fa-edit"></i> 
                                        Edit
                                    </a>
                                    @endcan
                                    @can('add-on-delete')
                                    <a href="#" class="btn btn-danger p-2 f-12" onclick="modalDelete('Add On', '{{ $add_on->title }}', '/add-on/' + {{ $add_on->id }}, '/add-on/')">
                                        <i class="far fa-trash-alt"></i>
                                        Hapus
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
@include('master-data.add-on.create')
@endsection

