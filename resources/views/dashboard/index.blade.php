@extends('home')

@section('style')
<style>
  .hilang{
    display: none;
  }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    {{-- <div class="page-header">
        <h3 class="page-title"> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            </ol>
        </nav>
    </div> --}}

    <div class="content-wrapper">
        <form action="{{ route('dashboard') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    {{-- <div class="form-group mb-3">
                        <label class="">Select Periode</label>
                        <select class="form-control @error('periode') is-invalid @enderror" name="periode">
                            <option disabled selected>Choose periode</option>
                            <option value="Daily">Daily</option>
                            <option value="Montly">Montly</option>
                        </select>
                    </div> --}}
                    <div class="form-group ">
                              <label> period :</label>
                              <select class="form-control select2" data-placeholder="Choose one"
                                  id="daterange" name="type">
                                  <option value="day" {{ ($type == 'day') ? 'selected' : ''}}>Daily</option>
                                  <option value="month" {{ ($type == 'month') ? 'selected' : '' }}>Monthly</option>
                              </select>
                      </div>
                </div>

                <div class="col-lg-3">
                    {{-- <div class="form-group">
                        <label for="">Start Date</label>
                        <input placeholder="Select Month"
                            class="form-control datepicker-here  digits @error('start_date') is-invalid @enderror"
                            type="month" name="start_date">
                    </div> --}}
                    <div class="form-group" id="datepicker-date-area">
                        <label> Date :</label>
                        <input type="text" name="start_date" id="date" value="{{$start_date ?? date('Y-m-d')}}"
                            autocomplete="off" class="datepicker form-control time" required>
                    </div>
                    <div class="form-group hilang" id="datepicker-month-area">
                        <label> Month :</label>
                        <input type="text" name="start_date" id="month" value="{{date('Y-m',strtotime($start_date)) ?? date('Y-m')}}"
                            autocomplete="off" class="datepicker-month form-control time" required>
                    </div>
                </div>

                {{-- <div class="card-body ">
                  <div class="row row-sm">
                      <div class="col-xl-4">
                          <div class="form-group ">
                              <label> period :</label>
                              <select class="form-control select2" data-placeholder="Choose one"
                                  id="daterange">
                                  <option value="day">Daily</option>
                                  <option value="month">Monthly</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-xl-4" style="z-index: 9;">
                          <div class="form-group" id="datepicker-date-area">
                              <label> Date :</label>
                              <input type="text" name="date" id="date" value="{{date('Y-m-d')}}"
                                  autocomplete="off" class="datepicker form-control time" required>
                          </div>
                          <div class="form-group hilang" id="datepicker-month-area">
                              <label> Month :</label>
                              <input type="text" name="date" id="month" value="{{date('Y-m')}}"
                                  autocomplete="off" class="datepicker-month form-control time" required>
                          </div>
                      </div>
                  </div>
              </div> --}}

              <div class="col-lg-3">
                  <div class="form-group mb-3">
                      <label>Material</label>
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


                <div class="col-lg-3">
                    <div class="form-group mt-4 ">
                        <button type="submit" class="btn btn-info btn-group-lg">
                            <i class="fas fa-cog fa-lg"></i>
                            Generate
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Area chart</h4>
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Stok Masuk</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0 text-success font-weight-medium">{{ $stock_masuk }}</h2>
                                </div>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                      <h5>Stok Keluar</h5>
                      <div class="row">
                          <div class="col-8 col-sm-12 col-xl-8 my-auto">
                              <div class="d-flex d-sm-block d-md-flex align-items-center">
                                  <h2 class="text-success ml-2 font-weight-medium">{{ $stock_keluar }}</h2>
                              </div>
                          </div>
                          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                              <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                          </div>
                      </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                      <h5>Total Stok</h5>
                      <div class="row">
                          <div class="col-8 col-sm-12 col-xl-8 my-auto">
                              <div class="d-flex d-sm-block d-md-flex align-items-center">
                                  <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ $stock_masuk - $stock_keluar }}</h2>
                              </div>
                          </div>
                          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                              <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
                          </div>
                      </div>
                    </div>
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
                container: '.datepicker-area'
            });

            let rangeNow = $('#daterange').val();
            if (rangeNow == 'day') {
                $('#datepicker-date-area').removeClass('hilang');
                const element = document.querySelector('#datepicker-date-area')
                element.classList.add('animated', 'fadeIn')
                // Hilangkan Month
                $('#datepicker-month-area').addClass('hilang');

            } else {
                $('#datepicker-month-area').removeClass('hilang');
                const element = document.querySelector('#datepicker-month-area')
                element.classList.add('animated', 'fadeIn')
                // Hilangkan Date
                $('#datepicker-date-area').addClass('hilang');
            }

            $('#daterange').on('change', function () {
                val = $(this).val();
                if (val == 'day') {
                    $('#datepicker-date-area').removeClass('hilang');
                    const element = document.querySelector('#datepicker-date-area')
                    element.classList.add('animated', 'fadeIn')
                    // Hilangkan Month
                    $('#datepicker-month-area').addClass('hilang');

                } else {
                    $('#datepicker-month-area').removeClass('hilang');
                    const element = document.querySelector('#datepicker-month-area')
                    element.classList.add('animated', 'fadeIn')
                    // Hilangkan Date
                    $('#datepicker-date-area').addClass('hilang');

                }
            })
</script>
@endsection
