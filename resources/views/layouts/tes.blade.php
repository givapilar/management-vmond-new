@extends('home')

@section('style')

@endsection


@section('content')
<div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">  </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Master Data</a></li>
          <li class="breadcrumb-item active" aria-current="page">restaurant</li>
        </ol>
      </nav>
    </div>
  
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            
            <div class="row">
              <div class="col-12">
                  @include('components.flash-message')
              </div>
            </div>
  
            <div class="row">
              <div class="col-6 mt-1">
                <span class="tx-bold text-lg text-white" style="font-size:16px;">
                  {{-- <h4 class="card-title">{{ $page_title }}</h4> --}}
                </span>
              </div>
    
              @can('restaurant-create')
              <div class="col-6 text-right">
                <button class="btn btn-sm btn-info btn-lg btn-open-modal" data-toggle="modal" data-target="#tambah-menu">
                  <i class="fa fa-plus"></i> 
                  Tambah Menu
                </button>
              </div>
              @endcan
            </div>
  
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color: #6c7293;">Tiger Nixon</td>
                        <td style="color: #6c7293;">Tiger Nixon</td>
                        <td style="color: #6c7293;">Tiger Nixon</td>
                        <td style="color: #6c7293;">Tiger Nixon</td>
                        <td style="color: #6c7293;">Tiger Nixon</td>
                        <td style="color: #6c7293;">Tiger Nixon</td>
                    </tr>
                    
                </tbody>
                
            </table>
  
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
