d<div class="modal modal-fullscreen" id="tambah-add-on-billiard" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $page_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="forms-sample" action="{{ route('add-on-billiard.store') }}" enctype="multipart/form-data" method="POST">
                @csrf

                @include('components.form-message')

                <div class="row">

                    <div class="col-l-6">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}"  placeholder="title">
                            
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-l-6">
                        <div class="form-group mb-3">
                            <label for="minimum_choice">Minimum Choice</label>
                            <input type="number" class="form-control @error('minimum_choice') is-invalid @enderror" id="minimum_choice" name="minimum_choice" value="{{ old('minimum_choice') }}"  placeholder="minimum_choice">
                            
                            @error('minimum_choice')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                </div>

                <div class="card-body">
                    <h4>Add On Detail <small class="text-danger">*</small></h4>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contactTable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="js-example-basic-single @error('restaurant_id') is-invalid @enderror"
                                                    id="restaurant" name="restaurant_id[]" style="width:100%">
                                                    <option disabled selected>Choose Material</option>
                                                    @foreach ($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}"
                                                        {{ old('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                                                        {{ $restaurant->nama }} </option>
                                                    @endforeach
                                                </select>
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

    
</script>

<script>
    function addField() {
        var rowCount = $('#contactTable tr').length;
        $("#contactTable").find('tbody')
            .append(
                $('<tr>' +
                    // '<td><input class="form-control" placeholder="Input nama" type="text" name="nama[]" id="nama'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td><select class="js-example-basic-single @error('restaurant_id') is-invalid @enderror" id="material'+rowCount+'" name="restaurant_id[]" style="width:100%"><option disabled selected>Choose Material</option>@foreach ($restaurants as $restaurant)<option value="{{ $restaurant->id }}"{{ old('restaurant_id') == $restaurant->id ?'selected' : '' }}>{{ $restaurant->nama }} </option>@endforeach</select></td>' +
                    '<td><input class="form-control" placeholder="Input harga" type="text" name="harga[]" id="harga'+rowCount+'" onkeyup="calculatePrice('+rowCount+')"></td>' +
                    '<td style="max-width: 6% !important"><button type="button" class="btn btn-outline-danger btn-remove" onclick="$(this).parent().parent().remove();changeOptionValue();"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>'
                )
            );

        // Initialize the newly added select element as Select2
        $('#material' + rowCount).select2({
            width: '100%'
        });

        new AutoNumeric('#harga' + rowCount, {
            currencySymbol: '',
            decimalPlaces: 0,
            // digitGroupSeparator : '.',
        });
    }
</script>

  
               
