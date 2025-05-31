<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240' // 10MB max
        ]);

        $file = $request->file('file');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        
        // Store the file in the public disk under uploads directory
        $path = $file->storeAs('uploads', $filename, 'public');
        
        return response()->json([
            'url' => Storage::url($path),
            'filename' => $filename
        ]);
    }
} 