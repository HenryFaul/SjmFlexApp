<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AssemblyLine;
use App\Models\BraidingType;
use App\Models\BusinessUnit;
use App\Models\CuttingType;
use App\Models\DefectBasis;
use App\Models\FlexType;
use App\Models\InterlockDefectGroup;
use App\Models\InterlockDefectType;
use App\Models\InterlockDownTimeType;
use App\Models\InterlockType;
use App\Models\InternalReturnType;
use App\Models\LocationType;
use App\Models\Operator;
use App\Models\ProductionModel;
use App\Models\Shift;
use App\Models\StaffMember;
use App\Models\StaffRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //user

        $test_user =  User::create([
            'name' => 'Henry',
            'email' => 'rhfaul@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        //Shift
        //6-2	2-10	10-6

        Shift::create([
            'name' => 'unallocated',
        ]);

        Shift::create([
            'name' => '6-2',
        ]);

        Shift::create([
            'name' => '2-10',
        ]);

        Shift::create([
            'name' => '10-6',
        ]);

        //FlexType
        FlexType::create([
            'name' => 'unallocated',
        ]);

        FlexType::create([
            'name' => 'Passenger',
        ]);

        FlexType::create([
            'name' => 'Small Truck',
        ]);

        FlexType::create([
            'name' => 'Large Truck',
        ]);


        //production models
        ProductionModel::create([
            'model' => 'unallocated',
            'flex_type_id'=>1,
            'is_active'=>true
        ]);

        ProductionModel::create([
            'model' => 'unallocated',
            'flex_type_id'=>2,
            'is_active'=>true
        ]);

        ProductionModel::create([
            'model' => 'unallocated',
            'flex_type_id'=>3,
            'is_active'=>true
        ]);

        ProductionModel::create([
            'model' => 'unallocated',
            'flex_type_id'=>4,
            'is_active'=>true
        ]);
        //CuttingType

        CuttingType::create([
            'name' => 'laser',
        ]);

        CuttingType::create([
            'name' => 'plasma',
        ]);

        //InterlockType

        InterlockType::create([
            'name' => 'unallocated',
        ]);

        InterlockType::create([
            'name' => 'Cut Pieces',
        ]);

        InterlockType::create([
            'name' => 'Finished Goods',
        ]);


        //BraidingType
        BraidingType::create([
            'name' => 'unallocated',
        ]);

        BraidingType::create([
            'name' => 'OB Cut Pcs',
        ]);

        BraidingType::create([
            'name' => 'IB',
        ]);

        //LocationType

        LocationType::create([
            'name' => 'unallocated',
        ]);

        LocationType::create([
            'name' => 'local',
        ]);

        LocationType::create([
            'name' => 'export',
        ]);

        //Business Units
        BusinessUnit::create([
            'name' => 'unallocated',
        ]);

        BusinessUnit::create([
            'name' => 'BU1',
        ]);

        BusinessUnit::create([
            'name' => 'BU2',
        ]);

        BusinessUnit::create([
            'name' => 'BU3',
        ]);

        BusinessUnit::create([
            'name' => 'BU4',
        ]);

        BusinessUnit::create([
            'name' => 'BU5',
        ]);

        BusinessUnit::create([
            'name' => 'BU6',
        ]);

        //Assembly Line

        AssemblyLine::create([
            'name' => 'unallocated',
        ]);

        AssemblyLine::create([
            'name' => 'Line 1',
        ]);

        AssemblyLine::create([
            'name' => 'Line 2',
        ]);

        AssemblyLine::create([
            'name' => 'Line 3',
        ]);

        AssemblyLine::create([
            'name' => 'Line 4',
        ]);

        AssemblyLine::create([
            'name' => 'Line 5',
        ]);

        AssemblyLine::create([
            'name' => 'Line 6',
        ]);

        //StaffRole

        StaffRole::create([
            'role' => 'unallocated',
        ]);

        StaffRole::create([
            'role' => 'Operator',
        ]);

        //StaffMember

        StaffMember::create([
            'title' => 'unallocated',
            'first_name' => 'unallocated',
            'last_name' => 'unallocated',
            'staff_clock_no'=>'1234'
        ]);

        //InterlockDownTimeType
        // public $fillable = ['type','comment','is_active'];


/*        •	Mechanical
•	Electrical
•	Settings
•	Health & Safety
•	Waiting for Operator
                 •	Material
    •	Management
•	Projects
•	Changeover*/


        InterlockDownTimeType::create([
            'type' => 'unallocated',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Mechanical',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Electrical',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Settings',
        ]);


        InterlockDownTimeType::create([
            'type' => 'Health & Safety',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Waiting for Operator',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Material',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Management',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Projects',
        ]);

        InterlockDownTimeType::create([
            'type' => 'Changeover',
        ]);


        //Defect Basis

        DefectBasis::create([
            'value' => 'Unallocated',
        ]);

        DefectBasis::create([
            'value' => 'Weight',
        ]);

        DefectBasis::create([
            'value' => 'Pieces',
        ]);

        //Defect Group
/*        •	Interlock Forming
•	Spot Welding
•	Induction Heating
•	Interlock Clamping*/

        InterlockDefectGroup::create([
            'value' => 'unallocated',
        ]);

        InterlockDefectGroup::create([
            'value' => 'Interlock Forming',
        ]);

        InterlockDefectGroup::create([
            'value' => 'Spot Welding',
        ]);

        InterlockDefectGroup::create([
            'value' => 'Induction Heating',
        ]);

        InterlockDefectGroup::create([
            'value' => 'Interlock Clamping',
        ]);

        //InternalReturnType

/*        •	Low Interlock
•	Loose Interlock
•	Interlock Spot Weld
•	Interlock Decoupling
•	Interlock Bubble
•	Ring under Sleeve
•	Twister Interlock
•	Dents
•	Cracks*/


        InternalReturnType::create([
            'value' => 'unallocated',
        ]);

        InternalReturnType::create([
            'value' => 'Low Interlock',
        ]);

        InternalReturnType::create([
            'value' => 'Loose Interlock',
        ]);

        InternalReturnType::create([
            'value' => 'Interlock Spot Weld',
        ]);

        InternalReturnType::create([
            'value' => 'Interlock Decoupling',
        ]);

        InternalReturnType::create([
            'value' => 'Interlock Bubble',
        ]);

        InternalReturnType::create([
            'value' => 'Ring under Sleeve',
        ]);

        InternalReturnType::create([
            'value' => 'Twister Interlock',
        ]);

        InternalReturnType::create([
            'value' => 'Dents',
        ]);

        InternalReturnType::create([
            'value' => 'Cracks',
        ]);


        //InterlockDefectType
        /*        Coil Width Too Big
        Damaged Coil
        Coil Change / Change Over
        Roll Off
        Roll Up
        Friction Hard/Soft
        Closed Corrugation / tails
        Vuvuzela/pitch to small
        Cutting Length Long/Short
        Bad/Skew Cutting
        Spot Weld Holes
        Spot Weld high/low Cracks
        Spot Weld Damage
        Damaged
        Burn Away
        High/Low Ring Position
        Ring cracks/damage rings
        Double Ring / gaps / skew /twisted
        OD too Small/Big
        Tails/ loose wires/ twisted
        Length Short/long
        Closed Corrugation2
        Friction Hard/ soft
        cracks/ holes/dents/edge damage
        Damage/ bad cutting/clamping damage*/

        InterlockDefectType::create([
            'value' => 'unallocated',
        ]);

        InterlockDefectType::create([
            'value' => 'Coil Width Too Big',
        ]);

        InterlockDefectType::create([
            'value' => 'Damaged Coil',
        ]);

        InterlockDefectType::create([
            'value' => 'Coil Change / Change Over',
        ]);

        InterlockDefectType::create([
            'value' => 'Roll Off',
        ]);

        InterlockDefectType::create([
            'value' => 'Roll Up',
        ]);

        InterlockDefectType::create([
            'value' => 'Friction Hard/Soft',
        ]);

        InterlockDefectType::create([
            'value' => 'Closed Corrugation / tails',
        ]);

        InterlockDefectType::create([
            'value' => 'Vuvuzela/pitch to small',
        ]);

        InterlockDefectType::create([
            'value' => 'Cutting Length Long/Short',
        ]);

        InterlockDefectType::create([
            'value' => 'Bad/Skew Cutting',
        ]);

        InterlockDefectType::create([
            'value' => 'Spot Weld Holes',
        ]);

        InterlockDefectType::create([
            'value' => 'Spot Weld high/low Cracks',
        ]);

        InterlockDefectType::create([
            'value' => 'Spot Weld Damage',
        ]);

        InterlockDefectType::create([
            'value' => 'Damaged',
        ]);

        InterlockDefectType::create([
            'value' => 'Burn Away',
        ]);

        InterlockDefectType::create([
            'value' => 'High/Low Ring Position',
        ]);

        InterlockDefectType::create([
            'value' => 'Ring cracks/damage rings',
        ]);

        InterlockDefectType::create([
            'value' => 'Double Ring / gaps / skew /twisted',
        ]);

        InterlockDefectType::create([
            'value' => 'OD too Small/Big',
        ]);

        InterlockDefectType::create([
            'value' => 'Tails/ loose wires/ twisted',
        ]);

        InterlockDefectType::create([
            'value' => 'Length Short/long',
        ]);

        InterlockDefectType::create([
            'value' => 'Closed Corrugation2',
        ]);

        InterlockDefectType::create([
            'value' => 'Friction Hard/ soft',
        ]);

        InterlockDefectType::create([
            'value' => 'cracks/ holes/dents/edge damage',
        ]);

        InterlockDefectType::create([
            'value' => 'Damage/ bad cutting/clamping damage',
        ]);





    }
}
