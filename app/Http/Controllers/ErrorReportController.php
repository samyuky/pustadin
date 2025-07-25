<?php

namespace App\Http\Controllers;

use App\Models\ErrorReport;
use Illuminate\Http\Request;

class ErrorReportController extends Controller
{
    /**
     * Menampilkan form untuk melaporkan error.
     */
    public function create()
    {
        return view('error_reports.create');
    }

    /**
     * Menyimpan laporan error baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reporter_name' => 'nullable|string|max:255',
            'reporter_email' => 'nullable|email|max:255',
            'attachment_path' => 'nullable|file|mimes:pdf,doc,docx,zip|max:2048',
        ]);

        // Tambahkan status secara eksplisit
        $validatedData['status'] = 'open'; // Menetapkan status default 'open'

        ErrorReport::create($validatedData);

        return redirect()->back()->with('success', 'Laporan error Anda telah berhasil diajukan!');
    }
}
