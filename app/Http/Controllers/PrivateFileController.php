<?php

namespace App\Http\Controllers;


class PrivateFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($filePath = null)
    {
        $fullPath = storage_path('app/' . $filePath);
        if (!empty($filePath) && file_exists($fullPath)) {
            return response()->file($fullPath);
        }
        return abort(404, 'Resource Unavailable');
    }
}
