<div class="modal modal-fullscreen" id="edit-membership{{ $membership->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="forms-sample" method="POST" action="{{ route('membership.update', $membership->id) }}" enctype="multipart/form-data">
              @method('patch')
              @csrf
              @include('components.form-message')

              <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label class="">Level</label>
                            <select class="form-control @error('level') is-invalid @enderror" name="level">
                                <option value="">Select Level</option>
                                <option value="Bronze" {{ $membership->level == 'Bronze' ? 'selected' : '' }}>Bronze</option>
                                <option value="Silver" {{ $membership->level == 'Silver' ? 'selected' : '' }}>Silver</option>
                                <option value="Gold" {{ $membership->level == 'Gold' ? 'selected' : '' }}>Gold</option>
                                <option value="Platinum" {{ $membership->level == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                <option value="Super Platinum" {{ $membership->level == 'Super Platinum' ? 'selected' : '' }}>Super Platinum</option>
                            </select>
                            
                            @error('level')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                      {{-- <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="minimum_transaksi">Minimun Transaction</label>
                            <input class="form-control @error('minimum_transaksi') is-invalid @enderror" id="harga" type="text" name="minimum_transaksi" placeholder="minimum_transaksi" required value="{{ old('minimum_transaksi') ?? $membership->minimum_transaksi }}">
                            
                            @error('minimum_transaksi')
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js"integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg=="crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
  <script>
    // new AutoNumeric('#harga', {
    //     currencySymbol : '',
    //     decimalPlaces : 0,
    //     // digitGroupSeparator : '.',
    // });                   
   
</script>


