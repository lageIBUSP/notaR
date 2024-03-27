<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Arquivo extends Model
{
    protected $fillable = [
        'name',
        'path',
    ];

    public function getUrlAttribute() {
        return Storage::url($this->path);
    }

    public function download() {
        // Gambiarra pra resolver problema do league/flysystem que não reconhece os mimetypes
        $headers = [];
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);
        if ($ext == 'r' | $ext == 'R')
            $headers = ['Content-Type' => 'text/plain'];
        // Manda o download
        return Storage::disk('public')->download($this->path, $this->name, $headers);
    }


}
