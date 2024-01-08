<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterlockLine extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['line_shift_id','flex_type_id', 'job_card_no','interlock_type_id', 'production_model_type_id', 'shift_leader_id', 'operator_id', 'business_unit_id', 'assembly_line_id', 'prod_capacity', 'prod_plan', 'prod_actual', 'prod_return',
        'prod_salvage', 'prod_qty_loss', 'prod_percent_loss','sum_down_time', 'work_time', 'work_down_time', 'man_input', 'total_defect_qty_inc','total_defect_kg_inc','total_defect_qty_conv_inc','total_defect_qty_conv_ex',
        'total_defect_qty_ex','total_defect_kg_ex', 'total_defect_percent_inc', 'total_defect_percent_ex'];

    public function scopeMonth(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['date'] ?? false,
            fn ($query, $value) => $query->whereHas('LineShift', function ($q) use ($value){
                $q->whereBetween('shift_date', [Carbon::parse($value)->startOfMonth(),Carbon::parse($value)->endOfMonth()]);
            }));
    }

    public function FlexType(): BelongsTo
    {
        return $this->belongsTo(FlexType::class,'flex_type_id');
    }

    public function LineShift(): BelongsTo
    {
        return $this->belongsTo(LineShift::class, 'line_shift_id');
    }

    public function ProductionModel(): BelongsTo
    {
        return $this->belongsTo(ProductionModel::class, 'production_model_type_id');
    }

    public function Interlock(): BelongsTo
    {
        return $this->belongsTo(Interlock::class, 'interlock_type_id');
    }

    public function calculateFields()
    {

        $interlock_line = $this;
        $production_model = ProductionModel::where('id', $interlock_line->production_model_type_id)->first();
        $found_interlock = $interlock_line->Interlock;

        $interlock_line->prod_capacity = $found_interlock->interlock_value;
        $interlock_line->prod_qty_loss = $interlock_line->prod_plan - $interlock_line->prod_actual;
        $interlock_line->prod_percent_loss = round(($interlock_line->prod_actual/$interlock_line->prod_plan) * 100,2);

        //Work Down Time
        //IF(([@[Prod Qty loss]]>0),(([@[Prod Qty loss]]*(25200/[@[Prod Capa]]))/60),0)
        if ($interlock_line->prod_plan - $interlock_line->prod_actual > 0 && $interlock_line->prod_capacity > 0) {
            $interlock_line->work_down_time = round( ($interlock_line->prod_plan - $interlock_line->prod_actual) * 25200/ $interlock_line->prod_capacity / 60,2);
        } else {
            $interlock_line->work_down_time = 0;
        }

        //Work Time
        //IF(([@[Prod Plan]]/[@[Prod Capa]])*100=100,430-[@[Down Time(Minutes)]],430*(([@[Prod Plan]]/[@[Prod Capa]])))
        if ($interlock_line->prod_plan > 0 && $interlock_line->prod_capacity > 0) {
            $cal_val = $interlock_line->prod_plan / $interlock_line->prod_capacity * 100;
            if ($cal_val == 100) {
                $interlock_line->work_time = round((430 - $interlock_line->work_down_time),2);
            } else {
                $interlock_line->work_time =  round(430 * ($interlock_line->prod_plan / $interlock_line->prod_capacity),2);
            }
        } else {
            $interlock_line->work_time = 0;
        }

        //Converted Pieces


        $interlock_line->save();


    }

}
