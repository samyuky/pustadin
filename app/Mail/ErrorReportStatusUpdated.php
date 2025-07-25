<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorReportStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $errorReport;
    public $status; // Ubah dari $newStatus menjadi $status untuk konsistensi

    public function __construct($errorReport, $status)
    {
        $this->errorReport = $errorReport;
        $this->status = $status; // Simpan parameter sebagai property
    }

    public function build()
    {
        return $this->subject('Status Laporan Error Diperbarui')
                   ->view('emails.error_report_status_updated')
                   ->with([
                       'errorReport' => $this->errorReport,
                       'status' => $this->status // Pastikan variabel ini tersedia di view
                   ]);
    }
}