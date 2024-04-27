<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project=Project::with('employees')->get();
        return response()->json([
            'status' => 'success',
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
        $project=Project::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        $project->employees()->attach($request->employee_id);
        DB::commit();
        return response()->json([
            'status' => 'success',
            'project' => $project,
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
    public function show(Project $project)
    {
        $project=Project::with('employees')->find($project->id);
        return response()->json([
            'status' => 'success',
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            DB::beginTransaction();
            $newData= [];
            if (isset($request->name))  {
                $newData['name'] =  $request->name;
            }
            if (isset($request->status))  {
                $newData['status'] =  $request->status;
            }
                
    
            $project->update([$newData]);
    
            return response()->json([
                'status' => 'success',
                'project' => $project,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
            ]);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
           'status' =>'success',
           'message' => 'Department deleted successfully'
        ]);
    }
}
