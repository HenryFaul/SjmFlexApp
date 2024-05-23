<?php

namespace App\Charts;

use App\Models\ComponentLine;
use App\Models\ContractSummary;

use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DownTimeChart
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
            ->select(DB::raw('line_shifts.shift_date as shift_date'), DB::raw('SUM(component_lines.work_time) as total_work_time'), DB::raw('SUM(component_lines.work_down_time) as total_work_down_time'))
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
                $totalWorkTime = $group->sum('total_work_time'); // Calculate total plan first

                return [
                    'label' => $group->first()->shift_date, // Changed 'your_date_column' to 'shift_date'
                    'ratio' => $totalWorkTime > 0 ? $group->sum('total_work_down_time') / $totalWorkTime : -1
                ];
            });

        return response()->json($result);
    }
}
