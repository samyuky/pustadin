<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DataRequestStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $dataRequest;
    public $status; // Ubah dari $newStatus menjadi $status untuk konsistensi

    public function __construct($dataRequest, $status)
    {
        $this->dataRequest = $dataRequest;
        $this->status = $status; // Simpan parameter sebagai property
    }

    public function build()
    {
        return $this->subject('Status Permintaan Data Diperbarui')
                   ->view('emails.data_request_status_updated')
                   ->with([
                       'dataRequest' => $this->dataRequest,
                       'status' => $this->status // Pastikan variabel ini tersedia di view
                   ]);
    }
}