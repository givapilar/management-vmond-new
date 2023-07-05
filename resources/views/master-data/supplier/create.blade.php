<div class="modal modal-fullscreen" id="tambah-supplier" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD SUPPLIER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample row p-3" action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"  placeholder="Enter name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3>Detail Supplier <span class="text-danger">*</span></h3>
                            <button class="btn btn-sm btn-success text-white p-2" onclick="addField()" type="button">Add Detail</button>
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
                                <tr>
                                    <td>
                                        <input type="text" class="form-control @error('name_detail') is-invalid @enderror" id="name_detail" name="name_detail[]" value="{{ old('name_detail') }}"  placeholder="Input Name supplier...">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone[]" value="{{ old('telephone') }}"  placeholder="Input telephone supplier...">
                                    </td>
                                    <td>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email[]" value="{{ old('email') }}"  placeholder="Input email supplier...">
                                    </td>
                                    <td> <textarea name="address[]" placeholder="Address" class="form-control" id="address" rows="3"></textarea></td>
                                  
                                    <td>
                                        <button type="button" disabled class="btn btn-outline-success" id="btn-add-document" onclick="addField()">
                                            <i class="fas fa-plus-square"></i>
                                        </button>
                                    <td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger p-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary mr-2 p-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script_bot')
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
            // changeOptionValue();
    }
</script>
@endpush
