<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Pkwt;

class PkwtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showPkwt()
    {
        $user = Auth::user();
        $pkwts = Pkwt::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'PKWT contracts retrieved successfully',
            'pkwts' => $pkwts
        ], 200);
    }

    public function createPkwt(Request $request)
    {
        $user = Auth::user();
        $pkwts = Pkwt::where('user_id', $user->id)->get();

        $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'contract_number' => 'required|string|max:255|unique:pkwts,contract_number',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,expired',
        ]);

        $pkwt = Pkwt::create([
            'employee_id' => $request->input('employee_id'),
            'contract_number' => 'PKWT-' . time(),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'message' => 'PKWT contract created successfully',
            'pkwt' => $pkwt
        ], 201);
    }

    public function editPkwt(Request $request, $id)
    {
        $user = Auth::user();
        $pkwt = Pkwt::where('id', $id)
                    ->where('user_id', $user->id)->get()
                    ->first();

        if (!$pkwt) {
            return response()->json(['message' => 'PKWT contract not found'], 404);
        }

        $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'contract_number' => 'required|string|max:255|unique:pkwts,contract_number,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,expired',
        ]);

        $data = [];

        if ($request->filled('employee_id')) {
            $data['employee_id'] = $request->input('employee_id');
        }
        if ($request->filled('contract_number')) {
            $data['contract_number'] = $request->input('contract_number');
        }
        if ($request->filled('start_date')) {
            $data['start_date'] = $request->input('start_date');
        }
        if ($request->filled('end_date')) {
            $data['end_date'] = $request->input('end_date');
        }
        if ($request->filled('status')) {
            $data['status'] = $request->input('status');
        }

        $pkwt->update($data);

        return response()->json([
            'message' => 'PKWT contract updated successfully',
            'pkwt' => $pkwt
        ], 200);
    }

    public function deletePkwt($id)
    {
        $user = Auth::user();
        $pkwt = Pkwt::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$pkwt) {
            return response()->json(['message' => 'PKWT contract not found'], 404);
        }

        $pkwt->delete();

        return response()->json(['message' => 'PKWT contract deleted successfully'], 200);
    }
}