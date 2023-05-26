<div class="modal modal-fullscreen" id="edit-stok-masuk{{ $stok_masuk->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDIT {{ strtoupper($page_title) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" method="POST" action="{{ route('stok-masuk.update', $stok_masuk->id) }}" novalidate>
                @method('patch')
                @csrf
                <div class="modal-body">
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
                        <input class="form-control @error('material_masuk') is-invalid @enderror" id="name" type="text" name="material_masuk" placeholder="Stok MAsuk" required value="{{ old('material_masuk') ?? $stok_masuk->material_masuk }}">

                        @error('material_masuk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4">{{ $stok_masuk->description }}</textarea>

                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2 p-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

  {{-- <script>
    (function($) {
  'use strict';
  if ($("#js-example-basic-single-material").length) {
    $("#js-example-basic-single-material").select2();
  }
  
});
  </script> --}}

