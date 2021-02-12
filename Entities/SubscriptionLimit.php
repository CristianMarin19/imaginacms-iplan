<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class SubscriptionLimit extends Model
{

  use Translatable;

  protected $table = 'iplan__subscription_limits';

  public $translatedAttributes = ["name"];

  protected $fillable = [
    "subscription_id",
    "entity",
    "attribute",
    "attribute_value",
    "quantity",
    "quantity_used",
  ];

  public function subscription()
  {
    return $this->belongsTo(Subscription::class,"subscription_id");
  }
}
