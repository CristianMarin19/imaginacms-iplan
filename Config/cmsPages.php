<?php

return [
  'admin' => [
    "plans" => [
      "permission" => "iplan.plans.manage",
      "activated" => true,
      "path" => "/plans",
      "name" => "qplan.admin.plans.index",
      "crud" => "../_crud/plans",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.adminPlans",
      "icon" => "fas fa-window-restore",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "limits" => [
      "permission" => "iplan.limits.manage",
      "activated" => true,
      "path" => "/limits",
      "name" => "qplan.admin.limits.index",
      "crud" => "../_crud/limits",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.adminLimits",
      "icon" => "fas fa-key",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qplan.plans"
        ]
      ]
    ],
    "categories" => [
      "permission" => "iplan.categories.manage",
      "activated" => true,
      "path" => "/categories",
      "name" => "qplan.admin.categories.index",
      "crud" => "../_crud/planCategories",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.adminCategories",
      "icon" => "fas fa-layer-group",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qplan.plans"
        ]
      ]
    ],
    "entityPlans" => [
      "permission" => "iplan.entityplans.manage",
      "activated" => true,
      "path" => "/entityPlans",
      "name" => "qplan.admin.entityPlans.index",
      "crud" => "../_crud/entityPlans",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.adminEntityPlans",
      "icon" => "fas fa-tasks",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qplan.plans"
        ]
      ]
    ],
    "subscriptions" => [
      "permission" => "iplan.subscriptions.manage",
      "activated" => true,
      "path" => "/subscriptions",
      "name" => "qplan.admin.subscriptions.index",
      "crud" => "../_crud/subscriptions",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.adminSubscriptions",
      "icon" => "fas fa-file-contract",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qplan.plans"
        ]
      ]
    ],
    "subscriptionsEdit" => [
      "permission" => "iplan.subscriptions.edit",
      "activated" => true,
      "path" => "/subscriptions/:id",
      "name" => "qplan.admin.subscriptions.edit",
      "page" => "../_pages/admin/subscriptions/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.editSubscriptions",
      "icon" => "fas fa-file-signature",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qplan.plans",
          "qplan.subscriptions"
        ]
      ]
    ]
  ],
  'panel' => [
    "subscriptions" => [
      "permission" => "iplan.subscriptions.manage",
      "activated" => true,
      "path" => "/subscriptions",
      "name" => "qplan.admin.subscriptions.index",
      "crud" => "../_crud/subscriptions",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iplan.cms.sidebar.panelSubscriptions",
      "icon" => "fas fa-file-contract",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qplan.plans"
        ]
      ]
    ]
  ],
  'main' => []
];
