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
        $this->interlockGroupSeed();
        $this->knittingGroupSeed();
        $this->braidingGroupSeed();
    }

    function interlockGroupSeed(): void
    {
        DefectGroup::create([
            'value' => 'unallocated',
            'component' => 'unallocated'
        ]);

        $InterlockFormingGroup = DefectGroup::create([
            'value' => 'Interlock Forming',
            'component' => 'Interlock'
        ]);

        $InterlockSpotWeldingGroup = DefectGroup::create([
            'value' => 'Spot Welding Interlock',
            'component' => 'Interlock'
        ]);

        $InductionHeatingGroup = DefectGroup::create([
            'value' => 'Induction Heating',
            'component' => 'Interlock'
        ]);

        $ClampingGroup = DefectGroup::create([
            'value' => 'Interlock Clamping',
            'component' => 'Interlock'
        ]);

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

        DefectType::create([
            'value' => 'unallocated',
            'component' => 'unallocated',
            'defect_group_id' => 1,
        ]);
        $values = ['Excessive Burr',
            'Coil Width Too Big',
            'Damaged Coil',
            'Coil Change / Change Over',
            'Roll Off',
            'Roll Up',
            'Friction Hard/Soft',
            'Closed Corrugation / tails',
            'Vuvuzela/pitch to small',
            'Cutting Length Long/Short',
            'Bad/Skew Cutting',
            ];
        $import_positions = range(34, 54, 2);
        $this->createDefectType($values,'Interlock',$InterlockFormingGroup->id,$import_positions);


        $values= ['Spot Weld Holes',
            'Spot Weld high/low Cracks',
            'Spot Weld Damage'];
        $import_positions = range(57, 59, 1);
        $this->createDefectType($values,'Interlock',$InterlockSpotWeldingGroup->id,$import_positions);

        $values=['Damaged','Burn Away'];
        $import_positions = range(61, 62, 1);
        $this->createDefectType($values,'Interlock',$InductionHeatingGroup->id,$import_positions);

        $values=["High/Low Ring Position",
            "Ring cracks/damage rings",
            "Double Ring / gaps / skew /twisted",
            "OD too Small/Big",
            "Tails/ loose wires/ twisted",
            "Length Short/long",
            "Closed Corrugation2",
            "Friction Hard/ soft",
            "cracks/ holes/dents/edge damage",
            "Damage/ bad cutting/clamping damage"];
        $import_positions = range(64, 73, 1);
        $this->createDefectType($values,'Interlock',$ClampingGroup->id,$import_positions);
    }

    function knittingGroupSeed() {

        $SupplierKnittingGroup = DefectGroup::create([
            'value' => 'Knitting Supplier',
            'component' => 'Knitting'
        ]);

        $values = ["End of load (pcs)",
            "Bobbin Change"];
        $this->createDefectType($values,'Knitting',$SupplierKnittingGroup->id,range(31,32,1),1);


        $KnittingGroup = DefectGroup::create([
            'value' => 'Knitting',
            'component' => 'Knitting'
        ]);

        $spotWeldingGroup = DefectGroup::create([
            'value' => 'Spot Welding Knitting',
            'component' => 'Knitting'
        ]);

        $values = ["Setup",
            "extension hard/ soft",
            "Wire Loops",
            "Wire Damage/ breakage/ visual",
            "Mesh length Short/Long",
            "Damaged Bellow",
            "Leak in Bellow"];
        $this->createDefectType($values,'Knitting',$KnittingGroup->id,range(33,39,1));

        $values = ["Burn Through",
            "Miss Aligned",
            "Outer braid visual",
            "Extension high/low",
            "Wire Beneath Cap"];
        $this->createDefectType($values,'Knitting',$spotWeldingGroup->id,range(41,45,1));
    }

    function braidingGroupSeed() {
        $BraidingGroup = DefectGroup::create([
            'value' => 'Braiding',
            'component' => 'Braiding'
        ]);

        $spotWeldingGroup = DefectGroup::create([
            'value' => 'Spot Welding Braiding',
            'component' => 'Braiding'
        ]);

        $values = ["Wire Breakage",
            "Cut Length Long",
            "Cut Length Short",
            "Visual Damage",
            "Incorrect Angle",
            "Diameter too Big",
            "Diameter too Small",
            "loops /visual braid",
            "Winding M/C Hard/Soft"];
        $this->createDefectType($values,'Braiding',$BraidingGroup->id,range(36,44,1));
        $values = ['IB Length Long/ short/skew',
            'gaps/loop/ visual parts',
            'Spot weld burnthrough /  test',
            'Damage /low/high ring',
            'Diameter too Big/small'];
        $this->createDefectType($values,'Braiding',$spotWeldingGroup->id,range(46,50,1));
    }

    function tubingGroupSeed() {
        $MaterialGroup = DefectGroup::create([
            'value' => 'Material',
            'component' => 'Tubing'
        ]);
        $values = ['Uneven Burr (Mat.)',
            'Wavey/Crinckle Coil',
            'Chips on coil (Mat.)',
            'Damaged coil (Mat.)',
            'Machine stop / start (Mat.)',
            'Maintenance',
            'Booster',
            'Lamination (Mat.)'];
        $this->createDefectType($values,'Tubing',$MaterialGroup->id,range(30,37,1));
        $TubingSetupGroup = DefectGroup::create([
            'value' => 'Setup',
            'component' => 'Tubing'
        ]);

        $values= ['Coil Change(Same Product)',
            'Product Change Over'];
        $this->createDefectType($values,'Tubing',$TubingSetupGroup->id,range(39,40,1));
        $WeldingCuttingGroup = DefectGroup::create([
            'value' => 'Welding Cutting Setting',
            'component' => 'Tubing'
        ]);
        $values= ['Bite and Rope Setting',
            'Caterpillar Setting/Slippage',
            'Shaping roller damage',
            'Machine stop / start(Tea/Lunch)',
            'Weld oxidation/ torch/settings',
            'Off centre welding',
            'Inside welding puncture',
            'Outside welding puncture',
            'Pre pierce setting',
            'Incorrect pre pierce position',
            'set up settings',
            'Cutting length defects / bad cutting',
            'Clamp scratch defects',
            'Change over settings /ssettings /  bad pipe shape',
            'Stains'];
        $this->createDefectType($values,'Tubing',$WeldingCuttingGroup->id,range(42,57,1));
        $FormingGroup = DefectGroup::create([
            'value' => 'Forming',
            'component' => 'Tubing'
        ]);

        $values = ['Inserting _ Chip/off cut between ply',
            'Inserting _ Centring of pipe defects',
            'Basic Material Puncture',
            'Bad burr welding pucture',
            'Projects/ Sample scrap	Leaks _ Forming pressure leak-O-ring',
            'Leaks _ Inner weld crack',
            'End Core / Edge Damage	Deformed corrugations',
            'incorrect centring/inner ply short	Damage by mould closing	Dents',
            'Piercing Split	Pierce Position	No Piercing'];
        $this->createDefectType($values,'Tubing',$FormingGroup->id,range(59,73,1));
        $DefectQtyEndCuttingGroup = DefectGroup::create([
            'value' => 'Defect QTY End Cutting',
            'component' => 'Tubing'
        ]);
        $values = ['Corrugation damage','Bad cutting condition2'];
        $this->createDefectType($values,'Tubing',$DefectQtyEndCuttingGroup->id,range(75,76,1));
        $DefectQtyReformingGroup = DefectGroup::create([
            'value' => 'Defect QTY Reforming',
            'component' => 'Tubing'
        ]);
        $values = ['Bellow dent',
            'Excessive reforming'];
        $this->createDefectType($values,'Tubing',$DefectQtyReformingGroup->id,range(78,79,1));
        $DefectQtyBelowInductionHeatingGroup = DefectGroup::create([
            'value' => 'Defect QTY Below Induction Heating',
            'component' => 'Tubing'
        ]);
        $values = ['Damage by heating',
            'Collapsed Bellows',
            'Collapsed bellows (Mat)'];
        $this->createDefectType($values,'Tubing',$DefectQtyBelowInductionHeatingGroup->id,range(81,83,1));
    }

    function createDefectType($values,$component,$defect_group_id,$import_positions,$is_inc = 0)
    {
        for($i=0;$i<count($values);$i++){
            DefectType::create([
                'value' => $values[$i],
                'component' => $component,
                'defect_group_id' => $defect_group_id,
                'import_pos' => $import_positions [$i],
                'is_material_error' => $is_inc
            ]);
        }
    }
}
