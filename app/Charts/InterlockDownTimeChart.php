<?php

namespace App\Charts;

use App\Models\ContractSummary;
use App\Models\InterlockLine;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class InterlockDownTimeChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {

        $today_date = Carbon::now();
        $month = ($today_date)->monthName;
        $filters['date'] = $today_date->toDateString();


        $interlock_line_down_time_inc_1 = InterlockLine::where('flex_type_id',1)->month($filters)->sum('sum_down_time');
        $interlock_line_down_time_inc_2 = InterlockLine::where('flex_type_id',2)->month($filters)->sum('sum_down_time');
        $interlock_line_down_time_inc_3 = InterlockLine::where('flex_type_id',3)->month($filters)->sum('sum_down_time');
        $interlock_line_down_time_inc_4 = InterlockLine::where('flex_type_id',4)->month($filters)->sum('sum_down_time');



        return $this->chart->barChart()
            ->setTitle('Interlock Down Time')
            ->setSubtitle('Month to date ('.$month.')')
            ->addData('Passenger Down Time', [$interlock_line_down_time_inc_2])
            ->addData('Small Truck Down Time', [$interlock_line_down_time_inc_3])
            ->addData('Large Truck Down Time', [$interlock_line_down_time_inc_4])

            ->setXAxis(['Down Times'])->toVue();



    }
}
