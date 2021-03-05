<?php
return [
    'plans' => [
        'productable' => [
            'loadOptions' => [
                'apiRoute' => 'apiRoutes.qcommerce.products',
                'select' => [ 'label' => 'name', 'id' => 'id' ],
            ],
            'value' => null, //If the field is not multiple, it must be null. Else, it must be an empty array
            'type' => 'select', //It's recommended to use select or multiselect field types
            'props' => [
                'label' => 'Producto',
                'multiple' => false,
                'useChips' => true,

            ],
        ],
    ]
];
