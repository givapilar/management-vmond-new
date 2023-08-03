<!DOCTYPE html>
<html>
<head>
    <title>Struk</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
   body {
    font-family: Arial, sans-serif;
    font-size: 12px;
}

#invoice {
    width: 70mm;
    margin: 0 auto;
    padding: 10px;
    /* border: 1px solid #000; */
}

#header {
    text-align: center;
}

#header h1 {
    margin: 0;
    font-size: 16px;
}

#content {
    margin-top: 20px;
}

h2 {
    margin: 0;
    font-size: 14px;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #000;
    padding: 5px;
}

.total-label {
    text-align: right;
}

.total-value {
    font-weight: bold;
}

#footer {
    margin-top: 20px;
    text-align: center;
    font-size: 10px;
}

/* Custom styles for roll paper size */
@page {
    size: 70mm 150mm;
    margin: 0;
}

@media print {
    body {
        margin: 0;
        padding: 0;
        width: 70mm;
        height: 297mm;
    }

    #invoice {
        border: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: avoid;
    }

    th, td {
        /* border: 1px solid #000; */
        padding: 5px;
    }
}

.table-top{
    margin-top: 20px;
}
</style>
<body>
    <div id="invoice">
        <div id="header">
            <h1>Vmond Coffee & Entry Space</h1>
            <p>Bundaran Ciater,Tanggerang Selatan</p>
        </div>
        <div id="content">
                {{-- {{ dd($orders) }} --}}
            <h2>#Inv{{ $orders->invoice_no }}</h2>
            {{-- @foreach ($orders as $item) --}}
            {{-- {{ dd($orderPivot) }} --}}
            <table class="table-top">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                @foreach ($orders->orderPivotMakanan() as $orderPivot)

                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $orderPivot->restaurant->nama }}</td>
                        <td>{{ $orderPivot->qty }}</td>
                        <td>{{ $orderPivot->restaurant->harga }}</td>
                        <td>{{ $orderPivot->qty * $orderPivot->restaurant->harga }}</td>
                    </tr>
                </tbody>

                {{-- <tr>
                    <td>2</td>
                    <td>Produk B</td>
                    <td>1</td>
                    <td>$15</td>
                    <td>$15</td>
                </tr> --}}
                @endforeach
                <tr>
                    <td colspan="4" class="total-label">Total</td>
                    {{-- <td class="total-value">{{ sum($orderPivot->harga) }}</td> --}}
                    <td class="total-value">Rp.{{ $orders->orderPivotMakanan()->sum(function ($orderPivot) {
                        return $orderPivot->qty * $orderPivot->restaurant->harga;
                    }) }}</td>
                </tr>
            </table>

        </div>
        <div id="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
        </div>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
