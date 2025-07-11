<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_name',
        'reporter_email',
        'reporter_phone',
        'title',
        'description',
        'related_system',
        'screenshot_path',
        'status',
        'admin_id', // <-- Tambahkan ini
    ];

    // Jika Anda memiliki relasi dengan model Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}