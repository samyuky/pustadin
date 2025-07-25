<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SimakFeatureRequest extends Model
    {
        use HasFactory;

        protected $fillable = [
            'feature_name',
            'description',
            'requester_name',
            'requester_email',
            'letter_file',
            'letter_path',
            'status',
            'admin_notes',
            'admin_id',
        ];

        // Relasi dengan model Admin (jika admin yang memproses)
        public function admin()
        {
            return $this->belongsTo(Admin::class);
        }
    }
    