<div class="modal modal-fullscreen" id="modal-fullscreen-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('bahan-baku.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="code">Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}"  placeholder="Enter Code">

                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="nama" value="{{ old('name') }}"  placeholder="Enter name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="unit">Unit</label>
                    <input type="unit" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit') }}"  placeholder="Enter Unit">
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
                        <textarea name="description" id="mytextarea"></textarea>
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                {{-- <a href="{{ route('material.index') }}">
                    <button class="btn btn-dark">Cancel</button>
                </a> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
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
