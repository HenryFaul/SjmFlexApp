<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterlockDownTimeType extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['type','comment','is_active'];
}
