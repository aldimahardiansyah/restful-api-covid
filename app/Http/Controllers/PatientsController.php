<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;

class PatientsController extends Controller
{
    function index()
    {
        $patients = Patients::all();
        $data = [
            'message' => 'Get all patients',
            'data' => $patients
        ];
        return response()->json($data, 200);
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
            'message' => 'Data has added',
            'data' => $patient
        ];
        return response()->json($data, 201);
    }

    function show($id)
    {
        // if (!is_numeric($id)) {
        //     return $this->search($id);
        // } else {
        $patient = Patients::find($id);
        if ($patient) {
            $data = [
                'message' => 'Get detail patient',
                'data' => $patient
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
        // }
    }

    function update($id, Request $request)
    {
        $patient = Patients::find($id);
        if ($patient) {
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'alamat' => $request->alamat ?? $patient->alamat,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];
            $patient->update($input);
            $data = [
                'message' => 'Data is updated',
                'data' => $patient
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
    }

    function destroy($id)
    {
        $patient =  Patients::find($id);

        if ($patient) {
            $patient->delete();

            $data = [
                'message' => "Data has deleted"
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
    }

    function search($name)
    {
        $patients = Patients::where('name', 'LIKE', "%$name%")->get();

        if (count($patients) > 0) {
            $data = [
                'message' => "result: $name",
                'data' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
    }

    function positive()
    {
        $patients = Patients::where('status', 'positive')->get();
        if (count($patients) > 0) {
            $data = [
                'message' => 'get positive patient',
                'data' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
    }

    function recovered()
    {
        $patients = Patients::where('status', 'recovered')->get();
        if (count($patients) > 0) {
            $data = [
                'message' => 'get recovered patients',
                'data' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
    }

    function dead()
    {
        $patients = Patients::where('status', 'dead')->get();
        if (count($patients) > 0) {
            $data = [
                'message' => 'get dead patients',
                'data' => $patients
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data, 404);
        }
    }
}
