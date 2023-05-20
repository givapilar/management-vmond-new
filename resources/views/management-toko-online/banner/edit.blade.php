<div class="modal modal-fullscreen" id="edit-banner{{ $banner->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ ($page_title) }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('banner.update', $banner->id) }}">
                @method('patch')
                @csrf

                @include('components.form-message')

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary"
                                        type="button">Upload</button>
                                    </span>
                                </div>
                                <div class="small text-danger">*Kosongkan jika tidak mau diisi</div> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <img src="{{ asset('assets/images/banner/'.($banner->image ?? 'user.png')) }}" width="110px"class="image img" />
                        </div>
                    </div>

                        
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                {{-- <textarea name="description" class="form-control" id="description" rows="4">{{ $restaurant->description }}</textarea> --}}
                                <textarea name="description" id="mytextarea">{!! $banner->description !!}</textarea>
                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="{{ route('banner.index') }}" class="btn btn-secondary btn-footer">Kembali</a>
                </div>
            </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    new AutoNumeric('#harga_edit', {
        currencySymbol : '',
        decimalCharacter : ',',
        digitGroupSeparator : '.',
    });

    tinymce.init({
        selector: '#mytextarea',
        skin: "oxide-dark",
        content_css: "dark"
    });
</script>

  
