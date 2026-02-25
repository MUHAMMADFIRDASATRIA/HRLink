<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Departments;
use App\Models\Positions;

class PositionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showPositions()
    {
        $user = Auth::user();
        $positions = Positions::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'Positions retrieved successfully',
            'positions' => $positions
        ], 200);
    }

    public function createPosition(Request $request)
    {
        $user = Auth::user();
        $positions = Positions::where('user_id', $user->id)->get();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|integer|exists:departments,id',
        ]);

            $position = Positions::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'department_id' => $request->input('department_id'),
            ]);

            return response()->json([
                'message' => 'Position created successfully',
                'position' => $position
            ], 201);
    }

    public function updatePosition(Request $request, $id)
    {
        $user = Auth::user();
        $positions = Positions::where( 'id', $id)
                    ->where('user_id', $user->id)->get()
                    ->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|integer|exists:departments,id',
        ]);

        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->input('name');
        }
        if ($request->filled('description')) {
            $data['description'] = $request->input('description');
        }
        if ($request->filled('department_id')) {
            $data['department_id'] = $request->input('department_id');
        }

        $position = Positions::findOrFail($id);
        $position->update($data);

        return response()->json([
            'message' => 'Position updated successfully',
            'position' => $position
        ], 200);
    }

    public function deletePosition($id)
    {
        $user = Auth::user();
        $positions = Positions::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$positions) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        $positions->delete();

        return response()->json([
            'message' => 'Position deleted successfully'
        ], 200);
    }
}
