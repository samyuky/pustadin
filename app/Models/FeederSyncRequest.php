<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeederSyncRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_name',    // Ditambahkan/disesuaikan
        'requester_email',   // Ditambahkan/disesuaikan
        'request_type',      // Ditambahkan/disesuaikan
        'description',
        'requester_phone',   // Ditambahkan/disesuaikan
        'status',
        'admin_id',          // Ditambahkan/disesuaikan
    ];

    // Jika Anda memiliki relasi dengan model Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
