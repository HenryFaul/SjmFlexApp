<?php

namespace App\Http\Controllers;

use App\Models\LineShift;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class LineShiftController extends Controller
{


    public function getProps(): array
    {

        $all_shifts = Shift::all();
        return array("all_shifts" => $all_shifts);

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
            'field',
            'direction',
            'show'
        ]);
        $paginate = $request['show'] ?? 10;
        $lineShifts = LineShift::with('Shift')->paginate($paginate)->withQueryString();

        return inertia(
            'LineShift/Index',
            [
                'filters' => $filters,
                'line_shifts' => $lineShifts,
            ]
        );
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        //'shift_date','shift_type_id','comment','is_active'

        $request->validate([
            'shift_date' => ['required', 'date'],
            'shift_type_id' => ['required', 'integer', 'exists:shifts,id'],
            'comment' => ['nullable', 'string'],
        ]);

        $conv_date = Carbon::parse($request->shift_date)->tz('Africa/Johannesburg');


        $lineShift = LineShift::create([
            'shift_date' => $conv_date,
            'shift_type_id' => $request->shift_type_id,
            'comment' => $request->comment,

        ]);

        if ($lineShift->exists()) {
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Line Shift Created');
        } else {
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Line Shift NOT Created');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\LineShift $lineShift
     * @return \Illuminate\Http\Response
     */
    public function show(LineShift $lineShift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\LineShift $lineShift
     * @return \Illuminate\Http\Response
     */
    public function edit(LineShift $lineShift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LineShift $lineShift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineShift $lineShift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\LineShift $lineShift
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineShift $lineShift)
    {
        //
    }
}
