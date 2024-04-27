<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStore;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department=Department::with('employees')->get();
        return response()->json([
            'status' => 'success',
            'department' => $department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStore $request)
    {
        try {
            DB::beginTransaction();
       $department=Department::create([
        'name' => $request->name,
        'description' => $request->description,
       ]);
       
       DB::commit();
            return response()->json([
                'status' => 'success',
                'department' => $department
            ]);
    }catch (\Throwable $th) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
        ]);
    }

}

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department=Department::with('employees')->find($department->id);
        return response()->json([
            'status' => 'success',
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        try {
            DB::beginTransaction();
        $newData= [];
        if (isset($request->name))  {
            $newData['name'] =  $request->name;
        }
        if (isset($request->description))  {
            $newData['description'] =  $request->description;
        }
        $department->update([$newData]);

        DB::commit();
        return response()->json([
            'status' => 'success',
            'department' => $department
        ]);
    }catch (\Throwable $th) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
        ]);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
           'status' =>'success',
           'message' => 'Department deleted successfully'
        ]);
    }
}
