
@extends('home')

@section('content')
<div class="content-wrapper mb-5">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-20">
                <div class="card-header rounded-t-20">
                    <h3 class="text-center">{{ $page_title }}</h3>
                </div>
                <div class="card-body rounded-b-20">
                    <div class="row">
                        <div class="col-12">
                            @include('components.flash-message')
                        </div>
                    </div>
                    <form class="forms-sample" action="{{ route('paket-menu.update', $package->id) }}" enctype="multipart/form-data" method="POST">
                        @method('patch')
                        @csrf
                        @include('components.form-message')
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="nama_paket">Nama Paket</label>
                                    <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" id="nama_paket" name="nama_paket" value="{{ old('nama_paket') ?? $package->nama_paket }}"  placeholder="Enter nama paket...">

                                    @error('nama_paket')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="">Category</label>
                                    <select class="form-control @error('category') is-invalid @enderror" name="category" id="category" onchange="categorySelection(this.value)">
                                        <option value="billiard" {{ $package->category == 'billiard' ? 'selected' : '' }}>Billiard</option>
                                        <option value="meeting_room" {{ $package->category == 'meeting_room' ? 'selected' : '' }}>Meeting Room</option>
                                        <option value="event" {{ $package->category == 'event' ? 'selected' : '' }}>Event</option>
                                        <option value="paket_menu" {{ $package->category == 'paket_menu' ? 'selected' : '' }}>Paket Menu</option>
                                    </select>

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') ?? $package->harga }}" id="harga"  placeholder="Harga">

                                    @error('harga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="harga_diskon">Harga Diskon</label>
                                    <input type="text" class="form-control @error('harga_diskon') is-invalid @enderror" id="harga_diskon" name="harga_diskon" value="{{ old('harga_diskon') ?? $package->harga_diskon }}" id="harga_diskon"  placeholder="Harga Diskon">

                                    @error('harga_diskon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="persentase">Persentase <small>%</small></label>
                                    <input type="number" class="form-control @error('persentase') is-invalid @enderror" id="persentase" name="persentase" value="{{ old('persentase') ?? $package->persentase }}"  placeholder="Persentase">

                                    @error('persentase')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3" id="billiard">
                                    <label class="billiard_id">Meja Billiard</label>
                                    <select class="form-control @error('billiard_id') is-invalid @enderror" name="billiard_id">
                                        <option disabled selected>Choose Meja Billiard</option>
                                        @foreach($billiards as $key => $billiard)
                                        <option value="{{ $billiard->id }}" {{ $package->billiard_id == $billiard->id ? 'selected' : '' }}>{{ $billiard->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('billiard_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 d-none" id="meeting_room">
                                    <label class="meeting_room_id">Meeting Room</label>
                                    <select class="form-control @error('meeting_room_id') is-invalid @enderror" name="meeting_room_id">
                                        <option disabled selected>Choose Meeting Room</option>
                                        @foreach($meeting_rooms as $key => $meeting_room)
                                        <option value="{{ $meeting_room->id }}"  {{ $package->room_meeting_id == $meeting_room->id ? 'selected' : '' }}>{{ $meeting_room->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('meeting_room_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label class="">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                                <option disabled selected>Choose Status</option>
                                                <option value="Tersedia" {{ $package->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="Tidak Tersedia" {{ $package->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                            </select>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label class="">Status Menu</label>
                                            <select class="form-control @error('status_menu') is-invalid @enderror" name="status_menu">
                                                <option disabled selected>Choose Status Menu</option>
                                                <option value="Active" {{ $package->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Non Active" {{ $package->status == 'Non Active' ? 'selected' : '' }}>Non Active</option>
                                            </select>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between mb-2">
                                                <label>Menu Restaurant</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <small class="text-secondary">Select All</small>
                                                    <input type="checkbox" id="checkbox">
                                                </div>
                                            </div>

                                            <select name="restaurant_id[]" class="js-example-basic-multiple select2-department select2" id="e1" multiple ="multiple" style="width:100%">
                                                @foreach ($restaurants as $restaurant)
                                                    <option value="{{$restaurant->id}}"
                                                        @foreach (old('restaurant_id') ?? $menu_package_pivots as $id)
                                                            @if ($id == $restaurant->id)
                                                                {{ 'selected' }}
                                                            @endif
                                                        @endforeach>
                                                        {{$restaurant->nama}} |

                                                        @if ($restaurant->harga_diskon)
                                                            <span>{{ $restaurant->harga_diskon }}</span> | Discount
                                                        @else
                                                            <span>{{ $restaurant->harga }}</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('restaurant_id')
                                                <span class="text-danger text-sm">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <img src="{{ asset('assets/images/paket-menu/'.($package->image ?? 'user.png')) }}" width="110px"class="image img d-block mx-auto mb-3" />
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3" id="minimal">
                                    <label for="minimal">Minimal </label>
                                    <input type="number" class="form-control @error('minimal') is-invalid @enderror" id="minimal" name="minimal" value="{{ old('minimal') ?? $package->minimal }}"  placeholder="minimal">

                                    @error('minimal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-3" id="status_konfirmasi">
                                    <label class="">Status Konfirmasi</label>
                                    <select class="form-control @error('status_konfirmasi') is-invalid @enderror" name="status_konfirmasi">
                                        <option disabled selected>Choose Status Konfirmasi</option>
                                        <option value="Aktif" {{ $package->status_konfirmasi == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Inactive" {{ $package->status_konfirmasi == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @error('status_konfirmasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group mb-3" id="jam">
                                    <label for="jam">Masukan Jam </label>
                                    <input type="number" class="form-control @error('jam') is-invalid @enderror" name="jam" value="{{ old('jam') ?? $package->jam }}"  placeholder="jam">

                                    @error('jam')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="4">{{ $package->description }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('paket-menu.index') }}" class="btn btn-danger p-2">Close</a>
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
    
    // var selectedValue = $('#category').val();
    // const minimalField = document.getElementById('minimal');
    // const statusKonfirmasiField = document.getElementById('status_konfirmasi');
    // const jamField = document.getElementById('jam');
    // const billiard = document.getElementById('billiard');
    // const meetingRoom = document.getElementById('meeting_room');

    // if (selectedValue === 'billiard') {
    //     $('#billiard').removeClass('d-none');
    //     $('#meeting_room').addClass('d-none');
    // }else if(selectedValue === 'meeting_room') {
    //     $('#meeting_room').removeClass('d-none')
    //     $('#billiard').addClass('d-none')
    // }else if (selectedValue === 'paket_menu'){
    //     minimalField.style.display = 'none';
    //     statusKonfirmasiField.style.display = 'none';
    //     jamField.style.display = 'none';
    // }

    // function categorySelection(val) {
    //     if (val === 'billiard') {
    //         $('#billiard').removeClass('d-none');
    //         $('#meeting_room').addClass('d-none');
    //     }else if(val === 'meeting_room') {
    //         $('#meeting_room').removeClass('d-none')
    //         $('#billiard').addClass('d-none')
    //     }else if(val === 'paket_menu') {
    //         minimalField.style.display = 'none';
    //         statusKonfirmasiField.style.display = 'none';
    //         jamField.style.display = 'none';
    //         billiard.style.display = 'none';
    //         meetingRoom.style.display = 'none';
    //     }
    // }
</script>

<script>
   function categorySelection(selectedCategory) {
        var billiardField = document.getElementById('billiard');
        var jamField = document.getElementById('jam');
        var minimalField = document.getElementById('minimal');
        var statusKonfirmasiField = document.getElementById('status_konfirmasi');

        // Hide Billiard field by default
        billiardField.style.display = 'none';

        // Always show Jam, Minimal, and Status Konfirmasi fields
        jamField.style.display = 'block';
        minimalField.style.display = 'block';
        statusKonfirmasiField.style.display = 'block';

        if (selectedCategory === 'billiard') {
            billiardField.style.display = 'block';
        } else if (selectedCategory === 'meeting_room') {
            // Use jQuery to show the Meeting Room field
            $('#meeting_room').removeClass('d-none');
        } else if (selectedCategory === 'paket_menu') {
            // Hide all fields for "paket_menu"
            billiardField.style.display = 'none';
            $('#meeting_room').addClass('d-none');
            jamField.style.display = 'none';
            minimalField.style.display = 'none';
            statusKonfirmasiField.style.display = 'none';
        }
    }

    // Call categorySelection on page load to set the initial visibility based on the selected category
    categorySelection(document.getElementById('category').value);

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
</script>
@endsection
