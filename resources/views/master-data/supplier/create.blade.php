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
                <form class="forms-sample row p-3" action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="nama">Name</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}"  placeholder="Enter nama">

                            @error('nama')
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
                        <table id="mytable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="th-sm text-white text-center">Name</th>
                                    <th class="th-sm text-white text-center">Telephone</th>
                                    <th class="th-sm text-white text-center">Email</th>
                                    <th class="th-sm text-white text-center">Address</th>
                                </tr>
                            </thead>
                            <tbody id="add-detail-supplier">
                                <tr>
                                    <td><input type="text" class="form-control"></td>
                                    <td><input type="tel" class="form-control"></td>
                                    <td><input type="text" class="form-control"></td>
                                    <td><input type="text" class="form-control"></td>
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
    var tbody = document.getElementById("add-detail-supplier");
    let countTbody = tbody.rows.length;
    console.log(countTbody);

    function addField() {
        var checkNewTbody = document.getElementById("add-detail-supplier");
        let checkNewCount = checkNewTbody.rows.length;
        console.log(checkNewCount);
        if (countTbody < checkNewCount) {
            $('#add-detail-supplier').append(
                `<tr>`+
                    `<td><input type="text" class="form-control" name="name[]" value="{{ old('name') }}"></td>`+
                    `<td><input type="text" class="form-control" name="telephone[]" value="{{ old('telephone') }}"></td>`+
                    `<td><input type="text" class="form-control" name="email[]" value="{{ old('email') }}"></td>`+
                    `<td><input type="text" class="form-control" name="address[]" value="{{ old('address') }}"></td>`+
                `</tr>`
            );
        }

    }
</script>
@endpush
