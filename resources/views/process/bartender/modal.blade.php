{{-- Modal --}}
<div class="modal fade" id="bartender-modal{{ $item->code }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="flex-grow-1 text-center">
                    <h2 class="modal-title" id="exampleModalLabel">Detail Order <span class="text-danger">#Ord{{ $item->invoice_no }}</span></h2>
                </div>
                <div class="flex-shrink-1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush pe-3">
                    {{-- <li class="list-group-item d-flex justify-content-start align-items-start">
                        <div class="flex-shrink-1">
                            <input class="form-check-input me-2 checkbox-1 p-2 mt-1" type="checkbox" value="" aria-label="..." id="">
                        </div>
                        <div class="flex-shrink-1">
                            <h3 class="me-2 mb-0">1.</h3>
                        </div>
                        <div class="d-flex flex-column bd-highlight">
                            <h3 class="p-0 m-0 fw-semi-bold menu-1">
                                Jus Jeruk
                            </h3>
                            <span class="text-wrap fs-5">
                                Note: Less sugar.
                            </span>
                        </div>
                    </li> --}}

                    @foreach ($item->orderPivot as $order_pivot)
                    @if ($order_pivot->restaurant->category == 'Minuman')
                        
                    <li class="list-group-item d-flex justify-content-start align-items-start">
                        <div class="flex-shrink-1">
                            <input class="form-check-input me-2 p-2 mt-1" onchange="confirmData('{{ $order_pivot->id }}')" type="checkbox" value="" aria-label="..." id="checkDetail{{ $order_pivot->id }}" {{ ($order_pivot->status_pemesanan == 'Selesai') ? 'checked disabled' : '' }}>
                        </div>
                        <div class="flex-shrink-1">
                            <h3 class="me-2 mb-0">1.</h3>
                        </div>
                        <div class="d-flex flex-column bd-highlight">
                            <h3 class="p-0 m-0 fw-semi-bold menu-1">
                                {{ $order_pivot->restaurant->nama }}
                            </h3>
                            <span class="text-wrap fs-5">
                                Note: Pedas, No Acar.
                            </span>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <span class="badge bg-success fs-6">Success</span>
                <span class="text-muted">Last updated 3 mins ago</span>
            </div>
        </div>
    </div>
 </div>
 {{-- End Modal --}}
