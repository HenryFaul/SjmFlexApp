<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterlockInternalReturn extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['production_model_type_id','line_shift_id','interlock_line_id','defect_bases_type_id',
        'internal_return_type_id','value','salvage_value'];
}
