<?php

namespace App\Imports;

use App\Models\FlexType;
use App\Models\ProductionModel;
use App\Models\Spring;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProductionModel implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        //'model','capacity','flex_type_id','bom','corr','syspro_code','is_active'
        //Model	capa	Corr	Flex Type	Bom	Syspro Codes

        foreach ($collection as $row) {
            if ($row != null) {

                if ($row['model'] != '') {

                    $Model = trim($row['model']);
                    $FlexType = trim($row['flex_type']);

                    //Get IDS

                    $flex_type = FlexType::where('name','LIKE',"%{$FlexType}%")->first();
                    $flex_type_id = $flex_type == null ? 1 : $flex_type->id;

                    //'model','tubing_value','braiding_type_id','flex_type_id','bom','syspro_code','is_active'
                    ProductionModel::create([
                        'model' => $Model,
                        'flex_type_id'=>$flex_type_id,
                        'is_active'=>true
                    ]);

                }
            }
        }
    }
}
