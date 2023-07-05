@extends('home')

@section('style')
<style>
    .jconfirm.jconfirm-material .jconfirm-box{
        background-color: #040507 !important;
        border: 1px solid #464646 !important;
        border-radius: 20px !important;
        box-shadow: 0px 0px 10px 0px rgba(255,255,255,0.50);
        -webkit-box-shadow: 0px 0px 10px 0px rgba(255,255,255,0.50);
        -moz-box-shadow: 0px 0px 10px 0px rgba(255,255,255,0.50);
    }
    .jconfirm .jconfirm-box div.jconfirm-title-c .jconfirm-title{
        color: white !important;
    }
    .jconfirm.jconfirm-material .jconfirm-box{
        padding: 15px 25px 10px 25px !important;
    }
    .jconfirm.jconfirm-material .jconfirm-box div.jconfirm-title-c{
        margin-bottom: 10px !important;
    }
    .jconfirm .jconfirm-box div.jconfirm-closeIcon{
        width: fit-content !important;
        height: fit-content !important;
        background: gray !important;
        padding: 5px !important;
        border-radius: 5px !important;
        top:15px !important;
        right:15px !important;
    }
    .jconfirm.jconfirm-material .jconfirm-box div.jconfirm-closeIcon{
        color: rgb(255 255 255) !important;
    }
    .custom-hr{
        margin-top: 2px !important;
        margin-bottom: 2px !important;
        background: #d4d4d4 !important;
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
                                <i class="fa-solid fa-building-shield" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>

                        <div class="col-6 text-right px-4">
                            <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                                Kembali
                            </a>
                            @can('departement-create')
                            <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-departement">
                                Tambah Departement
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
                                <th class="th-sm text-white" width='40%'>Name</th>
                                <th class="th-sm text-white" width='35%'>Permission</th>
                                <th class="th-sm text-white">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($departements as $departement)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $departement->name }}</td>
                                <td>
                                    <button onclick="detailModal('Permission User', 'departement/' + {{ $departement->id }}, 'small')" class="btn btn-sm btn-primary p-2">
                                        <i class="fa fa-info-circle"></i>Show Permissions
                                    </button>
                                </td>

                                @if(auth()->user()->can('departement-delete') || auth()->user()->can('departement-edit'))
                                <td>
                                    <div class="btn-group-sm">
                                        @can('departement-edit')
                                            <a href="{{ route('departement.edit', $departement->id) }}"
                                                class="btn btn-warning p-2 text-white">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </a>
                                        @endcan

                                        @can('departement-delete')
                                        <a href="#" class="btn btn-danger p-2 f-12" onclick="modalDelete('Departement', '{{ $departement->name }}', '/departement/' + {{ $departement->id }}, '/departement/')">
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
@include('master-data.departements.create')
@endsection
