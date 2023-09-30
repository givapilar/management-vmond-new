@extends('home')

@section('content')
<style>
    .current-stok:disabled{
        background-color: #2A3038 !important;
    }
</style>
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

                                <div class="col-lg-3">
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
                                
                                <div class="col-lg-3">
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

                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <label class="">Sub Category</label>
                                        <select class="form-control @error('sub_category') is-invalid @enderror" name="sub_category">
                                            <option value="">Select Sub Category</option>
                                            <option value="Hot" {{ $restaurant->sub_category == 'Hot' ? 'selected' : '' }}>Hot</option>
                                            <option value="Cold" {{ $restaurant->sub_category == 'Cold' ? 'selected' : '' }}>Cold</option>
                                        </select>
                                        
                                        @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <label for="stok_perhari">Stok Perhari</label>
                                        <input class="form-control @error('stok_perhari') is-invalid @enderror" id="name" type="number" name="stok_perhari" placeholder="stok_perhari" required value="{{ old('stok_perhari') ?? $restaurant->stok_perhari }}">
                                        
                                        @error('stok_perhari')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Tag</label>
                                        <input type="checkbox" id="checkbox">
                                        <select name="tag_id[]" id="e1" class="js-example-basic-multiple select2-department select2" id="e1" multiple="multiple" style="width:100%">
                                            @foreach ($tags as $tag)
                                                <option value="{{$tag->id}}" 
                                                    @foreach (old('tag_id') ?? $restaurant_tags as $id)
                                                        @if ($id == $tag->id)
                                                            {{ 'selected' }}
                                                        @endif
                                                    @endforeach>
                                                    {{$tag->tag_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <label for="harga">Harga</label>
                                        <input class="form-control @error('harga') is-invalid @enderror" id="harga" type="number" name="harga" placeholder="Harga" required value="{{ old('harga') ?? $restaurant->harga }}">
                                        
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
                                        <input class="form-control @error('harga_diskon') is-invalid @enderror" id="harga_diskon" type="number" name="harga_diskon" placeholder="harga_diskon" required value="{{ old('harga_diskon') ?? $restaurant->harga_diskon }}">
                                        
                                        @error('harga_diskon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <label for="persentase">Persentase <small>(%)</small></label>
                                        <input class="form-control @error('persentase') is-invalid @enderror" id="persentase" type="number" name="persentase" placeholder="persentase" required value="{{ old('persentase') ?? $restaurant->persentase }}">
                                        
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

                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <label for="current_stok">Current Stok</label>
                                        <input readonly class="form-control current-stok @error('current_stok') is-invalid @enderror" id="name" type="number" name="current_stok" placeholder="current_stok" value="{{ old('current_stok') ?? $restaurant->current_stok }}">
                                        
                                        @error('current_stok')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3">
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

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Add On</label>
                                        <input type="checkbox" id="checkbox_add_on">
                                        <select name="add_on_id[]" id="add_on" class="js-example-basic-multiple select2-department select2" multiple="multiple" style="width:100%">
                                            @foreach ($add_ons as $add_on)
                                                <option value="{{$add_on->id}}" 
                                                    @foreach (old('add_on_id') ?? $restaurant_add_on as $id)
                                                        @if ($id == $add_on->id)
                                                            {{ 'selected' }}
                                                        @endif
                                                    @endforeach>
                                                    {{$add_on->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group mb-3">
                                        <label for="lama_waktu">Lama Waktu <small>(Menit)</small> </label>
                                        <input class="form-control @error('lama_waktu') is-invalid @enderror" min="0" id="name" type="number" name="lama_waktu" placeholder="Lama Waktu" required value="{{ old('lama_waktu') ?? $restaurant->lama_waktu }}">
                                        
                                        @error('lama_waktu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                                
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" rows="4">{{ $restaurant->description }}</textarea>
                                        {{-- <textarea name="description" id="mytextarea">{!! $restaurant->description !!}</textarea> --}}
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
                            <a href="{{ route('restaurant.index') }}" class="btn btn-danger p-2">
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
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js"integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg=="crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
{{-- <script>
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
</script> --}}

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

   $("#checkbox_add_on").click(function () {
       if ($("#checkbox_add_on").is(':checked')) {
           $("#add_on > option").prop("selected", "selected");
           $("#add_on").trigger("change");
       } else {
           $("#add_on > option").removeAttr("selected");
           $("#add_on").val("");
           $("#add_on").trigger("change");
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
            persentase = Math.round(persentase); // Round to the nearest whole number
            persentaseInput.val(persentase);
        } else {
            persentaseInput.val('');
        }
    }

});
</script>
@endsection
