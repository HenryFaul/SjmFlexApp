<?php

namespace App\Http\Controllers\DataImports;

use App\Http\Controllers\Controller;
use App\Imports\ImportBraiding;
use App\Imports\ImportInterlock;
use App\Imports\ImportKnitting;
use App\Imports\ImportKnittingLines;
use App\Imports\ImportProductionModel;
use App\Imports\ImportRing;
use App\Imports\ImportRingTube;
use App\Imports\ImportSpring;
use App\Imports\ImportStaffMember;
use App\Imports\ImportInterlockLines;
use App\Models\Braiding;
use App\Models\Component;
use App\Models\ComponentLine;
use App\Models\Knitting;
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

                $count_before = Component::where('component','Braiding')->count();

                Excel::import(new ImportBraiding(),
                    $request->file('file')->store('files'));

                $count_after = Component::where('component','Braiding')->count();

                $message = "Braiding Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Interlock.xlsx":

                $count_before = Component::where('component','Interlock')->count();

                Excel::import(new ImportInterlock(),
                    $request->file('file')->store('files'));

                $count_after = Component::where('component','Interlock')->count();

                $message = "Interlock Count before: ".$count_before." count after: ".$count_after;

                break;
            case "InterlockLines.xlsx":

                $count_before = ComponentLine::where('component','Interlock')->count();

                Excel::import(new ImportInterlockLines(),
                    $request->file('file')->store('files'));

                $count_after = ComponentLine::where('component','Interlock')->count();

                $message = "Interlock lines count before: ".$count_before." count after: ".$count_after;

                break;
            case "KnittingLines.xlsx":

                $count_before = ComponentLine::where('component','Knitting')->count();

                Excel::import(new ImportKnittingLines(),
                    $request->file('file')->store('files'));

                $count_after = ComponentLine::where('component','Knitting')->count();

                $message = "Knitting lines count before: ".$count_before." count after: ".$count_after;

                break;

            case "Ring.xlsx":

                $count_before = Component::where('component','Ring')->count();

                Excel::import(new ImportRing(),
                    $request->file('file')->store('files'));

                $count_after = Component::where('component','Ring')->count();

                $message = "Ring Count before: ".$count_before." count after: ".$count_after;

                break;

            case "Spring.xlsx":

                $count_before = Component::where('component','Spring')->count();

                Excel::import(new ImportSpring(),
                    $request->file('file')->store('files'));

                $count_after = Component::where('component','Spring')->count();

                $message = "Spring Count before: ".$count_before." count after: ".$count_after;

                break;

            case "RingTube.xlsx":

                $count_before = Component::where('component','RingTube')->count();

                Excel::import(new ImportRingTube(),
                    $request->file('file')->store('files'));

                $count_after = Component::where('component','RingTube')->count();

                $message = "RingTube Count before: ".$count_before." count after: ".$count_after;

                break;
            case "Knitting.xlsx":

                $count_before = Component::where('component','Knitting')->count();

                Excel::import(new ImportKnitting(),
                    $request->file('file')->store('files'));

                $count_after = Component::where('component','Knitting')->count();

                $message = "Knitting Count before: ".$count_before." count after: ".$count_after;

                break;
            case "KnittingLines.xlsx":

//                $count_before = InterlockLine::all()->count();
//
//                Excel::import(new ImportInterlockLines(),
//                    $request->file('file')->store('files'));
//
//                $count_after = InterlockLine::all()->count();
//
//                $message = "Interlock lines count before: ".$count_before." count after: ".$count_after;

                break;
            default:
                $message = "No acceptable file name found.";
        }



        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', $message);

        return redirect()->back();


    }


}
