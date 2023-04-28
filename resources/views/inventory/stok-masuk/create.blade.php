{{-- <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Stok Masuk</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $page_title }}</h4>
                    <form class="forms-sample" action="{{ route('stok-masuk.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label>Material</label>
    
                            <select class="js-example-basic-single @error('material_id') is-invalid @enderror" id="material_id" name="material_id" style="width:100%">
                                <option disabled selected>Choose Material</option>
                                @foreach ($materials as $material)
                                <option value="{{ $material->id }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                    {{ $material->nama }} </option>
                                @endforeach
                            </select>
                            @error('material_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="material_masuk">Stok Masuk</label>
                            <input type="number" class="form-control @error('material_masuk') is-invalid @enderror" id="material_masuk" name="material_masuk" value="{{ old('material_masuk') }}"  placeholder="Stok Masuk">
    
                            @error('material_masuk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4"></textarea>

                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        
                        
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('stok-masuk.index') }}">
                            <button class="btn btn-dark">Cancel</button>
                        </a>
                    </form>
                </div>
            </div>
        </div>
        
        

    </div>
</div> --}}

<div class="modal modal-fullscreen" id="tambah-stok-masuk" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('stok-masuk.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label>Material</label>

                    <select class="js-example-basic-single @error('material_id') is-invalid @enderror" id="material_id" name="material_id" style="width:100%">
                        <option disabled selected>Choose Material</option>
                        @foreach ($materials as $material)
                        <option value="{{ $material->id }}"
                            {{ old('material_id') == $material->id ? 'selected' : '' }}>
                            {{ $material->nama }} </option>
                        @endforeach
                    </select>
                    @error('material_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="material_masuk">Stok Masuk</label>
                    <input type="number" class="form-control @error('material_masuk') is-invalid @enderror" id="material_masuk" name="material_masuk" value="{{ old('material_masuk') }}"  placeholder="Stok Masuk">

                    @error('material_masuk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="4"></textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                
                
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('stok-masuk.index') }}">
                    <button class="btn btn-dark">Cancel</button>
                </a>
            </form>
      </div>
    </div>
  </div>
               
