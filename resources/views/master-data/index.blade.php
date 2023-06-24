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
    <div class="row">
        @can('user-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('users.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/users.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">User Management</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data user</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('departement-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('departement.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/building.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Departement</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data departement</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('bahan-baku-list')
        <div class="col-12 col-lg-4 col-md-6 mb-4" onclick="location.href='{{ route('bahan-baku.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/raw-materials.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Bahan Baku</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data bahan baku</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('asset-management-list')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('asset-management.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/assets.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Asset Management</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data asset management</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('tag-list')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('tag.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/tags.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Tag</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data tag</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('meja-restaurant-list')
        <div class="col-12 col-lg-4 col-md-6" onclick="location.href='{{ route('meja-restaurant.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/meja-restaurant.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Meja Restaurant</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete data meja restaurant</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('membership-list')
        <div class="col-12 col-lg-4 col-md-6 mt-4" onclick="location.href='{{ route('membership.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/membership.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Membership</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete Membership</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('supplier-list')
        <div class="col-12 col-lg-4 col-md-6 mt-4" onclick="location.href='{{ route('supplier.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/supplier.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Supplier List</h3>
                        <p class="m-0 p-0 text-muted">Create, Update, and Delete supplier</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('other-settings')
        <div class="col-12 col-lg-4 col-md-6 mt-4" onclick="location.href='{{ route('other.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/other.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Other Settings</h3>
                        <p class="m-0 p-0 text-muted">Update data other settings</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('other-settings')
        <div class="col-12 col-lg-4 col-md-6 mt-4" onclick="location.href='{{ route('other.index') }}'">
            <div class="card rounded-20 p-2 bg-gray-800">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="flex-shrink-1 p-3 radius-r-20 bg-gray-400">
                        <img src="{{ asset('assets/images/icon/other.png') }}" alt="">
                    </div>
                    <div class="flex-grow-1 ml-3">
                        <h3 class="m-0 p-0">Category</h3>
                        <p class="m-0 p-0 text-muted">Update data category </p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection
