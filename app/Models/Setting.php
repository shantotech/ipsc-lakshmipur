<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One row per site setting (key => value). Read through App\Support\Site. */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];
}
