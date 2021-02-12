<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Limit extends Model
{
  Use Translatable;

  protected $table = 'iplan__limits';

  public $translatedAttributes = ["name"];

  protected $fillable = [
    "entity",
    "quantity",
    "attribute",
    "attribute_value",
    "plan_id",
  ];

  public function plan()
  {
    return $this->belongsTo(Plan::class,"plan_id");
  }

}
