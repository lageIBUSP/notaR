<?php

namespace App\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TmpFile
{
    static public function generateTmpFileName (string $name, string $extension) {
        $name = Str::slug($name);
        return '/temp/'.$name.'_'.date('Ymd-his').$extension;
    }
}
