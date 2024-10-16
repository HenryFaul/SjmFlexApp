<?php

namespace App\Imports;

use App\Models\AssemblyLine;
use App\Models\Component;
use App\Models\ComponentDefect;
use App\Models\ComponentLine;
use App\Models\DefectGroup;
use App\Models\DefectType;
use App\Models\LineShift;
use App\Models\ProductionModel;
use App\Models\Shift;
use App\Models\StaffMember;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportKnittingLines implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection->skip(1) as $row) {
            if ($row != null && trim($row[2]) != "") {
                $date = trim($row[2]);
                $prod_plan = trim($row[9]);
                $prod_actual = trim($row[10]);
                $shift = trim($row[13]);
                $man_input_text = trim($row[27]);
                $man_input_text = str_replace(',', '.', $man_input_text); // Change comma to a period
                $man_input = floatval($man_input_text);
                $line_shift = self::firstOrCreateLineShift($date, $shift);
                $job_card_no = trim($row[17]);
                $production_model = ProductionModel::where('model', trim($row[3]))->first();
                $shift_leader = StaffMember::search(trim($row[6]))->first();
                $business_unit_id = 1;
                $assembly_line = AssemblyLine::firstOrCreate(['name' => trim($row[7])]);
                $assembly_line_id = $assembly_line->id;
                $component = Component::where('component', 'Knitting')->where('model_type_id', $production_model->id)->first();//136
                if ($component != null) {
                    $component_line = ComponentLine::create([
                        'line_shift_id' => $line_shift->id,
                        'component' => 'Knitting',
                        'component_id' => $component->id,
                        'flex_type_id' => $production_model->flex_type_id,
                        'job_card_no' => $job_card_no,
                        'shift_leader_id' => $shift_leader->id ?? 1,
                        'operator_id' => 1,
                        'business_unit_id' => $business_unit_id,
                        'assembly_line_id' => $assembly_line_id,
                        'prod_capacity' => $component->component_value,
                        'prod_plan' => $prod_plan,
                        'prod_actual' => $prod_actual,
                        'man_input' => $man_input,

                    ]);
                    $component_line->calculateFields();
                    //Assume position is pivot table is going to stay the same. Interlock forming defect values import
                    $defect_groups = DefectGroup::where('component', 'Knitting')->get();
                    foreach ($defect_groups as $defect_group) {
                        $defect_types = $defect_group->defectTypes;
                        foreach ($defect_types as $defect_type) {
                            $value_text = trim($row[$defect_type->import_pos]);
                            $value_text = str_replace(',', '.', $value_text); // Change comma to a period
                            $value = floatval($value_text);
                            if ($value != null && $value > 0) {
                                $component_defect = ComponentDefect::create([
                                    'line_shift_id' => $line_shift->id,
                                    'component_line_id' => $component_line->id,
                                    'defect_type_id' => $defect_type->id,
                                    'defect_bases_type_id' => 3, //pieces
                                    'salvage_value' => 0,
                                    'value' => $value,
                                    'comment' => '',
                                    'is_inc' => $defect_type->is_material_error, //0 - excluded 1 - included
                                    'component' => 'Knitting',
                                ]);
                                $component_defect->ComponentLine->recalculateComponentLineDefects("Knitting");
                            }
                        }
                    }
                }
            }
        }
    }


    private function firstOrCreateLineShift($interlockDate,$shiftName) : LineShift{
        $formattedDate = Carbon::parse($interlockDate);
        $lineShift = LineShift::with('Shift')
            ->whereDate('shift_date', $formattedDate)
            ->whereHas('Shift', function ($query) use ($shiftName) {
                $query->where('name', $shiftName);
            })
            ->first();
        if (!$lineShift) {

            $shift = Shift::firstOrCreate(['name' => $shiftName]);
            $lineShift = LineShift::create([
                'shift_date' => $formattedDate,
                'shift_type_id' => $shift->id,
            ]);
        }
        return $lineShift;
    }
}
