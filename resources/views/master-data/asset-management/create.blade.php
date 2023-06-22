d<div class="modal modal-fullscreen" id="tambah-asset" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('asset-management.store') }}" enctype="multipart/form-data" method="POST">
                @csrf

                @include('components.form-message')

                <div class="row">

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}"  placeholder="Nama">
                            
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                            {{-- <textarea name="description" id="mytextarea"></textarea> --}}
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}"  placeholder="quantity">
                            
                            @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}"  placeholder="harga">
                            
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            <div class="small text-danger">*Kosongkan jika tidak mau diisi</div>
                        </div>
                    </div> --}}

                </div>

                <div class="card-body">
                    <h4>Asset Detail <small class="text-danger">*</small></h4>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contactTable">
                                    <thead>
                                        <tr>
                                            <th>Location</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Image</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location[]" value="{{ old('location') }}"  placeholder="Location">
                                                
                                                @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                            
                                            <td>
                                                <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty[]" value="{{ old('qty') }}"  placeholder="qty">
                                                
                                                @error('qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>

                                            <td>
                                                <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga[]" value="{{ old('harga') }}"  placeholder="harga">
                                                
                                                @error('harga')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>

                                            <td>
                                                <div class="form-group mt-3">
                                                    <input type="file" name="image" class="file-upload-default">
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                                        <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                            <td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                    '<td><input class="form-control" placeholder="Input Location" type="text" name="location[]" id="location'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Qty" type="text" name="qty[]" id="qty'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input Harga" type="text" name="harga[]" id="harga'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><input class="form-control" placeholder="Input File" type="file" name="image[]" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    // '<td><div class="form-group mt-3"><input type="file" name="image[]" class="file-upload-default" '+rowCount+'" onkeyup="calculatePrice('+rowCount+')"><div class="input-group col-xs-12"><input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image"><span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button">Upload</button></span></div></div></td>' +
                    // '<td><div><input type="file" name="image[]" id="harga" class="file-upload-default"><div class="input-group col-xs-12"><input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image"><span class="input-group-append"><button class="file-upload-browse btn btn-primary"  type="button">Upload</button></span></div></div></td>' +
                    // '<td><div><input type="file" name="image" class="file-upload-default"><div class="input-group col-xs-12"><input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image"><span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button">Upload</button></span></div></div> "'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td style="max-width: 6% !important"><button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();changeOptionValue();"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>'
                )
            )
            changeOptionValue();
    }
  
  </script>
  
               
