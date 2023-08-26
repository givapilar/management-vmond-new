@extends('home')

@section('style')
<style>
    .hilang {
        display: none;
    }

    * {
        margin: 0;
        padding: 0;
        }
        #dashboard-grafik {
        position: relative;
        height: 100vh;
        overflow: hidden;
        }
</style>
@endsection

@section('content')
<div class="content-wrapper p-0">
    {{-- Line cart --}}
    <form action="" method="get" class="p-3">
        <div class="card rounded-20 p-2">
            <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                <h4 class="text-center text-uppercase">Filter Stok</h4>
            </div>
            <div class="card-body bg-gray-800 rounded-20 p-3">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group ">
                            <label> period :</label>
                            <select class="form-control select2 text-light" data-placeholder="Choose one" id="daterange"
                                name="type">
                                <option value="day" {{ (Request::get('type') == 'day') ? 'selected' : ''}}>Daily
                                </option>
                                <option value="monthly" {{ (Request::get('type') == 'monthly') ? 'selected' : '' }}>
                                    Monthly</option>
                                <option value="yearly" {{ (Request::get('type') == 'yearly') ? 'selected' : '' }}>Yearly
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group" id="datepicker-date-area">
                            <label> Date :</label>
                            <input type="text" name="start_date" id="date"
                                value="{{Request::get('start_date') ?? date('Y-m-d')}}" autocomplete="off"
                                class="datepicker form-control time" required>
                        </div>
                        <div class="form-group hilang" id="datepicker-month-area">
                            <label> Month :</label>
                            <input type="text" name="month" id="month"
                                value="{{ Request::get('month') ?? date('Y-m') }}" autocomplete="off"
                                class="datepicker-month form-control time" required>
                        </div>
                        <div class="form-group hilang" id="datepicker-year-area">
                            <label> Year :</label>
                            <input type="text" name="year" id="month" value="{{ Request::get('year') ?? date('Y') }}"
                                autocomplete="off" class="datepicker-year form-control text-light" required>
                        </div>
                    </div>

                    {{-- <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label>Category :</label>
                            <select class="js-example-basic-single @error('category') is-invalid @enderror" id="category" name="category" style="width:100%">
                                <option disabled selected>Choose Category</option>
                                <option value="Makanan" {{ request('category') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="Minuman" {{ request('category') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label>Restaurant :</label>
                            <select class="js-example-basic-single @error('restaurant_id') is-invalid @enderror"
                                id="restaurant_id" name="restaurant_id" style="width:100%">
                                <option disabled selected>Choose Restaurant</option>
                                @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}"
                                    {{ old('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                                    {{ $restaurant->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-lg-4">
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

        <div class="col-lg-12 grid-margin stretch-card mt-4">
            <div class="card rounded-20 p-2">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                    <h4 class="text-center text-uppercase">10 Besar Hidangan Terlaris</h4>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div id="dashboard-grafik"></div>
                </div>
            </div>
        </div>


        <div class="row ">
            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">Total Penjualan Item</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($total_price,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">service</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($service,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">pb01</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/stock.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($pb01,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">Total Penjualan Bartender</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/bartender.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($total_bartender,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">Total Penjualan Kitchen</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/kitchen.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($total_kitchen,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">Total Penjualan FWB</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/billiard-ball.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($total_fwb,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4">
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div class="row">
                        <div class="card rounded-20 px-2 pb-2">
                            <div class="card-header rounded-t-20 pt-2 pl-2 pb-0 pr-2">
                                <h5 class="text-center text-uppercase">Total Quantity Terjual</h5>
                            </div>
                            <div class="card-body bg-gray-800 rounded-20 p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-left">
                                        <img src="{{ asset('assets/images/icon/boxes.png') }}" alt="" class="">
                                    </div>

                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center justify-content-end">
                                            <h2 class="mb-0 text-success ml-2 font-weight-medium">{{ number_format($total_qty,0) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- <div class="row p-3 mb-5">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded-20 p-2">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                    <h4 class="text-center text-uppercase">Dasboard Analytic</h4>
                </div>
                <div class="card-body bg-gray-800 rounded-20 p-3">
                    <div id="chart-container"></div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row mt-2 p-2">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card rounded-20 p-2">
            <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
                <div class="row">
                    <div class="col-6 mt-1 px-4">
                        <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                            <i class="fa-sharp fa-solid fa-boxes-stacked" style="font-size: 20px;"></i>
                        </span>
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
                    <th class="th-sm text-white">Waktu Pemesanan</th>
                    <th class="th-sm text-white">Nama Menu Restaurant</th>
                    <th class="th-sm text-white">Category</th>
                    <th class="th-sm text-white">Qty</th>
                    <th class="th-sm text-white">Harga Diskon</th>
                    <th class="th-sm text-white">Status Pemesanan</th>
                    <th class="th-sm text-white">Metode Pembayaran</th>
                    <th class="th-sm text-white">EDC</th>
                  </tr>
              </thead>
                  <tbody>
                    {{-- {{ dd($groupedItems) }} --}}
                    {{-- @foreach ($groupedItems as $groupKey => $grouped)
                        @php
                            list($nama, $category) = explode('|', $groupKey);
                            $totalQty = $grouped->sum('qty');
                        @endphp
                          <tr>
                              <td class="table-head text-white">{{ $loop->iteration }}</td>
                              <td class="table-head text-white">{{ $nama}}</td>
                              <td class="table-head text-white">{{ $category}}</td>
                              <td class="table-head text-white">{{ $totalQty}}</td>
                              <td class="table-head text-white">{{ $grouped->first()->order->status_pembayaran}}</td>
                              <td class="table-head text-white">{{ $grouped->first()->order->metode_pembayaran}}</td>
                              <td class="table-head text-white">{{ $grouped->first()->order->metode_edisi}}</td>
                          </tr>
                      @endforeach --}}
    
                        @foreach ($order_details as $order_detail)
                            <tr>
                                <td class="table-head text-white">{{ $loop->iteration }}</td>
                                <td class="table-head text-white">{{ $order_detail->created_at}}</td>
                                <td class="table-head text-white">{{ $order_detail->restaurant->nama}}</td>
                                <td class="table-head text-white">{{ $order_detail->category}}</td>
                                <td class="table-head text-white">{{ $order_detail->qty}}</td>
                                <td class="table-head text-white">{{ $order_detail->harga_diskon}}</td>
                                <td class="table-head text-white">{{ $order_detail->order->status_pembayaran}}</td>
                                <td class="table-head text-white">{{ $order_detail->order->metode_pembayaran}}</td>
                                <td class="table-head text-white">{{ $order_detail->order->metode_edisi}}</td>
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
<?php
// var dom = document.getElementById('chart-container');
    // var dom = document.getElementById('chart-container');
    //     var myChart = echarts.init(dom, null, {
    //         renderer: 'canvas',
    //         useDirtyRect: false
    //     });

    //     // Chart option from Laravel backend
    //     var chartOption = {!! json_encode($chartOption) !!};

    //     // Set the chart option
    //     if (chartOption && typeof chartOption === 'object') {
    //         myChart.setOption(chartOption);
    //     }

    //     // Resize chart when the window is resized
    //     window.addEventListener('resize', function() {
    //         myChart.resize();
    //     });
?>
<script>
    var dom = document.getElementById('dashboard-grafik');
    var myChart = echarts.init(dom, null, {
    renderer: 'canvas',
    useDirtyRect: false
    });
    var app = {};

    var option;

    option = {
    title: {
        text: 'Stacked Line'
    },
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine']
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    toolbox: {
        feature: {
        saveAsImage: {}
        }
    },
    xAxis: {
        type: 'category',
        data: <?php echo json_encode($dishNames); ?>
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name: 'Top Dishes',
            type: 'line', // You can use 'bar' for a bar chart
            data: <?php echo json_encode($dishQuantities); ?>,
            label: {
                show: true,
                position: 'top'
            }
        }
    ],
    };


    if (option && typeof option === 'object') {
    myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);

</script>
<script>
    

    // End chart

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
