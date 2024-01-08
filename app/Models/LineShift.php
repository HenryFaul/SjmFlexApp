<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineShift extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['shift_date','shift_type_id','comment','is_active'];


    public function Shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class,'shift_type_id');
    }




}
