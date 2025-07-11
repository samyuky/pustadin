<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Untuk menggunakan now()
use Illuminate\Support\Facades\Log; // Untuk logging pesan WA
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement; // Pastikan ini yang ada
use App\Models\BulletinBoardAnnouncement; // Pastikan ini yang ada

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Menampilkan daftar semua keluhan.
     */
    public function index()
    {
        $complaints = Complaint::latest()->paginate(10);
        return view('admin.complaints.index', compact('complaints')); // Meneruskan $complaints
    }

    /**
     * Menampilkan detail keluhan tertentu.
     */
    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Memperbarui keluhan (status dan catatan resolusi).
     */
    // public function update(Request $request, Complaint $complaint)
    // {
    //     $validatedData = $request->validate([
    //         'status' => 'required|in:new,investigating,resolved',
    //         'resolution_notes' => 'nullable|string',
    //     ]);

    //     // Jika status diubah menjadi 'resolved' dan belum ada resolved_at, set waktu sekarang
    //     if ($validatedData['status'] === 'resolved' && is_null($complaint->resolved_at)) {
    //         $validatedData['resolved_at'] = Carbon::now();
    //     } elseif ($validatedData['status'] !== 'resolved') {
    //         // Jika status bukan 'resolved', reset resolved_at
    //         $validatedData['resolved_at'] = null;
    //     }

    //     $complaint->update($validatedData);

    //     // --- Logika Pengiriman Pesan WhatsApp (Konseptual) ---
    //     if ($complaint->status === 'resolved' && $complaint->complainant_email) { // Kirim jika diselesaikan dan ada email pelapor
    //         $this->sendWhatsAppNotification($complaint);
    //     }

    //     return redirect()->route('admin.complaints.index')->with('success', 'Keluhan berhasil diperbarui!');
    // }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $complaint->status = $request->status;
        $complaint->admin_id = Auth::guard('admin')->id(); // Catat admin yang mengubah status
        $complaint->save();

        return redirect()->route('admin.error-reports.show', $complaint->id)
                         ->with('success', 'Status laporan error berhasil diperbarui.');
    }

    /**
     * Menghapus keluhan.
     */
    public function destroy(Complaint $complaint)
    {
        try {
            $complaint->delete();
            return redirect()->route('admin.complaints.index')->with('success', 'Keluhan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.complaints.index')->with('error', 'Gagal menghapus keluhan: ' . $e->getMessage());
        }
    }

    /**
     * Metode konseptual untuk mengirim notifikasi WhatsApp.
     * Anda perlu mengganti ini dengan integrasi WhatsApp API yang sebenarnya.
     */
    protected function sendWhatsAppNotification(Complaint $complaint)
    {
        // Asumsi nomor telepon pelapor bisa didapatkan dari email atau ada kolom terpisah
        // Untuk demo, kita gunakan email sebagai placeholder atau Anda bisa tambahkan kolom phone di migrasi
        $contactInfo = $complaint->complainant_email ?? $complaint->complainant_name; // Gunakan email atau nama sebagai kontak

        $message = "Halo " . ($complaint->complainant_name ?? 'Pelapor') . ",\n\n";
        $message .= "Keluhan Anda (Subjek: " . $complaint->subject . ") telah berhasil diselesaikan.\n";
        $message .= "Catatan penyelesaian: " . ($complaint->resolution_notes ?? 'Tidak ada catatan tambahan.') . "\n\n";
        $message .= "Terima kasih atas keluhan Anda.\nPUSDATIN UNIGA";

        // --- Placeholder untuk Panggilan API WhatsApp ---
        // Di sini Anda akan mengintegrasikan kode API WhatsApp Anda yang sebenarnya.
        // Anda perlu nomor telepon yang valid di database (misal, tambahkan kolom `phone` di Complaint)
        // Contoh:
        // $phoneNumber = $complaint->phone; // Jika ada kolom 'phone'
        // if ($phoneNumber) {
        //     $client = new \GuzzleHttp\Client();
        //     try {
        //         $response = $client->post('URL_API_WHATSAPP_ANDA', [
        //             'headers' => [ /* Auth Headers */ ],
        //             'json' => [
        //                 'to' => 'whatsapp:' . $phoneNumber,
        //                 'body' => $message,
        //             ],
        //         ]);
        //         Log::info("WhatsApp sent to {$phoneNumber} for complaint ID {$complaint->id}.");
        //     } catch (\Exception $e) {
        //         Log::error("Failed to send WhatsApp for complaint ID {$complaint->id}. Error: " . $e->getMessage());
        //     }
        // }

        Log::info("Simulasi pengiriman WhatsApp untuk keluhan ID {$complaint->id} ke {$contactInfo}. Pesan: " . $message);
    }
}
