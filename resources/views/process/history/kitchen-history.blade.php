@extends('process.layouts.app')

@push('style-top')

@endpush

@push('style-bot')
<style>
    .form-check-input{
        width: 1.5rem !important;
        height: 1.5rem !important;
    }
     menu-1{
        font-weight: 600 !important;
    }
</style>
@endpush

@section('content')
<section class="p-3">
    <form action="">
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 mb-3">
            <div class="col-lg-6">
                <div class="card h-100 border-r-20">
                    <div class="card-header border-rt-20 py-1">
                        <h5 class="card-title text-center pt-1 fw-bolder">FILTER DATA</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="form-group text-start" id="datepicker-date-area">
                                    <label class="">Date :</label>
                                    <input type="date" name="start_date" id="date" value="{{Request::get('start_date') ?? date('Y-m-d')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="form-group text-start" id="datepicker-date-area">
                                    <label class="">Time From :</label>
                                    <input type="time" name="time_from" id="date" value="{{Request::get('time_from') ?? date('H:i')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="form-group text-start" id="datepicker-date-area">
                                    <label class="">Time To :</label>
                                    <input type="time" name="time_to" id="date" value="{{Request::get('time_to') ?? date('H:i')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label class="">No Invoice :</label>
                                    <select class="js-example-basic-single" name="no_invoice"  style="width:100%">
                                        <option disabled selected>Choose No Invoice</option>
                                        <option value="All">All</option>
                                        @foreach ($no_invoices as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <div class="form-group">
                                    <label class="">Nama Customer :</label>
                                    <select class="js-example-basic-single" name="nama_customer"  style="width:100%">
                                        <option disabled selected>Choose Nama</option>
                                        <option value="All">All</option>
                                        @foreach ($nama_customers as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group mt-4 ">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        Generate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($orders as $item)
        {{-- @if ($item->status_pesanan !== 'selesai') --}}
        <div class="col">
            <div class="card h-100 border-r-20">
                <div class="card-header border-rt-20">
                    {{-- <a data-bs-toggle="modal" data-bs-target="#waiters-{{ $item->code }}" href="{{ route('waiters.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark"> --}}
                        <h5 class="card-title text-center pt-1 fw-bolder">#{{ $item->invoice_no }} 
                             </h5>
                        <h5 class="card-title text-center pt-1 fw-bolder">
                            (Meja 
                                @if($item->meja_restaurant_id || $item->category == 'Takeaway' )
                                    {{ $item->tableRestaurant->nama ?? ''}}
                                    @if ($item->category == 'Takeaway')
                                    {{ $item->category }}
                                        
                                    @endif
                                @elseif($item->biliard_id)
                                    {{ $item->tableBilliard->nama }}    
                                @elseif($item->meeting_room_id)
                                    {{ $item->tableMeetingRoom->nama }} 
                                @endif
                            )
                        </h5>
                    {{-- </a> --}}
                </div>
                <div class="card-body py-0 px-0">
                    <div class="scroll-style">
                        <ul class="list-group list-group-flush">
                            @foreach ($item->orderPivot as $order_pivot)
                                <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                    <div class="flex-shrink-1">
                                        <input disabled class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_pivot->id }}', this)" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_pivot->id }}" {{ ($order_pivot->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h5 class="me-2 mb-0">{{ $loop->iteration }}.</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1 bd-highlight">
                                        <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                            {{ $order_pivot->restaurant->nama }}
                                            ({{ $order_pivot->qty }}) 
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                            {{-- Meeting --}}
                            @foreach ($item->orderMeeting as $order_meeting)
                                <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                    <div class="flex-shrink-1">
                                        <input disabled class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_meeting->id }}', this)" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_meeting->id }}" {{ ($order_meeting->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h5 class="me-2 mb-0">{{ $loop->iteration }}.</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1 bd-highlight">
                                        <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                            {{ $order_meeting->restaurant->nama }}
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                            {{-- Restaurant --}}
                            @foreach ($item->orderBilliard as $order_billiard)
                                <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                    <div class="flex-shrink-1">
                                        <input disabled class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_billiard->id }}', this)" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_billiard->id }}" {{ ($order_billiard->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h5 class="me-2 mb-0">{{ $loop->iteration }}.</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1 bd-highlight">
                                        <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                            {{ $order_billiard->restaurant->nama }}
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- <div class="px-2 py-2">
                        <button class="btn btn-success rounded-lg p-2 mt-1 w-100" onclick="confirmData('{{ $item->id }}')">Selesaikan Pemesanan</button>
                    </div> --}}
                </div>

                <div class="card-footer border-rb-20">
                    <a href="{{ route('kasir.dashboard-detail-kasir.show',$item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger rounded-lg p-2 mt-1 w-100">Print</a>
                    <small class="text-muted">Customer :<span class="text-success"> <b> {{ strtoupper($item->name) }} </b></span></small><br>
                    <small class="text-muted">Last updated <span class="text-danger">{{ $item->elapsed_time }}</span></small><br>
                    <small class="text-muted">Datetime Order <span class="text-danger">{{ $item->created_at->format('H:i') }}</span></small>
                </div>
            </div>
            {{-- @include('process.waiters.modal') --}}

        </div>
        {{-- @endif --}}
        @endforeach
    </div>
</section>
{{-- @include('process.waiters.modal') --}}
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    window.setTimeout( function() {
        window.location.reload();
    }, 60000);
    function confirmData(id) {
        $.confirm({
            icon: 'glyphicon glyphicon-heart',
            title: 'Warning!',
            content: 'Apakah anda yakin?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function(){
                        axios.post('{{ route("waiters.status-update") }}', {
                            id
                        })
                        .then(response => {
                            // console.log(response);
                            alert('Berhasil Diupdate');
                            location.reload();
                        })
                        .catch(error => {
                            alert(error.response.data);
                        });
                    }
                },
                close: function () {
                    
                }
            }
        });
    }

</script>

<script>
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
@endpush
