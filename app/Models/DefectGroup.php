<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefectGroup extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['value','comment','component'];

    public function defectTypes(): HasMany
    {
        return $this->hasMany(DefectType::class);
    }
}
