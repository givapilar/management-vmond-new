@extends('home')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Form elements </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Form elements</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ ( $page_title) }}</h4>
                    <form method="POST" action="{{ route('permit.update', $permits->id) }}" novalidate>
                        @method('patch')
                        @csrf
        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
        
                                    <div class="form-group mb-3">
                                        <label for="nama">Name</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $permits->user->name }}">
                                        
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
                                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $permits->user->getRoleNames()[0] }}">
                                        
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
                                        <input class="form-control @error('action') is-invalid @enderror" id="action" type="text" name="action" placeholder="action" required value="{{ old('action') ?? $permits->action }}">
                                        
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
                                        <input class="form-control @error('page') is-invalid @enderror" id="page" type="text" name="page" placeholder="page" required value="{{ old('page') ?? $permits->page }}">
                                        
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
                                        <input class="form-control @error('datetime') is-invalid @enderror" id="datetime" type="text" name="datetime" placeholder="datetime" required value="{{ old('datetime') ?? $permits->datetime }}">
                                        
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
                                        <input class="form-control @error('status') is-invalid @enderror" id="status" type="text" name="status" placeholder="status" required value="{{ old('status') ?? $permits->status }}">
                                        
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Permission</label>
                                        <input type="checkbox" id="checkbox">
                                        <select name="permissions[]" id="e1" class="js-example-basic-multiple select2-department select2" id="e1" multiple="multiple" style="width:100%">
                                            @foreach ($permissions as $permission)
                                            {{-- {{ dd($rolePermissions) }} --}}
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
                            </div>
        
                            <div class="row">
                                <div class="col-lg-12">
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

