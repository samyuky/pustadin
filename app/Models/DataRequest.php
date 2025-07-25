<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_name',    
        'requester_email',   
        'requester_phone', 
        'title',
        'description',
        'purpose',
        'needed_date',
        'attachment_path',
        'status',
    ];

    protected $casts = [
        'needed_date' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}