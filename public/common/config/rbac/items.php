<?php

return [
    'viewProduct' => [
        'type' => 2,
        'description' => 'View a product',
    ],
    'createProduct' => [
        'type' => 2,
        'description' => 'Create a product',
    ],
    'updateProduct' => [
        'type' => 2,
        'description' => 'Update a product',
    ],
    'deleteProduct' => [
        'type' => 2,
        'description' => 'Delete a product',
    ],
    'viewOrder' => [
        'type' => 2,
        'description' => 'View an order',
    ],
    'createOrder' => [
        'type' => 2,
        'description' => 'Create an order',
    ],
    'updateOrder' => [
        'type' => 2,
        'description' => 'Update an order',
    ],
    'deleteOrder' => [
        'type' => 2,
        'description' => 'Delete an order',
    ],
    'member' => [
        'type' => 1,
        'children' => [
            'createOrder',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'member',
            'viewProduct',
            'viewOrder',
            'createProduct',
            'updateProduct',
            'deleteProduct',
            'updateOrder',
            'deleteOrder',
        ],
    ],
];
