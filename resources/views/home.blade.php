{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('layouts.head')
   
  </head>
  <body>
    <div class="container-scroller">
        @include('layouts.sidebar')
        
        <div class="container-fluid page-body-wrapper">
            
        @include('layouts.navbar')

        <div class="main-panel">
          
          @yield('content')

          <!-- content-wrapper ends -->
            @include('layouts.footer')
            
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
    <!-- container-scroller -->

    @include('layouts.foot')
  </body>
</html>
