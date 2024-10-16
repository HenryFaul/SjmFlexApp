<?php

namespace App\Http\Controllers;

use App\Models\ComponentDefect;
use App\Models\ComponentLine;
use App\Models\DefectBasis;
use App\Models\DefectGroup;
use App\Models\DefectType;
use Illuminate\Http\Request;

class DefectController extends Controller
{


    public function getProps(): array
    {

      // ['line_shift_id','interlock_line_id','production_model_type_id','interlock_defect_type_id',
       // 'interlock_defect_group_type_id','defect_bases_type_id','value','salvage_value'];

        $all_interlock_defect_groups = DefectGroup::all();
        $all_defect_bases = DefectBasis::all();
        $all_interlock_defect_types = DefectType::all();

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
    public function store(Request $request,$component)
    {


       // 'line_shift_id','interlock_line_id','production_model_type_id','interlock_type_id','interlock_defect_type_id',
       // 'interlock_defect_group_type_id','defect_bases_type_id','value','salvage_value','comment'

        $request->validate([
            'defect_id' => ['nullable','exists:component_defects,id'],
            'line_shift_id' => ['required', 'integer','exists:line_shifts,id'],
            'component_line_id' => ['required', 'integer', 'exists:component_lines,id'],
            'defect_type_id' => ['required', 'integer', 'exists:defect_types,id'],
            'defect_bases_type_id' => ['required', 'integer', 'exists:defect_bases,id'],
            'value' => ['required', 'numeric'],
            'salvage_value' => ['required', 'numeric'],
            'comment' => ['nullable','string'],
            'is_inc' => ['required','boolean'],
            'component' => ['required','string']
        ]);
        if ($request->defect_id) {
            $interlock_defect = ComponentDefect::find($request->defect_id);
            if ($interlock_defect) {
                $interlock_defect->update([
                    'line_shift_id' => $request->line_shift_id,
                    'component_line_id' => $request->component_line_id,
                    'defect_type_id' => $request->defect_type_id,
                    'defect_bases_type_id' => $request->defect_bases_type_id,
                    'salvage_value' => $request->salvage_value,
                    'value' => $request->value,
                    'comment' => $request->comment,
                    'is_inc' => $request->is_inc,
                    'component' => $component,
                ]);
            } else {
                $request->session()->flash('flash.bannerStyle', 'danger');
                $request->session()->flash('flash.banner', 'Defect NOT Updated');
            }
        } else {
            // Create a new defect if defect_id is not present
            $interlock_defect = ComponentDefect::create([
                'line_shift_id' => $request->line_shift_id,
                'component_line_id' => $request->component_line_id,
                'defect_type_id' => $request->defect_type_id,
                'defect_bases_type_id' => $request->defect_bases_type_id,
                'salvage_value' => $request->salvage_value,
                'value' => $request->value,
                'comment' => $request->comment,
                'is_inc' => $request->is_inc,
                'component' => $component,
            ]);
            if ($interlock_defect->exists()) {
                $componentLine = ComponentLine::find($interlock_defect->component_line_id);
                $componentLine->recalculateComponentLineDefects();
                $request->session()->flash('flash.bannerStyle', 'success');
                $request->session()->flash('flash.banner', 'Defect Created');
            } else {
                $request->session()->flash('flash.bannerStyle', 'danger');
                $request->session()->flash('flash.banner', 'Defect NOT Created');
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComponentDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentDefect $interlockDefect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComponentDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentDefect $interlockDefect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComponentDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComponentDefect $interlockDefect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComponentDefect  $interlockDefect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$defect)
    {
        $defect_id = $request->defect_id;
        $defect = ComponentDefect::find($defect_id);
        if ($defect->exists()) {
            $defect->delete();
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Defect Deleted');
        } else {
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Defect NOT Deleted');
        }
    }
}
