<div class="modal modal-fullscreen" id="edit-suppluer{{ $meja_restaurant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('meja-restaurant.update', $meja_restaurant->id) }}" novalidate>
                @method('patch')
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">

                            <div class="form-group mb-3">
                                <label for="nama">Nama Meja</label>
                                <input class="form-control @error('nama') is-invalid @enderror" id="nama" type="text" name="nama" placeholder="nama" required value="{{ old('nama') ?? $meja_restaurant->nama }}">

                                @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Category</label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Indoor" {{ $meja_restaurant->category == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                    <option value="Outdoor" {{ $meja_restaurant->category == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                                </select>

                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option value="">Select Status</option>
                                    <option value="Tersedia" {{ $meja_restaurant->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Tidak Tersedia" {{ $meja_restaurant->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>

                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4">{{ $meja_restaurant->description }}</textarea>
                            {{-- <textarea name="description" id="mytextarea">{!! $meja_restaurant->description !!}</textarea> --}}
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
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
<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>

    tinymce.init({
        selector: '#mytextarea',
        skin: "oxide-dark",
        content_css: "dark"
    });
</script>

