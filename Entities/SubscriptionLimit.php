<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class SubscriptionLimit extends Model
{

  protected $table = 'iplan__subscription_limits';
  protected $fillable = [
    "name",
    "subscription_id",
    "entity",
    "attribute",
    "attribute_value",
    "quantity",
    "quantity_used",
    "start_date",
    "end_date",
    "changed_subscription_date"
  ];

  public function subscription()
  {
    return $this->belongsTo(Subscription::class,"subscription_id");
  }

  public function getQuantityAvailableAttribute(){

    $result = $this->quantity - $this->quantity_used;

    return abs($result);
  }

}
