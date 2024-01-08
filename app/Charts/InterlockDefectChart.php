<?php

namespace App\Charts;

use App\Models\ContractSummary;
use App\Models\InterlockLine;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class InterlockDefectChart
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


        $interlock_line_defect_inc_1 = InterlockLine::where('flex_type_id',1)->month($filters)->sum('total_defect_percent_inc');
        $interlock_line_defect_ex_1  = InterlockLine::where('flex_type_id',1)->month($filters)->sum('total_defect_percent_ex');

        $interlock_line_defect_inc_2 = InterlockLine::where('flex_type_id',2)->month($filters)->sum('total_defect_percent_inc');
        $interlock_line_defect_ex_2  = InterlockLine::where('flex_type_id',2)->month($filters)->sum('total_defect_percent_ex');

        $interlock_line_defect_inc_3 = InterlockLine::where('flex_type_id',3)->month($filters)->sum('total_defect_percent_inc');
        $interlock_line_defect_ex_3  = InterlockLine::where('flex_type_id',3)->month($filters)->sum('total_defect_percent_ex');

        $interlock_line_defect_inc_4 = InterlockLine::where('flex_type_id',4)->month($filters)->sum('total_defect_percent_inc');
        $interlock_line_defect_ex_4  = InterlockLine::where('flex_type_id',4)->month($filters)->sum('total_defect_percent_ex');



        return $this->chart->barChart()
            ->setTitle('Interlock Defects')
            ->setSubtitle('Month to date ('.$month.')')
            ->addData('Passenger Inc', [$interlock_line_defect_inc_2])
            ->addData('Passenger Ex', [$interlock_line_defect_ex_2])
            ->addData('Small Truck Inc', [$interlock_line_defect_inc_3])
            ->addData('Small Truck Ex', [$interlock_line_defect_ex_3])
            ->addData('Large Truck Inc', [$interlock_line_defect_inc_4])
            ->addData('Large Truck Ex', [$interlock_line_defect_ex_4])

            ->setXAxis(['Defects'])->toVue();



    }
}
