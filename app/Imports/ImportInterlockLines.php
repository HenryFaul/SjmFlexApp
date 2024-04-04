<?php

namespace App\Imports;

use App\Models\Interlock;
use App\Models\InterlockDefect;
use App\Models\InterlockDefectType;
use App\Models\InterlockLine;
use App\Models\InterlockType;
use App\Models\LineShift;
use App\Models\ProductionModel;
use App\Models\Shift;
use App\Models\StaffMember;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportInterlockLines implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection->skip(1) as $row) {
            if ($row != null && trim($row[2]) != "") {
                $interlockDate = trim($row[2]);
                $prod_plan = trim($row[13]);
                $prod_actual = trim($row[14]);
                $shift = trim($row[17]);
                $man_input_text = trim($row[31]);
                $man_input_text = str_replace(',', '.', $man_input_text); // Change comma to a period
                $man_input = floatval($man_input_text);
                $line_shift = self::firstOrCreateLineShift($interlockDate,$shift);
                $job_card_no = trim($row[21]);
                $production_model = ProductionModel::where('model',trim($row[3]))->first();
                $interlock_type= InterlockType::where('name',trim($row[5]))->first();
                $shift_leader = StaffMember::search(trim($row[9]))->first();
                $operator_name = str_replace(".", " ", trim($row[10]));
                $business_unit_id = 1;
                $assembly_line_id = 1;
                $operator = StaffMember::search($operator_name)->first();
                $interlock = Interlock::where('model_type_id',$production_model->id)->first();//136
                if($interlock != null) {
                    $interlock_line = InterlockLine::create([
                        'job_card_no' =>  $job_card_no,
                        'flex_type_id' => $production_model->flex_type_id,
                        'line_shift_id' =>$line_shift->id,
                        'interlock_type_id' => $interlock->id,
                        'production_model_type_id' => $production_model->id,//136
                        'shift_leader_id' =>  $shift_leader->id,
                        'operator_id' =>  $operator->id ?? 1,
                        'business_unit_id' => $business_unit_id,
                        'assembly_line_id' => $assembly_line_id,
                        'prod_capacity' => $interlock->interlock_value,
                        'prod_plan' => $prod_plan,
                        'prod_actual' => $prod_actual,
                        'man_input' => $man_input
                    ]);
                    $interlock_line->calculateFields();
                    //Assume position is pivot table is going to stay the same. Interlock forming defect values import
                    for ($i = 34; $i <= 54; $i=$i+2) {
                        $value_text = trim($row[$i]);
                        $value_text = str_replace(',', '.', $value_text); // Change comma to a period
                        $value = floatval($value_text);
                        if($value != null && $value > 0) {
                            $interlock_defect_type = InterlockDefectType::where('import_pos', $i)->first();
                            $interlock_defect = InterlockDefect::create([
                                'line_shift_id' => $line_shift->id,
                                'interlock_line_id' => $interlock_line->id,
                                'production_model_type_id' => $production_model->id,
                                'interlock_type_id' => $interlock->id,
                                'interlock_defect_type_id' => $interlock_defect_type->id,
                                'interlock_defect_group_type_id' => $interlock_defect_type->interlock_defect_group_id,
                                'defect_bases_type_id' => 2, //weight
                                'salvage_value' => 0,
                                'value' => $value,
                                'comment' => '',
                                'is_inc' => 0,
                            ]);
                            $interlock_defect->totalDefect();
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
