{{-- <div class="content-wrapper">
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
                    <h4 class="card-title">{{ $page_title }}</h4>
                    <form method="POST" action="{{ route('departement.store') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') }}">
        
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
        
                            
                            <div class="form-group">
                                <label>Permission</label>
                                <select name="permissions[]" id="e1" class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                                    @foreach ($permissions as $permission)
                                    <option value="{{$permission->id}}" 
                                        @foreach (old('permissions') ?? [] as $id)
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
                                    <span class="text-danger text-sm">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        
                        <div class="card-footer bg-gray1" style="border-radius:0px 0px 15px 15px;">
                            <button type="submit" class="btn btn-success btn-footer">Add</button>
                            <a href="{{ route('departement.index') }}" class="btn btn-danger btn-footer">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
 --}}

 <div class="modal modal-fullscreen" id="tambah-departement" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('departement.store') }}" novalidate>
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="name" required value="{{ old('name') }}">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- <div class="form-group mb-3">
                        <label for="">Permissions</label> <br>
                        <small>Select All</small>
                        <input type="checkbox" id="checkbox">

                        <div class="select2-purple">
                            <select class="select2" name="permissions[]" id="e1" data-placeholder="Select The Permissions" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                                @foreach ($permissions as $permission)
                                    <option value="{{$permission->id}}" 
                                        @foreach (old('permissions') ?? [] as $id)
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
                            <span class="text-danger text-sm">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    
                    {{-- <div class="form-group">
                        <label>Permission</label>
                        <input type="checkbox" id="checkbox" >Select All
                        <select name="permissions[]" id="e1" class="js-example-basic-multiple" multiple id="e1" style="width:100%">
                            @foreach ($permissions as $permission)
                            <option value="{{$permission->id}}" 
                                @foreach (old('permissions') ?? [] as $id)
                                    @if ($id == $permission->id)
                                        {{ ' selected' }}
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
                    
                    {{-- <select class="form-control" multiple id="e1" style="width:300px">
                        <option value="AL">Alabama</option>
                        <option value="Am">Amalapuram</option>
                        <option value="An">Anakapalli</option>
                        <option value="Ak">Akkayapalem</option>
                        <option value="WY">Wyoming</option>
                    </select>
                    <input type="checkbox" id="checkbox" >Select All --}}

                </div>
                
                <div class="card-footer bg-gray1" style="border-radius:0px 0px 15px 15px;">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-dark">Cancel</button>
                </div>
            </form>
      </div>
    </div>
  </div>

  <script>
    $("#e1").select2();
        $("#checkbox").click(function(){
            if($("#checkbox").is(':checked') ){
                $("#e1 > option").prop("selected","selected");
                $("#e1").trigger("change");
            }else{
                $("#e1 > option").removeAttr("selected");
                $("#e1").trigger("change");
            }
        });

        $("#button").click(function(){
            alert($("#e1").val());
        });

  </script>