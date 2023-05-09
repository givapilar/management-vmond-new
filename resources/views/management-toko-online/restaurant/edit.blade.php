@extends('home')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('management-toko-online.index') }}">Toko Online</a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @include('components.flash-message')
                        </div>
                    </div>
                    <form class="forms-sample" method="POST" action="{{ route('restaurant.update', $restaurant->id) }}" enctype="multipart/form-data">
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
                                        <input class="form-control @error('harga') is-invalid @enderror" id="harga" type="text" name="harga" placeholder="Harga" required value="{{ old('harga') ?? $restaurant->harga }}">
                                        
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
                                            <option value="Tersedia" {{ $restaurant->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="Tidak Tersedia" {{ $restaurant->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
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
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js"integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg=="crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        new AutoNumeric('#harga', {
            currencySymbol: '',
            decimalCharacter: ',',
            digitGroupSeparator: '.',
        });

    </script>
@endsection
