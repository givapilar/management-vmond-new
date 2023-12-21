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
                    <form class="forms-sample" method="POST" action="{{ route('add-on.update', $add_ons->id) }}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        @include('components.form-message')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="title">Title</label>
                                        <input class="form-control @error('title') is-invalid @enderror" id="name" type="text" name="title" placeholder="title" required value="{{ old('title') ?? $add_ons->title }}">
                                        
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="minimum_choice">Minimum Choice</label>
                                        <input class="form-control @error('minimum_choice') is-invalid @enderror" id="name" type="text" name="minimum_choice" placeholder="minimum_choice" required value="{{ old('minimum_choice') ?? $add_ons->minimum_choice }}">
                                        
                                        @error('minimum_choice')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <h4>Add On Detail <small class="text-danger">*</small></h4>
                            <hr>
                            <button type="button" class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                <i class="fas fa-plus-square"></i>
                            </button>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <table class="table table-striped" id="contactTable">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($add_ons->detailAddOn as $key => $item)
                                            {{-- {{ dd($item) }} --}}
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama[]" value="{{ $item->nama }}"  placeholder="nama">
                                                    
                                                    @error('nama')
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
                                                    <button type="button" class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus"></i></button>

                                                <td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('add-on.index') }}" class="btn btn-danger p-2">
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
    
  
</script>

<script>
   
    function addField() {
        var rowCount = $('#contactTable tr').length;
        $("#contactTable").find('tbody')
            .append(
                $('<tr>' +
                    '<td><input class="form-control" placeholder="Input Location" type="text" name="nama[]" id="location" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Harga" type="text" name="harga[]" id="harga" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td style="max-width: 6% !important"><button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();changeOptionValue();"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>'
                )
            )
    new AutoNumeric('#harga' + rowCount, {
        currencySymbol : '',
        decimalPlaces : 0,
        // digitGroupSeparator : '.',
    }); 
    }
  
  
  </script>
@endsection
