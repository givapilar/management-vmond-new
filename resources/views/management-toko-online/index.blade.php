@extends('home')

@section('style')
@endsection
<style>
    /* .card{
        background-color: #1b2352 !important;
        box-shadow: -8px 12px 18px 0 #0d1337;
        cursor: pointer;
    }
    .card-header{
        border-radius: calc(3px - 1px) calc(3px - 1px) 0 0;
    }

    .icon-mdi{
        font-size: 56px;
    }
    .bg-master{
        background-color: #11163a !important;
    }

    .card-master {
        cursor: pointer;
        transition: all 0.7s;
    }

    .card-master:hover {
        transform: scale(1.07) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    } */
    .radius-r-20{
        border-radius: 20px 50% 50% 20px !important;
    }
    .card {
        cursor: pointer;
        transition: all 0.2s;
    }

    .card:hover {
        transform: scale(1.02) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }
    .bg-gray-400{
        background: #191c24;
    }
</style>

@section('content')
<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title"> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Toko Online</a></li>
                {{-- <li class="breadcrumb-item active" aria-current="page">User</li> --}}
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4" onclick="location.href='{{ route('restaurant.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/restaurant.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Restaurant</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data restaurant</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4" onclick="location.href='{{ route('biliard.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/biliard.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Biliard</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data biliard</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4" onclick="location.href='{{ route('meeting-room.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/meeting-room.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Meeting Room</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data meeting room</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mt-3" onclick="location.href='{{ route('banner.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/advertising.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Media Advertising</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data media advertising</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
