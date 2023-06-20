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
                    <form class="forms-sample" method="POST" action="{{ route('supplier.update', $supplier->id) }}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        @include('components.form-message')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="nama">Nama</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="name" type="text" name="name" placeholder="Nama" required value="{{ old('nama') ?? $supplier->name }}">
                                        
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
                                            <textarea name="description" class="form-control" id="description" rows="4">{{ $supplier->description }}</textarea>
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

                        <div class="">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h3>Detail Supplier <span class="text-danger">*</span></h3>
                                <button class="btn btn-sm btn-success text-white p-2" onclick="addField()" type="button">Edit Detail Supplier</button>
                            </div>
                            {{-- <hr class="m-0 p-0" style="border-top:1px solid #fff !important;"> --}}
                        </div>
    
                        <div class="mb-3">
                            <table id="contactTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="th-sm text-white text-center">Name</th>
                                        <th class="th-sm text-white text-center">Telephone</th>
                                        <th class="th-sm text-white text-center">Email</th>
                                        <th class="th-sm text-white text-center">Address</th>
                                        <th class="th-sm text-white text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="add-detail-supplier">
                                    @foreach ($supplier->detailSupplier as $key => $item)
                                        
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control @error('name_detail') is-invalid @enderror" id="name_detail" name="name_detail[]" value="{{ $item->name }}"  placeholder="Input Name supplier...">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone[]" value="{{ $item->telephone }}"  placeholder="Input telephone supplier...">
                                        </td>
                                        <td>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email[]" value="{{ $item->email }}"  placeholder="Input email supplier...">
                                        </td>
                                        <td> <textarea name="address[]" placeholder="Address" class="form-control" id="address" rows="3">{{ $item->address }}</textarea></td>
                                        
                                        <td>
                                            @if ($key == 0)
                                            <button type="button" disabled class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                                <i class="fas fa-plus-square"></i>
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus"></i></button>
                                            @endif
                                        <td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('supplier.index') }}" class="btn btn-danger p-2">
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
                    '<td><input class="form-control" placeholder="Input Name Supplier" type="text" name="name_detail[]" id="name_detail'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Telephone" type="number" name="telephone[]" id="telephone'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Email" type="email" name="email[]" id="email'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><textarea name="address[]"  placeholder="Address" class="form-control" id="description" rows="3" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></textarea></td>' +
                    '<td style="max-width: 6% !important"><button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();changeOptionValue();"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>'
                )
            )
            changeOptionValue();
    }
</script>
@endsection
