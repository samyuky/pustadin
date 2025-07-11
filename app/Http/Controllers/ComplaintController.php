<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Menampilkan form untuk mengajukan keluhan.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Menyimpan keluhan baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'complainant_name' => 'nullable|string|max:255',
            'complainant_email' => 'nullable|email|max:255',
        ]);

        // Pastikan status default diset jika tidak ada di validasi
        $validatedData['status'] = $validatedData['status'] ?? 'pending';

        Complaint::create($validatedData);

        return redirect()->back()->with('success', 'Keluhan Anda telah berhasil diajukan!');
    }

    // Metode index() dan show() untuk publik dihapus karena pengelolaan hanya untuk admin.
    // Jika Anda ingin mengaktifkan kembali tampilan publik, Anda bisa menambahkannya kembali di sini.
    // public function index() { ... }
    // public function show(Complaint $complaint) { ... }
}
