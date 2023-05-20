<div class="modal modal-fullscreen" id="modal-fullscreen-xl-edit{{ $material->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('material.update', $material->id) }}" novalidate>
                @method('patch')
                @csrf

                <div class="card-body">
                    
                    <div class="form-group mb-3">
                        <label for="code">Code</label>
                        <input class="form-control @error('code') is-invalid @enderror" id="code" type="text" name="code" placeholder="Code" required value="{{ old('code') ?? $material->code }}">

                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama">Name</label>
                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $material->nama }}">

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="unit">Unit</label>
                        <input class="form-control @error('unit') is-invalid @enderror" id="unit" type="text" name="unit" placeholder="unit" required value="{{ old('unit') ?? $material->unit }}">

                        @error('unit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            {{-- <textarea name="description" class="form-control" id="description" rows="4">{{ $restaurant->description }}</textarea> --}}
                            <textarea name="description" id="mytextarea">{!! $material->description !!}</textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </div>
            </form>
      </div>
    </div>
  </div>
<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>

    tinymce.init({
        selector: '#mytextarea',
        skin: "oxide-dark",
        content_css: "dark"
    });
</script>

