<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $fillable = ['component','model_type_id','component_value','component_type','flex_type_id','bom','location','cutting_type','corr','syspro_code','is_active'];

    public function ProductionModel(): BelongsTo
    {
        return $this->belongsTo(ProductionModel::class, 'model_type_id');
    }

    public function FlexType(): BelongsTo
    {
        return $this->belongsTo(FlexType::class, 'flex_type_id');
    }
}
