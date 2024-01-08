<?php

namespace App\Http\Controllers;

use App\Models\DefectBasis;
use App\Models\InterlockDefect;
use App\Models\InterlockDefectGroup;
use App\Models\InterlockDefectType;
use App\Models\InterlockDownTimeType;
use Illuminate\Http\Request;

class InterlockDefectController extends Controller
{


    public function getProps(): array
    {

      // ['line_shift_id','interlock_line_id','production_model_type_id','interlock_defect_type_id',
       // 'interlock_defect_group_type_id','defect_bases_type_id','value','salvage_value'];

        $all_interlock_defect_groups = InterlockDefectGroup::all();
        $all_defect_bases = DefectBasis::all();
        $all_interlock_defect_types = InterlockDefectType::all();

        return array("all_interlock_defect_groups"=>$all_interlock_defect_groups,"all_defect_bases"=>$all_defect_bases,"all_interlock_defect_types"=>$all_interlock_defect_types);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {


       // 'line_shift_id','interlock_line_id','production_model_type_id','interlock_type_id','interlock_defect_type_id',
       // 'interlock_defect_group_type_id','defect_bases_type_id','value','salvage_value','comment'

        $request->validate([
            'line_shift_id' => ['required', 'integer','exists:line_shifts,id'],
            'interlock_line_id' => ['required', 'integer', 'exists:interlock_lines,id'],
            'production_model_type_id' => ['required', 'integer', 'exists:production_models,id'],
            'interlock_type_id' => ['required', 'integer', 'exists:interlocks,id'],
            'interlock_defect_type_id' => ['required', 'integer', 'exists:interlock_defect_types,id'],
            'interlock_defect_group_type_id' => ['required', 'integer', 'exists:interlock_defect_groups,id'],
            'defect_bases_type_id' => ['required', 'integer', 'exists:defect_bases,id'],
            'value' => ['required', 'numeric'],
            'salvage_value' => ['required', 'numeric'],
            'comment' => ['nullable','string'],
            'is_inc' => ['required','boolean'],

        ]);

        $interlock_defect = InterlockDefect::create([
            'line_shift_id' => $request->line_shift_id,
            'interlock_line_id' => $request->interlock_line_id,
            'production_model_type_id' => $request->production_model_type_id,
            'interlock_type_id' => $request->interlock_type_id,
            'interlock_defect_type_id' => $request->interlock_defect_type_id,
            'interlock_down_time_type_id' => $request->interlock_down_time_type_id,
            'interlock_defect_group_type_id' => $request->interlock_defect_group_type_id,
            'defect_bases_type_id' => $request->defect_bases_type_id,
            'salvage_value' => $request->salvage_value,
            'value' => $request->value,
            'comment' => $request->comment,
            'is_inc' => $request->is_inc,

        ]);

        if ($interlock_defect->exists()) {

            $interlock_defect->totalDefect();
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Defect Created');
        } else {
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Defect NOT Created');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InterlockDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function show(InterlockDefect $interlockDefect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InterlockDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function edit(InterlockDefect $interlockDefect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InterlockDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InterlockDefect $interlockDefect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InterlockDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterlockDefect $interlockDefect)
    {
        //
    }
}
