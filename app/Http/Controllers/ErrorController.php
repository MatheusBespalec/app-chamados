<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ErrorController extends Controller
{
    public function index()
    {
        $headers = [
            'ID',
            'Código',
            'Arquivo',
            'Linha',
            'Mensagem',
            'Status',
            'Ultima Ocorrência'
        ];
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

        return Inertia::render('Error/Index', compact('headers', 'errors'));
    }
}
