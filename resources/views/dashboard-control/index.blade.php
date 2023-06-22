@extends('home')

@section('style')
<style>
.testimonial-card .card-up {
  height: 80px;
  overflow: hidden;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

.aqua-gradient {
  background: linear-gradient(40deg, #2096ff, #05ffa3) !important;
  border-radius: 0 0 20px 20px;
}

.testimonial-card .avatar {
  width: 120px;
  margin-top: -60px;
  overflow: hidden;
  border: 5px solid #fff;
  border-radius: 50%;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="card p-3" style="border-radius: 15px;">
        <div class="d-flex justify-content-between">
            <h3 class="mt-1">{{ strtoupper($page_title) }}</h3>

            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambah-controller">Add Control</button>
        </div>
    </div>

    <div class="row">
        @foreach ($meja_controls as $item)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card testimonial-card mt-3 mb-3 position-relative rounded-20 p-2  position-relative">
                <div class="card-header rounded-t-20 pt-1 pl-2 pb-0 pr-2">
                    <h4 class="text-center mb-3">{{ strtoupper($item->Billiard->nama) }}</h4>
                </div>

                <div class="card-body  bg-gray-800 rounded-20 p-3 text-center">
                    <div class="form-group">
                        <select name="status_lamp{{ $item->id }}" id="status_lamp{{ $item->id }}" class="form-control">
                            <option value="true" selected>ON</option>
                            <option value="false">OFF</option>
                        </select>
                    </div>

                    <button class="btn btn-md bg-primary p-2 w-100" onclick="postDataAPI('{{ $item->id }}','{{ $item->Billiard->nama }}', '{{ route('dashboard-control') }}', {{ $item->address }})">Submit</button>

                </div>
                <div class="position-absolute" style="top:10px; right:10px;">
                    <div class="dropdown">
                        <button class="btn btn-transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis d-block mx-auto"></i>
                            {{-- <i class="fa-solid fa-gear d-block mx-auto"></i> --}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-controller-{{ $item->id }}">Edit</a>
                          <a class="dropdown-item" href="#"  onclick="modalDelete('Controller', '{{ $item->Billiard->nama }}', '/dashboard-control/' + {{ $item->id }}, '/dashboard-control/')">Delete</a>
                        </div>
                    </div>
                    @include('dashboard-control.edit')
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('dashboard-control.create')
@endsection

@section('javascript')
<script>
    function postDataAPI(id, title, link, address) {
        let dataSelected = $('#status_lamp'+id).find(":selected").val();
        $.confirm({
            title: `Control ${title}?`,
            content: `Are you sure want to control ${title}`,
            autoClose: 'cancel|8000',
            buttons: {
                yes: {
                    text: 'Yes',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: "http://localhost:3000/v1/api-control-lamp",
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "addr":address,
                                "val": (dataSelected == 'true') ? true : false
                            },
                            success: function (data) {
                                // window.location.href = link
                                Toastify({
                                    text: "Control successfully!",
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "#D5F3E9",
                                        color: "#1f7556"
                                    },
                                    duration: 3000
                                }).showToast();
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });
    }
</script>
@endsection
