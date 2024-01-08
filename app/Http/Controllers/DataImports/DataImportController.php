<?php

namespace App\Http\Controllers\DataImports;

use App\Http\Controllers\Controller;
use App\Imports\ImportBraiding;
use App\Imports\ImportInterlock;
use App\Imports\ImportProductionModel;
use App\Imports\ImportRing;
use App\Imports\ImportRingTube;
use App\Imports\ImportSpring;
use App\Imports\ImportStaffMember;
use App\Models\Braiding;
use App\Models\Interlock;
use App\Models\ProductionModel;
use App\Models\Ring;
use App\Models\RingTube;
use App\Models\Spring;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataImportController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {


        return inertia(
            'DataImport/Index',
            [
                'Imports' => 'Import Data',

            ]
        );

    }

    public function import(Request $request): \Illuminate\Http\RedirectResponse
    {

        $file_name = $request->file('file')->getClientOriginalName();


        switch ($file_name) {

            case "ProductionModelsUnique.xlsx":

                $count_before = ProductionModel::all()->count();

                Excel::import(new ImportProductionModel(),
                    $request->file('file')->store('files'));

                $count_after = ProductionModel::all()->count();

                $message = "Model Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Staff.xlsx":

                $count_before = StaffMember::all()->count();

                Excel::import(new ImportStaffMember(),
                    $request->file('file')->store('files'));

                $count_after = StaffMember::all()->count();

                $message = "Staff Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Braiding.xlsx":

                $count_before = Braiding::all()->count();

                Excel::import(new ImportBraiding(),
                    $request->file('file')->store('files'));

                $count_after = Braiding::all()->count();

                $message = "Braiding Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Interlock.xlsx":

                $count_before = Interlock::all()->count();

                Excel::import(new ImportInterlock(),
                    $request->file('file')->store('files'));

                $count_after = Interlock::all()->count();

                $message = "Interlock Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Ring.xlsx":

                $count_before = Ring::all()->count();

                Excel::import(new ImportRing(),
                    $request->file('file')->store('files'));

                $count_after = Ring::all()->count();

                $message = "Ring Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Spring.xlsx":

                $count_before = Spring::all()->count();

                Excel::import(new ImportSpring(),
                    $request->file('file')->store('files'));

                $count_after = Spring::all()->count();

                $message = "Spring Count before: ".$count_before." count after: ".$count_after;

                break;

            case "RingTube.xlsx":

                $count_before = RingTube::all()->count();

                Excel::import(new ImportRingTube(),
                    $request->file('file')->store('files'));

                $count_after = RingTube::all()->count();

                $message = "RingTube Count before: ".$count_before." count after: ".$count_after;

                break;


            default:
                $message = "No acceptable file name found.";
        }



        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', $message);

        return redirect()->back();


    }


}
