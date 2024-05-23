<?php

namespace App\Http\Controllers;

use App\Charts\DefectChart;
use App\Charts\DownTimeChart;
use App\Charts\PlanVsActualChart;
use App\Charts\MonthlyUsersChart;
use App\Models\AssemblyLine;
use App\Models\BusinessUnit;
use App\Models\Component;
use App\Models\ComponentLine;
use App\Models\ComponentDefect;
use App\Models\ComponentDownTime;
use App\Models\LineShift;
use App\Models\ProductionModel;
use App\Models\StaffMember;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InterlockLineController extends Controller
{

    public function monthToDate(Request $request, PlanVsActualChart $chart, DefectChart $chart2, DownTimeChart $chart3): \Inertia\Response|\Inertia\ResponseFactory
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'flex_type' => 'nullable|integer',
        ]);

        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());
        $flexType = $request->input('flex_type', 2);

        return inertia(
            'ComponentLine/MonthToDate',
            [
                'chart' => $chart->build("Interlock",$flexType,$startDate,$endDate),
                'chart2' => $chart2->build("Interlock",$flexType,$startDate,$endDate),
                'chart3' => $chart3->build("Interlock",$flexType,$startDate,$endDate),
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
        $filters = $request->only([
            'searchName',
            'isActive',
            'field',
            'show'
        ]);

        $paginate = $request['show'] ?? 10;
        $all_interlock_line_items = ComponentLine::where('component','Interlock')->where('id', '>', 0)->with('LineShift', fn($query) => $query->with('Shift'))->with('Component.ProductionModel')->paginate($paginate)->withQueryString();

        return inertia(
            'ComponentLine/Index',
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
        $component = "Interlock";
        $all_line_shifts = LineShift::where('id', '>=', 0)->with('Shift')->get();
        $all_production_models = ProductionModel::with('FlexType')->get();
        $all_staff_members = StaffMember::all();
        $all_business_units = BusinessUnit::all();
        $all_assembly_lines = AssemblyLine::all();
        $all_interlocks = Component::where('component',$component)->where('id', '>=', 0)->with('ProductionModel', fn($query) => $query->with('FlexType'))->get();

        //fn($query) => $query->with('FlexType')

        return inertia(
            'ComponentLine/Create',
            [
                'all_line_shifts' => $all_line_shifts,
                'all_production_models' => $all_production_models,
                'all_staff_members' => $all_staff_members,
                'all_business_units' => $all_business_units,
                'all_assembly_lines' => $all_assembly_lines,
                'all_components' => $all_interlocks,
                'component' => $component,
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
            'component_id' => ['required', 'integer', 'exists:components,id'],
            'production_model_type_id' => ['required', 'integer', 'exists:production_models,id'],
            'shift_leader_id' => ['required', 'integer', 'exists:staff_members,id'],
            'operator_id' => ['required', 'integer', 'exists:staff_members,id'],
            'business_unit_id' => ['required', 'integer', 'exists:business_units,id'],
            'assembly_line_id' => ['required', 'integer', 'exists:assembly_lines,id'],

        ]);

        $production_model = ProductionModel::where('id', $request->production_model_type_id)->first();

        $interlock_line = ComponentLine::create([
            'component' => 'Interlock', // 'Interlock
            'job_card_no' => $request->job_card_no,
            'flex_type_id' => $production_model->flex_type_id,
            'line_shift_id' => $request->line_shift_id,
            'component_id' => $request->component_id,
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
     * @param \App\Models\ComponentLine $interlockLine
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(ComponentLine $interlockLine): \Inertia\Response|\Inertia\ResponseFactory
    {

        $interlockLine = ComponentLine::where('id', $interlockLine->id)
            ->with('LineShift', fn($query) => $query->with('Shift'))
            ->with('Component', fn($query) => $query->with('ProductionModel')->with('FlexType'))
            ->first();

        $all_staff_members = StaffMember::all();
        $all_business_units = BusinessUnit::all();
        $all_assembly_lines = AssemblyLine::all();
        $down_times = ComponentDownTime::where('component_line_id', $interlockLine->id)->with('DownTimeType')->get();
        $defects = ComponentDefect::where('component_line_id', $interlockLine->id)->with('DefectType.DefectGroup')->with('DefectBasis')->get();

        // $found_interlock = Interlock::where('model_type_id',$production_model->id)->where('flex_type_id',$production_model->flex_type_id)->with('ProductionModel')->with('FlexType')->with('Location')->with('CuttingType')->first();

        //fn($query) => $query->with('OffloadingHoursFrom')

        return inertia(
            'ComponentLine/Show',
            [
                'component' => 'Interlock',
                'component_line' => $interlockLine,
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
     * @param \App\Models\ComponentLine $interlockLine
     */
    public function update(Request $request, ComponentLine $interlockLine)
    {

        //'line_shift_id', 'job_card_no', 'production_model_type_id', 'shift_leader_id', 'operator_id', 'business_unit_id', 'assembly_line_id', 'prod_capacity', 'prod_plan', 'prod_actual', 'prod_return',
        //        'prod_salvage', 'prod_qty_loss', 'prod_percent_loss', 'work_time', 'work_down_time', 'man_input', 'total_defect_qty_inc',
        //        'total_defect_qty_ex', 'total_defect_percent_inc', 'total_defect_percent_ex'

        $request->validate([
            'job_card_no' => ['required', 'string'],
            'line_shift_id' => ['required', 'integer', 'exists:line_shifts,id'],
            'component_id' => ['required', 'integer', 'exists:components,id'],
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
