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
                   
                    <form method="POST" action="{{ route('departement.update', $departement->id) }}" novalidate>
                        @method('patch')
                        @csrf

                        <div class="card-body">
                            
                            {{-- @include('backend.components.form-message') --}}

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') ?? $departement->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Permission</label>
                                <input type="checkbox" id="checkbox">
                                <select name="permissions[]" id="e1" class="js-example-basic-multiple select2-department select2" id="e1" multiple="multiple" style="width:100%">
                                    @foreach ($permissions as $permission)
                                        <option value="{{$permission->id}}" 
                                            @foreach (old('permissions') ?? $rolePermissions as $id)
                                                @if ($id == $permission->id)
                                                    {{ ' selected' }}
                                                @endif
                                            @endforeach>
                                            {{$permission->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                @error('permissions')
                                    <span class="text-danger f-12">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                {{-- <div class="form-group">
                                    <label>Permission</label>
                                    <input type="checkbox" id="checkbox">
                                    <select name="permissions[]" class="js-example-basic-multiple select2-department select2" id="e1" multiple ="multiple" style="width:100%">
                                        @foreach ($permissions as $permission)
                                        <option value="{{$permission->id}}" 
                                            @foreach (old('permissions') ?? [] as $id)
                                                @if ($id == $permission->id)
                                                    {{ 'selected' }}
                                                @endif
                                            @endforeach>
                                            {{$permission->name}}
                                        </option>
                                        @endforeach
                                    </select>
            
                                    @error('permissions')
                                          <span class="text-danger text-sm">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                </div> --}}
                        </div>

                        <div class="card-footer bg-gray1" style="border-radius:0px 0px 15px 15px;">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{ route('departement.index') }}" class="btn btn-danger">Cancel</a>
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

