<?php

namespace App\Http\Controllers;

use App\Models\DataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Untuk logging pesan WA (opsional)

class DataRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->only(['index', 'show', 'updateStatus', 'destroy']);
    }

    public function create()
    {
        return view('data_requests.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'requester_name' => 'required|string|max:255',
            'requester_email' => 'required|email|max:255',
            'requester_phone' => 'nullable|string|max:20',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'required|string|max:255',
            'needed_date' => 'required|date',
            'attachment_path' => 'nullable|file|mimes:pdf,doc,docx,zip|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment_path')) {
            $attachmentPath = $request->file('attachment_path')->store('attachments', 'public');
        }

        DataRequest::create([
            'requester_name' => $validatedData['requester_name'],
            'requester_email' => $validatedData['requester_email'],
            'requester_phone' => $validatedData['requester_phone'],
            'admin_id' => null,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'purpose' => $validatedData['purpose'],
            'needed_date' => $validatedData['needed_date'],
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permintaan data Anda telah berhasil diajukan!');
    }

    public function index()
    {
        $dataRequests = DataRequest::latest()->get();
        return view('admin.data_requests.index', compact('dataRequests'));
    }

    public function show(DataRequest $dataRequest)
    {
        return view('admin.data_requests.show', compact('dataRequest'));
    }

    public function updateStatus(Request $request, DataRequest $dataRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'delivered_data_file' => 'nullable|file|max:10240', // Maks 10MB untuk file yang dikirim
            // Anda bisa tambahkan validasi untuk jenis file yang dikirim jika perlu
        ]);

        $deliveredDataPath = $dataRequest->delivered_data_path; // Ambil path lama jika ada

        // Jika ada file baru yang diunggah untuk delivered_data_file
        if ($request->hasFile('delivered_data_file')) {
            // Hapus file lama jika ada
            if ($deliveredDataPath && Storage::disk('public')->exists($deliveredDataPath)) {
                Storage::disk('public')->delete($deliveredDataPath);
            }
            // Simpan file baru
            $deliveredDataPath = $request->file('delivered_data_file')->store('delivered_data', 'public');
        }

        $dataRequest->update([
            'status' => $request->status,
            'admin_id' => Auth::guard('admin')->id(),
            'delivered_data_path' => $deliveredDataPath, // Simpan path file yang dikirim
        ]);

        // --- Logika Pengiriman Pesan WhatsApp (Konseptual) ---
        // Pesan WA akan dikirim jika status diubah menjadi 'approved' atau 'completed'
        // DAN ada file data yang dikirimkan
        if (in_array($dataRequest->status, ['approved', 'completed']) && $dataRequest->delivered_data_path) {
            $this->sendWhatsAppNotification($dataRequest);
        }

        return redirect()->route('admin.data_requests.index')->with('success', 'Status permintaan data berhasil diperbarui.');
    }

    public function destroy(DataRequest $dataRequest)
    {
        try {
            // Hapus file lampiran user jika ada
            if ($dataRequest->attachment_path && Storage::disk('public')->exists($dataRequest->attachment_path)) {
                Storage::disk('public')->delete($dataRequest->attachment_path);
            }
            // Hapus file data yang dikirimkan admin jika ada
            if ($dataRequest->delivered_data_path && Storage::disk('public')->exists($dataRequest->delivered_data_path)) {
                Storage::disk('public')->delete($dataRequest->delivered_data_path);
            }

            $dataRequest->delete();

            return redirect()->route('admin.data_requests.index')->with('success', 'Permintaan data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.data_requests.index')->with('error', 'Gagal menghapus permintaan data: ' . $e->getMessage());
        }
    }

    /**
     * Metode konseptual untuk mengirim notifikasi WhatsApp.
     * Anda perlu mengganti ini dengan integrasi WhatsApp API yang sebenarnya.
     */
    protected function sendWhatsAppNotification(DataRequest $dataRequest)
    {
        $phoneNumber = $dataRequest->requester_phone; // Nomor telepon pemohon
        $dataLink = Storage::url($dataRequest->delivered_data_path); // URL publik dari file data
        $message = "Halo " . $dataRequest->requester_name . ",\n\n";
        $message .= "Permintaan data Anda (Judul: " . $dataRequest->title . ") telah " . ucfirst($dataRequest->status) . ".\n";
        $message .= "Data yang Anda minta dapat diunduh melalui link berikut:\n" . $dataLink . "\n\n";
        $message .= "Terima kasih atas kerja sama Anda.\nPUSDATIN UNIGA";

        // --- Placeholder untuk Panggilan API WhatsApp ---
        // Di sini Anda akan mengintegrasikan kode API WhatsApp Anda yang sebenarnya.
        // Contoh dengan cURL (Anda mungkin menggunakan library Guzzle atau SDK dari penyedia WA API):
        /*
        $whatsappApiEndpoint = 'URL_API_WHATSAPP_ANDA'; // Contoh: 'https://api.twilio.com/2010-04-01/Accounts/ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/Messages.json'
        $apiToken = 'TOKEN_API_ANDA'; // Contoh: 'YOUR_TWILIO_AUTH_TOKEN'
        $fromNumber = 'NOMOR_WHATSAPP_ANDA'; // Contoh: 'whatsapp:+14155238886' (nomor Twilio sandbox)

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post($whatsappApiEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken, // Atau Basic Auth, tergantung API
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'to' => 'whatsapp:' . $phoneNumber, // Format nomor WA yang benar
                    'from' => $fromNumber,
                    'body' => $message,
                    // 'mediaUrl' => [$dataLink], // Jika API mendukung pengiriman file langsung
                ],
            ]);
            Log::info("WhatsApp sent to {$phoneNumber} for request ID {$dataRequest->id}. Response: " . $response->getBody());
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp to {$phoneNumber} for request ID {$dataRequest->id}. Error: " . $e->getMessage());
        }
        */

        // Untuk tujuan demonstrasi, kita hanya akan log pesan
        Log::info("Simulasi pengiriman WhatsApp ke {$phoneNumber} untuk permintaan ID {$dataRequest->id}. Pesan: " . $message);
    }
}
