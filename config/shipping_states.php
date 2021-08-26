<?php
/**
 * Class ${NAME}
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 29/11/20 22:52
 */


return [
    [
        'CODE' => 'PRODUCT_ORDER_CONFIRMED',
        'NAME' => 'Confirmado',
        'DESCRIPTION' => 'Compra confirmada',
        'ROL' => [
            'role:admin',
            'role:provider',
        ]
    ],
    [
        'CODE' => 'PACKED',
        'NAME' => 'Empacado',
        'DESCRIPTION' => 'Compra Empacada',
        'ROL' => [
            'role:admin',
            'role:provider'
        ]
    ],
    [
        'CODE' => 'ASSIGNED',
        'NAME' => 'Asignado',
        'DESCRIPTION' => 'Generación de Delivery Order',
        'ROL' => [
            'role:admin'
        ]
    ],
    [
        'CODE' => 'COLLECTED',
        'NAME' => 'Recolectado',
        'DESCRIPTION' => 'Producto recolectado',
        'ROL' => [
            'role:admin',
            'role:distributor'
        ]
    ],
    [
        'CODE' => 'ON_ROAD',
        'NAME' => 'En camino',
        'DESCRIPTION' => 'En camino al domicilio de entrega',
        'ROL' => [
            'role:admin',
            'role:distributor'
        ]
    ],
    [
        'CODE' => 'AVAILABLE_IN_NODE',
        'NAME' => 'En nodo',
        'DESCRIPTION' => 'Disponible en Nodo',
        'ROL' => [
            'role:admin',
            'role:distributor'
        ]
    ],
    [
        'CODE' => 'DELIVERED_TO_CUSTOMER',
        'NAME' => 'Entregado',
        'DESCRIPTION' => 'Entregado al comprador',
        'ROL' => [
            'role:admin',
            'role:distributor'
        ]
    ],
    [
        'CODE' => 'NOT_DELIVERED',
        'NAME' => 'No entregado',
        'DESCRIPTION' => 'No Entregado al comprador',
        'ROL' => [
            'role:admin',
            'role:distributor'
        ]
    ],
    [
        'CODE' => 'RETURNED_TO_NODE',
        'NAME' => 'Devuelto a nodo',
        'DESCRIPTION' => 'Producto Devuelto al Nodo',
        'ROL' => [
            'role:admin',
            'role:distributor'
        ]
    ],
    [
        'CODE' => 'WITHDRAWN_BY_CUSTOMER',
        'NAME' => 'Retirado',
        'DESCRIPTION' => 'Producto retirado por el comprador',
        'ROL' => [
            'role:admin',
            'role:provider'
        ]
    ],
    [
        'CODE' => 'NOT_WITHDRAWN_BY_CUSTOMER',
        'NAME' => 'No retirado',
        'DESCRIPTION' => 'Producto no retirado por el comprador',
        'ROL' => [
            'role:admin',
            'role:provider'
        ]
    ],
    [
        'CODE' => 'ACCEPTED',
        'NAME' => 'Aceptado',
        'DESCRIPTION' => 'Producto recibido y aceptado',
        'ROL' => [
            'role:admin',
            'role:provider',
            'role:client'
        ]
    ],
    [
        'CODE' => 'PENDING_PAYMENT',
        'NAME' => 'Pago pendiente',
        'DESCRIPTION' => 'El pago esta pendiente de ser procesado.',
        'ROL' => [
            'role:admin'
        ]
    ],
    [
        'CODE' => 'REJECTED_PAYMENT',
        'NAME' => 'Pago rechazado',
        'DESCRIPTION' => 'El pago fue rechazado.',
        'ROL' => [
            'role:admin'
        ]
    ],
    [
        'CODE' => 'CLOSED',
        'NAME' => 'Finalizado',
        'DESCRIPTION' => 'Circuito de compra cerrada',
        'ROL' => [
            'role:admin',
            'role:provider'
        ]
    ],
];
