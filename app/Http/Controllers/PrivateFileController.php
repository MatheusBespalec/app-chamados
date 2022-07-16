<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivateFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($filePath)
    {
        $fullPath = storage_path('app/' . $filePath);
        if (file_exists($fullPath)) {
            return response()->file($fullPath);
        }
        return abort(404, 'Resource Unavailable');
    }
}
