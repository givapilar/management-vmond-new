@extends('home')

@section('style')
<style>
  .hilang{
    display: none;
  }
</style>
@endsection

@section('content')
<div class="content-wrapper p-0">
    <div class="row p-3">
        <div class="col-12 col-md-3 grid-margin">
            <div class="card rounded-20 px-2 pb-2">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Total Membership Bronze</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                        </div>

                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="mb-0 text-success ml-2 font-weight-medium"> {{ $membershipBronze }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 grid-margin">
            <div class="card rounded-20 px-2 pb-2">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Total Membership Silver</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                        </div>

                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="mb-0 text-success ml-2 font-weight-medium"> {{ $membershipSilver}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 grid-margin">
            <div class="card rounded-20 px-2 pb-2">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Total Membership Gold</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                        </div>

                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="mb-0 text-success ml-2 font-weight-medium"> {{ $membershipGold}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 grid-margin">
            <div class="card rounded-20 px-2 pb-2">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Total Membership Platinum</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                        </div>

                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="mb-0 text-success ml-2 font-weight-medium"> {{ $membershipPlatinum}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="get" class="p-3">
        <div class="card rounded-20 p-2">
            <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                <h4 class="text-center text-uppercase">Filter Stok</h4>
            </div>
            <div class="card-body bg-gray-800 rounded-20 p-3">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <label> period :</label>
                            <select class="form-control select2 text-light" data-placeholder="Choose one" id="daterange" name="type">
                                {{-- <option value="day" {{ (Request::get('type') == 'day') ? 'selected' : ''}}>Daily</option> --}}
                                <option value="monthly" {{ (Request::get('type') == 'monthly') ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ (Request::get('type') == 'yearly') ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group" id="datepicker-date-area">
                            <label> Date :</label>
                            <input type="text" name="start_date" id="date" value="{{Request::get('start_date') ?? date('Y-m-d')}}"
                                autocomplete="off" class="datepicker form-control time" required>
                        </div>
                        <div class="form-group hilang" id="datepicker-month-area">
                            <label> Month :</label>
                            <input type="text" name="month" id="month" value="{{ Request::get('month') ?? date('Y-m') }}"
                                autocomplete="off" class="datepicker-month form-control time" required>
                        </div>
                        <div class="form-group hilang" id="datepicker-year-area">
                            <label> Year :</label>
                            <input type="text" name="year" id="month" value="{{ Request::get('year') ?? date('Y') }}"
                                autocomplete="off" class="datepicker-year form-control text-light" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label>Material :</label>
                            <select class="js-example-basic-single @error('material_id') is-invalid @enderror"
                                id="material_id" name="material_id" style="width:100%">
                                <option disabled selected>Choose Material</option>
                                @foreach ($materials as $material)
                                <option value="{{ $material->id }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                    {{ $material->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group mt-4 ">
                            <button type="submit" class="btn btn-primary btn-group-lg p-2 ">
                                {{-- <i class="fas fa-cog fa-lg"></i> --}}
                                Generate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row p-3">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card rounded-20 p-2">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                    <h4 class="text-center text-uppercase">Stok Trend</h4>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 grid-margin ">
            <div class="card rounded-20 px-2 pb-2">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Total Stok</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                            {{-- <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i> --}}
                        </div>

                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ $stock_masuk - $stock_keluar }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card rounded-20 px-2 pb-2 mt-3">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Stok Masuk</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            {{-- <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i> --}}
                            <img src="{{ asset('assets/images/icon/stockin.png') }}" alt="" class="">
                        </div>
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="mb-0 text-success font-weight-medium">{{ $stock_masuk }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card rounded-20 px-2 pb-2 mt-3">
                <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                    <h5 class="text-center text-uppercase">Stok Keluar</h5>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                            {{-- <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i> --}}
                            <img src="{{ asset('assets/images/icon/stockout.png') }}" alt="" class="">
                        </div>
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                <h2 class="text-danger ml-2 font-weight-medium">{{ $stock_keluar }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Line cart --}}
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card card rounded-20 p-2">
                    <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
                        <div class="row">
                            <div class="col-6 mt-1 px-4">
                                <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                                    <i class="fa-solid fa-address-card"  style="font-size: 20px;"></i>
                                    <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
                                </span>
                            </div>
    
                            <div class="col-6 text-right px-4">
                                <a class="btn btn-sm btn-danger p-2" href="{{ route('master-data.index') }}">
                                    Kembali
                                </a>
    
                                @can('add-on-create')
                                <button class="btn btn-sm btn-success btn-open-modal p-2" data-toggle="modal" data-target="#tambah-add-on">
                                    Tambah
                                </button>
                                @endcan
                            </div>
                        </div>
                    </div>
    
                    <div class="card-body bg-gray-800 rounded-20 p-3">
                        <div class="row">
                            <div class="col-12">
                                @include('components.flash-message')
                            </div>
                        </div>
    
                        <table id="mytable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="th-sm text-white">No</th>
                                    <th class="th-sm text-white">Nama</th>
                                    <th class="th-sm text-white">Email</th>
                                    <th class="th-sm text-white">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($account_users as $item)
                                <tr>
                                    <td class="table-head text-white">{{ $loop->iteration }}</td>
                                    <td class="table-head text-white">{{ $item->username ?? ''}}</td>
                                    <td class="table-head text-white">{{ $item->email ?? '' }}</td>
                                    <td class="table-head text-white">{{ $item->telephone ?? '' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')

<script>
    let date = @json($stok_masuk);
    console.log(date);

    generateChartTransaksi('myChart', @json($date), @json($stok_masuk), @json($stok_keluar));

    function generateChartTransaksi(id, date, stok_masuk, stok_keluar) {
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: date,
                datasets: [{
                    label: '# Stok Masuk',
                    data: stok_masuk,
                    borderWidth: 1
                },{
                    label: '# Stok Keluar',
                    data: stok_keluar,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        startView: 2,
        minViewMode: 0,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-date-area'
    });

    $('.datepicker-month').datepicker({
        format: "yyyy-mm",
        startView: 2,
        minViewMode: 1,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-month-area'
    });

    $('.datepicker-year').datepicker({
        format: "yyyy",
        startView: 2,
        minViewMode: 2,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-year-area'
    });

    let rangeNow = $('#daterange').val();
    if (rangeNow == 'day') {
        $('#datepicker-date-area').removeClass('hilang');
        const element = document.querySelector('#datepicker-date-area')
        element.classList.add('animated', 'fadeIn')
        // Hilangkan Month
        $('#datepicker-month-area').addClass('hilang');
        $('#datepicker-year-area').addClass('hilang');

    } else if(rangeNow == 'monthly') {
        $('#datepicker-month-area').removeClass('hilang');
        const element = document.querySelector('#datepicker-month-area')
        element.classList.add('animated', 'fadeIn')
        // Hilangkan Date
        $('#datepicker-date-area').addClass('hilang');
        $('#datepicker-year-area').addClass('hilang');
    } else {
        $('#datepicker-year-area').removeClass('hilang');
        const element = document.querySelector('#datepicker-year-area')
        element.classList.add('animated', 'fadeIn')
        // Hilangkan Date
        $('#datepicker-date-area').addClass('hilang');
        $('#datepicker-month-area').addClass('hilang');
    }

    $('#daterange').on('change', function () {
        val = $(this).val();
        if (val == 'day') {
            $('#datepicker-date-area').removeClass('hilang');
            const element = document.querySelector('#datepicker-date-area')
            element.classList.add('animated', 'fadeIn')
            // Hilangkan Month
            $('#datepicker-month-area').addClass('hilang');
            $('#datepicker-year-area').addClass('hilang');

        } else if(val == 'monthly') {
            $('#datepicker-month-area').removeClass('hilang');
            const element = document.querySelector('#datepicker-month-area')
            element.classList.add('animated', 'fadeIn')
            // Hilangkan Date
            $('#datepicker-date-area').addClass('hilang');
            $('#datepicker-year-area').addClass('hilang');
        } else {
            $('#datepicker-year-area').removeClass('hilang');
            const element = document.querySelector('#datepicker-year-area')
            element.classList.add('animated', 'fadeIn')
            // Hilangkan Date
            $('#datepicker-date-area').addClass('hilang');
            $('#datepicker-month-area').addClass('hilang');
        }
    })
</script>
@endsection
