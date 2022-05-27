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
        return Storage::disk('public')->download($this->path);
    }


}
