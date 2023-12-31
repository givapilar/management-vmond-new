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
                                <i class="fa-solid fa-lines-leaning" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('management-toko-online.index') }}">
                                Kembali
                            </a>
                            @can('biliard-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-biliard">
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

                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="th-sm text-white">No</th>
                                <th class="th-sm text-white">Nama</th>
                                <th class="th-sm text-white">No Meja</th>
                                <th class="th-sm text-white">Harga</th>
                                <th class="th-sm text-white">Status</th>
                                <th class="th-sm text-white">image</th>
                                <th class="th-sm text-white" width="15%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($biliards as $biliard)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $biliard->nama }}</td>
                                <td class="table-head text-white">{{ $biliard->no_meja }}</td>
                                <td class="table-head text-white">{{ $biliard->harga }}</td>
                                <td class="table-head text-white">{{ $biliard->status }}</td>
                                <td class="table-head text-white">
                                <img src="{{ asset('assets/images/biliard/'.($biliard->image ?? 'user.png')) }}" width="110px" class="image img" />
                                </td>
                                @if(auth()->user()->can('biliard-delete') || auth()->user()->can('biliard-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                    @can('biliard-edit')
                                    <a class="btn btn-warning f-12 p-2" href="{{ route('biliard.edit', $biliard->id) }}">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    @endcan
                                    @can('biliard-delete')
                                    <a href="#" class="btn btn-danger f-12 p-2" onclick="modalDelete('Biliard', '{{ $biliard->nama }}', '/biliard/' + {{ $biliard->id }}, '/biliard/')">
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
@include('management-toko-online.biliard.create')
@endsection
