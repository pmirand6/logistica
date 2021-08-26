<div>
    <p>
        {{ $orders[0]->driver->name }} {{ $orders[0]->driver->lastName }}:
        <br>
        Te remitimos la hoja de ruta del día {{ date('d/m/Y', strtotime($orders[0]->created_at)) }}.
    </p>
    <table style="border-collapse: collapse; width: 100%;" border="1">
        <tbody>
        <tr>
            <th>Pedido</th>
            <th>Orden de Trabajo</th>
            <th>Producto</th>
            <th>Unidades</th>
            <th>Requiere Frío</th>
            <th>Domicilio Origen</th>
            <th>Domicilio Destino</th>
            <th>Modalidad de Entrega</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td> {{ $order->shipping->shippingCode }} </td>
                <td> {{ $order->orderCode }} </td>
                <td> {{ $order->shipping->product }} </td>
                <td> {{ $order->shipping->quantity }} </td>
                <td> @if ($order->shipping->requiresCold == 1) Si @else No @endif </td>
                <td> {{ $order->shipping->providerAddress }} </td>
                <td> @if ($order->shipping->deliveryType == 'delivery') {{ $order->shipping->customerDeliveryAddress }} @else {{ $order->shipping->node->streetName }} @endif </td>
                <td> @if ($order->shipping->deliveryType == 'delivery') A Domicilio @else Nodo @endif </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p>
        Un cordial saludo.
        <br>
        Equipo Feriame.
    </p>
</div>
