<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee=Employee::with(['departments','projects'])->get();
        return response()->json([
            'status' => 'success',
            'employee' => $employee,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
        $employee=Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'position' => $request->position,
            'department_id' => $request->department_id,
        ]);

        $employee->projects()->attach($request->project_id);
        
        DB::commit();
        return response()->json([
            'status' => 'success',
            'employee' => $employee,
        ]);
        }catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => $th,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
