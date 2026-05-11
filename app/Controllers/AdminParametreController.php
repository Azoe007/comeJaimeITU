<?php

namespace App\Controllers;

use App\Models\ParametreModel;

class AdminParametreController extends BaseController
{
    protected ParametreModel $parametreModel;

    public function __construct()
    {
        $this->parametreModel = new ParametreModel();
    }

    public function index()
    {
        $parametres = $this->getParametres();

        return view('admin/settings', [
            'pageTitle' => 'Parametres - Health Coach',
            'pageHeading' => 'Parametres metier',
            'breadcrumb' => 'Parametres',
            'activeMenu' => 'settings',
            'parametres' => $parametres,
        ]);
    }

    public function save()
    {
        $payload = $this->extractPayload();
        $errors = $this->validatePayload($payload);
        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $current = $this->parametreModel->orderBy('id', 'DESC')->first();
        if ($current) {
            $this->parametreModel->update((int) $current['id'], $payload);
        } else {
            $this->parametreModel->insert($payload);
        }

        return redirect()->to(base_url('admin/settings'))->with('success', 'Parametres mis a jour avec succes.');
    }

    protected function extractPayload(): array
    {
        return [
            'prix_gold' => (float) $this->request->getPost('prix_gold'),
            'duree_gold' => (int) $this->request->getPost('duree_gold'),
            'reduction_gold' => (float) $this->request->getPost('reduction_gold'),
        ];
    }

    protected function validatePayload(array $payload): array
    {
        $errors = [];
        if ($payload['prix_gold'] <= 0) {
            $errors['prix_gold'] = 'Le prix Gold doit etre superieur a zero.';
        }
        if ($payload['duree_gold'] <= 0) {
            $errors['duree_gold'] = 'La duree Gold doit etre superieure a zero.';
        }
        if ($payload['reduction_gold'] < 0 || $payload['reduction_gold'] > 100) {
            $errors['reduction_gold'] = 'La reduction Gold doit etre comprise entre 0 et 100.';
        }

        return $errors;
    }

    protected function getParametres(): array
    {
        $defaults = [
            'prix_gold' => 30000,
            'duree_gold' => 30,
            'reduction_gold' => 15,
        ];

        $current = $this->parametreModel->orderBy('id', 'DESC')->first();

        return array_merge($defaults, $current ?? []);
    }
}
