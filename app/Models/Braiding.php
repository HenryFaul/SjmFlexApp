<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Braiding extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['model_type_id','tubing_value','braiding_type_id','flex_type_id','bom','syspro_code','is_active'];

}
