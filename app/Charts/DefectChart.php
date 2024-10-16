<?php

namespace App\Charts;

use App\Models\ComponentLine;
use App\Models\ContractSummary;

use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DefectChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($component,$flex_type_id,$start_date,$end_date): \Illuminate\Http\JsonResponse
    {

        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);
        $data = ComponentLine::where('component',$component)->join('line_shifts', 'component_lines.line_shift_id', '=', 'line_shifts.id')
            ->whereBetween('line_shifts.shift_date', [$startDate, $endDate]) // Modify 'date_column' to your actual column  name
            ->where('flex_type_id',$flex_type_id)
            ->select(DB::raw('line_shifts.shift_date as shift_date'), DB::raw('SUM(component_lines.total_defect_qty_conv_ex) +  SUM(component_lines.total_defect_qty_ex) as total_qty_defect_ex'), DB::raw('SUM(component_lines.prod_actual) as total_actual'))
            ->groupBy('line_shifts.shift_date')
            ->get();

        $result = $data->groupBy(function($item) use ($startDate, $endDate) {
            if ($endDate->diffInDays($startDate) <= 7) {
                return Carbon::parse($item->shift_date)->format('Y-m-d');
            } elseif ($endDate->diffInWeeks($startDate) <= 4) {
                return Carbon::parse($item->shift_date)->format('Y - W');
            } else {
                return Carbon::parse($item->shift_date)->format('Y-m');
            }
        })
            ->map(function($group) {
                $totalActual = $group->sum('total_actual'); // Calculate total plan first

                return [
                    'label' => $group->first()->shift_date, // Changed 'your_date_column' to 'shift_date'
                    'ratio' => $totalActual > 0 ? $group->sum('total_qty_defect_ex') / $totalActual : -1
                ];
            });

        return response()->json($result);
    }
}
