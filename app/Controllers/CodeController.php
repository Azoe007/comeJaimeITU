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
        $codesDisponibles = [
            ['code' => 'HC-1000-A', 'valeur_en_ar' => 10000, 'type' => 'Standard', 'id_statut_code' => 1],
            ['code' => 'HC-2500-B', 'valeur_en_ar' => 25000, 'type' => 'Gold', 'id_statut_code' => 1],
            ['code' => 'HLT-2026-90', 'valeur_en_ar' => 10000, 'type' => 'Promo', 'id_statut_code' => 1],
        ];

        $data = [
            'pageTitle'   => 'Codes - Health Coach',
            'pageHeading' => 'Codes',
            'breadcrumb'  => 'Codes',
            'codes'       => $codesDisponibles,
        ];

        return view('code/index', $data);
    }

    public function adminIndex()
    {
        $codes = [
            ['code' => 'HC-1000-A', 'valeur_en_ar' => 10000, 'id_statut_code' => 1, 'prenom' => '', 'nom' => ''],
            ['code' => 'HC-2500-B', 'valeur_en_ar' => 25000, 'id_statut_code' => 2, 'prenom' => 'Rakoto', 'nom' => 'Jaime'],
            ['code' => 'HC-5000-C', 'valeur_en_ar' => 50000, 'id_statut_code' => 3, 'prenom' => '', 'nom' => ''],
        ];

        $stats = [
            'total_codes' => count($codes),
            'available_codes' => count(array_filter($codes, fn($c) => (int) $c['id_statut_code'] === 1)),
            'used_codes' => count(array_filter($codes, fn($c) => (int) $c['id_statut_code'] === 2)),
            'blocked_codes' => count(array_filter($codes, fn($c) => (int) $c['id_statut_code'] === 3)),
        ];

        $data = [
            'pageTitle'   => 'Codes de recharge - Health Coach',
            'pageHeading' => 'Codes de recharge',
            'breadcrumb'  => 'Codes',
            'activeMenu'  => 'codes',
            'codes'       => $codes,
            'stats'       => $stats,
        ];

        return view('admin/codes', $data);
    }
}
