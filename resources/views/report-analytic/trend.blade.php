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
    </form>

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
