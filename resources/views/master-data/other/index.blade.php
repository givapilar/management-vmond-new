@extends('home')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <form class="forms-sample" action="{{ route('other.update', ['id' => Crypt::encryptString($other_setting->id ?? 0)]) }}" enctype="multipart/form-data" method="POST">
        @csrf
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
                    <div class="card-body bg-gray-800 rounded-20 p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="no_wa">Whatsapp admin <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" name="no_wa" value="{{ $other_setting->no_wa ?? old('no_wa') }}"  placeholder="Enter whatsapp admin...">
                                    <span class="text-danger" style="font-size: 12px;">Note: Tidak perlu memasukan angka depan 0</span>

                                    @error('no_wa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="pb01">Biaya PB01 (%) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('pb01') is-invalid @enderror" id="pb01" name="pb01" min="0" max="100" value="{{ $other_setting->pb01 ?? old('pb01') }}"  placeholder="Enter Biaya PB01...">

                                    @error('pb01')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="layanan">Biaya Layanan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('layanan') is-invalid @enderror" step="0.01" id="layanan" min="0" max="100000" name="layanan" value="{{ $other_setting->layanan ?? old('layanan') }}"  placeholder="Enter Biaya Layanan...">

                                    @error('layanan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="biaya_packing">Biaya Packing <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('biaya_packing') is-invalid @enderror" step="0.01" id="biaya_packing" min="0" max="100000" name="biaya_packing" value="{{ $other_setting->biaya_packing ?? old('biaya_packing') }}"  placeholder="Enter Biaya biaya_packing...">

                                    @error('biaya_packing')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <h3>Makanan</h3>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_start">Time Open Weekdays <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_start') is-invalid @enderror" id="time_start" name="time_start" value="{{ $other_setting->time_start ?? old('time_start') }}"  placeholder="Enter time open...">

                                    @error('time_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_close">Time Close Weekdays <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_close') is-invalid @enderror" id="time_close" name="time_close" value="{{ $other_setting->time_close ?? old('time_close') }}"  placeholder="Enter time open...">

                                    @error('time_close')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_start_weekend">Time Open Weekend<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_start_weekend') is-invalid @enderror" id="time_start_weekend" name="time_start_weekend" value="{{ $other_setting->time_start_weekend ?? old('time_start_weekend') }}"  placeholder="Enter time open...">

                                    @error('time_start_weekend')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_close_weekend">Time Close Weekend <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_close_weekend') is-invalid @enderror" id="time_close_weekend" name="time_close_weekend" value="{{ $other_setting->time_close_weekend ?? old('time_close_weekend') }}"  placeholder="Enter time open...">

                                    @error('time_close_weekend')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <h3>Minuman</h3>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_start_weekdays_minuman">Time Open Weekdays <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_start_weekdays_minuman') is-invalid @enderror" id="time_start_weekdays_minuman" name="time_start_weekdays_minuman" value="{{ $other_setting->time_start_weekdays_minuman ?? old('time_start_weekdays_minuman') }}"  placeholder="Enter time open...">

                                    @error('time_start_weekdays_minuman')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_close_weekdays_minuman">Time Close Weekdays <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_close_weekdays_minuman') is-invalid @enderror" id="time_close_weekdays_minuman" name="time_close_weekdays_minuman" value="{{ $other_setting->time_close_weekdays_minuman ?? old('time_close_weekdays_minuman') }}"  placeholder="Enter time open...">

                                    @error('time_close_weekdays_minuman')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_start_weekend_minuman">Time Open Weekend<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_start_weekend_minuman') is-invalid @enderror" id="time_start_weekend_minuman" name="time_start_weekend_minuman" value="{{ $other_setting->time_start_weekend_minuman ?? old('time_start_weekend_minuman') }}"  placeholder="Enter time open...">

                                    @error('time_start_weekend_minuman')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="time_close_weekend_minuman">Time Close Weekend <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('time_close_weekend_minuman') is-invalid @enderror" id="time_close_weekend_minuman" name="time_close_weekend_minuman" value="{{ $other_setting->time_close_weekend_minuman ?? old('time_close_weekend_minuman') }}"  placeholder="Enter time open...">

                                    @error('time_close_weekend_minuman')
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
                </div>
            </div>

            {{-- Card --}}

            <div class="col-lg-6 col-12 grid-margin stretch-card h-auto d-inline-block">
                <div class="card card rounded-20 p-2 h-auto d-inline-block" >
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
                    <div class="card-body bg-gray-800 rounded-20 p-4">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description_notifikasi" class="form-control" id="description" rows="4" placeholder="Description Notifikasi">{{ $other_setting->description_notifikasi ?? old('description_notifikasi') }}</textarea>
                                    {{-- <textarea name="description" id="mytextarea"></textarea> --}}
                                    @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="">Status Notifikasi</label>
                                    <select class="form-control @error('status_notifikasi') is-invalid @enderror" name="status_notifikasi">
                                        <option disabled selected>Choose Status</option>
                                        <option value="Active" {{ $other_setting->status_notifikasi == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $other_setting->status_notifikasi == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    
                                    @error('status_notifikasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
