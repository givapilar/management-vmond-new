@extends('home')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header rounded-t-20">
                    <h3 class="text-center">{{ $page_title }}</h3>
                </div>
                <div class="card-body rounded-b-20">
                    <form method="POST" action="{{ route('permit.update', $permits->id) }}" novalidate>
                        @method('patch')
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="nama">Name</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $permits->user->name }}" readonly>

                                        @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="nama">Role</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $permits->user->getRoleNames()[0] }}" readonly>

                                        @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="action">Action</label>
                                        <input class="form-control @error('action') is-invalid @enderror" id="action" type="text" name="action" placeholder="action" required value="{{ old('action') ?? $permits->action }}" readonly>

                                        @error('action')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="page">Page</label>
                                        <input class="form-control @error('page') is-invalid @enderror" id="page" type="text" name="page" placeholder="page" required value="{{ old('page') ?? $permits->page }}" readonly>

                                        @error('page')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="datetime">Datetime</label>
                                        <input class="form-control @error('datetime') is-invalid @enderror" id="datetime" type="text" name="datetime" placeholder="datetime" required value="{{ old('datetime') ?? $permits->datetime }}" readonly>

                                        @error('datetime')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="status">Status</label>
                                        {{-- <input class="form-control @error('status') is-invalid @enderror" id="status" type="text" name="status" placeholder="status" required value="{{ old('status') ?? $permits->status }}"> --}}
                                        <select class="form-control @error('status') is-invalid @enderror" name="status">
                                            <option disabled selected>Choose Status</option>
                                            <option value="Dalam Proses" {{ ($permits->status == 'Dalam Proses') ? 'selected' : '' }}>Dalam Proses</option>
                                            <option value="Disetujui" {{ ($permits->status == 'Disetujui') ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak" {{ ($permits->status == 'Ditolak') ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Permission</label>
                                        <input type="checkbox" id="checkbox">
                                        <select name="permissions[]" id="e1" class="js-example-basic-multiple select2-department select2" id="e1" multiple="multiple" style="width:100%">
                                            @foreach ($permissions as $permission)
                                                <option value="{{$permission->id}}"
                                                    @foreach (old('permissions') ?? $rolePermissions as $id)
                                                        @if ($id == $permission->id)
                                                            {{ 'selected' }}
                                                        @endif
                                                    @endforeach>
                                                    {{$permission->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" rows="4">{{ $permits->description }}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <textarea name="note" class="form-control" id="note" rows="4">{{ $permits->note }}</textarea>

                                        @error('note')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('permit.index') }}">
                                <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                            </a>
                            <button type="submit" class="btn btn-primary mr-2 p-2">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script>
     $("#checkbox").click(function () {
       if ($("#checkbox").is(':checked')) {
           $("#e1 > option").prop("selected", "selected");
           $("#e1").trigger("change");
       } else {
           $("#e1 > option").removeAttr("selected");
           $("#e1").val("");
           $("#e1").trigger("change");
       }
   });
</script>
@endsection

