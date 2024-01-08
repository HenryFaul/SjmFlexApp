<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterlockDefectType extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['value','comment','is_active','is_material_error'];
}
