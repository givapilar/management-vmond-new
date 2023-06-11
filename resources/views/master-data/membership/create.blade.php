<div class="modal modal-fullscreen" id="tambah-membership" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('membership.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @include('components.form-message')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label class="">Level</label>
                            <select class="form-control @error('level') is-invalid @enderror" name="level">
                                <option disabled selected>Choose Level</option>
                                <option value="Bronze">Bronze</option>
                                <option value="Silver">Silver</option>
                                <option value="Gold">Gold</option>
                                <option value="Platinum">Platinum</option>
                                <option value="Super Platinum">Super Platinum</option>
                            </select>
                            
                            @error('level')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="minimum_transaksi">Minimun Transaction</label>
                            <input type="text" class="form-control @error('minimum_transaksi') is-invalid @enderror" id="minimum_transaksi" name="minimum_transaksi" value="{{ old('minimum_transaksi') }}"  placeholder="Minimum Transaction">
                            
                            @error('minimum_transaksi')
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

  <script>
    // new AutoNumeric('#minimum_transaksi', {
    //     currencySymbol : '',
    //     decimalPlaces : 0,
    //     // digitGroupSeparator : '.',
    // });                   
   
</script>
               
