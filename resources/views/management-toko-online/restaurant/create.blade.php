    <style>
        .current-stok{
            background-color: #2A3038 !important;
        }
        
    </style>
<div class="modal modal-fullscreen" id="tambah-menu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('restaurant.store') }}" enctype="multipart/form-data" method="POST">
                @csrf

                @include('components.form-message')

                <div class="row">

                    <div class="col-lg-3">

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

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label class="">Category</label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category">
                                <option disabled selected>Choose Category</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                            </select>
    
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="harga">Harga <small>%</small></label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}"  placeholder="harga">
                            
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="harga_diskon">Harga diskon <small>%</small></label>
                            <input type="number" class="form-control @error('harga_diskon') is-invalid @enderror" id="harga_diskon" name="harga_diskon" value="{{ old('harga_diskon') }}"  placeholder="harga_diskon">
                            
                            @error('harga_diskon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div> --}}

                    

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="stok_perhari">Stok Perhari</label>
                            <input type="number" class="form-control @error('stok_perhari') is-invalid @enderror" id="stok_perhari" name="stok_perhari" value="{{ old('stok_perhari') }}"  placeholder="Stok Perhari">
                            
                            @error('stok_perhari')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Tags</label>
                            <input type="checkbox" id="checkbox">
                            <select name="tag_id[]" class="js-example-basic-multiple select2-department select2" id="e1" multiple ="multiple" style="width:100%">
                                @foreach ($tags as $tag)
                                <option value="{{$tag->id}}"
                                    @foreach (old('tag_id') ?? [] as $id)
                                        @if ($id == $tag->id)
                                            {{ 'selected' }}
                                        @endif
                                    @endforeach>
                                    {{$tag->tag_name}}
                                </option>
                                @endforeach
                            </select>
    
                            @error('tag_id')
                                  <span class="text-danger text-sm">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" id="harga"  placeholder="Harga">
                            
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="harga_diskon">Harga Diskon</label>
                            <input type="text" class="form-control @error('harga_diskon') is-invalid @enderror" id="harga_diskon" name="harga_diskon" value="{{ old('harga_diskon') }}" id="harga_diskon"  placeholder="Harga_diskon">
                            
                            @error('harga_diskon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="persentase">Persentase <small>%</small></label>
                            <input type="number" class="form-control @error('persentase') is-invalid @enderror" id="persentase" name="persentase" value="{{ old('persentase') }}"  placeholder="Persentase">
                            
                            @error('persentase')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label class="">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option disabled selected>Choose Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
    
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="current_stok">Current Stok</label>
                            <input type="number" class="form-control current-stok @error('current_stok') is-invalid @enderror" id="current_stok" name="current_stok" value="0"  placeholder="Current Stok">
                            
                            @error('current_stok')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3">
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2 p-2">Submit</button>
                </div>
            </form>
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js" integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
                                                                                                                                                                                                                     
  <script>
    new AutoNumeric('#harga', {
        currencySymbol : '',
        decimalPlaces : 0,
        // digitGroupSeparator : '.',
    });                   
    new AutoNumeric('#harga_diskon', {
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

    $("#checkbox").click(function () {
       if ($("#checkbox").is(':checked')) {
           $("#e1 > option").prop("selected", "selected");
           $("#e1").trigger("change");
       } else {
           $("#e1 > option").removeAttr("selected");
           $("#e1").val("");
           $("#e1").trigger("change");
       }
   });
</script>

<script>
    $(document).ready(function() {
    var hargaInput = $('#harga');
    var persentaseInput = $('#persentase');
    var hargaDiskonInput = $('#harga_diskon');

    hargaInput.on('keyup', calculateDiscountedPrice);
    persentaseInput.on('keyup', calculateDiscountedPrice);

    hargaInput.on('keyup', calculatePersentase);
    hargaDiskonInput.on('keyup', calculatePersentase);

    function calculateDiscountedPrice() {
        var originalHarga = hargaInput.val();
        var hargaVal = originalHarga.replace(/,/g, "");

        // Harga Diskon
        var originalDiskon = hargaDiskonInput.val();
        var hargaDiskonVal = originalDiskon.replace(/,/g, "");

        var harga = parseFloat(hargaVal);
        var hargaDiskon = parseFloat(hargaDiskonInput.val());
        // var hargaDiskon = parseFloat(hargaDiskonVal);
        var persentase = parseFloat(persentaseInput.val());

        if (!isNaN(harga) && !isNaN(persentase)) {
            var diskon = (harga * persentase) / 100;
            var hargaDiskon = harga - diskon;

            hargaDiskonInput.val(hargaDiskon);
        }

    }
    function calculatePersentase() {
        var harga = parseFloat(hargaInput.val());
        var hargaDiskon = parseFloat(hargaDiskonInput.val());

        if (!isNaN(harga) && !isNaN(hargaDiskon) && harga > 0) {
            var persentase = ((harga - hargaDiskon) / harga) * 100;
            persentaseInput.val(persentase);
        } else {
            persentaseInput.val('');
        }
    }
});

    // $(document).ready(function() {
    //     // const hargaInput = $('#harga');
    //     var hargaInput = $('#harga');
    //     var originalHarga = hargaInput.val();
    //     var hargaVal = originalHarga.replace(/,00/g, "");
    //     var hargaNew = hargaVal.replace(/\./g, "");
    //     // console.log(hargaNew);
        
    //     var persentaseInput = $('#persentase');
    //     var originalPersentase = persentaseInput.val();
    //     var persentaseVal = originalPersentase.replace(/,00/g, "");
    //     var persentaseNew = persentaseVal.replace(/\./g, "");
        
    //     var hargaDiskonInput = $('#harga_diskon');
    //     var originalHargaDiskon = hargaDiskonInput.val();
    //     var hargaDiskonVal = originalHargaDiskon.replace(/,00/g, "");
    //     var hargaDiskonNew = hargaDiskonVal.replace(/\./g, "");

    //     // const persentaseInput = $('#persentase');
    //     // const hargaDiskonInput = $('#harga_diskon');

    //     hargaNew.on('keyup', calculateDiscountedPrice);
    //     persentaseNew.on('keyup', calculateDiscountedPrice);
        
    //     hargaNew.on('keyup', calculatePersentase);
    //     hargaDiskonNew.on('keyup', calculatePersentase);

    //     function calculateDiscountedPrice() {
    //         const harga = parseFloat(hargaNew.val());
    //         const hargaDiskon = parseFloat(hargaDiskonNew.val());
    //         const persentase = parseFloat(persentaseNew.val());

    //         if (!isNaN(harga) && !isNaN(persentase)) {
    //             const diskon = (harga * persentase) / 100;
    //             const hargaDiskon = harga - diskon;
    //             // const persentase = ((harga - hargaDiskon) / harga) * 100;

    //             hargaDiskonNew.val(hargaDiskon);
                
    //             // persentaseNew.value = persentase.toFixed(2);
    //         }
    //     }

    //     function calculatePersentase() {
    //         const harga = parseFloat(hargaNew.val());
    //         const hargaDiskon = parseFloat(hargaDiskonNew.val());

    //         if (!isNaN(harga) && !isNaN(hargaDiskon) && harga > 0) {
    //             const persentase = ((harga - hargaDiskon) / harga) * 100;
    //             persentaseNew.val(persentase);
    //         } else {
    //             persentaseNew.val('');
    //         }
    //     }
    // });
    // $(document).ready(function() {
    //     const hargaInput = $('#harga');
    //     const hargaDiskonInput = $('#harga_diskon');
    //     const persentaseInput = $('#persentase');

    //     hargaInput.on('keyup', calculatePersentase);
    //     hargaDiskonInput.on('keyup', calculatePersentase);

    //     function calculatePersentase() {
    //         const harga = parseFloat(hargaInput.val());
    //         const hargaDiskon = parseFloat(hargaDiskonInput.val());

    //         if (!isNaN(harga) && !isNaN(hargaDiskon) && harga > 0) {
    //             const persentase = ((harga - hargaDiskon) / harga) * 100;
    //             persentaseInput.val(persentase);
    //         } else {
    //             persentaseInput.val('');
    //         }
    //     }
    // });
</script>
               
