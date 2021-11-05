<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;

class PatientsController extends Controller
{
    function index()
    {
        $patients = Patients::all();
        return response()->json($patients, 200);
    }

    function store(Request $request)
    {
        $input = [
            'name' => $request->name,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at
        ];
        $patient = Patients::create($input);
        $data = [
            'message' => 'Patient has added',
            'data' => $patient
        ];
        return response()->json($data, 201);
    }

    function show($id)
    {
        $patient = Patients::find($id);
        if ($patient) {
            $data = [
                'message' => 'Show detail patient',
                'data' => $patient
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Patient not found"
            ];
            return response()->json($data, 404);
        }
    }
}
