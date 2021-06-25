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
    ],
    "userMenuLinks" => [
        [
            "title" => "iplan::common.title.my-subscriptions",
            "routeName" => "plans.mySubscriptions",
            "icon" => "fa fa-id-card-o mr-2",

        ],
        [
            "title" => "iplan::common.title.my-qrs",
            "routeName" => "plans.myQrs",
            "icon" => "fa fa-qrcode mr-2",
        ]
    ],
];
