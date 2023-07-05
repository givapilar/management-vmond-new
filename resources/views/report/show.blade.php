
<hr class="custom-hr">
<table class="table table-striped table-hover mb-0" id="departementTable">
    <thead>
        <tr>
            <th class="th-sm text-white">No</th>
            <th class="th-sm text-white">No Invoice</th>
            {{-- <th class="th-sm text-white">Nama</th>
            <th class="th-sm text-white">Qty</th>
            <th class="th-sm text-white">Total Price</th> --}}
        </tr>
    </thead>

    <tbody>
        @foreach ($orders as $item)
        {{ dd($item->name) }}
        <tr class="custom-tr">
            <td class="text-white">{{ $loop->iteration }}</td>
            <td class="text-white">{{ $order_pivot->invoice_no }}</td>
            {{-- <td class="text-white">{{ $order_pivot->nama }}</td>
            <td class="text-white">{{ $order_pivot->qty }}</td>
            <td class="text-white">{{ $order_pivot->total_price }}</td> --}}
        </tr>
        @endforeach
    </tbody>
</table>
