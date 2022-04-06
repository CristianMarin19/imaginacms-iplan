<?php
return [
  'crudFields' => [
    'url' => 'Plan Link'
  ],
  'settings' => [
    'default-plan-to-new-users' => 'Default plan for new users',
    'enableQr' => 'Enable QR code for users',
    'defaultPageDescription' => 'Default description in plan home page',
    'tenant' => [
      'group' => 'Tenants',
      'tenantWithCentralData' => 'Entities with central data',
      'entities' => [
        'plans' => 'Plans',
      ],
    ],
  ],
  'settingHints' => [
    'default-plan-to-new-users' => 'Select a default plan for new users',
  ],
  'messages' => [
    'entity-create-not-allowed' => 'Creating/Updating Not Allowed',
    'user-valid-subscription' => 'El usuario <b>:name</b>, posee al menos una (1) suscripción vigente.',
    'user-not-valid-subscription' => 'Lo sentimos. El usuario <b>:name</b>, no posee en el momento ninguna suscripción vigente.',
  ],
  'title' => [
    'my-qrs' => 'My QR Code',
    'my-subscriptions' => 'My Subscriptions',
    'print' => 'Print',
  ],
  "planNotFound" => "Plan not valid"
];
