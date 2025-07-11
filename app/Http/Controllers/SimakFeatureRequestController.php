<?php

    namespace App\Http\Controllers;

    use App\Models\SimakFeatureRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage; // Untuk menyimpan file surat

    class SimakFeatureRequestController extends Controller
    {
        /**
         * Menampilkan form untuk mengajukan permintaan fitur SIMAK.
         */
        public function create()
        {
            return view('simak_feature_requests.create');
        }

        /**
         * Menyimpan permintaan fitur SIMAK baru ke database.
         */
        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'feature_name' => 'required|string|max:255',
                'description' => 'required|string',
                'requester_name' => 'required|string|max:255',
                'requester_email' => 'required|email|max:255',
                'requester_phone' => 'nullable|string|max:20',
                'letter_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Surat dari dekan/ketua
            ]);

            $letterPath = null;
            if ($request->hasFile('letter_file')) {
                $letterPath = $request->file('letter_file')->store('simak_feature_letters', 'public');
            }

            SimakFeatureRequest::create([
                'feature_name' => $validatedData['feature_name'],
                'description' => $validatedData['description'],
                'requester_name' => $validatedData['requester_name'],
                'requester_email' => $validatedData['requester_email'],
                'requester_phone' => $validatedData['requester_phone'],
                'letter_path' => $letterPath,
                'status' => 'pending', // Status awal saat diajukan
                'admin_notes' => null,
                'admin_id' => null,
            ]);

            return redirect()->back()->with('success', 'Permintaan fitur SIMAK Anda telah berhasil diajukan!');
        }
    }
    