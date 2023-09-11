<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Receipt | Vmond Coffee & Eatery Space</title>
    <style>
        * {
            font-size: 14px;
            font-family: 'Times New Roman';
        }

        td, th, tr, table {
            border-top: 1px solid black;
            border-collapse: collapse;
            padding: 4px;
        }

        td.description, th.description {
            width: 120px;
            max-width: 120px;
        }

        td.quantity, th.quantity {
            width: 20px;
            max-width: 20px;
            word-break: break-all;
            text-align: center;
        }

        td.price, th.price {
            width: 80px;
            max-width: 80px;
            word-break: break-all;
            text-align: center;
        }

        .centered {
            text-align: center;
            align-content: center;
            margin: 0;
            font-weight: 400;
        }

        .ticket {
            width: 100%;
            text-align: center;
        }

        img {
            width: 100px;
        }

        @media print {
            .hidden-print, .hidden-print * {
                display: none !important;
            }
        }

        @page {
            size: 70mm 160mm;
            margin: 5;
        }

        .head__text {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            padding: 0;
        }

        .line {
            width: 100%;
            border-top: 1px dashed #3f3f3f;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .invoiceNumber {
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding-left: 5px;
            padding-right: 5px;
            text-align: left;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .invoiceNumber > div {
            font-weight: 400;
        }
    </style>
</head>
<body>
   
    <div class="ticket">
        {{-- <img src="{{ asset('assets/images/logo/logo-print.jpg') }}" alt="Logo"> --}}
        {{-- <div class="line"></div> --}}
        <h2 class="head__text">Vmond Coffee & Eatery Space
            <span class="centered">
                <br>Bundaran Ciater, Tanggerang Selatan
                <br>
            </span>
        </h2>
        <div class="line"></div>

        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                No. Invoice:
                <span style="float: right; margin-right: 15px;">#{{ $orders->invoice_no }}</span>
            </div>
        </div>

        @if ($orders->tipe_pemesanan == null)
            
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Metode Pembayaran:
                <span style="float: right; margin-right: 15px;"> {{ $orders->metode_pembayaran }}</span>
            </div>
        </div>
        @else
        
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Metode Pembayaran:
                <span style="float: right; margin-right: 15px;"> {{ $orders->metode_edisi }}</span>
            </div>
        </div>
        @endif
        
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Datetime:
                <span style="float: right; margin-right: 15px;">{{ $orders->created_at }}</span>
            </div>
        </div>
        <div class="line"></div>

        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Customer:
                <span style="float: right; margin-right: 15px;">{{ $orders->name }} </span>
            </div>
        </div>
        <div class="invoiceNumber">
            <div style="margin-left: 2px;">
                Table:
                @if($orders->kode_meja || $orders->category == 'Takeaway')
                    @if ($orders->category == 'Takeaway')
                        <span style="float: right; margin-right: 15px;"> {{ $orders->category }} {{ $orders->kode_meja ?? '' }}</span>
                    @else
                        <span style="float: right; margin-right: 15px;">{{ $orders->kode_meja ?? '' }}</span>
                    @endif
                @elseif($orders->biliard_id)
                    <span style="float: right; margin-right: 15px;">{{ $orders->tableBilliard->nama }}</span>    
                @elseif($orders->meeting_room_id)
                    <span style="float: right; margin-right: 15px;">{{ $orders->tableMeetingRoom->nama }}</span> 
                @endif   
            </div>
        </div>
        <div style="margin-bottom: 5px"></div>
        <table>
            <thead>
                <tr>
                    <th class="quantity">Qty</th>
                    <th class="description">Description</th>
                    <th class="price">Price</th>
                </tr>
            </thead>
            <tbody>

            @php
            
            $totalPrice = 0;
            @endphp
            {{-- Billiard  --}}
            
            @php
                $firstOrderBilliard = $orders->orderBilliard->first();
            @endphp

            @if ($orders->biliard_id)
                {{-- @foreach ($orders->orderBilliard as $order_billiard) --}}
                <tr>
                    <td class="quantity">{{ $firstOrderBilliard->qty ?? 0 }}</td>
                    <td class="description">{{ $firstOrderBilliard->paketMenu->nama_paket ?? '' }}</td>
                    <td class="price" style="text-align: right">Rp.{{ number_format($firstOrderBilliard->paketMenu->harga ?? 0,0) }}</td>
                </tr>
                {{-- @endforeach    --}}
            @else
                @foreach ($orders->orderPivotMinuman() as $orderPivot)
                    <tr>
                        <td class="quantity">{{ $orderPivot->qty }}</td>
                        <td class="description">{{ $orderPivot->restaurant->nama }}</td>
                        <td class="price" style="text-align: right">Rp.{{ number_format($orderPivot->restaurant->harga_diskon * $orderPivot->qty,0) }}</td>
                    </tr>
                    @php
                    // Calculate the running total for each item
                    $totalPrice += $orderPivot->restaurant->harga_diskon * $orderPivot->qty ;
                    @endphp

                @endforeach
            @endif
                
                <tr>
                    <td class="quantity"> &nbsp;</td>
                    <td class="description">&nbsp;</td>
                    <td class="price" style="text-align: right">&nbsp;</td>
                </tr>

                @if($orders->kode_meja || $orders->category == 'Takeaway')

                <tr>
                    <td class="quantity">&nbsp;</td>
                    <td class="description">Total</td>
                    {{-- <td class="price" style="text-align: right">Rp.{{ number_format($totalPrice,0) }}</td> --}}
                    <td class="price" style="text-align: right">Rp.{{ number_format($totalPrice,0) }}</td>
                </tr>

                <tr>
                    <td class="quantity"></td>
                    <td class="description">Layanan</td>

                    <td class="price" style="text-align: right">Rp.{{ number_format($orders->orderPivot->sum(function ($orderPivot) {
                        return $orderPivot->qty * $orderPivot->restaurant->harga_diskon;
                    }) * $other_setting->layanan/100,0 ) }}</td>
                </tr>

                <tr style="margin-top: 20px !important;">
                    <td class="quantity"></td>
                    <td class="description">PB01</td>
                    <td class="price" style="text-align: right">Rp.{{ number_format($orders->orderPivotMinuman()->sum(function ($orderPivot)use($other_setting) {
                        return $orderPivot->qty * $orderPivot->restaurant->harga_diskon + $orderPivot->qty * $orderPivot->restaurant->harga_diskon * $other_setting->layanan/100;
                    }) * $other_setting->pb01/100,0 ) }}</td>

                    {{-- Order Billiard --}}
                    {{-- <td class="price" style="text-align: right">Rp.{{ number_format($orders->orderBilliard->sum(function ($orderBilliard) {
                        return $orderBilliard->qty * $orderBilliard->restaurant->harga;
                    }) * $other_setting->pb01/100,0 ) }}</td> --}}
                    
                </tr>
                
                <tr>
                    <td class="quantity"></td>
                    <td class="description">Order Total</td>
                    <td class="price" style="text-align: right">Rp.{{ number_format(
                        $totalPrice +
                        $orders->orderPivot->sum(function ($orderPivot) {
                            return $orderPivot->qty * $orderPivot->restaurant->harga_diskon;
                        }) * $other_setting->layanan/100 +
                        $orders->orderPivotMinuman()->sum(function ($orderPivot) use ($other_setting) {
                            return $orderPivot->qty * $orderPivot->restaurant->harga_diskon + $orderPivot->qty * $orderPivot->restaurant->harga_diskon * $other_setting->layanan/100;
                        }) * $other_setting->pb01/100,
                        0
                    ) }}</td>
                </tr>

                @elseif($orders->biliard_id)

                {{-- order Billiard --}}
                <tr>
                    <td class="quantity">&nbsp;</td>
                    <td class="description">Total</td>
                    <td class="price" style="text-align: right">Rp.{{ number_format($firstOrderBilliard->paketMenu->harga ?? 0,0) }}</td>
                </tr>

                <tr>
                    <td class="quantity"></td>
                    <td class="description">Layanan</td>

                    <td class="price" style="text-align: right">
                        @if ($firstOrderBilliard)
                            @php
                                $totalPrice = $firstOrderBilliard->paketMenu->harga * ($other_setting->layanan / 100);
                            @endphp
                            Rp.{{ number_format($totalPrice, 0) }}
                        @endif
                    </td>
                </tr>

                <tr style="margin-top: 20px !important;">
                    <td class="quantity"></td>
                    <td class="description">PB01</td>
                    <td class="price" style="text-align: right">
                        @if ($firstOrderBilliard)
                            @php
                                $totalPrice = $firstOrderBilliard->paketMenu->harga * ($other_setting->pb01 / 100);
                            @endphp
                            Rp.{{ number_format($totalPrice, 0) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="quantity"></td>
                    <td class="description">Order Total</td>
                    {{-- Order Billiard --}}
                    <td class="price" style="text-align: right">Rp.{{ number_format($orders->total_price,0) }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="line"></div>
        <p class="centered" style="margin-top: 10px; font-weight: 600;">Thanks for your purchase!</p>
        <div class="line"></div>
    </div>
</body>
</html>