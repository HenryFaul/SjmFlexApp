<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefectType extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['value','comment','is_active','is_material_error','import_pos','is_inc','component'];

    public function DefectGroup(): BelongsTo
    {
        return $this->belongsTo(DefectGroup::class, 'defect_group_id');
    }
}
