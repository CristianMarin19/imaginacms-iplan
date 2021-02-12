<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class EntityPlan extends Model
{

    protected $table = 'iplan__entity_plan';
    protected $fillable = [
      "module",
      "entity",
      "status",
    ];

}
