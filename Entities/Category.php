<?php

namespace Modules\Iplan\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $table = 'iplan__categories';
    public $translatedAttributes = ["title", "slug", "description"];
    protected $fillable = [
      "parent_id",
      "options",
      "status",
    ];

    public function plans()
    {
      return $this->hasMany(Plans::class,"category_id");
    }

    public function children()
    {
        return $this->hasMany(Category::class,"parent_id");
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,"parent_id");
    }
}
