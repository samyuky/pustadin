<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Complaint;

class ComplaintStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $request, string $status)
    {
        $this->request = $request;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Keluhan Diperbarui')
                   ->view('emails.complaint_status_updated');
    }
}