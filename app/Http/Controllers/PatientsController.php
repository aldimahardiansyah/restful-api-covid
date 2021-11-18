<?php

namespace App\Http\Controllers;

// mengimport model Patients
// digunakan untuk berinteraksi dengan database

use App\Models\history;
use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\status;
use Illuminate\Validation\Rule;

class PatientsController extends Controller
{
    # membuat method untuk template output
    function output($patient)
    {
        $result = [];
        foreach ($patient as $patient) {
            array_push($result, [
                'id' => $patient->id,
                'name' => $patient->name,
                'phone' => $patient->phone,
                'address' => $patient->address,

                # mencari status berdasarkan status id
                'status_id' => $patient->status->id,
                'status' => status::find($patient->status_id)->status,
                'in_date_at' => history::where('patients_id', $patient->id)->first()->in_date_at,
                'out_date_at' => history::where('patients_id', $patient->id)->first()->out_date_at,
                'updated_at' => $patient->updated_at,
                'created_at' => $patient->created_at
            ]);
        }

        return $result;
    }

    # membuat method untuk mencari status berdasarkan status_id
    function search_status_id($status)
    {
        if (strtolower($status) == 'positive') {
            return 1;
        } else if (strtolower($status) == 'recovered') {
            return 2;
        } else if (strtolower($status) == 'dead') {
            return 3;
        }
    }

    # membuat metod index
    function index()
    {
        # menggunakan model Patients untuk select data
        $patients = Patients::all();

        # menghitung total resource
        $total = count($patients);

        if ($total > 0) {
            $data = [
                'message' => 'Get All Resource',
                'total' => $total,
                'data' => $this->output($patients)
            ];

            # mengirim data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data is empty"
            ];

            # mengembalika data (json) dan kode 200
            return response()->json($data, 200);
        }
    }

    # membuat method store
    function store(Request $request)
    {
        # memvalidasi request
        $request->validate([
            'name' => 'required',
            'phone' => 'required | numeric',
            'address' => 'required',
            'status' => ['required', Rule::in(['positive', 'Positive', 'recovered', 'Recovered', 'dead', 'Dead'])],
            'in_date_at' => 'required | date',
            'out_date_at' => 'nullable | date'
        ]);


        $inputPatient = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status_id' => $this->search_status_id($request->status)
        ];

        # menggunakan model Patients untuk insert data
        $patient = Patients::create($inputPatient);

        $inputHistory = [
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at,
            'patients_id' => $patient->id
        ];

        # menggunakan model history untuk insert data
        history::create($inputHistory);

        $data = [
            'message' => 'Resource is added successfully',

            # memanggil method output dengan argumen array dari patient
            'data' => $this->output([$patient])
        ];

        # mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }

    # membuat method show
    function show($id)
    {
        # cari id patient yang ingin ditampilkan
        $patient = Patients::find($id);

        if ($patient) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $this->output([$patient])
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method update
    function update($id, Request $request)
    {
        # memvalidasi request status
        $request->validate([
            'status' => ['nullable', Rule::in(['positive', 'Positive', 'recovered', 'Recovered', 'dead', 'Dead'])]
        ]);

        # mencari id patient yang ingin diupdate
        $patient = Patients::find($id);

        if ($patient) {

            # menangkap data untuk tabel patient
            $input_patient = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status_id' => $this->search_status_id($request->status ?? $patient->status_id)
            ];

            # melakukan update data patient
            $patient->update($input_patient);

            # mencari history yang akan diupdate
            $history = history::where('patients_id', $patient->id)->first();

            # menangkap data untuk table history
            $inputHistory = [
                'in_date_at' => $request->in_date_at ?? $history->in_date_at,
                'out_date_at' => $request->out_date_at ?? $history->out_date_at,
                'patients_id' => $patient->id
            ];

            # melakukan update data history
            $history->update($inputHistory);

            $data = [
                'message' => 'Resource is update successfully',
                'data' => $this->output([$patient])
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method destroy
    function destroy($id)
    {
        # mencari id patient yang ingin dihapus
        $patient =  Patients::find($id);
        $history = history::where('patients_id', $id)->first();

        if ($patient) {
            # hapus patient tersebut
            $patient->delete();
            $history->delete();

            $data = [
                'message' => "Resource is delete successfully"
            ];

            # mengembalikan pesan dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method search
    function search($name)
    {
        # mencari data patient berdasarkan nama
        $patients = Patients::where('name', 'LIKE', "%$name%")->get();

        if (count($patients) > 0) {
            $data = [
                'message' => "Get searched resource",
                'data' => $this->output($patients)
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method search by status
    function search_by_status($status)
    {
        # mencari patients berdasarkan status
        $patients = Patients::where('status_id', $this->search_status_id($status))->get();

        # menghitung total hasil pencarian
        $total = count($patients);

        if ($total > 0) {
            $data = [
                'message' => "Get $status Resource",
                'total' => $total,
                'data' => $this->output($patients)
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }
}
