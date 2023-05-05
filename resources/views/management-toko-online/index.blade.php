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

</style>
@endsection
@section('content')

<section>
    <div class="row">
       <div class="col-12 col-lg-4 mt-lg-3 mt-3" onclick="location.href='{{ route('restaurant.index') }}'">
         <div class="card" style="background:linear-gradient(rgba(50, 50, 50, 0.5), rgba(50,50,50,0.5)), url(https://images.unsplash.com/photo-1514933651103-005eec06c04b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80);object-fit: cover;object-position: center;">
            <h1>Restaurant</h1>
        </div>
       </div>
       <div class="col-12 col-lg-4 mt-lg-3 mt-3" onclick="location.href='{{ route('biliard.index') }}'">
         <div class="card" style="background:linear-gradient(rgba(50,50,50,0.5), rgba(50,50,50,0.5)), url({{ asset('assets/images/biliard/biliard.jpg') }});object-fit: cover;object-position: center;">
            <h1>Billiard</h1>
        </div>
       </div>
       <div class="col-12 col-lg-4 mt-lg-3 mt-3" onclick="location.href='{{ route('meeting-room.index') }}'">
         <div class="card" style="background:linear-gradient(rgba(50,50,50,0.5), rgba(50,50,50,0.5)), url(https://www.google.com/url?sa=i&url=https%3A%2F%2Funsplash.com%2Fs%2Fphotos%2Fmeeting-room&psig=AOvVaw08EyUZjf7vjWVNs_xH9VsH&ust=1683384719960000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCKiD3P-23v4CFQAAAAAdAAAAABAE);object-fit: cover;object-position: center;">
            <h1>Meeting Room</h1>
        </div>
       </div>
    </div>
</section>
@endsection
