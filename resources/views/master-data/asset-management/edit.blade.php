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

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control" id="description" rows="4">{{ $asset_managements->description }}</textarea>
                                            {{-- <textarea name="description" id="mytextarea">{!! $asset_managements->description !!}</textarea> --}}
                                            @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h4>Asset Detail <small class="text-danger">*</small></h4>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <table class="table table-striped" id="contactTable">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Image</th>
                                                <th></th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <button type="button" class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                                <i class="fas fa-plus-square"></i>
                                            </button>
                                            @foreach ($asset_managements->detailAsset as $item)
                                                
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location[]" value="{{ $item->location }}"  placeholder="Location">
                                                    
                                                    @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </td>
                                                
                                                <td>
                                                    <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty[]" value="{{ $item->qty }}"  placeholder="qty">
                                                    
                                                    @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </td>
    
                                                <td>
                                                    <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga[]" value="{{ $item->harga }}"  placeholder="harga">
                                                    
                                                    @error('harga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </td>
    
                                                <td>
                                                    <div class="form-group mt-3">
                                                        <input type="file" name="image[]" class="file-upload-default">
                                                        <div class="input-group col-xs-12">
                                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                                            <span class="input-group-append">
                                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <img src="{{ asset('assets/images/asset-management/'.($item->image ?? 'user.png')) }}" width="110px" class="image img" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                <td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('asset-management.index') }}" class="btn btn-danger p-2">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary mr-2 p-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js" integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    new AutoNumeric('#harga', {
        currencySymbol : '',
        decimalPlaces : 0,
        // digitGroupSeparator : '.',
    });                   
    
    tinymce.init({
        selector: '#mytextarea',
        skin: "oxide-dark",
        content_css: "dark"
    });
</script>

<script>
   
    function addField() {
        var rowCount = $('#contactTable tr').length;
        $("#contactTable").find('tbody')
            .append(
                $('<tr>' +
                    '<td><input class="form-control" placeholder="Input Location" type="text" name="location[]" id="location" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Qty" type="text" name="qty[]" id="qty" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Harga" type="text" name="harga[]" id="harga" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input File" type="file" name="image[]" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td></td>' +
                    // '<td><div class="form-group mt-3"><input type="file" name="image" class="file-upload-default" ><div '+rowCount+'" onkeyup="calculatePrice('+rowCount+')" class="input-group col-xs-12"><input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image"><span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button">Upload</button></span></div></div></td>' +
                    '<td style="max-width: 6% !important"><button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();changeOptionValue();"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>'
                )
            )
            changeOptionValue();
    }
  
    function save()
    {
        val12.forEach(item => {
            $(".select_part option[value='"+item+"']").removeAttr('disabled');
        });
  
        $('#formPO').submit();
    }
  
  </script>
@endsection
