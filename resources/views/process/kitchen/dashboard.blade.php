@extends('process.layouts.app')

@push('style-top')

@endpush

@push('style-bot')
<style>
    .form-check-input{
        width: 1.5rem !important;
        height: 1.5rem !important;
    }
     menu-1{
        font-weight: 600 !important;
    }
</style>
@endpush

@section('content')
<section class="p-3">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <div class="col">
            @foreach ($order_table as $item)
            @if ($item->status == 'Paid')
            <div class="card h-100 border-r-20">
                <div class="card-header border-rt-20">
                    <a data-bs-toggle="modal" data-bs-target="#modal-{{ $item->code }}" href="{{ route('kitchen.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark">
                        <h5 class="card-title text-center pt-1 fw-bolder">#{{ $item->invoice_no }}</h5>
                    </a>
                </div>
                <div class="card-body py-1">
                    <div class="scroll-style">
                        <ul class="list-group list-group-flush pe-3">
                            <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" aria-label="..." id="">
                                </div>
                                {{-- <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0">1.</h5>
                                </div> --}}
                                <div class="d-flex flex-column bd-highlight">
                                    <h5 class="p-0 m-0 menu-1">
                                        {{ $item->name }}
                                    </h5>
                                    {{-- <small class="text-wrap">
                                        Note: Pedas, No Acar.
                                    </small> --}}
                                </div>
                            </li>
                            {{-- <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1 checkbox-2" type="checkbox" value="" aria-label="..." id="">
                                </div>
                                <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0">2.</h5>
                                </div>
                                <div class="d-flex flex-column bd-highlight">
                                    <h5 class="p-0 m-0 menu-2">
                                        Mie Goreng Modern
                                    </h5>
                                    <small class="text-wrap">
                                        Note: Sedang
                                    </small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1 checkbox-3" type="checkbox" value="" aria-label="..." id="">
                                </div>
                                <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0">3.</h5>
                                </div>
                                <div class="d-flex flex-column bd-highlight">
                                    <h5 class="p-0 m-0 menu-3">
                                        Ayam Teriyaki
                                    </h5>
                                    <small class="text-wrap">
                                        Note: -
                                    </small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1 checkbox-4" type="checkbox" value="" aria-label="..." id="">
                                </div>
                                <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0">4.</h5>
                                </div>
                                <div class="d-flex flex-column bd-highlight">
                                    <h5 class="p-0 m-0 menu-4">
                                        French Fries
                                    </h5>
                                    <small class="text-wrap">
                                        Note: -
                                    </small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1 checkbox-5" type="checkbox" value="" aria-label="..." id="">
                                </div>
                               <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0">5.</h5>
                                </div>
                                <div class="d-flex flex-column bd-highlight">
                                    <h5 class="p-0 m-0 menu-5">
                                        Nasi Cup #1
                                    </h5>
                                    <small class="text-wrap">
                                        Note: Tidak pakai sambal Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id tenetur nam, modi totam natus ratione, vitae eaque praesentium reprehenderit, voluptatem quas. Eos minima, atque earum distinctio incidunt hic natus quos?
                                    </small>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                
                <div class="card-footer border-rb-20">
                    <span class="badge bg-success">Success</span>
                    <small class="text-muted">Last updated <span class="text-danger">3 mins ago</span></small>
                </div>
            </div>
            @include('process.kitchen.modal')

            @endif
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script>
    function checkedModal(id, data) {
        $.confirm({
            icon: 'glyphicon glyphicon-heart',
            title: 'Warning!',
            content: 'Apakah anda yakin?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function(){
                        $('.checkbox-'+id).prop("checked", data);

                        // Is True
                        if (data) return $('.menu-'+id).addClass('text-decoration-line-through');
                        // Is False
                        $('.menu-'+id).removeClass('text-decoration-line-through');
                    }
                },
                close: function () {
                    $('.checkbox-'+id).prop("checked", !data);
                    event.preventDefault(); // prevent the checkbox from being checked
                }
            }
        });
    }


    for (let i = 1; i <= 5; i++) {
        $('.checkbox-'+i).click( function() {
            // Condition is false
            if (!$(this).is(':checked')) return checkedModal(i,false);

            // Condition is true
            checkedModal(i,true);

            // if ($(this).is(':checked')) {
            //     checkedModal(i,true);
            // }else{
            //     checkedModal(i,false);
            // }
        });
    }
</script>
@endpush
