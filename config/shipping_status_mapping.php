<?php
/**
 * Class ${NAME}
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 29/11/20 22:52
 */

$a = 'test';

return [
    'NODO' => [
        'LOGISTICA' => [
            'ADMIN' => [
                'FIRST_STATE' => config('DeliveryStates/node_states.NODE.PACKED.NAME')
            ],
            'PROVIDER' => [
                'FIRST_STATE' => config('DeliveryStates/node_states.NODE.PRODUCT_ORDER_CONFIRMED.NAME'),
            ]
        ],
    ],
    'TAKE_AWAY' => [
        'LOGISTICA' => [
            'ADMIN' => [
                'FIRST_STATE' => config('DeliveryStates/take_away_states.TAKE_AWAY.PACKED.NAME')
            ],
            'PROVIDER' => [
                'FIRST_STATE' => config('DeliveryStates/take_away_states.TAKE_AWAY.PRODUCT_ORDER_CONFIRMED.NAME')
            ]
        ]
    ],
    'DELIVERY' => [
        'LOGISTICA' => [
            'ADMIN' => [
                'FIRST_STATE' => config('DeliveryStates/delivery_states.DELIVERY.PACKED.NAME')
            ],
            'PROVIDER' => [
                'FIRST_STATE' => config('DeliveryStates/delivery_states.DELIVERY.PRODUCT_ORDER_CONFIRMED.NAME'),
            ]
        ]
    ]

];
