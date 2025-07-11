<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Complaint extends Model
    {
        use HasFactory;

        protected $fillable = [
            'subject',
            'message',
            'complainant_name',
            'complainant_email',
            'status',
            'resolution_notes', // <-- Tambahkan ini
            'resolved_at',      // <-- Tambahkan ini
        ];

        protected $casts = [
            'resolved_at' => 'datetime', // Cast ke datetime
        ];
    }
    