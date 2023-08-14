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
    .accordion-button:not(.collapsed){
        color:#000;
    }
</style>
@endpush

@section('content')
<section class="p-3">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($orders as $item)
        @php
            $orderPivotMinumanCount = $item->orderPivotMinuman()->count();
            $orderMeetingMinumanTimeCount = $item->orderMeetingMinumanTime($current_time)->count();
            $orderBilliardMinumanTimeCount = $item->orderBilliardMinumanTime($current_time)->count();
            
            $orderPivotMinumanDoneCount = $item->orderPivotMinumanDone()->count();
            $orderMeetingMinumanTimeDoneCount = $item->orderMeetingMinumanTimeDone($current_time)->count();
            $orderBilliardMinumanTimeDoneCount = $item->orderBilliardMinumanTimeDone($current_time)->count();

        @endphp
        @if (($orderPivotMinumanCount != 0 && ($orderPivotMinumanDoneCount < $orderPivotMinumanCount)) || ($orderMeetingMinumanTimeCount != 0 && ($orderMeetingMinumanTimeDoneCount < $orderMeetingMinumanTimeCount)) || ($orderBilliardMinumanTimeCount != 0 && ($orderBilliardMinumanTimeDoneCount < $orderBilliardMinumanTimeCount)))
            <div class="col">
                <div class="card h-100 border-r-20">
                    <div class="card-header border-rt-20">
                        {{-- <a data-bs-toggle="modal" data-bs-target="#modal-bartender{{ $item->code }}" href="{{ route('bartender.dashboard.detail',$item->id) }}" class="text-decoration-none text-dark"> --}}
                            {{-- {{ dd($item->user) }} --}}
                            <h5 class="card-title text-center pt-1 fw-bolder">#{{ $item->invoice_no }}</h5>
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
                                ) </h5>
                        {{-- </a> --}}
                    </div>
                    <div class="card-body py-1">
                        <div class="scroll-style">
                            <ul class="list-group list-group-flush pe-3">
                                @foreach ($item->orderPivotMinuman() as $orderPivot)
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
                                                    Note: -
                                                @endif
                                            </h5>
                                        </span>
                                        
                                    </div>
                                </li>
                            @endforeach
                                
                                @foreach ($item->orderMeetingMinumanTime($current_time) as $orderMeeting)
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
                                                ({{ $orderMeeting->qty }}) 
                                            </h5>
                                        </div>
                                    </li>
                                @endforeach

                                @foreach ($item->orderBilliardMinumanTime($current_time) as $orderBilliard)
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
                                                ({{ $orderBilliard->qty }}) 
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
                        <a href="{{ route('bartender.dashboard-detail-bartender.show',$item->id) }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger rounded-lg p-2 mt-1 w-100">Print</a>
                        <small class="text-muted">Last updated <span class="text-danger">{{ $item->elapsed_time }}</span></small>
                        {{-- <span class="badge bg-danger">Print</span>
                        
                        <small class="text-muted">Last updated <span class="text-danger">3 mins ago</span></small> --}}
                    </div>
                </div>
                @include('process.bartender.modal')
            </div>
        @endif
        @endforeach

    </div>
</section>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    window.setTimeout( function() {
        window.location.reload();
    }, 5000);
</script>
<script>
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
        axios.post('{{ route("bartender.status-dashboard") }}', {
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
        // $.confirm({
        //     icon: 'glyphicon glyphicon-heart',
        //     title: 'Warning!',
        //     content: 'Apakah anda yakin?',
        //     type: 'red',
        //     typeAnimated: true,
        //     buttons: {  
        //         yes: {
        //             text: 'Yes',
        //             btnClass: 'btn-red',
        //             action: function(){
        //                 axios.post('{{ route("bartender.status-dashboard") }}', {
        //                     id,
        //                     type
        //                 })
        //                 .then(response => {
        //                     alert('Berhasil Diupdate');
        //                     location.reload();
        //                     // console.log(response);
        //                 })
        //                 .catch(error => {
        //                     alert(error.message);
        //                 });
        //             }
        //         },
        //         close: function () {
        //             $('#checkDetail'+id).prop("checked", false);
        //             event.preventDefault(); // prevent the checkbox from being checked
        //         }
        //     }
        // });
    }
    
    function removeData(id, type) {
        axios.post('{{ route("bartender.status-remove") }}', {
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
        // $.confirm({
        //     icon: 'glyphicon glyphicon-heart',
        //     title: 'Warning!',
        //     content: 'Apakah anda yakin ingin membatalkan?',
        //     type: 'red',
        //     typeAnimated: true,
        //     buttons: {  
        //         yes: {
        //             text: 'Yes',
        //             btnClass: 'btn-red',
        //             action: function(){
        //                 axios.post('{{ route("bartender.status-remove") }}', {
        //                     id,
        //                     type
        //                 })
        //                 .then(response => {
        //                     alert('Berhasil Diupdate');
        //                     location.reload();
        //                 })
        //                 .catch(error => {
        //                     alert(error.response.data);
        //                 });
        //             }
        //         },
        //         close: function () {
        //             $('#checkDetail'+id).prop("checked", true);
        //             event.preventDefault(); // prevent the checkbox from being checked
        //         }
        //     }
        // });
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
