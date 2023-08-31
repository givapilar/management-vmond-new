<div class="modal modal-fullscreen" id="tambah-voucher" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('voucher.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @include('components.form-message')
                <div class="row">
                  <div class="col-12 col-lg-4">
                      <div class="form-group mb-3">
                          <label for="code">Code</label>
                          <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}"  placeholder="Code">
                          
                          @error('code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class="form-group mb-3">
                          <label for="">Discount <small>(%)</small> </label>
                          <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}"  placeholder="discount">
                          
                          @error('discount')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                        <label for="">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}"  placeholder="harga">
                        
                        @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                        <label for="">Minimun Transaksi</label>
                        <input type="number" class="form-control @error('minimum_transaksi') is-invalid @enderror" id="minimum_transaksi" name="minimum_transaksi" value="{{ old('minimum_transaksi') }}"  placeholder="minimum_transaksi">
                        
                        @error('minimum_transaksi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  {{-- hp --}}
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
               
