<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Departments;


class DepartmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showDepartments()
    {
        $user = Auth::user();
        $departments = Departments::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'Departments retrieved successfully',
            'departments' => $departments
        ],200);
    }

    public function createDepartment(Request $request)
    {
        $user = Auth::user();
        $departments = Departments::where('user_id', $user->id)->get();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department = Departments::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'message' => 'Department created successfully', 
            'department' => $department
            ], 201);
    }

    public function updateDepartment(Request $request, $id)
    {
        $user = Auth::user();
        $departments = Departments::where('id', $id)
                    ->where('user_id', $user->id)->get()
                    ->first();

        if (!$departments) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department = Departments::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->input('name');
        } if ($request->filled('description')) {
            $data['description'] = $request->input('description');
        }

        $department->Department::findOrFail($id);
        $department->update($data);

        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ], 200);
    }

    public function deleteDepartment($id)
    {
        $user = Auth::user();
        $departments = Departments::where('user_id', $user->id)->get();

        $department = Departments::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json(['message' => 'Department deleted successfully'], 200);
    }
}
