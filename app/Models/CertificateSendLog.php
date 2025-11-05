<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateSendLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'to_email',
        'cc_emails',
        'status',
        'error',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}


