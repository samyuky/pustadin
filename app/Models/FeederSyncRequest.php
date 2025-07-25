<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class FeederSyncRequest extends Model
    {
        use HasFactory;

        protected $fillable = [
            'subject',
            'description',
            'requester_name',
            'requester_email',
            'request_type',
            'status',
            'resolution_notes',
            'admin_id',
            'resolved_at',
        ];
    }
    