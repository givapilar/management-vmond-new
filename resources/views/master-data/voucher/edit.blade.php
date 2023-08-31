<div class="modal modal-fullscreen" id="edit-voucher{{ $voucher->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="forms-sample" method="POST" action="{{ route('voucher.update', $voucher->id) }}" enctype="multipart/form-data">
              @method('patch')
              @csrf
              @include('components.form-message')

              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                      <label for="code">Code</label>
                      <input class="form-control @error('code') is-invalid @enderror" id="code" type="text" name="code" placeholder="code" required value="{{ old('code') ?? $voucher->code }}">
                      
                      @error('code')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                      <label for="discount">Discount</label>
                      <input class="form-control @error('discount') is-invalid @enderror" id="discount" type="number" name="discount" placeholder="discount" required value="{{ old('discount') ?? $voucher->discount }}">
                      
                      @error('discount')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                      <label for="harga">Harga Discount</label>
                      <input class="form-control @error('harga') is-invalid @enderror" id="harga" type="number" name="harga" placeholder="harga" required value="{{ old('harga') ?? $voucher->harga }}">
                      
                      @error('harga')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                    <label for="minimum_transaksi">Minimum Transaksi</label>
                    <input class="form-control @error('minimum_transaksi') is-invalid @enderror" id="minimum_transaksi" type="number" name="minimum_transaksi" placeholder="minimum_transaksi" required value="{{ old('minimum_transaksi') ?? $voucher->minimum_transaksi }}">
                    
                    @error('minimum_transaksi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                </div>

                  {{-- <div class="col-12 col-lg-6">
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" name="status">
                            <option disabled selected>Choose Status</option>
                            <option value="active" {{ ($voucher->status == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ ($voucher->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div> --}}
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


