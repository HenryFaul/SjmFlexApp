<?php

namespace App\Imports;

use App\Models\Braiding;
use App\Models\BraidingType;
use App\Models\Component;
use App\Models\FlexType;
use App\Models\Interlock;
use App\Models\InterlockType;
use App\Models\LocationType;
use App\Models\ProductionModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportInterlock implements ToCollection, WithHeadingRow
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
                    $InterLock = trim($row['interlock']);
                    $Type = trim($row['type']);
                    $FlexType = trim($row['flex_type']);
                    $Bom =  doubleval(trim($row['bom']));
                    $CuttingType =  doubleval(trim($row['cutting_type']));
                    $Location = trim($row['location']);
                    $SysproCodes = trim($row['syspro_codes']);

                    //Get IDS
                    $flex_type = FlexType::where('name','LIKE',"%{$FlexType}%")->first();
                    $flex_type_id = $flex_type == null ? 1 : $flex_type->id;

                    $model_type = ProductionModel::where('model','LIKE',"%{$Model}%")->first();

                    $model_type_id = $model_type == null ? $flex_type_id : $model_type->id;

                    $found_interlock = Component::where('component','Interlock')->where('model_type_id',$model_type_id)->where('flex_type_id',$flex_type_id)->first();


                    if($found_interlock == null){
                        //'model','tubing_value','braiding_type_id','flex_type_id','bom','syspro_code','is_active'
                        Component::create([
                            'component'=>'Interlock',
                            'model_type_id' => $model_type_id,
                            'component_value'=>$InterLock,
                            'component_type'=>$Type,
                            'flex_type_id'=>$flex_type_id,
                            'bom'=>$Bom,
                            'location'=>$Location,
                            'cutting_type'=>$CuttingType,
                            'syspro_code'=>$SysproCodes,
                            'is_active'=>true

                        ]);
                    }
                }
            }
        }
    }
}
