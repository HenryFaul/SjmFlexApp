<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentDownTime extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['line_shift_id','component_line_id','down_time_type_id','value','comment','component'];

    public function DownTimeType(): BelongsTo
    {
        return $this->belongsTo(DownTimeType::class, 'down_time_type_id');
    }

//    public function totalDowntime(){
//
//        $interlock_down_time = $this;
//
//        $all_related_down_times = ComponentDownTime::where('component_line_id',$interlock_down_time->interlock_line_id)->get();
//
//        $total_value = 0;
//
//        foreach ($all_related_down_times as $all_related_down_time){
//
//            $total_value += $all_related_down_time->value;
//        }
//
//        if (is_numeric($total_value)){
//
//            $interlock_line = InterlockLine::where('id',$interlock_down_time->interlock_line_id)->first();
//            $interlock_line->sum_down_time = $total_value;
//            $interlock_line->save();
//        }
//
//    }
}
