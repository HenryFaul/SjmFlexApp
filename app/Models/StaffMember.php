<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class StaffMember extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['title','first_name','last_name','is_active','staff_clock_no'];

    public function scopeSearch($query, $searchTerm)
    {
        // Split the search term into separate words
        $splitSearch = array_filter(explode(' ', $searchTerm)); // Split into words, remove empty

        return $query->where(function ($query) use ($splitSearch) {
            foreach ($splitSearch as $word) {
                $query->where('last_name', 'like', '%' . Str::lower($word) . '%');
            }
        });
    }
}
