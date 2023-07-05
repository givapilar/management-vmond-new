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
                                <i class="fa-solid fa-boxes-stacked" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                                Kembali
                            </a>

                            @can('bahan-baku-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#modal-fullscreen-xl">
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
                                <th class="th-sm text-white">Code</th>
                                <th class="th-sm text-white">Nama</th>
                                <th class="th-sm text-white">Unit</th>
                                <th class="th-sm text-white">Minimal Stok</th>
                                <th class="th-sm text-white">Description</th>
                                <th class="th-sm text-white" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $material->code }}</td>
                                <td class="table-head text-white">{{ $material->nama }}</td>
                                <td class="table-head text-white">{{ $material->unit }}</td>
                                <td class="table-head text-white">{{ $material->minimal_stok }}</td>
                                <td class="table-head text-white">{{ $material->description ?? 'N/A' }}</td>
                                @if(auth()->user()->can('bahan-baku-delete') || auth()->user()->can('bahan-baku-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                    @can('bahan-baku-edit')
                                    <button class="btn btn-sm btn-warning p-2 btn-lg btn-open-modal" data-toggle="modal" data-target="#modal-fullscreen-xl-edit{{ $material->id }}">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </button>
                                    @endcan
                                    @can('bahan-baku-delete')
                                    <a href="#" class="btn btn-danger p-2 f-12" onclick="modalDelete('Bahan Baku', '{{ $material->nama }}', '/bahan-baku/' + {{ $material->id }}, '/bahan-baku/')">
                                        <i class="far fa-trash-alt"></i>
                                        Hapus
                                    </a>
                                    @endcan
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @include('master-data.material.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('master-data.material.create')
@endsection
