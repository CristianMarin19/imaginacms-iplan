<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    protected $table = 'iplan__subscriptions';
    protected $fillable = [
      "name",
      "description",
      "category_name",
      "entity",
      "entity_id",
      "frequency",
      "start_date",
      "end_date",
      "status",
      "options",
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function limits()
    {
      return $this->hasMany(SubscriptionLimit::class,"subscription_id");
    }

    public function entityData(){
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo($this->entity ?? "Modules\\User\\Entities\\{$driver}\\User","entity_id");
    }

    public function related($related){
        return $this->morphedByMany($related, "related", "iplan__subscription_related")->withTimestamps();
    }



}
