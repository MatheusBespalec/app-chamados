<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
