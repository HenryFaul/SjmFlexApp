<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['id','model','flex_type_id','comment','is_active'];

    public function FlexType(): BelongsTo
    {
        return $this->belongsTo(FlexType::class,'flex_type_id');
    }

    public function Components(): HasMany
    {
        return $this->hasMany(Component::class, 'model_type_id');
    }
}
