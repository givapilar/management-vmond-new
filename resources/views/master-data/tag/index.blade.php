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
                  <i class="fa-solid fa-tags" style="font-size: 20px;"></i>
                  <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
              </span>
            </div>

            <div class="col-6 text-right px-4">
              <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                  Kembali
              </a>
              @can('tag-create')
              <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-tag">
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
                <th class="th-sm text-white">Tag Name</th>
                <th class="th-sm text-white">position</th>
                <th class="th-sm text-white">status</th>
                <th class="th-sm text-white" width="13%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tags as $tag)
              <tr>
                <td class="table-head text-white">{{ $loop->iteration }}</td>
                <td class="table-head text-white">{{ $tag->tag_name }}</td>
                <td class="table-head text-white">{{ $tag->position ?? 'not found' }}</td>
                <td class="table-head text-white">{{ $tag->status ?? 'not found' }}</td>
                @if(auth()->user()->can('tag-delete') || auth()->user()->can('tag-edit'))
                <td>
                  <div class="btn-group-sm">
                    @can('tag-edit')
                    <button class="btn btn-sm btn-warning p-2 btn-lg btn-open-modal" data-toggle="modal" data-target="#edit-tag{{ $tag->id }}">
                      <i class="fa fa-edit"></i>
                      Edit
                    </button>
                    @endcan

                    @can('tag-delete')
                    <a href="#" class="btn btn-danger p-2 btn-lg btn-open-modal" onclick="modalDelete('Tag', '{{ $tag->nama }}', '/tag/' + {{ $tag->id }}, '/tag/')">
                      <i class="far fa-trash-alt"></i>
                      Delete
                    </a>
                    @endcan
                  </div>
                </td>
                @endif
              </tr>
              @include('master-data.tag.edit')
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('master-data.tag.create')
@endsection
