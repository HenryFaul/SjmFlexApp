<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterlockDefect extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = ['line_shift_id','interlock_line_id','production_model_type_id','interlock_type_id','interlock_defect_type_id',
        'interlock_defect_group_type_id','defect_bases_type_id','value','salvage_value','is_inc','comment'];


    public function ProductionModel(): BelongsTo
    {
        return $this->belongsTo(ProductionModel::class, 'production_model_type_id');
    }

    public function Interlock(): BelongsTo
    {
        return $this->belongsTo(Interlock::class, 'interlock_type_id');
    }

    public function DefectType(): BelongsTo
    {
        return $this->belongsTo(InterlockDefectType::class, 'interlock_defect_type_id');
    }

    public function DefectGroup(): BelongsTo
    {
        return $this->belongsTo(InterlockDefectGroup::class, 'interlock_defect_group_type_id');
    }

    public function DefectBasis(): BelongsTo
    {
        return $this->belongsTo(DefectBasis::class, 'defect_bases_type_id');
    }




    public function totalDefect()
    {

        $interlock_defect = $this;
        $interlock = $interlock_defect->Interlock;
        $bom = $interlock->bom;

        //if bases weight or pieces
        //if is_inc

        $all_defects = InterlockDefect::where('interlock_line_id',$interlock_defect->interlock_line_id)->get();


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

        $interlock_line = InterlockLine::where('id',$interlock_defect->interlock_line_id)->first();

        //=IFERROR([@[Defect Qty Total Excl2]]+[@Material2];"")
        $interlock_line->total_defect_qty_inc=$ex_pieces + $ex_pieces_conv; // + Whatever Material2 is as its always 0;

        $interlock_line->total_defect_kg_inc=$inc_weight;
        $interlock_line->total_defect_qty_ex=$ex_pieces;
        $interlock_line->total_defect_kg_ex=$ex_weight;
        $interlock_line->total_defect_qty_conv_inc=round($inc_pieces_conv,4);
        $interlock_line->total_defect_qty_conv_ex= round($ex_pieces_conv,4);

        //calculate defect %
        if ($interlock_line->prod_actual>0){
            //=IFERROR([@[Defect Qty Total Incl]]/[@[Prod Actual]];"")
            $interlock_line->total_defect_percent_inc = $interlock_line->total_defect_qty_inc/$interlock_line->prod_actual;
            //=IFERROR([@[Defect Qty Total Excl2]]/([@[Prod Actual]]+[@[Defect Qty Total Excl2]]);"")
            $total_qty_ex = $ex_pieces+$ex_pieces_conv;
            $interlock_line->total_defect_percent_ex = $total_qty_ex/($interlock_line->prod_actual + $total_qty_ex);
        }


        $interlock_line->save();

    }
}
