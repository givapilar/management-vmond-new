@extends('home')
@section('style')
<style>
  .card{
    transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1) !important;
    overflow: hidden !important;
    border-radius: 20px !important;
    height: 12rem;
    object-fit: cover;
    object-position: center;
  }
  .card:hover{
    transform: scale(0.98);
    box-shadow: 0 0 5px -2px rgba(0, 0, 0, 0.3);
    background-size: 130%;
    transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
  }
  .card h1{
    position: absolute;
    top: 50%; right: 50%;
    transform: translate(50%,-50%);
  }

  .cursor{
    cursor: pointer;
  }
</style>
@endsection
@section('content')

<section>
    <div class="row">
       <div class="col-12 col-lg-4 mt-lg-3 mt-3 cursor" onclick="location.href='{{ route('restaurant.index') }}'">
         <div class="card" style="background:linear-gradient(rgba(50, 50, 50, 0.5), rgba(50,50,50,0.5));">
            <img src="{{ asset('assets/images/icon/restaurant.jpg') }}" alt="">
            <h1>Restaurant</h1>
        </div>
       </div>
       <div class="col-12 col-lg-4 mt-lg-3 mt-3 cursor" onclick="location.href='{{ route('biliard.index') }}'">
        <div class="card" style="background:linear-gradient(rgba(50,50,50,0.5), rgba(50,50,50,0.5));">
            <img src="{{ asset('assets/images/icon/biliard.jpg') }}" alt="">
            <h1>Billiard</h1>
        </div>
       </div>
       <div class="col-12 col-lg-4 mt-lg-3 mt-3 cursor" onclick="location.href='{{ route('meeting-room.index') }}'">
         <div class="card" style="background:linear-gradient(rgba(50,50,50,0.5), rgba(50,50,50,0.5));">
            <img src="{{ asset('assets/images/icon/meeting-room.jpg') }}" alt="">
            <h1>Meeting Room</h1>
        </div>
       </div>

       <div class="col-12 col-lg-4 mt-lg-3 mt-3 cursor" onclick="location.href='{{ route('banner.index') }}'">
        <div class="card" style="background:linear-gradient(rgba(50,50,50,0.5), rgba(50,50,50,0.5));" >
          <img src="{{ asset('assets/images/icon/banner.jpg') }}" alt="">
           <h1>Banner</h1>
       </div>
      </div>
    </div>
</section>
@endsection
