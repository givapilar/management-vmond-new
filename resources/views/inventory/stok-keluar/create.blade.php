<div class="modal modal-fullscreen" id="tambah-stok-keluar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH {{ strtoupper($page_title) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="forms-sample" action="{{ route('stok-keluar.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Material</label>

                        <select class="js-example-basic-single @error('material_id') is-invalid @enderror" id="material_id" name="material_id" style="width:100%">
                            <option disabled selected>Choose Material</option>
                            @foreach ($materials as $material)
                            <option value="{{ $material->id }}"
                                {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                {{ $material->nama }} </option>
                            @endforeach
                        </select>
                        @error('material_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="material_keluar">Stok Keluar</label>
                        <input type="number" class="form-control @error('material_keluar') is-invalid @enderror" id="material_keluar" name="material_keluar" value="{{ old('material_keluar') }}"  placeholder="Stok Keluar">

                        @error('material_keluar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4"></textarea>

                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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

