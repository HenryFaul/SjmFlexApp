<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentLine extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['line_shift_id', 'component','component_id', 'flex_type_id','job_card_no','shift_leader_id', 'operator_id', 'business_unit_id', 'assembly_line_id', 'prod_capacity', 'prod_plan', 'prod_actual',
        'prod_qty_loss', 'daily_plan_vs_actual', 'work_time', 'work_down_time', 'man_input', 'total_defect_qty_inc','total_defect_kg_inc','total_defect_qty_conv_inc','total_defect_qty_conv_ex',
        'total_defect_qty_ex','total_defect_kg_ex', 'total_defect_percent_inc', 'total_defect_percent_ex'];

    public function scopeMonth(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['date'] ?? false,
            fn ($query, $value) => $query->whereHas('LineShift', function ($q) use ($value){
                $q->whereBetween('shift_date', [Carbon::parse($value)->startOfMonth(),Carbon::parse($value)->endOfMonth()]);
            }));
    }

    public function LineShift(): BelongsTo
    {
        return $this->belongsTo(LineShift::class, 'line_shift_id');
    }

    public function Component(): BelongsTo
    {
        return $this->belongsTo(Component::class, 'component_id');
    }

    public function FlexType(): BelongsTo
    {
        return $this->belongsTo(FlexType::class, 'flex_type_id');
    }

    public function Defects(): HasMany
    {
        return $this->hasMany(ComponentDefect::class, 'component_line_id');
    }

    public function calculateFields()
    {
        $component_line = $this;
        $found_component = $component_line->Component;
        $production_model = ProductionModel::where('id', $found_component->model_type_id)->first();
        $component_line->prod_capacity = $found_component->component_value;
        $component_line->prod_qty_loss = $component_line->prod_plan - $component_line->prod_actual;
        $component_line->daily_plan_vs_actual = round(($component_line->prod_actual/$component_line->prod_plan) * 100,2);

        //Work Down Time
        //IF(([@[Prod Qty loss]]>0),(([@[Prod Qty loss]]*(25200/[@[Prod Capa]]))/60),0)
        if ($component_line->prod_plan - $component_line->prod_actual > 0 && $component_line->prod_capacity > 0) {
            $component_line->work_down_time = round( ($component_line->prod_plan - $component_line->prod_actual) * 25200/ $component_line->prod_capacity / 60,2);
        } else {
            $component_line->work_down_time = 0;
        }
        //Work Time
        //IF(([@[Prod Plan]]/[@[Prod Capa]])*100=100,430-[@[Down Time(Minutes)]],430*(([@[Prod Plan]]/[@[Prod Capa]])))
        if ($component_line->prod_plan > 0 && $component_line->prod_capacity > 0) {
            $cal_val = $component_line->prod_plan / $component_line->prod_capacity * 100;
            if ($cal_val == 100) {
                $component_line->work_time = round((430 - $component_line->work_down_time),2);
            } else {
                $component_line->work_time =  round(430 * ($component_line->prod_plan / $component_line->prod_capacity),2);
            }
        } else {
            $component_line->work_time = 0;
        }
        $component_line->save();
    }

    public function recalculateComponentLineDefects($component)
    {

        $componentLine = $this;
        $component = $componentLine->Component;
        $bom = $component->bom;

        $all_defects = $componentLine->Defects;


        $inc_weight = 0;
        $ex_weight = 0;
        $inc_pieces = 0;
        $ex_pieces = 0;
        $inc_pieces_conv = 0;
        $ex_pieces_conv = 0;

        foreach ($all_defects as $defect){

            //weight and included
            if ($defect->defect_bases_type_id === 2 && $defect->is_inc === 1){
                $inc_weight += $defect->value;
                $inc_pieces_conv += $defect->value/$bom;
            }
            //weight and excluded
            if ($defect->defect_bases_type_id === 2 && $defect->is_inc === 0){
                $ex_weight += $defect->value;
                $ex_pieces_conv += $defect->value/$bom;
            }
            //pieces and included
            if ($defect->defect_bases_type_id === 3 && $defect->is_inc === 1){
                $inc_pieces += $defect->value;
            }
            //pieces and excluded
            if ($defect->defect_bases_type_id === 3 && $defect->is_inc === 0){
                $ex_pieces += $defect->value;
            }
        }

        //=IFERROR([@[Defect Qty Total Excl2]]+[@Material2];"")
        $componentLine->total_defect_qty_inc=$ex_pieces + $ex_pieces_conv; // + Whatever Material2 is as its always 0;

        $componentLine->total_defect_kg_inc=$inc_weight;
        $componentLine->total_defect_qty_ex=$ex_pieces;
        $componentLine->total_defect_kg_ex=$ex_weight;
        $componentLine->total_defect_qty_conv_inc=round($inc_pieces_conv,4);
        $componentLine->total_defect_qty_conv_ex= round($ex_pieces_conv,4);

        //calculate defect %
        if ($componentLine->prod_actual>0){
            //=IFERROR([@[Defect Qty Total Incl]]/[@[Prod Actual]];"")
            $componentLine->total_defect_percent_inc = $componentLine->total_defect_qty_inc/$componentLine->prod_actual;
            //=IFERROR([@[Defect Qty Total Excl2]]/([@[Prod Actual]]+[@[Defect Qty Total Excl2]]);"")
            $total_qty_ex = $ex_pieces+$ex_pieces_conv;
            $componentLine->total_defect_percent_ex = $total_qty_ex/($componentLine->prod_actual + $total_qty_ex);
        }

        $componentLine->save();
    }

}
