<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    # Check if $value is encrypted
    public static function decrypyId($value)
    {
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }

        return $value;
    }
}
