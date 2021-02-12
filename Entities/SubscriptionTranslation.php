<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ["name","description","category_name"];
    protected $table = 'iplan__subscription_translations';
}
