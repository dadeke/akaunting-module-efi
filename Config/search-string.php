<?php

return [
    'Modules\Efi\Models\Transaction' => [
        'columns' => [
            'id',
            'document' => [
                'relationship' => true,
                'route' => 'invoices.index'
            ]
        ]
    ]
];
