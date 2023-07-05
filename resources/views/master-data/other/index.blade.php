@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-6 col-12 grid-margin stretch-card">
            <div class="card card rounded-20 p-2">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
                    <div class="row">
                        <div class="col-6 mt-1 px-4">
                            <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                                <i class="fa-solid fa-tags" style="font-size: 20px;"></i>
                                <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                            </span>
                        </div>


                    </div>
                </div>
                <form class="forms-sample" action="{{ route('other.update', ['id' => Crypt::encryptString($other_setting->id ?? 0)]) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="card-body bg-gray-800 rounded-20 p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="no_wa">Whatsapp admin <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" name="no_wa" value="{{ $other_setting->no_wa ?? old('no_wa') }}"  placeholder="Enter whatsapp admin...">

                                    @error('no_wa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 pt-3 mt-3" style="border-top: 2px solid rgb(68,70,84);">
                            <a class="btn btn-md btn-danger p-2" href="{{ route('master-data.index') }}">Kembali</a>
                            <button type="submit" class="btn btn- btn-primary mr-2 p-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('master-data.tag.create')
@endsection

@push('script_bot')
<script>
    function phoneMask() {
        var num = $(this).val().replace(/\D/g,'');
        $(this).val(num.substring(0,13));
    }
    $('[type="tel"]').keyup(phoneMask);
</script>
@endpush
