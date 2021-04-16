<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class SubscriptionLimitTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ["name"];
    protected $table = 'iplan__subscription_limit_translations';
}
