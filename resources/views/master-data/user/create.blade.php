<div class="modal modal-fullscreen" id="tambah-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH {{ strtoupper($page_title) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="forms-sample" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('components.form-message')

                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"  placeholder="Enter name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}"  placeholder="Enter email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Role</label>
                        <select class="form-control" name="role">
                            <option disabled selected>Select One Role Only</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ (old('role') == $role) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}"  placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Avatar</label>
                        <input type="file" name="avatar" class="file-upload-default">
                        <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                        </div>
                        <div class="small text-danger">*Kosongkan jika tidak mau diisi</div>
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

<script src="https://cdn.tiny.cloud/1/6vch58fk4gud1ywlf06b61zgh32srvlfldxj53oxqnt7fpxt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    new AutoNumeric('#harga', {
        currencySymbol : '',
        decimalCharacter : ',',
        digitGroupSeparator : '.',
    });

    tinymce.init({
        selector: '#mytextarea',
        skin: "oxide-dark",
        content_css: "dark"
    });
</script>
