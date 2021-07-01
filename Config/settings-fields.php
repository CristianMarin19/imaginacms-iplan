<?php

return [
    'defaultPlanToNewUsers' => [
        'name' => 'iplan::defaultPlanToNewUsers',
        'value' => null,
        'type' => 'select',
        'loadOptions' => [
          'apiRoute' => 'apiRoutes.qplan.plans',
          'select' => ['label' => 'name', 'id' => 'id'],
        ],
        'props' => [
          'label' => 'iplan::common.settings.default-plan-to-new-users',
          'hint' => 'iplan::common.settingHints.default-plan-to-new-users',
          'clearable' => true
        ],
    ],
    'enableQr' => [
        'name' => 'iplan::enableQr',
        'value' => '0',
        'type' => 'checkbox',
        'props' => [
            'label' => 'iplan::common.settings.enableQr',
            'trueValue' => '1',
            'falseValue' => '0'
        ],
    ],
    'defaultPageDescription' => [
        'name' => 'iplan::defaultPageDescription',
        'value' => '0',
        'type' => 'html',
        'props' => [
            'label' => 'iplan::common.settings.defaultPageDescription',
        ]
    ]
];
