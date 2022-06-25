<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ErrorController extends Controller
{
    public function index()
    {
        $errors = [
            [
                'id' => 1,
                'code' => 0,
                'file' => 'teste.php',
                'line' => 25,
                'message' => 'testestestes',
                'status' => 0,
                'updated_at' => '21/05/2022'
            ],
            [
                'id' => 2,
                'code' => 0,
                'file' => 'index.php',
                'line' => 258,
                'message' => 'aaaaaaaaaaaaa',
                'status' => 0,
                'updated_at' => '15/05/2022'
            ],
        ];

        return Inertia::render('Error/Index', compact('errors'));
    }

    public function show()
    {
        $error = [
            'id' => 1,
            'message' => 'Undefined variable $teste',
            'url' => 'http://teste.com/login',
            'method' => 'POST'
        ];
        return Inertia::render('Error/Show', compact('error'));
    }
}
