@extends('home')

@section('style')
<style>
  .hilang {
      display: none;
  }

</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row mt-2 p-2">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card card rounded-20 p-2">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
                    <div class="row">
                        <div class="col-6 mt-1 px-4">
                            <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                                <i class="fa-sharp fa-solid fa-boxes-stacked" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-12">
                            @include('components.flash-message')
                        </div>
                    </div>

                    <table id="mytable" class="table table-striped" style="width:100%" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm text-white">No</th>
                            <th class="th-sm text-white">Nama</th>
                            <th class="th-sm text-white">Action</th>
                            <th class="th-sm text-white">Page</th>
                            <th class="th-sm text-white">Datetime</th>
                            <th class="th-sm text-white">Status</th>
                            <th class="th-sm text-white">Description</th>
                            <th class="th-sm text-white"  width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permits as $permit)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $permit->user->name }}</td>
                                <td class="table-head text-white">{{ $permit->action }}</td>
                                <td class="table-head text-white">{{ $permit->page }}</td>
                                <td class="table-head text-white">{{ $permit->datetime }}</td>
                                <td class="table-head text-white">{{ $permit->status }}</td>
                                <td class="table-head text-white">{{ $permit->description }}</td>
                                <td>
                                    <div class="btn-group-sm">
                                        {{-- @can('stok-masuk-edit') --}}
                                        <a href="{{ route('permit.edit', $permit->id) }}"
                                            class="btn btn-warning p-2 text-white">
                                            <i class="far fa-edit"></i>
                                            Edit
                                        </a>
                                        {{-- @endcan --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection
