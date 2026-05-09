<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\UserHealthModel;
use App\Models\UserModel;

class ObjectifController extends BaseController
{
    protected UserModel $userModel;
    protected UserHealthModel $userHealthModel;
    protected ObjectifModel $objectifModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userHealthModel = new UserHealthModel();
        $this->objectifModel = new ObjectifModel();
    }

    public function diagnostic(): string
    {
        $prefill = $this->getPrefillData();
        $funnel = session('objectif_funnel') ?? [];

        return view('objectif/diagnostic', [
            'pageTitle' => 'Commencer mon bilan - Health Coach',
            'diagnostic' => [
                'genre' => old('genre', $funnel['genre'] ?? $prefill['genre'] ?? ''),
                'taille' => old('taille', $funnel['taille'] ?? $prefill['taille'] ?? ''),
                'poids' => old('poids', $funnel['poids'] ?? $prefill['poids'] ?? ''),
            ],
        ]);
    }

    public function saveDiagnostic()
    {
        $rules = [
            'genre' => 'required|in_list[M,F,Autre]',
            'taille' => 'required|numeric|greater_than[0]',
            'poids' => 'required|numeric|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $funnel = session('objectif_funnel') ?? [];
        $funnel['genre'] = (string) $this->request->getPost('genre');
        $funnel['taille'] = (float) $this->request->getPost('taille');
        $funnel['poids'] = (float) $this->request->getPost('poids');

        session()->set('objectif_funnel', $funnel);

        return redirect()->to(base_url('objectif/intention'));
    }

    public function intention(): string
    {
        $funnel = session('objectif_funnel') ?? [];

        if (empty($funnel['genre']) || empty($funnel['taille']) || empty($funnel['poids'])) {
            return redirect()->to(base_url('objectif/diagnostic'));
        }

        return view('objectif/intention', [
            'pageTitle' => 'Fixer mon objectif - Health Coach',
            'objectifs' => $this->objectifModel->findAll(),
            'selectedObjectif' => old('objectif_id', $funnel['objectif_id'] ?? ''),
            'targetKg' => old('target_kg', $funnel['target_kg'] ?? ''),
        ]);
    }

    public function saveIntention()
    {
        $rules = [
            'objectif_id' => 'required|integer',
            'target_kg' => 'permit_empty|numeric|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $objectifId = (int) $this->request->getPost('objectif_id');
        $objectif = $this->objectifModel->find($objectifId);

        if (! $objectif) {
            return redirect()->back()->withInput()->with('error', 'Objectif introuvable.');
        }

        $normalized = $this->normalizeObjectiveName((string) $objectif['nom']);
        $targetKg = $this->request->getPost('target_kg');

        if (in_array($normalized, ['augmenter', 'reduire'], true) && ($targetKg === null || $targetKg === '' || (float) $targetKg <= 0)) {
            return redirect()->back()->withInput()->with('error', 'Precisez le nombre de kilos souhaite.');
        }

        $funnel = session('objectif_funnel') ?? [];
        $funnel['objectif_id'] = $objectifId;
        $funnel['objectif_nom'] = (string) $objectif['nom'];
        $funnel['objectif_type'] = $normalized;
        $funnel['target_kg'] = $targetKg !== null && $targetKg !== '' ? (float) $targetKg : null;

        session()->set('objectif_funnel', $funnel);

        return redirect()->to(base_url('suggestion'));
    }

    protected function getPrefillData(): array
    {
        $userId = (int) session('user_id');
        if ($userId <= 0) {
            return [];
        }

        $user = $this->userModel->find($userId);
        $health = $this->userHealthModel->getByUserId($userId);

        return [
            'genre' => $user['genre'] ?? '',
            'taille' => $health['taille'] ?? '',
            'poids' => $health['poids'] ?? '',
        ];
    }

    protected function normalizeObjectiveName(string $name): string
    {
        $value = strtolower(trim($name));

        if (str_contains($value, 'redu')) {
            return 'reduire';
        }

        if (str_contains($value, 'augment') || str_contains($value, 'gain')) {
            return 'augmenter';
        }

        return 'ideal';
    }
}
