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
        'resolution_notes',
        'resolved_at',
        'admin_id'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];
}