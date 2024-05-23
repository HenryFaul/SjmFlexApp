<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AssemblyLine;
use App\Models\BraidingType;
use App\Models\BusinessUnit;
use App\Models\CuttingType;
use App\Models\DefectBasis;
use App\Models\FlexType;
use App\Models\DefectGroup;
use App\Models\DefectType;
use App\Models\DownTimeType;
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

        $test_user2 =  User::create([
            'name' => 'Stefan',
            'email' => 'stefan.vanstaden5@gmail.com',
            'password' => bcrypt('123456789')
        ]);

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

/*        •	Mechanical
•	Electrical
•	Settings
•	Health & Safety
•	Waiting for Operator
                 •	Material
    •	Management
•	Projects
•	Changeover*/


        DownTimeType::create([
            'type' => 'unallocated',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Mechanical',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Electrical',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Settings',
            'component' => 'Interlock'
        ]);


        DownTimeType::create([
            'type' => 'Health & Safety',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Waiting for Operator',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Material',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Management',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Projects',
            'component' => 'Interlock'
        ]);

        DownTimeType::create([
            'type' => 'Changeover',
            'component' => 'Interlock'
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

        DefectGroup::create([
            'value' => 'unallocated',
        ]);

        $InterlockFormingGroup = DefectGroup::create([
            'value' => 'Interlock Forming',
            'component' => 'Interlock'
        ]);

        DefectGroup::create([
            'value' => 'Spot Welding',
            'component' => 'Interlock'
        ]);

        DefectGroup::create([
            'value' => 'Induction Heating',
            'component' => 'Interlock'
        ]);

        DefectGroup::create([
            'value' => 'Interlock Clamping',
            'component' => 'Interlock'
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

        DefectType::create([
            'value' => 'unallocated',
            'component' => 'Interlock'
        ]);

        DefectType::create([
            'value' => 'Excessive Burr',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 34
        ]);

        DefectType::create([
            'value' => 'Coil Width Too Big',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 36
        ]);

        DefectType::create([
            'value' => 'Damaged Coil',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 38
        ]);

        DefectType::create([
            'value' => 'Coil Change / Change Over',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 40
        ]);

        DefectType::create([
            'value' => 'Roll Off',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 42
        ]);

        DefectType::create([
            'value' => 'Roll Up',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 44
        ]);

        DefectType::create([
            'value' => 'Friction Hard/Soft',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 46
        ]);

        DefectType::create([
            'value' => 'Closed Corrugation / tails',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 48
        ]);

        DefectType::create([
            'value' => 'Vuvuzela/pitch to small',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 50
        ]);

        DefectType::create([
            'value' => 'Cutting Length Long/Short',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 52
        ]);

        DefectType::create([
            'value' => 'Bad/Skew Cutting',
            'component' => 'Interlock',
            'defect_group_id' => $InterlockFormingGroup->id,
            'import_pos' => 54
        ]);

        DefectType::create([
            'value' => 'Spot Weld Holes',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Spot Weld high/low Cracks',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Spot Weld Damage',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Damaged',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Burn Away',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'High/Low Ring Position',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Ring cracks/damage rings',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Double Ring / gaps / skew /twisted',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'OD too Small/Big',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Tails/ loose wires/ twisted',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Length Short/long',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Closed Corrugation2',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Friction Hard/ soft',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'cracks/ holes/dents/edge damage',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);

        DefectType::create([
            'value' => 'Damage/ bad cutting/clamping damage',
            'component' => 'Interlock',
            'defect_group_id' => 1,
        ]);
    }
}
