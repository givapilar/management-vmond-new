@extends('home')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master data</a></li>
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
                    <form class="forms-sample" method="POST" action="{{ route('asset-management.update', $asset_managements->id) }}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        @include('components.form-message')

                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="nama">Nama</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="nama" placeholder="Nama" required value="{{ old('nama') ?? $asset_managements->nama }}">
                                        
                                        @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="quantity">Quantity</label>
                                        <input class="form-control @error('quantity') is-invalid @enderror" id="name" type="number" name="quantity" placeholder="quantity" required value="{{ old('quantity') ?? $asset_managements->quantity }}">
                                        
                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        {{-- <textarea name="description" class="form-control" id="description" rows="4">{{ $asset_managements->description }}</textarea> --}}
                                        <textarea name="description" id="mytextarea">{!! $asset_managements->description !!}</textarea>
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
                            <a href="{{ route('asset-management.index') }}" class="btn btn-secondary btn-footer">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
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
@endsection
