<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;

class AdminSportController extends BaseController
{
    protected ActiviteSportiveModel $activiteSportiveModel;

    public function __construct()
    {
        $this->activiteSportiveModel = new ActiviteSportiveModel();
    }

    public function index()
    {
        $editingId = (int) ($this->request->getGet('edit') ?? 0);
        $editingSport = $editingId > 0 ? $this->activiteSportiveModel->find($editingId) : null;

        return view('admin/sports', [
            'pageTitle' => 'CRUD Sports - Health Coach',
            'pageHeading' => 'Gestion des activites sportives',
            'breadcrumb' => 'Sports',
            'activeMenu' => 'sports',
            'sports' => $this->activiteSportiveModel->orderBy('id', 'DESC')->findAll(),
            'editingSport' => $editingSport,
        ]);
    }

    public function store()
    {
        $payload = $this->extractPayload();
        $errors = $this->validatePayload($payload);
        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $this->activiteSportiveModel->insert($payload);
        return redirect()->to(base_url('admin/sports'))->with('success', 'Activite sportive creee avec succes.');
    }

    public function update(int $id)
    {
        if (! $this->activiteSportiveModel->find($id)) {
            return redirect()->to(base_url('admin/sports'))->with('error', 'Activite introuvable.');
        }

        $payload = $this->extractPayload();
        $errors = $this->validatePayload($payload);
        if ($errors !== []) {
            return redirect()->to(base_url('admin/sports?edit=' . $id))->withInput()->with('errors', $errors);
        }

        $this->activiteSportiveModel->update($id, $payload);
        return redirect()->to(base_url('admin/sports'))->with('success', 'Activite sportive mise a jour avec succes.');
    }

    public function delete(int $id)
    {
        if (! $this->activiteSportiveModel->find($id)) {
            return redirect()->to(base_url('admin/sports'))->with('error', 'Activite introuvable.');
        }

        $this->activiteSportiveModel->delete($id);
        return redirect()->to(base_url('admin/sports'))->with('success', 'Activite sportive supprimee avec succes.');
    }

    protected function extractPayload(): array
    {
        return [
            'description' => trim((string) $this->request->getPost('description')),
            'diminution_poids' => (float) $this->request->getPost('diminution_poids'),
            'frequence' => (int) $this->request->getPost('frequence'),
            'duree' => (int) $this->request->getPost('duree'),
        ];
    }

    protected function validatePayload(array $payload): array
    {
        $errors = [];
        if ($payload['description'] === '') {
            $errors['description'] = 'La description est requise.';
        }
        if ($payload['diminution_poids'] <= 0) {
            $errors['diminution_poids'] = 'La variation de poids doit etre positive.';
        }
        if ($payload['frequence'] <= 0) {
            $errors['frequence'] = 'La frequence doit etre superieure a zero.';
        }
        if ($payload['duree'] <= 0) {
            $errors['duree'] = 'La duree doit etre superieure a zero.';
        }

        return $errors;
    }
}
