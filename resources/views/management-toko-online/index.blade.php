@extends('home')

@section('style')
@endsection
<style>
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
    <div class="row">
        @can('restaurant-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('restaurant.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/menu.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Restaurant</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete Menu Restaurant</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('biliard-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('biliard.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/billiard.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Billiard</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete Data Billiard</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('meeting-room-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('meeting-room.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/meeting-room.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Meeting Room</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete Data Meeting Room</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('media-advertising-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('media-advertising.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/media-marketing.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Media Advertising</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete Media Advertising</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('paket-menu-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('paket-menu.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/media-marketing.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Paket Menu</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete Paket Menu</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection
