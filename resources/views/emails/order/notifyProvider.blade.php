<div>
    <p>
        <b>{{ $order->shipping->providerName }} :</b>
        <br><br>
        Hoy {{ date('d/m/Y', strtotime($order->created_at)) }} vamos a retirar {{ $order->shipping->quantity }} unidades del  producto {{ $order->shipping->product }} del pedido {{ $order->shipping->purchase_order->code }}.
        <br><br>
        Nos alegra tu venta en feriame y estamos orgullosos sobre tu crecimiento junto a nosotros.
        <br><br>
        Equipo de feriame.
    </p>
</div>
