<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentDefect extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['line_shift_id','component_line_id','defect_type_id','defect_bases_type_id','value','salvage_value','is_inc','comment','component'];

    public function ComponentLine(): BelongsTo
    {
        return $this->belongsTo(ComponentLine::class, 'component_line_id');
    }

    public function DefectType(): BelongsTo
    {
        return $this->belongsTo(DefectType::class, 'defect_type_id');
    }

    public function DefectBasis(): BelongsTo
    {
        return $this->belongsTo(DefectBasis::class, 'defect_bases_type_id');
    }
}
