<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<style>
    * {
        margin: 0;
        padding: 0;
        font-size: 8px;
    }

    .row{
        height: 70mm;
    }

    .first-row{
        margin-top: 10mm
    }

    /* Set additional styling options for the columns*/
    .column {
        float: left;
        width: 99mm;
        height: 70mm;
        overflow: hidden;
    }

    .left-col{
        margin-right: 2mm;
        margin-left: 4mm;
    }

    .right-col{
        margin-left: 2mm;
        margin-right: 4mm;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    body {
        font-family: DejaVu Sans, serif;
    }

    .page_break {
        page-break-before: always;
    }

    table {
        font-size: 8px;
        margin: 0 2mm 2mm 2mm;
        width: 100%;
    }

    .imgWrapper{
        margin-left: 3mm; 
        margin-top: 8mm;
        position: relative;
    }

    th {
        text-align: left;
        width: 15mm;
    }

    td {
        word-wrap: break-word;         /* All browsers since IE 5.5+ */
        overflow-wrap: break-word;     /* Renamed property in CSS3 draft spec */
    }
    .qr{
        height: 21mm;
    }
    .logo{
        height: 60px; 
        top: 15px; 
        position: absolute;
    }
    .marginTop{
        min-height: 10mm;
        max-height: 10mm;
        font-size: 10mm;
        overflow: hidden;
        width: 100%;
        background-color: white;
        background: white;
        padding: 0;
        margin: 0;
        color: white;
    }
</style>

@foreach($orders as $i=>$order)
    @php($qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(200)->errorCorrection('H')->generate($order->shipping->shippingCode)))
    
    @if(($i+1)%2 != 0)
        @php($col = "left-col")
    @else
        @php($col = "right-col")
    @endif


    @if($i % 8 == 0)
        <div class="marginTop">AA</div>
    @endif

    @if($i % 2 != 0)
        <div class="row">
    @endif
            <div class="column {!! $col !!}">
                <div class="imgWrapper">
                    <img class="qr" src="data:image/png;base64, {!! $qrCode !!}">
                    <img class="logo" src="../public/assets/images/logo.png" />
                </div>
                <table>
                    <tr>
                        <th>Artículo:</th>
                        <td>{{ $order->shipping->product }}</td>
                        <th>Cantidad:</th>
                        <td>{{ $order->shipping->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Proveedor:</th>
                        <td>{{ $order->shipping->providerName }}</td>
                        <th>Retirar en:</th>
                        <td>{{ $order->shipping->providerAddress }}</td>
                    </tr>
                    <tr>
                        <th>Cliente:</th>
                        <td>{{ $order->shipping->clientName }}</td>
                        <th>Entregar en:</th>
                        <td>@if ($order->shipping->deliveryType == 'delivery') {{ $order->shipping->customerDeliveryAddress }} @else {{ $order->shipping->node->streetName }} @endif</td>
                    </tr>
                    <tr>
                        <th>Fecha de entrega:</th>
                        <td>{{ date('d/m/Y', strtotime($order->shipping->estimatedDeliveryDate )) }}</td>
                    </tr>
                </table>
            </div>
            @if($i % 2 != 0)
        </div>
    @endif
@endforeach
