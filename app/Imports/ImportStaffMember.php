<?php

namespace App\Imports;

use App\Models\StaffMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStaffMember implements  ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row != null) {

                if ($row['clock_nr'] != '') {

                    $clock_nr = trim($row['clock_nr']);
                    $name = trim($row['name']);
                    $rank = trim($row['rank']);

                    StaffMember::create([

                        'last_name' => $name,
                        'staff_clock_no'=>$clock_nr
                    ]);

                }
            }
        }
    }

}
