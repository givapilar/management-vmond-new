{{-- Modal --}}
<div class="modal fade" id="modal-bartender{{ $item->code }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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
                    @foreach ($item->orderPivot as $order_pivot)
                        @if (($order_pivot->restaurant->category ?? '') == 'Minuman')
                            <div class="mt-3"></div>
                            <div class="accordion" id="accordion-{{ $order_pivot->restaurant->id }}" style="border-radius: 10px !important; ">
                                <div class="accordion-item" style="border-radius: 10px !important; background-color: #5e5e5e54 !important;">
                                  <h2 class="accordion-header" id="heading-{{ $order_pivot->restaurant->id }}" style="border-radius: 10px !important;">
                                    <button class="accordion-button collapsed text-wrap fs-2 fw-bold" style="border-radius: 10px !important; background-color: #5e5e5e00 !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $order_pivot->restaurant->id }}" aria-expanded="false" aria-controls="collapse-{{ $order_pivot->restaurant->id }}">
                                        {{ $order_pivot->restaurant->nama ?? '' }}
                                    </button>
                                  </h2>
                                  <div id="collapse-{{ $order_pivot->restaurant->id }}" style="border-radius: 10px !important; background-color: #5e5e5e00 !important;" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion-{{ $order_pivot->restaurant->id }}">
                                    <div class="accordion-body">
                                    @if (count($order_pivot->orderAddOn) != 0)
                                        @foreach ($order_pivot->orderAddOn as $oad)
                                            <div class="flex-shrink-1 mt-3" style="border-top:1px solid #000;">
                                                <h3 class="me-2 mt-3">{{ $loop->iteration }}.
                                                    {{ $oad->addOn->title ?? '' }}
                                                </h3>
                                            </div>
                                            <li class="list-group-item d-flex justify-content-start align-items-start bg-transparent border-0 mb-0 pt-0 pb-0">
                                                <div class="d-flex flex-column bd-highlight">
                                                    <span class="text-wrap fs-5">
                                                        Note: {{ $oad->addOnDetail->nama ?? '' }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                    <div class="flex-shrink-1 mt-3" style="border-top:1px solid #000;">
                                        <h3 class="me-2 mt-3">1.
                                            Tidak Ada Note
                                        </h3>
                                    </div>
                                    <li class="list-group-item d-flex justify-content-start align-items-start bg-transparent border-0 mb-0 pt-0 pb-0">
                                        <div class="d-flex flex-column bd-highlight">
                                            <span class="text-wrap fs-5">
                                                Note: -
                                            </span>
                                        </div>
                                    </li>
                                    @endif
                                    </div>
                                  </div>
                                </div>
                              </div>
                            
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
