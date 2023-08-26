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
                                <i class="fa-solid fa-panorama" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('management-toko-online.index') }}">
                                Kembali
                            </a>
                            @can('media-advertising-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-banner">
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
                            <th class="th-sm text-white">image</th>
                            <th class="th-sm text-white">Description</th>
                            <th class="th-sm text-white" width="15%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">
                                    <img src="{{ asset('assets/images/banner/'.($banner->image ?? 'user.png')) }}" width="110px" class="image img" />
                                </td>
                                <td class="table-head text-white">{{ $banner->description }}</td>
                                @if(auth()->user()->can('media-advertising-delete') || auth()->user()->can('media-advertising-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                    @can('media-advertising-edit')
                                    <button class="btn btn-sm btn-warning btn-lg btn-open-modal p-2" data-toggle="modal" data-target="#edit-banner{{ $banner->id }}">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </button>
                                    @endcan
                                    @can('media-advertising-delete')
                                    <a href="#" class="btn btn-danger f-12 p-2" onclick="modalDelete('banner', '{{ $banner->nama }}', '/media-advertising/' + {{ $banner->id }}, '/media-advertising/')">
                                        <i class="far fa-trash-alt"></i>
                                        Delete
                                    </a>
                                    @endcan
                                    </div>
                                </td>
                                @endif
                                </tr>
                                @include('management-toko-online.banner.edit')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('management-toko-online.banner.create')
@endsection
