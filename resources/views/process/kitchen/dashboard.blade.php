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
        @foreach ($orders as $item)
        {{-- {{ dd($item->orderBilliard) }} --}}
        @php
            $orderPivotMakananCount = $item->orderPivotMakanan()->count();
            $orderMeetingMakananTimeCount = $item->orderMeetingMakananTime($current_time)->count();
            $orderBilliardMakananTimeCount = $item->orderBilliardMakananTime($current_time)->count();
            
            $orderPivotMakananDoneCount = $item->orderPivotMakananDone()->count();
            $orderMeetingMakananTimeDoneCount = $item->orderMeetingMakananTimeDone($current_time)->count();
            $orderBilliardMakananTimeDoneCount = $item->orderBilliardMakananTimeDone($current_time)->count();

        @endphp
        @if (($orderPivotMakananCount != 0 && ($orderPivotMakananDoneCount < $orderPivotMakananCount)) || ($orderMeetingMakananTimeCount != 0 && ($orderMeetingMakananTimeDoneCount < $orderMeetingMakananTimeCount)) || ($orderBilliardMakananTimeCount != 0 && ($orderBilliardMakananTimeDoneCount < $orderBilliardMakananTimeCount)))
            <div class="col">
                <div class="card h-100 border-r-20">
                    <div class="card-header border-rt-20">
                        {{-- <a data-bs-toggle="modal" data-bs-target="#modal-{{ $item->code }}" href="{{ route('kitchen.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark"> --}}
                            {{-- {{ dd($item->user) }} --}}
                            <h5 class="card-title text-center pt-1 fw-bolder">#{{ $item->invoice_no }} </h5>
                            <h5 class="card-title text-center pt-1 fw-bolder">
                                (Meja 
                                @if($item->meja_restaurant_id || $item->category == 'Takeaway' )
                                    @if ($item->category == 'Takeaway')
                                        {{ $item->category }}
                                        {{ $item->tableRestaurant->nama ?? ''}}
                                    
                                    @else
                                        {{ $item->tableRestaurant->nama ?? ''}}
                                    @endif
                                @elseif($item->biliard_id)
                                    {{ $item->tableBilliard->nama }}    
                                @elseif($item->meeting_room_id)
                                    {{ $item->tableMeetingRoom->nama }} 
                                @endif
                            )
                            </h5>
                        {{-- </a> --}}
                    </div>
                    <div class="card-body py-1">
                        <div class="scroll-style">
                            <ul class="list-group list-group-flush pe-3">
                                @foreach ($item->orderPivotMakanan() as $orderPivot)
                                <li class="list-group-item d-flex justify-content-start align-items-start">
                                    <div class="flex-shrink-1">
                                        @if ($orderPivot->status_pemesanan == 'Selesai')
                                            <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="removeData('{{ $orderPivot->id }}', 'pivot')"  id="" {{ $orderPivot->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                        @else
                                            <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="confirmData('{{ $orderPivot->id }}', 'pivot')"  id="" {{ $orderPivot->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column bd-highlight">
                                        <h5 class="p-0 m-0 menu-1 {{ $orderPivot->status_pemesanan == 'Selesai' ? 'text-decoration-line-through' : '' }}">
                                            {{ $orderPivot->restaurant->nama }}
                                            ({{ $orderPivot->qty }}) 
                                        </h5>

                                        <span class="text-wrap fs-5">
                                            <h5 class="flex-shrink-1 mt-1" style="font-size: 14px">
                                                @if (count($orderPivot->orderAddOn) != 0)
                                                    @foreach ($orderPivot->orderAddOn as $oad)
                                                        <span class="fw-bold">{{ $oad->addOn->title ?? '' }}</span>:
                                                        {{ $oad->addOnDetail->nama ?? '' }} | 
                                                    @endforeach
                                                @else
                                                    
                                                @endif
                                            </h5>
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                                @foreach ($item->orderMeetingMakananTime($current_time) as $orderMeeting)
                                    <li class="list-group-item d-flex justify-content-start align-items-start">
                                        <div class="flex-shrink-1">
                                            @if ($orderMeeting->status_pemesanan == 'Selesai')
                                                <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="removeData('{{ $orderMeeting->id }}', 'meeting')"  id="" {{ $orderMeeting->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                            @else
                                                <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="confirmData('{{ $orderMeeting->id }}', 'meeting')"  id="" {{ $orderMeeting->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column bd-highlight">
                                            <h5 class="p-0 m-0 menu-1 {{ $orderMeeting->status_pemesanan == 'Selesai' ? 'text-decoration-line-through' : '' }}">
                                                {{ $orderMeeting->restaurant->nama }}
                                                (x{{ $orderMeeting->qty }}) 

                                            </h5>
                                            
                                        </div>
                                    </li>
                                @endforeach
                                @foreach ($item->orderBilliardMakananTime($current_time) as $orderBilliard)
                                    <li class="list-group-item d-flex justify-content-start align-items-start">
                                        <div class="flex-shrink-1">
                                            @if ($orderBilliard->status_pemesanan == 'Selesai')
                                                <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="removeData('{{ $orderBilliard->id }}', 'billiard')"  id="" {{ $orderBilliard->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                            @else
                                                <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="confirmData('{{ $orderBilliard->id }}', 'billiard')"  id="" {{ $orderBilliard->status_pemesanan == 'Selesai' ? 'checked' : '' }}>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column bd-highlight">
                                            <h5 class="p-0 m-0 menu-1 {{ $orderBilliard->status_pemesanan == 'Selesai' ? 'text-decoration-line-through' : '' }}">
                                                {{ $orderBilliard->restaurant->nama }}
                                                (x{{ $orderBilliard->qty }}) 

                                            </h5>

                                            <span class="text-wrap fs-5">
                                                <h5 class="flex-shrink-1 mt-1" style="font-size: 14px">
                                                    @if (count($orderBilliard->orderAddOn) != 0)
                                                        @foreach ($orderBilliard->orderAddOn as $oad)
                                                            <span class="fw-bold">{{ $oad->addOn->title ?? '' }}</span>:
                                                            {{ $oad->addOnDetail->nama ?? '' }} | 
                                                        @endforeach
                                                    @else
                                                        Note: -
                                                    @endif
                                                </h5>
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer border-rb-20">
                        <a href="{{ route('kitchen.dashboard-detail-kitchen.show',$item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger rounded-lg p-2 mt-1 w-100">Print</a>
                        {{-- <span class="badge bg-danger">Print</span> --}}
                        {{-- <small class="text-muted">Last updated <span class="text-danger">3 mins ago</span></small> --}}
                        <small class="text-muted">Last updated <span class="text-danger">{{ $item->elapsed_time }}</span></small>

                        
                    </div>
                </div>
                @include('process.kitchen.modal')

            </div>
        @endif
        @endforeach

        {{-- Billiard --}}
        
        {{-- @foreach ($order_table as $item)
            @if ($item->status_pembayaran == 'Paid')
                    @php
                        $pivotCount = $item->orderBilliard->count();
                        $pivotChecked = $item->orderBilliard->where('status_pemesanan', 'Selesai')->count();
                    @endphp
                    <div class="col">
                        <div class="card h-100 border-r-20">
                            <div class="card-header border-rt-20">
                                <a data-bs-toggle="modal" data-bs-target="#modal-{{ $item->id }}" href="{{ route('kitchen.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark">
                                    <h5 class="card-title text-center pt-1 fw-bolder">#{{ $item->invoice_no }}</h5>
                                </a>
                            </div>
                            <div class="card-body py-1">
                                <div class="scroll-style">
                                    <ul class="list-group list-group-flush pe-3">
                                        <li class="list-group-item d-flex justify-content-start align-items-start">
                                            <div class="flex-shrink-1">
                                                <input class="form-check-input me-2 p-2 mt-1 checkbox-1" type="checkbox" value="" onchange="confirmDataAll('{{ $item->id }}')" aria-label="..." id="" {{ ($pivotCount == $pivotChecked) ? 'checked disabled' : '' }}>
                                            </div>
                                            <div class="d-flex flex-column bd-highlight">
                                                <h5 class="p-0 m-0 menu-1 {{ ($pivotCount == $pivotChecked) ? 'text-decoration-line-through' : '' }}">
                                                    {{ $item->name }} tes
                                                </h5>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="card-footer border-rb-20">
                                <span class="badge bg-success">Success</span>
                                <small class="text-muted">Last updated <span class="text-danger">3 mins ago</span></small>
                            </div>
                        </div>
                        @include('process.kitchen.modal-billiard')
                    </div>
            @endif
        @endforeach --}}

    </div>
</section>
{{-- @if ($order_table->isNotEmpty())
    @include('process.kitchen.modal')
@endif --}}
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>

<script>
    // var socket = io('http://localhost:3000',{ transports: ["websocket"] });
    window.setTimeout( function() {
        window.location.reload();
    }, 5000);
    // socket.on('notif-order', (msg) => {
    //     console.log('DATA::',msg);
    // })
    // function checkedModal(id) {
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
    //                     // Is True
    //                    $('.menu-'+id).addClass('text-decoration-line-through');
    //                     // Is False
    //                     // $('.menu-'+id).removeClass('text-decoration-line-through');
    //                 }
    //             },
    //             close: function () {
    //                 // $('.checkbox-'+id).prop("checked", false);
    //                 event.preventDefault(); // prevent the checkbox from being checked
    //             }
    //         }
    //     });
    // }

    // function confirmDataAll(id) {
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
    //                     axios.post('{{ route("kitchen.status-dashboard-all") }}', {
    //                         id
    //                     })
    //                     .then(response => {
    //                         alert('Berhasil Diupdate');
    //                         location.reload();
    //                     })
    //                     .catch(error => {
    //                         alert(error.response.data);
    //                     });
    //                 }
    //             },
    //             close: function () {
    //                 $('#checkDetail'+id).prop("checked", false);
    //                 event.preventDefault(); // prevent the checkbox from being checked
    //             }
    //         }
    //     });
    // }

    function confirmData(id, type) {
        axios.post('{{ route("kitchen.status-dashboard") }}', {
            id,
            type
        })
        .then(response => {
            // console.log(response.data);
            // alert('Berhasil Diupdate');
            location.reload();
        })
        .catch(error => {
            alert(error.response.data);
        });
    }

    // function confirmData(id, type) {
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
    //                     axios.post('{{ route("kitchen.status-dashboard") }}', {
    //                         id,
    //                         type
    //                     })
    //                     .then(response => {
    //                         alert('Berhasil Diupdate');
    //                         location.reload();
    //                     })
    //                     .catch(error => {
    //                         alert(error.response.data);
    //                     });
    //                 }
    //             },
    //             close: function () {
    //                 $('#checkDetail'+id).prop("checked", false);
    //                 event.preventDefault(); // prevent the checkbox from being checked
    //             }
    //         }
    //     });
    // }
    
    function removeData(id, type) {
        axios.post('{{ route("kitchen.status-remove") }}', {
            id,
            type
        })
        .then(response => {
            // alert('Berhasil Diupdate');
            location.reload();
        })
        .catch(error => {
            alert(error.response.data);
        });
    }


//     function checkedModal(id, data) {
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
//                 action: function () {
//                     $('.checkbox-' + id).prop("checked", data);

//                     // AJAX request to save checkbox state
//                     $.ajax({
//                         url: '/save-checkbox-state/' + id,
//                         method: 'POST',
//                         data: {
//                             checked: data
//                         },
//                         success: function (response) {
//                             // Handle success response if needed
//                             if (response.success) {
//                                 if (data) {
//                                     return $('.menu-' + id).addClass('text-decoration-line-through');
//                                 } else {
//                                     $('.menu-' + id).removeClass('text-decoration-line-through');
//                                 }
//                             } else {
//                                 console.log('Failed to save checkbox state: ' + response.message);
//                             }
//                         },
//                         error: function (xhr, status, error) {
//                             console.log('AJAX request failed: ' + error);
//                         }
//                     });
//                 }
//             },
//             close: function () {
//                 $('.checkbox-' + id).prop("checked", !data);
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

    //         if ($(this).is(':checked')) {
    //             checkedModal(i,true);
    //         }else{
    //             checkedModal(i,false);
    //         }
    //     });
    // }
</script>
@endpush
