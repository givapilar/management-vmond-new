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
                <th class="th-sm text-white">Nama</th>
                <th class="th-sm text-white">Kupon</th>
              </tr>
          </thead>
              <tbody>
                  @foreach ($kupons as $kupon)
                  {{-- {{ dd($kupon->order->name) }} --}}
                    {{-- @if (!is_null($kupon->feedback)) --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="table-head text-white">{{ $kupon->order->name ?? '-' }}</td>
                            <td class="table-head text-white">{{ $kupon->code ?? '-' }}</td>
                        </tr>
                    {{-- @endif --}}
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
