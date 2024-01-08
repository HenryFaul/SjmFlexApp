<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffMember extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['title','first_name','last_name','is_active','staff_clock_no'];
}
