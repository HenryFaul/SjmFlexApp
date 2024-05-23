<?php

namespace App\Http\Controllers;

use App\Models\StaffMember;
use App\Models\User;
use Illuminate\Http\Request;

class StaffMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'searchName',
            'isActive',
            'field',
            'direction',
            'show'
        ]);
        //$filters = $request->input('searchName', ''); // Get the search term from the request
        $paginate = $request['show'] ?? 10;
        $staff_members = StaffMember::filter($filters['searchName'])->paginate($paginate)->withQueryString();

        return inertia(
            'StaffMember/Index',
            [
                'filters' => $filters,
                'staff_members' => $staff_members,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffMember  $staffMember
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(StaffMember $staffMember): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia(
            'StaffMember/Show',
            [
                'staff_member' => $staffMember,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffMember  $staffMember
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffMember $staffMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffMember  $staffMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffMember $staffMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffMember  $staffMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffMember $staffMember)
    {
        //
    }
}
