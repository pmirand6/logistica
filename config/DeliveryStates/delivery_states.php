<?php

return [
    'DELIVERY' => [
        'PENDING_PAYMENT' => [
            'NAME' => 'Pendiente de Pago',
            'NEXT_STATE' => [
                'PRODUCT_ORDER_CONFIRMED',
                'REJECTED_PAYMENT'
            ],
            'CODE' => 'PENDING_PAYMENT',
            'ROL' => [
                'System'
            ]
        ],
        'REJECTED_PAYMENT' => [
            'NAME' => 'Pago Rechazado',
            'NEXT_STATE' => [],
            'CODE' => 'REJECTED_PAYMENT',
            'ROL' => [
                'System',
                'Cliente'
            ]
        ],
        'PRODUCT_ORDER_CONFIRMED' => [
            'NAME' => 'Confirmado',
            'NEXT_STATE' => ['PACKED'],
            'CODE' => 'PRODUCT_ORDER_CONFIRMED',
            'ROL' => [
                'System',
                'Cliente'
            ]
        ],
        'PACKED' => [
            'NAME' => 'Empacado',
            'NEXT_STATE' => ['ASSIGNED'],
            'CODE' => 'PACKED',
            'ROL' => [
                'Proveedor'
            ]
        ],
        'ASSIGNED' => [
            'NAME' => 'Asignado',
            'NEXT_STATE' => ['COLLECTED'],
            'CODE' => 'ASSIGNED',
            'ROL' => [
                'Administrador'
            ]
        ],
        'COLLECTED' => [
            'NAME' => 'Recolectado',
            'NEXT_STATE' => ['ON_ROAD'],
            'CODE' => 'COLLECTED',
            'ROL' => [
                'Distribuidor',
                'Administrador'
            ]
        ],
        'ON_ROAD' => [
            'NAME' => 'En Camino',
            'NEXT_STATE' => [
                'DELIVERED_TO_CUSTOMER',
                'NOT_DELIVERED'
            ],
            'CODE' => 'ON_ROAD',
            'ROL' => [
                'System',
                'Administrador',
                'Distribuidor'
            ]
        ],
        'DELIVERED_TO_CUSTOMER' => [
            'NAME' => 'Entregado',
            'NEXT_STATE' => ['ACCEPTED'],
            'CODE' => 'DELIVERED_TO_CUSTOMER',
            'ROL' => [
                'Distribuidor',
                'Administrador'
            ]
        ],
        'NOT_DELIVERED' => [
            'NAME' => 'No entregado',
            'NEXT_STATE' => ['RETURNED_TO_NODE'],
            'CODE' => 'NOT_DELIVERED',
            'ROL' => [
                'Distribuidor',
                'Administrador'
            ]
        ],
        'RETURNED_TO_NODE' => [
            'NAME' => 'Devuelto a nodo',
            'NEXT_STATE' => [
                'DELIVERED_TO_CUSTOMER',
                'CLOSED',
            ],
            'CODE' => 'RETURNED_TO_NODE',
            'ROL' => [
                'Distribuidor',
                'Administrador'
            ]
        ],
        'ACCEPTED' => [
            'NAME' => 'Aceptado',
            'NEXT_STATE' => ['CLOSED'],
            'CODE' => 'ACCEPTED',
            'ROL' => [
                'Cliente',
                'Administrador'
            ]
        ],
        'CLOSED' => [
            'NAME' => 'Finalizado',
            'NEXT_STATE' => [],
            'CODE' => 'CLOSED',
            'ROL' => [
                'System',
                'Administrador'
            ]
        ],
    ]
];
