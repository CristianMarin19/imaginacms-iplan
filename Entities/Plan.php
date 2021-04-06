<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $table = 'iplan__plans';
    protected $fillable = [
      "name",
      "description",
      "frequency_id",
      "category_id",
      'options',
    ];
    protected $casts = [
        'options' => 'array',
    ];

    public function limits()
    {
      return $this->belongsToMany(Limit::class,'iplan__plan_limits');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,"category_id");
    }

    public function product()
    {
        return $this->morphOne(\Modules\Icommerce\Entities\Product::class,'entity');
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }
}
