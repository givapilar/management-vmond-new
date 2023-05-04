@extends('home')

@section('style')
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
        <div class="row">
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
          </div>
          <div class="col-sm-4 grid-margin">
            <div class="card">
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
          </div>
          <div class="col-sm-4 grid-margin">
            <div class="card">
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

    <div class="content-wrapper">
      {{-- <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-group-lg">
                        <i class="fas fa-cog fa-lg"></i>
                        Generate
                    </button>
                </div>
            </div>
        </div>
      </form> --}}
      <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <input placeholder="Select Month"  class="form-control datepicker-here  digits @error('start_date') is-invalid @enderror"
                    type="date" data-language="en" data-min-view="months" data-view="months"
                    data-date-format="MM yyyy" name="start_date">
                    {{-- <label for="month">Month: </label>
                    <input type="text" id="month" name="month" class="monthPicker" /> --}}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-group-lg">
                        <i class="fas fa-cog fa-lg"></i>
                        Generate
                    </button>
                </div>
            </div>
        </div>
      </form>
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Area chart</h4>
                <div>
                    <canvas id="myChart"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
</div>
@endsection

