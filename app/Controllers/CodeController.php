<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CodeController extends BaseController
{
    // public function index()
    // {
    //     return view('code/index', [
    //         'pageTitle' => 'Codes - Health Coach',
    //         'pageHeading' => 'Codes',
    //         'breadcrumb' => 'Codes',
    //     ]);
    // }

    public function index()
{
    $codeModel = new \App\Models\CodeModel();
    
    // On ne récupère que les codes disponibles (statut 1)
    $codesDisponibles = $codeModel->where('id_statut_code', 1)->findAll();

    $data = [
        'pageTitle'   => 'Codes - Health Coach',
        'pageHeading' => 'Codes',
        'breadcrumb'  => 'Codes',
        'codes'       => $codesDisponibles // ito ilay clé $codes any amin view
    ];

    return view('code/index', $data);
}
}
