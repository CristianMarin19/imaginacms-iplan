<?php
return [
    'crudFields' => [
        'url' => 'Enlace del plan'
    ],
    'settings' => [
        'default-plan-to-new-users' => 'Plan por defecto para nuevos usuarios',
        'enableQr' => 'Habilitar Código QR para los usuarios suscritos',
    ],
    'settingHints' => [
        'default-plan-to-new-users' => 'Selecciona un plan por defecto para nuevos usuarios',
    ],
    'messages' => [
        'entity-create-not-allowed' => 'Creación/Actualización no Permitida',
        'user-valid-subscription' => 'El Usuario <b>:name</b>, posee al menos una (1) suscripción vigente.',
        'user-not-valid-subscription' => 'Lo sentimos. El usuario <b>:name</b>, no posee en el momento ninguna suscripción vigente.',
    ],
    'title' => [
        'my-qrs' => 'Mi Código QR',
        'my-subscriptions' => 'Mis Suscripciones',
        'print' => 'Imprimir',
    ]
];
