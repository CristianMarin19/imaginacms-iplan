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
        'useInput' => true,
        'useChips' => true,
        'hint' => 'iplan::common.settingHints.default-plan-to-new-users',
    ],
  ]
];
