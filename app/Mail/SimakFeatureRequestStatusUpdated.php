<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SimakFeatureRequest;

class SimakFeatureRequestStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct(SimakFeatureRequest $request, string $status)
    {
        $this->request = $request;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Permintaan Fitur SIMAK Diperbarui')
                   ->view('emails.simak_feature_request_status_updated');
    }
}