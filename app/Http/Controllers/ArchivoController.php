<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function download($filename)
    {
        $path = 'evidencias/' . $filename;

        if (Storage::exists($path)) {
         return Storage::download($path, $filename);
        }
    }
}