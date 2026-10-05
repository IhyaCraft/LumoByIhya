<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table = 'otp_verifications';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'otp_hash',
        'type',
        'expires_at',
        'attempts',
        'verified_at',
        'created_at'
    ];

    protected $useTimestamps = false;
}