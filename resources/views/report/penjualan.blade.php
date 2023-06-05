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
  <form action="" method="get" class="p-2">
    <div class="card rounded-20 p-2">
        <div class="card-header rounded-t-20 pt-1 pl-2 pb-1 pr-2">
            <h4 class="text-center text-uppercase">Filter Stok</h4>
        </div>
        <div class="card-body bg-gray-800 rounded-20 p-3">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group ">
                        <label> period :</label>
                        <select class="form-control select2 text-light" data-placeholder="Choose one" id="daterange" name="type">
                            <option value="day" {{ (Request::get('type') == 'day') ? 'selected' : ''}}>Daily</option>
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

                <div class="col-lg-5">
                    <div class="form-group mb-3">
                        <label>Order :</label>
                        <select class="js-example-basic-single"
                            id="order_id" name="order_id" style="width:100%">
                            <option disabled selected>Choose Order</option>
                            @foreach ($orders as $order)
                            <option value="{{ $order->id }}"
                                {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                {{ $order->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-1">
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

  <div class="row mt-2 p-2">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card rounded-20 p-2">
        <div class="card-header rounded-t-20 pt-1 pl-2 pb-2 pr-2">
            <div class="row">
                <div class="col-6 mt-1 px-4">
                    <span class="d-flex justify-content-start align-items-center tx-bold text-lg text-white" style="font-size:16px;">
                        <i class="fa-sharp fa-solid fa-boxes-stacked" style="font-size: 20px;"></i>
                        <h4 class="card-title mb-0 pb-0 ml-2">{{ strtoupper($page_title) }}</h4>
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
                <th class="th-sm text-white">No Invoice</th>
                <th class="th-sm text-white">Nama</th>
                <th class="th-sm text-white">Qty</th>
                <th class="th-sm text-white">Total Price</th>
              </tr>
          </thead>
              <tbody>
                  @foreach ($orders as $order)
                      <tr>
                          <td class="table-head text-white">{{ $loop->iteration }}</td>
                          <td class="table-head text-white">{{ $order->invoice_no}}</td>
                          {{-- <td>
                              <a href="{{ route('report-penjualan.edit', $order->id) }}"
                                  class="btn btn-warning p-2 text-white">
                                  <i class="far fa-edit"></i>
                                  Edit
                                </a>
                                <button onclick="detailModal('Report Penjualan', 'report-penjualan/' + {{ $order->id }}, 'small')" class="btn btn-sm btn-primary p-2">
                                    <i class="fa fa-info-circle"></i>#Inv{{ $order->invoice_no }}
                                </button>
                            </td> --}}
                            <td class="table-head text-white">{{ $order->name }}</td>
                            <td class="table-head text-white">{{ $order->qty ?? 0}}</td>
                            <td class="table-head text-white">{{ $order->total_price}}</td>
                      </tr>
                  @endforeach

              </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')

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
@endsection
