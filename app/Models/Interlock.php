<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interlock extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['model_type_id','interlock_value','interlock_type_id','flex_type_id','bom','location_type_id','cutting_type_id','syspro_code','is_active'];


    public function ProductionModel(): BelongsTo
    {
        return $this->belongsTo(ProductionModel::class, 'model_type_id');
    }

    public function FlexType(): BelongsTo
    {
        return $this->belongsTo(FlexType::class, 'flex_type_id');
    }

    public function Location(): BelongsTo
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
    }

    public function CuttingType(): BelongsTo
    {
        return $this->belongsTo(CuttingType::class, 'cutting_type_id');
    }

}
