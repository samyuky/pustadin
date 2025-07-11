<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Announcement extends Model
    {
        use HasFactory;

        protected $fillable = [
            'title',
            'content',
            'admin_id',
            'published_at',
        ];

        protected $casts = [
            'published_at' => 'datetime',
        ];

        // Relasi dengan model Admin
        public function admin()
        {
            return $this->belongsTo(Admin::class);
        }
    }
    