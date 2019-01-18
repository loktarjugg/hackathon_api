<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->file('file')->storePublicly('public');

        return url(\Storage::url($path));
    }
}
