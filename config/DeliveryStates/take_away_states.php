<?php

return [
    'TAKEAWAY' => [
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
            'NEXT_STATE' => [
                'WITHDRAWN_BY_CUSTOMER',
                'NOT_WITHDRAWN_BY_CUSTOMER'
            ],
            'CODE' => 'PACKED',
            'ROL' => [
                'Proveedor'
            ]
        ],
        'NOT_WITHDRAWN_BY_CUSTOMER' => [
            'NAME' => 'No retirado',
            'NEXT_STATE' => ['CLOSED'],
            'CODE' => 'NOT_WITHDRAWN_BY_CUSTOMER',
            'ROL' => [
                'Proveedor'
            ]
        ],
        'WITHDRAWN_BY_CUSTOMER' => [
            'NAME' => 'Retirado',
            'NEXT_STATE' => ['ACCEPTED'],
            'CODE' => 'WITHDRAWN_BY_CUSTOMER',
            'ROL' => [
                'Proveedor'
            ]
        ],
        'ACCEPTED' => [
            'NAME' => 'Aceptado',
            'NEXT_STATE' => ['CLOSED'],
            'CODE' => 'ACCEPTED',
            'ROL' => [
                'Cliente'
            ]
        ],
        'CLOSED' => [
            'NAME' => 'Finalizado',
            'NEXT_STATE' => [],
            'CODE' => 'CLOSED',
            'ROL' => [
                'Proveedor',
                'System'
            ]
        ],
    ]
];
