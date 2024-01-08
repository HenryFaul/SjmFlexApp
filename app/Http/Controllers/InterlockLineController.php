<?php

namespace App\Http\Controllers;

use App\Charts\InterlockDefectChart;
use App\Charts\InterlockDownTimeChart;
use App\Charts\InterlockPlanVsActualChart;
use App\Charts\MonthlyUsersChart;
use App\Models\AssemblyLine;
use App\Models\BusinessUnit;
use App\Models\Interlock;
use App\Models\InterlockDefect;
use App\Models\InterlockDownTime;
use App\Models\InterlockLine;
use App\Models\LineShift;
use App\Models\ProductionModel;
use App\Models\StaffMember;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InterlockLineController extends Controller
{

    public function monthToDate(InterlockPlanVsActualChart $chart, InterlockDefectChart $chart2, InterlockDownTimeChart $chart3): \Inertia\Response|\Inertia\ResponseFactory
    {


        $today_date = Carbon::now();
        $month = ($today_date)->monthName;
        $filters['date'] = $today_date->toDateString();

        $all_flex_1 = InterlockLine::where('flex_type_id', 1)->month($filters)->get();
        $all_flex_2 = InterlockLine::where('flex_type_id', 2)->month($filters)->get();
        $all_flex_3 = InterlockLine::where('flex_type_id', 3)->month($filters)->get();
        $all_flex_4 = InterlockLine::where('flex_type_id', 4)->month($filters)->get();




        //Flex 1
        $sum_prod_capacity_1 = 0;
        $sum_prod_actual_1 = 0;
        $sum_prod_return_1 = 0;
        $sum_work_time_1 = 0;
        $sum_work_down_time_1 = 0;
        $sum_man_input_1 = 0;
        $sum_total_defect_qty_inc_1 = 0;
        $sum_total_defect_kg_inc_1 = 0;
        $sum_total_defect_qty_conv_inc_1 = 0;
        $sum_total_defect_qty_conv_ex_1 = 0;
        $sum_total_defect_qty_ex_1 = 0;
        $sum_total_defect_kg_ex_1 = 0;
        $sum_total_defect_percent_inc_1 = 0;
        $sum_total_defect_percent_ex_1 = 0;

        foreach ($all_flex_1 as $flex_1) {

            $sum_prod_actual_1 += $flex_1->prod_actual;
            $sum_prod_capacity_1 += $flex_1->prod_capacity;
            $sum_prod_return_1 += $flex_1->prod_return;
            $sum_work_time_1 += $flex_1->work_time;
            $sum_work_down_time_1 += $flex_1->work_down_time;
            $sum_man_input_1 += $flex_1->man_input;
            $sum_total_defect_qty_inc_1 += $flex_1->total_defect_qty_inc;
            $sum_total_defect_kg_inc_1 += $flex_1->total_defect_kg_inc;
            $sum_total_defect_qty_conv_inc_1 += $flex_1->total_defect_qty_conv_inc;
            $sum_total_defect_qty_conv_ex_1 += $flex_1->total_defect_qty_conv_ex;
            $sum_total_defect_qty_ex_1 += $flex_1->total_defect_qty_ex;
            $sum_total_defect_kg_ex_1 += $flex_1->total_defect_kg_ex;
        }

        //calculate defect %
        if ($sum_prod_actual_1 > 0) {
            $sum_total_defect_percent_inc_1 = round((($sum_total_defect_qty_inc_1 + $sum_total_defect_qty_conv_inc_1) / $sum_prod_actual_1), 4);
            $sum_total_defect_percent_ex_1 = round((($sum_total_defect_qty_ex_1 + $sum_total_defect_qty_conv_ex_1) / $sum_prod_actual_1), 4);
        }

        $flex_1_data = array("sum_prod_actual_1" => $sum_prod_actual_1, "sum_prod_capacity_1" => $sum_prod_capacity_1,
            "sum_prod_return_1" => $sum_prod_return_1, "sum_work_time_1" => $sum_work_time_1, "sum_work_down_time_1" => $sum_work_down_time_1,
            "sum_man_input_1" => $sum_man_input_1, "sum_total_defect_qty_inc_1" => $sum_total_defect_qty_inc_1, "sum_total_defect_kg_inc_1" => $sum_total_defect_kg_inc_1,
            "sum_total_defect_qty_conv_ex_1" => $sum_total_defect_qty_conv_ex_1, "sum_total_defect_qty_conv_inc_1" => $sum_total_defect_qty_conv_inc_1,
            "sum_total_defect_qty_ex_1" => $sum_total_defect_qty_ex_1, "sum_total_defect_kg_ex_1" => $sum_total_defect_kg_ex_1,
            "sum_total_defect_percent_inc" => $sum_total_defect_percent_inc_1, "sum_total_defect_percent_ex" => $sum_total_defect_percent_ex_1);

        //Flex 2
        $sum_prod_capacity_2 = 0;
        $sum_prod_actual_2 = 0;
        $sum_prod_return_2 = 0;
        $sum_work_time_2 = 0;
        $sum_work_down_time_2 = 0;
        $sum_man_input_2 = 0;
        $sum_total_defect_qty_inc_2 = 0;
        $sum_total_defect_kg_inc_2 = 0;
        $sum_total_defect_qty_conv_inc_2 = 0;
        $sum_total_defect_qty_conv_ex_2 = 0;
        $sum_total_defect_qty_ex_2 = 0;
        $sum_total_defect_kg_ex_2 = 0;
        $sum_total_defect_percent_inc_2 = 0;
        $sum_total_defect_percent_ex_2 = 0;

        foreach ($all_flex_2 as $flex_2) {

            $sum_prod_actual_2 += $flex_2->prod_actual;
            $sum_prod_capacity_2 += $flex_2->prod_capacity;
            $sum_prod_return_2 += $flex_2->prod_return;
            $sum_work_time_2 += $flex_2->work_time;
            $sum_work_down_time_2 += $flex_2->work_down_time;
            $sum_man_input_2 += $flex_2->man_input;
            $sum_total_defect_qty_inc_2 += $flex_2->total_defect_qty_inc;
            $sum_total_defect_kg_inc_2 += $flex_2->total_defect_kg_inc;
            $sum_total_defect_qty_conv_inc_2 += $flex_2->total_defect_qty_conv_inc;
            $sum_total_defect_qty_conv_ex_2 += $flex_2->total_defect_qty_conv_ex;
            $sum_total_defect_qty_ex_2 += $flex_2->total_defect_qty_ex;
            $sum_total_defect_kg_ex_2 += $flex_2->total_defect_kg_ex;
        }

        //calculate defect %
        if ($sum_prod_actual_2 > 0) {
            $sum_total_defect_percent_inc_2 = round((($sum_total_defect_qty_inc_2 + $sum_total_defect_qty_conv_inc_2) / $sum_prod_actual_2), 4);
            $sum_total_defect_percent_ex_2 = round((($sum_total_defect_qty_ex_2 + $sum_total_defect_qty_conv_ex_2) / $sum_prod_actual_2), 4);
        }

        $flex_2_data = array("sum_prod_actual_2" => $sum_prod_actual_2, "sum_prod_capacity_2" => $sum_prod_capacity_2,
            "sum_prod_return_2" => $sum_prod_return_2, "sum_work_time_2" => $sum_work_time_2, "sum_work_down_time_2" => $sum_work_down_time_2,
            "sum_man_input_2" => $sum_man_input_2, "sum_total_defect_qty_inc_2" => $sum_total_defect_qty_inc_2, "sum_total_defect_kg_inc_2" => $sum_total_defect_kg_inc_2,
            "sum_total_defect_qty_conv_ex_2" => $sum_total_defect_qty_conv_ex_2, "sum_total_defect_qty_conv_inc_2" => $sum_total_defect_qty_conv_inc_2,
            "sum_total_defect_qty_ex_2" => $sum_total_defect_qty_ex_2, "sum_total_defect_kg_ex_2" => $sum_total_defect_kg_ex_2,
            "sum_total_defect_percent_inc_2" => $sum_total_defect_percent_inc_2, "sum_total_defect_percent_ex_2" => $sum_total_defect_percent_ex_2);

        //Flex 3
        $sum_prod_capacity_3 = 0;
        $sum_prod_actual_3 = 0;
        $sum_prod_return_3 = 0;
        $sum_work_time_3 = 0;
        $sum_work_down_time_3 = 0;
        $sum_man_input_3 = 0;
        $sum_total_defect_qty_inc_3 = 0;
        $sum_total_defect_kg_inc_3 = 0;
        $sum_total_defect_qty_conv_inc_3 = 0;
        $sum_total_defect_qty_conv_ex_3 = 0;
        $sum_total_defect_qty_ex_3 = 0;
        $sum_total_defect_kg_ex_3 = 0;
        $sum_total_defect_percent_inc_3 = 0;
        $sum_total_defect_percent_ex_3 = 0;

        foreach ($all_flex_3 as $flex_3) {

            $sum_prod_actual_3 += $flex_3->prod_actual;
            $sum_prod_capacity_3 += $flex_3->prod_capacity;
            $sum_prod_return_3 += $flex_3->prod_return;
            $sum_work_time_3 += $flex_3->work_time;
            $sum_work_down_time_3 += $flex_3->work_down_time;
            $sum_man_input_3 += $flex_3->man_input;
            $sum_total_defect_qty_inc_3 += $flex_3->total_defect_qty_inc;
            $sum_total_defect_kg_inc_3 += $flex_3->total_defect_kg_inc;
            $sum_total_defect_qty_conv_inc_3 += $flex_3->total_defect_qty_conv_inc;
            $sum_total_defect_qty_conv_ex_3 += $flex_3->total_defect_qty_conv_ex;
            $sum_total_defect_qty_ex_3 += $flex_3->total_defect_qty_ex;
            $sum_total_defect_kg_ex_3 += $flex_3->total_defect_kg_ex;
        }

        //calculate defect %
        if ($sum_prod_actual_3 > 0) {
            $sum_total_defect_percent_inc_3 = round((($sum_total_defect_qty_inc_3 + $sum_total_defect_qty_conv_inc_3) / $sum_prod_actual_3), 4);
            $sum_total_defect_percent_ex_3 = round((($sum_total_defect_qty_ex_3 + $sum_total_defect_qty_conv_ex_3) / $sum_prod_actual_3), 4);
        }

        $flex_3_data = array("sum_prod_actual_3" => $sum_prod_actual_3, "sum_prod_capacity_3" => $sum_prod_capacity_3,
            "sum_prod_return_3" => $sum_prod_return_3, "sum_work_time_3" => $sum_work_time_3, "sum_work_down_time_3" => $sum_work_down_time_3,
            "sum_man_input_3" => $sum_man_input_3, "sum_total_defect_qty_inc_3" => $sum_total_defect_qty_inc_3, "sum_total_defect_kg_inc_3" => $sum_total_defect_kg_inc_3,
            "sum_total_defect_qty_conv_ex_3" => $sum_total_defect_qty_conv_ex_3, "sum_total_defect_qty_conv_inc_3" => $sum_total_defect_qty_conv_inc_3,
            "sum_total_defect_qty_ex_3" => $sum_total_defect_qty_ex_3, "sum_total_defect_kg_ex_3" => $sum_total_defect_kg_ex_3,
            "sum_total_defect_percent_inc_3" => $sum_total_defect_percent_inc_3, "sum_total_defect_percent_ex_3" => $sum_total_defect_percent_ex_3);


        //Flex 4
        $sum_prod_capacity_4 = 0;
        $sum_prod_actual_4 = 0;
        $sum_prod_return_4 = 0;
        $sum_work_time_4 = 0;
        $sum_work_down_time_4 = 0;
        $sum_man_input_4 = 0;
        $sum_total_defect_qty_inc_4 = 0;
        $sum_total_defect_kg_inc_4 = 0;
        $sum_total_defect_qty_conv_inc_4 = 0;
        $sum_total_defect_qty_conv_ex_4 = 0;
        $sum_total_defect_qty_ex_4 = 0;
        $sum_total_defect_kg_ex_4 = 0;
        $sum_total_defect_percent_inc_4 = 0;
        $sum_total_defect_percent_ex_4 = 0;

        foreach ($all_flex_4 as $flex_4) {

            $sum_prod_actual_4 += $flex_4->prod_actual;
            $sum_prod_capacity_4 += $flex_4->prod_capacity;
            $sum_prod_return_4 += $flex_4->prod_return;
            $sum_work_time_4 += $flex_4->work_time;
            $sum_work_down_time_4 += $flex_4->work_down_time;
            $sum_man_input_4 += $flex_4->man_input;
            $sum_total_defect_qty_inc_4 += $flex_4->total_defect_qty_inc;
            $sum_total_defect_kg_inc_4 += $flex_4->total_defect_kg_inc;
            $sum_total_defect_qty_conv_inc_4 += $flex_4->total_defect_qty_conv_inc;
            $sum_total_defect_qty_conv_ex_4 += $flex_4->total_defect_qty_conv_ex;
            $sum_total_defect_qty_ex_4 += $flex_4->total_defect_qty_ex;
            $sum_total_defect_kg_ex_4 += $flex_4->total_defect_kg_ex;
        }

        //calculate defect %
        if ($sum_prod_actual_4 > 0) {
            $sum_total_defect_percent_inc_4 = round((($sum_total_defect_qty_inc_4 + $sum_total_defect_qty_conv_inc_4) / $sum_prod_actual_4), 4);
            $sum_total_defect_percent_ex_4 = round((($sum_total_defect_qty_ex_4 + $sum_total_defect_qty_conv_ex_4) / $sum_prod_actual_4), 4);
        }

        $flex_4_data = array("sum_prod_actual_4" => $sum_prod_actual_4, "sum_prod_capacity_4" => $sum_prod_capacity_4,
            "sum_prod_return_4" => $sum_prod_return_4, "sum_work_time_4" => $sum_work_time_4, "sum_work_down_time_4" => $sum_work_down_time_4,
            "sum_man_input_4" => $sum_man_input_4, "sum_total_defect_qty_inc_4" => $sum_total_defect_qty_inc_4, "sum_total_defect_kg_inc_4" => $sum_total_defect_kg_inc_4,
            "sum_total_defect_qty_conv_ex_4" => $sum_total_defect_qty_conv_ex_4, "sum_total_defect_qty_conv_inc_4" => $sum_total_defect_qty_conv_inc_4,
            "sum_total_defect_qty_ex_4" => $sum_total_defect_qty_ex_4, "sum_total_defect_kg_ex_4" => $sum_total_defect_kg_ex_4,
            "sum_total_defect_percent_inc_4" => $sum_total_defect_percent_inc_4, "sum_total_defect_percent_ex_4" => $sum_total_defect_percent_ex_4);



        return inertia(
            'InterlockLine/MonthToDate',
            [
                'chart' => $chart->build(),
                'chart2' => $chart2->build(),
                'chart3' => $chart3->build(),
                'flex_1_data'=>$flex_1_data,
                'flex_2_data'=>$flex_2_data,
                'flex_3_data'=>$flex_3_data,
                'flex_4_data'=>$flex_4_data
            ]
        );


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        //

        //all_interlock_line_items

        $filters = $request->only([
            'searchName',
            'isActive',
            'field',
            'show'
        ]);

        $paginate = $request['show'] ?? 10;
        $all_interlock_line_items = InterlockLine::where('id', '>', 0)->with('LineShift', fn($query) => $query->with('Shift'))->with('ProductionModel')->with('Interlock')->paginate($paginate)->withQueryString();

        return inertia(
            'InterlockLine/Index',
            [
                'filters' => $filters,
                'all_interlock_line_items' => $all_interlock_line_items,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {

        //'job_card_no','production_model_type_id','shift_leader_id','operator_id','business_unit_id','assembly_line_id'
        $all_line_shifts = LineShift::where('id', '>=', 0)->with('Shift')->get();
        $all_production_models = ProductionModel::with('FlexType')->get();
        $all_staff_members = StaffMember::all();
        $all_business_units = BusinessUnit::all();
        $all_assembly_lines = AssemblyLine::all();
        $all_interlocks = Interlock::where('id', '>=', 0)->with('ProductionModel', fn($query) => $query->with('FlexType'))->get();

        //fn($query) => $query->with('FlexType')

        return inertia(
            'InterlockLine/Create',
            [
                'all_line_shifts' => $all_line_shifts,
                'all_production_models' => $all_production_models,
                'all_staff_members' => $all_staff_members,
                'all_business_units' => $all_business_units,
                'all_assembly_lines' => $all_assembly_lines,
                'all_interlocks' => $all_interlocks

            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // 'line_shift_id','job_card_no','production_model_type_id','shift_leader_id','operator_id','business_unit_id','assembly_line_id'
        //interlock_type_id
        $request->validate([
            'job_card_no' => ['required', 'string'],
            'line_shift_id' => ['required', 'integer', 'exists:line_shifts,id'],
            'interlock_type_id' => ['required', 'integer', 'exists:interlocks,id'],
            'production_model_type_id' => ['required', 'integer', 'exists:production_models,id'],
            'shift_leader_id' => ['required', 'integer', 'exists:staff_members,id'],
            'operator_id' => ['required', 'integer', 'exists:staff_members,id'],
            'business_unit_id' => ['required', 'integer', 'exists:business_units,id'],
            'assembly_line_id' => ['required', 'integer', 'exists:assembly_lines,id'],

        ]);

        $production_model = ProductionModel::where('id', $request->production_model_type_id)->first();

        $interlock_line = InterlockLine::create([
            'job_card_no' => $request->job_card_no,
            'flex_type_id' => $production_model->flex_type_id,
            'line_shift_id' => $request->line_shift_id,
            'interlock_type_id' => $request->interlock_type_id,
            'production_model_type_id' => $request->production_model_type_id,
            'shift_leader_id' => $request->shift_leader_id,
            'operator_id' => $request->operator_id,
            'business_unit_id' => $request->business_unit_id,
            'assembly_line_id' => $request->assembly_line_id,

        ]);

        if ($interlock_line->exists()) {
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Interlock Line Created');
        } else {
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Interlock Line NOT Created');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\InterlockLine $interlockLine
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(InterlockLine $interlockLine): \Inertia\Response|\Inertia\ResponseFactory
    {

        $interlockLine = InterlockLine::where('id', $interlockLine->id)->with('LineShift', fn($query) => $query->with('Shift'))->with('ProductionModel', fn($query) => $query->with('FlexType'))
            ->with('Interlock', fn($query) => $query->with('ProductionModel')->with('FlexType')->with('Location')->with('CuttingType'))->first();

        $all_staff_members = StaffMember::all();
        $all_business_units = BusinessUnit::all();
        $all_assembly_lines = AssemblyLine::all();
        $down_times = InterlockDownTime::where('interlock_line_id', $interlockLine->id)->with('DownTimeType')->get();
        $defects = InterlockDefect::where('interlock_line_id', $interlockLine->id)->with('DefectType')->with('DefectGroup')->with('DefectBasis')->get();

        $production_model = $interlockLine->ProductionModel;

        // $found_interlock = Interlock::where('model_type_id',$production_model->id)->where('flex_type_id',$production_model->flex_type_id)->with('ProductionModel')->with('FlexType')->with('Location')->with('CuttingType')->first();

        //fn($query) => $query->with('OffloadingHoursFrom')

        return inertia(
            'InterlockLine/Show',
            [
                'interlock_line' => $interlockLine,
                'all_staff_members' => $all_staff_members,
                'all_business_units' => $all_business_units,
                'all_assembly_lines' => $all_assembly_lines,
                'down_times' => $down_times,
                'defects' => $defects
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\InterlockLine $interlockLine
     * @return \Illuminate\Http\Response
     */
    public function edit(InterlockLine $interlockLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InterlockLine $interlockLine
     */
    public function update(Request $request, InterlockLine $interlockLine)
    {

        //'line_shift_id', 'job_card_no', 'production_model_type_id', 'shift_leader_id', 'operator_id', 'business_unit_id', 'assembly_line_id', 'prod_capacity', 'prod_plan', 'prod_actual', 'prod_return',
        //        'prod_salvage', 'prod_qty_loss', 'prod_percent_loss', 'work_time', 'work_down_time', 'man_input', 'total_defect_qty_inc',
        //        'total_defect_qty_ex', 'total_defect_percent_inc', 'total_defect_percent_ex'

        $request->validate([
            'job_card_no' => ['required', 'string'],
            'line_shift_id' => ['required', 'integer', 'exists:line_shifts,id'],
            'interlock_type_id' => ['required', 'integer', 'exists:interlocks,id'],
            'production_model_type_id' => ['required', 'integer', 'exists:production_models,id'],
            'shift_leader_id' => ['required', 'integer', 'exists:staff_members,id'],
            'operator_id' => ['required', 'integer', 'exists:staff_members,id'],
            'business_unit_id' => ['required', 'integer', 'exists:business_units,id'],
            'assembly_line_id' => ['required', 'integer', 'exists:assembly_lines,id'],
            'prod_plan' => ['required', 'numeric', 'gt:0'],
            'prod_actual' => ['required', 'numeric', 'gt:0'],
            'man_input' => ['required', 'numeric', 'gt:0'],
        ]);

        $production_model = ProductionModel::where('id', $request->production_model_type_id)->first();


        $is_updated = $interlockLine->update(
            [
                'job_card_no' => $request->job_card_no,
                'line_shift_id' => $request->line_shift_id,
                'interlock_type_id' => $request->interlock_type_id,
                'flex_type_id' => $production_model->flex_type_id,
                'production_model_type_id' => $request->production_model_type_id,
                'shift_leader_id' => $request->shift_leader_id,
                'operator_id' => $request->operator_id,
                'business_unit_id' => $request->business_unit_id,
                'assembly_line_id' => $request->assembly_line_id,
                'prod_plan' => $request->prod_plan,
                'prod_actual' => $request->prod_actual,
                'man_input' => $request->man_input,
            ]
        );


        $interlockLine->calculateFields();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\InterlockLine $interlockLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterlockLine $interlockLine)
    {
        //
    }
}
