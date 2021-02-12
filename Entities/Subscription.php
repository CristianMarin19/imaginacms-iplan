<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use Translatable;

    protected $table = 'iplan__subscriptions';
    public $translatedAttributes = ["name","description","category_name"];
    protected $fillable = [
      "entity",
      "entity_id",
      "frequency",
      "start_date",
      "end_date",
    ];

    public function limits()
    {
      return $this->hasMany(SubscriptionLimit::class,"subscription_id");
    }
}
