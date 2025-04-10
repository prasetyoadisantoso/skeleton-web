<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class Encryption
{
    // Encrypt Token
    public function EncryptToken($data = null)
    {
        return Crypt::encryptString($data);
    }

    // Decrypt Token
    public function DecryptToken($data = null)
    {
        return Crypt::decryptString($data);
    }
}
