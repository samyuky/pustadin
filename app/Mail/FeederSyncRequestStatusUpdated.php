<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\FeederSyncRequest;

class FeederSyncRequestStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $feederSyncRequest;
    public $status;

    public function __construct(FeederSyncRequest $feederSyncRequest, $status)
    {
        $this->feederSyncRequest = $feederSyncRequest;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Status Permintaan Sinkronisasi Feeder Diperbarui')
                   ->view('emails.feeder_sync_request_status_updated');
    }
}