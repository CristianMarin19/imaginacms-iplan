<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class LimitTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ["name"];
    protected $table = 'iplan__limit_translations';
}
