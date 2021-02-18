<?php

return [
    'name' => 'Iplan',
    'subscriptionEntities' =>[
        [
            'label' => 'Users',
            'value' => 'Modules\\User\\Entities\\Sentinel\\User',
            'apiRoute' => 'apiRoutes.quser.users',
            'options' => ['label' => 'fullName', 'id' => 'id']
        ],
        [
            'label' => 'User Groups',
            'value' => 'Modules\\Iprofile\\Entities\\Department',
            'apiRoute' => 'apiRoutes.quser.departments',
            'options' => ['label' => 'title', 'id' => 'id']
        ]
    ]
];
