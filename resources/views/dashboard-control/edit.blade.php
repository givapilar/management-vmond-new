<div class="modal modal-fullscreen text-start" id="edit-controller-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDIT CONTROLLER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="forms-sample" method="POST" action="{{ route('dashboard-control.update', $item->id) }}" novalidate>
                @method('patch')
                @csrf

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Meja Sports</label>
                        <select class="form-control @error('billiard_id_update') is-invalid @enderror" id="billiard_id_update" name="billiard_id_update" style="width:100%">
                            <option disabled selected>Choose Meja Sports</option>
                            @foreach ($billiards as $billiard)
                            <option value="{{ $billiard->id }}" class="gap-2"
                                {{ $item->billiard_id == $billiard->id ? 'selected' : '' }}>
                                {{ $billiard->nama }} </option>
                            @endforeach
                        </select>

                        @error('billiard_id_update')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <input type="number" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $item->address ?? old('address') }}" >

                        @error('address')
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

