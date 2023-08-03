<div class="modal modal-fullscreen" id="tambah-tag" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('tag.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @include('components.form-message')
                <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group mb-3">
                          <label for="tag_name">Tag Name</label>
                          <input type="text" class="form-control @error('tag_name') is-invalid @enderror" id="tag_name" name="tag_name" value="{{ old('tag_name') }}"  placeholder="Tag Name">
                          
                          @error('tag_name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                  </div>
                  <div class="col-12 col-lg-6">
                      <div class="form-group mb-3">
                          <label for="position">Position</label>
                          <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}"  placeholder="Position">
                          
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
                            <option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ (old('status') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary mr-2 p-2">Submit</button>
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
               
