<div class="modal modal-fullscreen" id="edit-tag{{ $tag->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="forms-sample" method="POST" action="{{ route('tag.update', $tag->id) }}" enctype="multipart/form-data">
              @method('patch')
              @csrf
              @include('components.form-message')

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group mb-3">
                      <label for="nama">Nama</label>
                      <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="tag_name" placeholder="Tag Name" required value="{{ old('nama') ?? $tag->tag_name }}">
                      
                      @error('nama')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="form-group mb-3">
                      <label for="position">Position</label>
                      <input class="form-control @error('position') is-invalid @enderror" id="position" type="text" name="position" placeholder="Position" required value="{{ old('position') ?? $tag->position }}">
                      
                      @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" name="status">
                            <option disabled selected>Choose Status</option>
                            <option value="active" {{ ($tag->status == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ ($tag->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
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
  </div>


