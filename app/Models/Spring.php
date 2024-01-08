<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spring extends Model
{
    use HasFactory;

    public $fillable = ['model','capacity','flex_type_id','bom','corr','syspro_code','is_active'];
}
