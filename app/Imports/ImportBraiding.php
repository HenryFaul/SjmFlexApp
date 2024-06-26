<?php

namespace App\Imports;

use App\Models\Braiding;
use App\Models\BraidingType;
use App\Models\Component;
use App\Models\FlexType;
use App\Models\ProductionModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBraiding implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row != null) {
                if ($row['model'] != '') {
                    $Model = trim($row['model']);
                    $Tubing = trim($row['tubing']);
                    $Type = trim($row['type']);
                    $FlexType = trim($row['flex_type']);
                    $Bom = doubleval(trim($row['bom']));
                    $SysproCodes = trim($row['syspro_codes']);

                    //Get IDS
                    $flex_type = FlexType::where('name', 'LIKE', "%{$FlexType}%")->first();
                    $flex_type_id = $flex_type == null ? 1 : $flex_type->id;

                    $model_type = ProductionModel::where('model', 'LIKE', "%{$Model}%")->where('flex_type_id', $flex_type_id)->first();
                    $model_type_id = $model_type == null ? $flex_type_id : $model_type->id;

                    $found_braiding = Component::where('component','Braiding')->where('model_type_id',$model_type_id)->where('flex_type_id',$flex_type_id)
                        ->first();

                    if ($found_braiding == null){
                        Component::create([
                            'component' => 'Braiding',
                            'model_type_id' => $model_type_id,
                            'component_value' => $Tubing,
                            'component_type' => $Type,
                            'flex_type_id' => $flex_type_id,
                            'bom' => $Bom,
                            'syspro_code' => $SysproCodes,
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
}
