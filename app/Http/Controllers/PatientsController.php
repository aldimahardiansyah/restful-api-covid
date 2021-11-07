<?php

namespace App\Http\Controllers;

// mengimport model Patients
// digunakan untuk berinteraksi dengan database
use Illuminate\Http\Request;
use App\Models\Patients;

class PatientsController extends Controller
{
    # membuat metod index
    function index()
    {
        # menggunakan model Patients untuk select data
        $patients = Patients::all();

        if (count($patients) > 0) {
            $data = [
                'message' => 'Get all patients',
                'data' => $patients
            ];

            # mengirim data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "table is empty"
            ];

            # mengembalika data (json) dan kode 201
            return response()->json($data, 204);
        }
    }

    # membuat method store
    function store(Request $request)
    {
        # menangkap data request
        $input = [
            'name' => $request->name,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at
        ];

        #menggunakan model Patients untuk insert data
        $patient = Patients::create($input);
        $data = [
            'message' => 'Data has added',
            'data' => $patient
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
                'message' => 'Get detail patient',
                'data' => $patient
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method update
    function update($id, Request $request)
    {
        # mencari id patient yang ingin diupdate
        $patient = Patients::find($id);

        if ($patient) {
            # menangkap data request
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'alamat' => $request->alamat ?? $patient->alamat,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];

            # melakukan update data
            $patient->update($input);

            $data = [
                'message' => 'Data is updated',
                'data' => $patient
            ];

            # mengembalikan data (json) dan kode 201
            return response()->json($data, 201);
        } else {
            $data = [
                'message' => "Data not found"
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

        if ($patient) {
            # hapus patient tersebut
            $patient->delete();

            $data = [
                'message' => "Data has deleted"
            ];

            # mengembalikan pesan dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
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
                'message' => "result: $name",
                'data' => $patients
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method search by status
    function search_by_status($status)
    {
        # mencari patients berdasarkan status
        $patients = Patients::where('status', $status)->get();

        if (count($patients) > 0) {
            $data = [
                'message' => "get $status patients",
                'data' => $patients
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method positive
    function positive()
    {
        # mengembalikan hasil dari memanggil method search_by_status dengan argumen positive
        return $this->search_by_status('positive');
    }

    # membuat method recovered
    function recovered()
    {
        # mengembalikan hasil dari memanggil method search_by_status dengan argumen recovered
        return $this->search_by_status('recovered');
    }

    # membuat method dead
    function dead()
    {
        # mengembalikan hasil dari memanggil method search_by_status dengan argumen dead
        return $this->search_by_status('dead');
    }
}
