@extends('home')

@section('style')
@endsection
<style>
    .info-box-icon {
        border-radius: 5px;
        align-items: center;
        display: flex;
        padding: 5px;
        font-size: 2.5rem;
        justify-content: center;
    }

    .info-box-text {
        display: block;
        font-size: 21px;
        margin-top: .776rem;
        margin-left: .776rem;
    }

    .box-body {
        padding: 1rem;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        border-radius: 10px;
    }

    .card-master {
        cursor: pointer;
        transition: all 0.7s;
    }

    .card-master:hover {
        transform: scale(1.07) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }

    .mt-30 {
        margin-top: 30px;
    }

    .me-15 {
        margin-right: 15px !important;
    }

    .h-50 {
        height: 50px !important;
    }

    .w-50 {
        width: 50px !important;
    }

    .l-h-50 {
        line-height: 3.0714285714rem !important;
    }

    .rounded {
        border-radius: .25rem !important;
    }

    @media (max-width: 767px) {
        .small-box {
            text-align: center;
        }

        .small-box .icon {
            display: none;
        }

        .small-box p {
            font-size: 0.8571rem;
        }
    }

    .box {
        position: relative;
        margin-bottom: 1.5rem;
        width: 100%;
        background-color: #ffffff !important;
        border-radius: 15px;
        padding: 0px;
        -webkit-transition: .5s;
        transition: .5s;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05);
        box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05);
    }
    }

</style>

@section('content')
<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title"> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="row mx-lg-100 mt-20">

                        <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('users.index') }}'">
                            <div class="box card-master">
                                <div class="box-body p-10">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-secondary h-50 w-50 l-h-50 rounded text-center">
                                            <img src="{{ asset('assets/images/icon/user.png') }}" style="height: 26px"
                                                alt="">
                                        </div>
                                        <div class="d-flex flex-column fw-500">
                                            <span class="text-dark fs-14">User</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('departement.index') }}'">
                            <div class="box card-master">
                                <div class="box-body p-10">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-secondary h-50 w-50 l-h-50 rounded text-center">
                                            <img src="{{ asset('assets/images/icon/departement.png') }}"
                                                style="height: 26px" alt="">
                                        </div>
                                        <div class="d-flex flex-column fw-500">
                                            <span class="text-dark fs-14">Departement</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('material.index') }}'">
                            <div class="box card-master">
                                <div class="box-body p-10">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-secondary h-50 w-50 l-h-50 rounded text-center">
                                            <img src="{{ asset('assets/images/icon/material.png') }}"
                                                style="height: 26px" alt="">
                                        </div>
                                        <div class="d-flex flex-column fw-500">
                                            <span class="text-dark fs-14">Material</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
