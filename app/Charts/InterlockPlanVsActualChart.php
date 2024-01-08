<?php

namespace App\Charts;

use App\Models\ContractSummary;
use App\Models\InterlockLine;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class InterlockPlanVsActualChart
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
        //'prod_plan', 'prod_actual',
        $interlock_line_actual_1 = InterlockLine::where('flex_type_id',1)->month($filters)->sum('prod_actual');
        $interlock_line_planned_1 = InterlockLine::where('flex_type_id',1)->month($filters)->sum('prod_plan');
        $interlock_line_actual_2 = InterlockLine::where('flex_type_id',2)->month($filters)->sum('prod_actual');
        $interlock_line_planned_2 = InterlockLine::where('flex_type_id',2)->month($filters)->sum('prod_plan');
        $interlock_line_actual_3 = InterlockLine::where('flex_type_id',3)->month($filters)->sum('prod_actual');
        $interlock_line_planned_3 = InterlockLine::where('flex_type_id',3)->month($filters)->sum('prod_plan');
        $interlock_line_actual_4 = InterlockLine::where('flex_type_id',4)->month($filters)->sum('prod_actual');
        $interlock_line_planned_4 = InterlockLine::where('flex_type_id',4)->month($filters)->sum('prod_plan');


        return $this->chart->barChart()
            ->setTitle('Interlock Planned vs Actual')
            ->setSubtitle('Month to date ('.$month.')')
            ->addData('Passenger planned', [$interlock_line_planned_2])
            ->addData('Passenger actual', [$interlock_line_actual_2])
            ->addData('Small Truck planned', [$interlock_line_planned_3])
            ->addData('Small Truck actual', [$interlock_line_actual_3])
            ->addData('Large Truck planned', [$interlock_line_planned_4])
            ->addData('Large Truck actual', [$interlock_line_actual_4])

            ->setXAxis(['Actual vs Planned'])->toVue();



    }
}
