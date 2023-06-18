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
        @foreach ($order_table as $item)
        {{-- {{ dd($item->orderPivot->restaurant) }} --}}
        @if ($item->status_pembayaran =='Paid')
        @php
            // $pivotCount = $item->orderPivot->count();
            // $pivotChecked = $item->orderPivot->where('status_pemesanan', 'Selesai')->count();
            $pivotCount = $item->count();
            $pivotChecked = $item->where('status_pembayaran', 'Paid')->count();
        @endphp
        <div class="col">
            <div class="card h-100 border-r-20">
                <div class="card-header border-rt-20">
                    <a data-bs-toggle="modal" data-bs-target="#bartender-modal{{ $item->code }}" href="{{ route('bartender.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark">
                        <h5 class="card-title text-center pt-1 fw-bolder">#Ord{{ $item->invoice_no }}</h5>
                    </a>
                </div>
                <div class="card-body py-1 px-1">
                    <div class="scroll-style">
                        <ul class="list-group list-group-flush">
                            @foreach ($item->orderPivot as $order_pivot)
                            @if ($order_pivot->restaurant->category == 'Minuman')

                            <li class="list-group-item d-flex justify-content-start align-items-center p-2">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_pivot->id }}')" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_pivot->id }}" {{ ($order_pivot->status_pemesanan == 'Selesai') ? 'checked' : '' }}>
                                </div>
                                <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0">1.</h5>
                                </div>
                                <div class="d-flex flex-grow-1 bd-highlight">
                                    <h5 class="p-0 m-0 fw-semi-bold menu-1">
                                        {{ $order_pivot->restaurant->nama }}
                                    </h5>
                                    {{-- <span class="text-wrap fs-5">
                                        Note: Pedas, No Acar.
                                    </span> --}}
                                </div>
                            </li>
                            @endif
                            @endforeach
                            {{-- <li class="list-group-item d-flex justify-content-start align-items-start">
                                <div class="flex-shrink-1">
                                    <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="confirmDataAll('{{ $item->id }}')" aria-label="..." id="">
                                </div>
                                <div class="flex-shrink-1">
                                    <h5 class="me-2 mb-0"></h5>
                                </div>
                                <div class="d-flex flex-column bd-highlight">
                                    <h5 class="p-0 m-0 menu-1">
                                        {{ $item->name }}
                                    </h5>
                                    <small class="text-wrap">
                                        Note: Less Sugar.
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
        </div>
        @endif
        @include('process.bartender.modal')
        @endforeach
    </div>
</section>
@include('process.bartender.modal')
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function confirmDataAll(id) {
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
                        axios.post('{{ route("bartender.status-bartender-dashboard-all") }}', {
                            id
                        })
                        .then(response => {
                            alert('Berhasil Diupdate');
                            location.reload();
                        })
                        .catch(error => {
                            alert(error.response.data);
                        });
                    }
                },
                close: function () {
                    $('#checkDetail'+id).prop("checked", false);
                    event.preventDefault(); // prevent the checkbox from being checked
                }
            }
        });
    }

    function confirmData(id) {
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
                        axios.post('{{ route("bartender.status-dashboard") }}', {
                            id
                        })
                        .then(response => {
                            alert('Berhasil Diupdate');
                            location.reload();
                        })
                        .catch(error => {
                            alert(error.response.data);
                        });
                    }
                },
                close: function () {
                    $('#checkDetail'+id).prop("checked", false);
                    event.preventDefault(); // prevent the checkbox from being checked
                }
            }
        });
    }
    // function checkedModal(id, data) {
    //     $.confirm({
    //         icon: 'glyphicon glyphicon-heart',
    //         title: 'Warning!',
    //         content: 'Apakah anda yakin?',
    //         type: 'red',
    //         typeAnimated: true,
    //         buttons: {
    //             yes: {
    //                 text: 'Yes',
    //                 btnClass: 'btn-red',
    //                 action: function(){
    //                     $('.checkbox-'+id).prop("checked", data);

    //                     // Is True
    //                     if (data) return $('.menu-'+id).addClass('text-decoration-line-through');
    //                     // Is False
    //                     $('.menu-'+id).removeClass('text-decoration-line-through');
    //                 }
    //             },
    //             close: function () {
    //                 $('.checkbox-'+id).prop("checked", !data);
    //                 event.preventDefault(); // prevent the checkbox from being checked
    //             }
    //         }
    //     });
    // }


    // for (let i = 1; i <= 5; i++) {
    //     $('.checkbox-'+i).click( function() {
    //         // Condition is false
    //         if (!$(this).is(':checked')) return checkedModal(i,false);

    //         // Condition is true
    //         checkedModal(i,true);

    //         // if ($(this).is(':checked')) {
    //         //     checkedModal(i,true);
    //         // }else{
    //         //     checkedModal(i,false);
    //         // }
    //     });
    // }
</script>
@endpush
