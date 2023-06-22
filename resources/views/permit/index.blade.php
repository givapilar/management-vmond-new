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
                                <i class="fa-solid fa-file-circle-check" style="font-size: 20px;"></i>
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
                                <th class="th-sm text-white">Link</th>
                                <th class="th-sm text-white">Status</th>
                                @if (auth()->user()->can('permit-edit'))
                                <th class="th-sm text-white"  width="15%">Action</th>
                                @endif
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
                                <td class="table-head text-white">
                                    @if($permit->action == 'edit' && $permit->status == 'Disetujui' && $permit->linkPermit->status == true)
                                        <a href="{{ $permit->linkPermit->link }}"
                                            class="btn btn-success p-2 text-white">
                                            Action
                                        </a>
                                    @elseif($permit->action == 'delete' && $permit->status == 'Disetujui' && $permit->linkPermit->status == true)
                                        <a href="{{ $permit->linkPermit->link }}"
                                            class="btn btn-success p-2 text-white">
                                            Action
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-success p-2 text-white position-relative disabled" title="Status permit belum disetujui">
                                            Action
                                            @if(($permit->linkPermit->status ?? true) == false)
                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                                                <span class="visually-hidden">Alerts</span>
                                            </span>
                                            @else
                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">Alerts</span>
                                            </span>
                                            @endif
                                        </a>
                                    @endif
                                </td>
                                <td class="table-head text-white">
                                    @if ($permit->status == 'Dalam Proses')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $permit->status }}</span>
                                    @elseif($permit->status == 'Disetujui')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $permit->status }}</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $permit->status }}</span>
                                    @endif
                                </td>
                                {{-- <td class="table-head text-white">{{ $permit->description }}</td> --}}
                                @if (auth()->user()->can('permit-edit'))
                                <td>
                                    @if ($permit->status == 'Disetujui' && $permit->linkPermit->status == false)
                                    <div class="btn-group-sm">
                                        @can('permit-edit')
                                        <a href="#"
                                            class="btn btn-warning p-2 text-white position-relative disabled">
                                            <i class="far fa-edit"></i>
                                            Edit

                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                                                <span class="visually-hidden">Alerts</span>
                                            </span>
                                        </a>
                                        @endcan
                                    </div>
                                    @else
                                    <div class="btn-group-sm">
                                        @can('permit-edit')
                                        <a href="{{ route('permit.edit', $permit->id) }}"
                                            class="btn btn-warning p-2 text-white">
                                            <i class="far fa-edit"></i>
                                            Edit
                                        </a>
                                        @endcan
                                    </div>

                                    @endif
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
@endsection

@section('javascript')

@endsection
