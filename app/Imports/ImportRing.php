<?php

namespace App\Imports;

use App\Models\FlexType;
use App\Models\Interlock;
use App\Models\InterlockType;
use App\Models\LocationType;
use App\Models\ProductionModel;
use App\Models\Ring;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportRing implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        //'model','capacity','flex_type_id','bom','syspro_code','is_active'
        //Model	capa	Syspro Code	Flex Type	Bom

        foreach ($collection as $row) {
            if ($row != null) {

                if ($row['model'] != '') {

                    $Model = trim($row['model']);
                    $Capacity = doubleval(trim($row['capa']));
                    $FlexType = trim($row['flex_type']);
                    $Bom =  doubleval(trim($row['bom']));
                    $SysproCodes = trim($row['syspro_codes']);

                    //Get IDS



                    $flex_type = FlexType::where('name','LIKE',"%{$FlexType}%")->first();
                    $flex_type_id = $flex_type == null ? 1 : $flex_type->id;


                    $model_type = ProductionModel::where('model','LIKE',"%{$Model}%")->first();
                    $model_type_id = $model_type == null ? $flex_type_id : $model_type->id;

                    $found_ring = Ring::where('model_type_id',$model_type_id)->where('flex_type_id',$flex_type_id);

                    if($found_ring == null){
                        //'model','tubing_value','braiding_type_id','flex_type_id','bom','syspro_code','is_active'
                        Ring::create([
                            'model_type_id' => $model_type_id,
                            'capacity'=>$Capacity,
                            'flex_type_id'=>$flex_type_id,
                            'bom'=>$Bom,
                            'syspro_code'=>$SysproCodes,
                            'is_active'=>true
                        ]);
                    }



                }
            }
        }
    }
}
