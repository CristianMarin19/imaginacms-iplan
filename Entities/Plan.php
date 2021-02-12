<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use Translatable;

    protected $table = 'iplan__plans';
    public $translatedAttributes = ["name","description"];
    protected $fillable = [
      "frequency_id",
      "category_id",
    ];

    public function limits()
    {
      return $this->hasMany(Limit::class,"plan_id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class,"category_id");
    }
}
