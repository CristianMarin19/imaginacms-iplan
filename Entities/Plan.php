<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\Product;

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

    public function product()
    {
        return $this->belongsTo(Product::class,"id","entity_id");
    }
}
