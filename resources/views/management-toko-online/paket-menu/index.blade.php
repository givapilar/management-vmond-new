@extends('home')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<style>
    .current-stok{
        background-color: #2A3038 !important;
    }

</style>
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
                                <i class="fa-solid fa-fork-knife" style="font-size: 20px;"></i>
                                <i class="fa-solid fa-utensils"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('management-toko-online.index') }}">
                                Kembali
                            </a>
                            @can('paket-menu-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-paket">
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
                        <th class="th-sm text-white">Image</th>
                        <th class="th-sm text-white">Nama Paket</th>
                        <th class="th-sm text-white">Category</th>
                        <th class="th-sm text-white">Harga</th>
                        <th class="th-sm text-white">Status</th>
                        <th class="th-sm text-white" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menu_packages as $package)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">
                                    <img src="{{ asset('assets/images/paket-menu/'.($package->image ?? '')) }}" width="110px" class="image img" />
                                </td>
                                <td class="table-head text-white">{{ $package->nama_paket }}</td>
                                <td class="table-head text-white">{{ str_replace('_', ' ',$package->category) }}</td>
                                <td class="table-head text-white">{{ $package->harga }}</td>
                                <td class="table-head text-white">{{ $package->status }}</td>

                                @if(auth()->user()->can('paket-menu-delete') || auth()->user()->can('paket-menu-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                        @can('paket-menu-edit')
                                        <a class="btn btn-warning p-2 f-12" href="{{ route('paket-menu.edit', $package->id) }}">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                        @endcan

                                        @can('paket-menu-delete')
                                        <a href="#" class="btn btn-danger p-2 f-12" onclick="modalDelete('Paket Menu', '{{ $package->nama }}', '/paket-menu/' + {{ $package->id }}, '/paket-menu/')">
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
@include('management-toko-online.paket-menu.create')
@endsection
