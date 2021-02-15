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
    ];

    public function limits()
    {
      return $this->belongsToMany(Limit::class,'iplan__plan_limits');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,"category_id");
    }
}
