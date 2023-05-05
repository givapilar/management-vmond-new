@extends('home')

@section('style')
@endsection

<style>
    body {
        margin-top: 20px;
        color: #bcd0f7;
        background: #1A233A;
    }

    .account-settings .user-profile {
        margin: 0 0 1rem 0;
        padding-bottom: 1rem;
        text-align: center;
    }

    .account-settings .user-profile .user-avatar {
        margin: 0 0 1rem 0;
    }

    .account-settings .user-profile .user-avatar img {
        width: 90px;
        height: 90px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
    }

    .account-settings .user-profile h5.user-name {
        margin: 0 0 0.5rem 0;
    }

    .account-settings .user-profile h6.user-email {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 400;
    }

    .account-settings .about {
        margin: 1rem 0 0 0;
        font-size: 0.8rem;
        text-align: center;
    }

    .card {
        background: #272E48;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }

    .form-control {
        border: 1px solid #596280;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        font-size: .825rem;
        background: #1A233A;
        color: #bcd0f7;
    }

</style>
@section('content')
<div class="content-wrapper">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-sm-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img class="border-rounded"
                                        src="{{ asset('assets/images/user/'.(Auth::user()->avatar ?? 'user.png')) }}"
                                        alt="Maxwell Admin" style="width: 100px; height:100px;">
                                </div>
                                <h5 class="user-name">{{ Auth::user()->name }}</h5>
                                <h6 class="user-email">{{ Auth::user()->email }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-3 text-primary">Profile Details</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') ?? $user->name }}"
                                            placeholder="Enter name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') ?? $user->email }}"
                                            placeholder="Enter email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label>Roles</label>
                                        <select class="form-control" name="role">
                                            <option disabled selected>Select One Role Only</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role }}"
                                                {{ (old('role') ?? $user->getRoleNames()[0] == $role) ? 'selected' : ''  }}>
                                                {{ $role }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div>
                                        <img src="{{ asset('assets/images/user/'.($user->avatar ?? 'user.png')) }}"
                                            width="110px" class="image img" />
                                    </div>
                                    <div class="form-group">
                                        <label>File upload</label>
                                        <input type="file" name="avatar" class="file-upload-default">
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
                            </div>
                            @if (Auth::user()->id == $user->id)
                            <div class="form-group mb-3">
                                <label for="password">Old Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" placeholder="Password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" value="{{ old('new_password') }}"
                                    placeholder="New Password">
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            @endif
                            <div class="" style="border-radius:0px 0px 10px 10px;">
                                <button type="submit" class="btn btn-info btn-footer">Simpan</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-footer">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('javascript')
<script>

</script>
@endsection
