<?php

namespace App\Charts;

use App\Models\ComponentLine;
use App\Models\ContractSummary;

use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssemblyTubingPpmChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($flex_type_id,$start_date,$end_date): \Illuminate\Http\JsonResponse
    {
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);
        $data = ComponentLine::whereIn('component', ["Assembly", "Tubing"])
            ->join('line_shifts', 'component_lines.line_shift_id', '=', 'line_shifts.id')
            ->whereBetween('line_shifts.shift_date', [$startDate, $endDate])
            ->where('flex_type_id', $flex_type_id)
            ->select(
                DB::raw('line_shifts.shift_date as shift_date'),
                DB::raw('SUM(component_lines.total_defect_qty_ex) as total_defect_qty_ex'),  // Sum for both Assembly and Tubing
                DB::raw('SUM(CASE WHEN component = "Assembly" THEN component_lines.prod_actual ELSE 0 END) as assembly_output')  // Sum for Assembly output only
            )
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
                $totalAssemblyTubingDefects = $group->sum('total_defect_qty_ex');
                $totalAssemblyOutput = $group->sum('output');
                return [
                    'label' => $group->first()->shift_date,
                    'ratio' => $totalAssemblyOutput > 0 ? ($totalAssemblyTubingDefects / ($totalAssemblyTubingDefects + $totalAssemblyOutput)) * 1000000 : -1,
                ];
            });

        return response()->json($result);
    }
}
