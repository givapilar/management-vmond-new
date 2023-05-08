<div class="modal modal-fullscreen" id="edit-restaurant{{ $restaurant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ ($page_title) }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" method="POST" action="{{ route('restaurant.update', $restaurant->id) }}" novalidate>
                @method('patch')
                @csrf

                @include('components.form-message')

                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="Nama" required value="{{ old('nama') ?? $restaurant->nama }}">
                                
                                @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Category</label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Makanan" {{ $restaurant->category == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="Minuman" {{ $restaurant->category == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                </select>
                                
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="harga">Harga</label>
                                <input class="form-control @error('harga') is-invalid @enderror" id="name" type="text" name="harga" placeholder="Harga" required value="{{ old('harga') ?? $restaurant->harga }}">
                                
                                @error('harga')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label class="">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option disabled selected>Choose Status</option>
                                    <option value="">Select Category</option>
                                    <option value="Tersedia" {{ $restaurant->category == 'Tersedia' ? 'selected' : '' }}>Makanan</option>
                                    <option value="Tidak Tersedia" {{ $restaurant->category == 'Tidak Tersedia' ? 'selected' : '' }}>Minuman</option>
                                </select>
                                
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                </div>
                                <div class="small text-danger">*Kosongkan jika tidak mau diisi</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <img src="{{ asset('assets/images/restaurant/'.($restaurant->image ?? 'user.png')) }}" width="110px"class="image img" />
                        </div>
                    </div>

                        
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4">{{ $restaurant->description }}</textarea>
                                
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
                    <a href="{{ route('restaurant.index') }}" class="btn btn-secondary btn-footer">Kembali</a>
                </div>
            </form>
      </div>
    </div>
  </div>

  
