<?php

namespace App\Http\Controllers;

use App\Models\InterlockDefectType;
use App\Models\InterlockDownTime;
use App\Models\InterlockDownTimeType;
use App\Models\Shift;
use Illuminate\Http\Request;

class InterlockDownTimeController extends Controller
{

    public function getProps(): array
    {
        $all_interlock_down_time_types = InterlockDownTimeType::all();
        return array("all_interlock_down_time_types"=>$all_interlock_down_time_types);
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


        //line_shift_id','interlock_line_id','interlock_down_time_type_id','value','comment'

        $request->validate([
            'line_shift_id' => ['required', 'integer','exists:line_shifts,id'],
            'interlock_line_id' => ['required', 'integer', 'exists:interlock_lines,id'],
            'interlock_down_time_type_id' => ['required', 'integer', 'exists:interlock_down_time_types,id'],
            'value' => ['required', 'integer'],
            'comment' => ['nullable','string'],

        ]);


        $interlock_down_time = InterlockDownTime::create([
            'line_shift_id' => $request->line_shift_id,
            'interlock_line_id' => $request->interlock_line_id,
            'production_model_type_id' => $request->production_model_type_id,
            'interlock_down_time_type_id' => $request->interlock_down_time_type_id,
            'value' => $request->value,
            'comment' => $request->comment,

        ]);

        if ($interlock_down_time->exists()) {

            $interlock_down_time->totalDowntime();
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Down Time Created');
        } else {
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Down Time NOT Created');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InterlockDownTime  $interlockDownTime
     * @return \Illuminate\Http\Response
     */
    public function show(InterlockDownTime $interlockDownTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InterlockDownTime  $interlockDownTime
     * @return \Illuminate\Http\Response
     */
    public function edit(InterlockDownTime $interlockDownTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InterlockDownTime  $interlockDownTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InterlockDownTime $interlockDownTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InterlockDownTime  $interlockDownTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterlockDownTime $interlockDownTime)
    {
        //
    }
}
