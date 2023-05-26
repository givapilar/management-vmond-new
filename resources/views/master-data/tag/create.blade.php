<div class="modal modal-fullscreen" id="tambah-menu-tag" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <input type="text" class="form-control @error('tag_name') is-invalid @enderror" id="tag_name" name="tag_name" value="{{ old('tag_name') }}"  placeholder="tag_name">
                            
                            @error('tag_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('tag.index') }}">
                    <button class="btn btn-dark">Cancel</button>
                </a>
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
               
