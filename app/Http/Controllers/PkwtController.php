<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $pkwts = Pkwt::with('employee')->where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'PKWT contracts retrieved successfully',
            'pkwts' => $pkwts
        ], 200);
    }

    public function createPkwt(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'employee_id'    => 'required|integer|exists:employees,id',
            'contract_number' => 'required|string|max:255|unique:pkwt,contract_number',
            'tglMulaiRaw'    => 'required|date',
            'tglBerakhirRaw' => 'required|date|after_or_equal:tglMulaiRaw',
            'contract_type' => 'required|string|max:100',
            'work_type' => 'required|string|max:100',
            'work_type_secondary' => 'required|string|max:100',
            'base_salary' => 'required|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
            'total_salary' => 'required|numeric|min:0',
            'responsible_name' => 'required|string|max:255',
            'signed_date' => 'required|date',
            'work_location' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'signed_contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $signedContractPath = $request->hasFile('signed_contract_file')
            ? $request->file('signed_contract_file')->store('pkwt/signed', 'public')
            : null;

        $end  = new \DateTime($request->input('tglBerakhirRaw'));
        $now  = new \DateTime('today');
        $diff = (int) $now->diff($end)->days;
        $sisa = $end >= $now ? $diff : -$diff;

        if ($sisa < 0)       $status = 'expired';
        elseif ($sisa <= 30) $status = 'near-expired';
        else                 $status = 'active';

        $pkwt = Pkwt::create([
            'user_id'         => $user->id,
            'employee_id'     => $request->input('employee_id'),
            'contract_number' => $request->input('contract_number'),
            'start_date'      => $request->input('tglMulaiRaw'),
            'end_date'        => $request->input('tglBerakhirRaw'),
            'contract_type'   => $request->input('contract_type'),
            'work_type'       => $request->input('work_type'),
            'work_type_secondary' => $request->input('work_type_secondary'),
            'base_salary'     => $request->input('base_salary'),
            'allowance'       => $request->input('allowance', 0),
            'total_salary'    => $request->input('total_salary'),
            'responsible_name' => $request->input('responsible_name'),
            'signed_date'     => $request->input('signed_date'),
            'work_location'   => $request->input('work_location'),
            'notes'           => $request->input('notes'),
            'signed_contract_file' => $signedContractPath,
            'status'          => $status,
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
                    ->where('user_id', $user->id)
                    ->first();

        if (!$pkwt) {
            return response()->json(['message' => 'PKWT contract not found'], 404);
        }

        $request->validate([
            'employee_id'    => 'required|integer|exists:employees,id',
            'contract_number' => 'required|string|max:255|unique:pkwt,contract_number,' . $id,
            'tglMulaiRaw'    => 'required|date',
            'tglBerakhirRaw' => 'required|date|after_or_equal:tglMulaiRaw',
            'contract_type' => 'required|string|max:100',
            'work_type' => 'required|string|max:100',
            'work_type_secondary' => 'required|string|max:100',
            'base_salary' => 'required|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
            'total_salary' => 'required|numeric|min:0',
            'responsible_name' => 'required|string|max:255',
            'signed_date' => 'required|date',
            'work_location' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'signed_contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $signedContractPath = $pkwt->signed_contract_file;
        if ($request->hasFile('signed_contract_file')) {
            if ($signedContractPath) {
                Storage::disk('public')->delete($signedContractPath);
            }
            $signedContractPath = $request->file('signed_contract_file')->store('pkwt/signed', 'public');
        }

        $end  = new \DateTime($request->input('tglBerakhirRaw'));
        $now  = new \DateTime('today');
        $diff = (int) $now->diff($end)->days;
        $sisa = $end >= $now ? $diff : -$diff;

        if ($sisa < 0)       $status = 'expired';
        elseif ($sisa <= 30) $status = 'near-expired';
        else                 $status = 'active';

        $pkwt->update([
            'employee_id' => $request->input('employee_id'),
            'contract_number' => $request->input('contract_number'),
            'start_date'  => $request->input('tglMulaiRaw'),
            'end_date'    => $request->input('tglBerakhirRaw'),
            'contract_type' => $request->input('contract_type'),
            'work_type' => $request->input('work_type'),
            'work_type_secondary' => $request->input('work_type_secondary'),
            'base_salary' => $request->input('base_salary'),
            'allowance' => $request->input('allowance', 0),
            'total_salary' => $request->input('total_salary'),
            'responsible_name' => $request->input('responsible_name'),
            'signed_date' => $request->input('signed_date'),
            'work_location' => $request->input('work_location'),
            'notes' => $request->input('notes'),
            'signed_contract_file' => $signedContractPath,
            'status'      => $status,
        ]);

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