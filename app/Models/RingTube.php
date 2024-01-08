<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RingTube extends Model
{
    use HasFactory;

    public $fillable = ['model_type_id','capacity','flex_type_id','bom','syspro_code','is_active'];
}
