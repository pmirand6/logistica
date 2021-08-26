<?php


return [
    'NODE' => [
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
            'NEXT_STATE' => ['AVAILABLE_IN_NODE'],
            'CODE' => 'ON_ROAD',
            'ROL' => [
                'System',
                'Administrador',
                'Distribuidor'
            ]
        ],
        'AVAILABLE_IN_NODE' => [
            'NAME' => 'En nodo',
            'NEXT_STATE' => [
                'WITHDRAWN_BY_CUSTOMER',
                'NOT_WITHDRAWN_BY_CUSTOMER'
            ],
            'CODE' => 'AVAILABLE_IN_NODE',
            'ROL' => [
                'Distribuidor',
                'Administrador'
            ]
        ],
        'NOT_WITHDRAWN_BY_CUSTOMER' => [
            'NAME' => 'No retirado',
            'NEXT_STATE' => ['CLOSED'],
            'CODE' => 'NOT_WITHDRAWN_BY_CUSTOMER',
            'ROL' => [
                'Administrador'
            ]
        ],
        'WITHDRAWN_BY_CUSTOMER' => [
            'NAME' => 'Retirado',
            'NEXT_STATE' => ['ACCEPTED'],
            'CODE' => 'WITHDRAWN_BY_CUSTOMER',
            'ROL' => [
                'Administrador'
            ]
        ],
        'ACCEPTED' => [
            'NAME' => 'Aceptado',
            'NEXT_STATE' => ['CLOSED'],
            'CODE' => 'ACCEPTED',
            'ROL' => [
                'Administrador',
                'Cliente'
            ]
        ],
        'CLOSED' => [
            'NAME' => 'Finalizado',
            'NEXT_STATE' => [],
            'CODE' => 'CLOSED',
            'ROL' => [
                'Administrador',
                'System'
            ]
        ],
    ],
];
