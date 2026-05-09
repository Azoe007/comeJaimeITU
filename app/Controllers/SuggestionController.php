<?php

namespace App\Controllers;

class SuggestionController extends BaseController
{
    public function index(): string
    {
        $funnel = session('objectif_funnel') ?? [];

        if (empty($funnel['objectif_nom'])) {
            return redirect()->to(base_url('objectif/diagnostic'));
        }

        $targetKg = $funnel['target_kg'] ?? null;
        $objectifType = $funnel['objectif_type'] ?? 'ideal';
        $objectifLabel = $this->buildObjectiveLabel($objectifType, $targetKg);

        return view('suggestion/index', [
            'pageTitle' => 'Suggestion personnalisee - Health Coach',
            'suggestion' => [
                'objectifLabel' => $objectifLabel,
                'regime' => 'Equilibre Vital',
                'sport' => 'Marche active + cardio doux',
                'duree' => 15,
                'prix' => 24000,
                'prixGold' => 20400,
            ],
            'isLoggedIn' => (bool) session('isLoggedIn'),
        ]);
    }

    protected function buildObjectiveLabel(string $objectifType, $targetKg): string
    {
        if ($objectifType === 'reduire' && $targetKg) {
            return '-' . rtrim(rtrim(number_format((float) $targetKg, 1, '.', ''), '0'), '.') . ' kg';
        }

        if ($objectifType === 'augmenter' && $targetKg) {
            return '+' . rtrim(rtrim(number_format((float) $targetKg, 1, '.', ''), '0'), '.') . ' kg';
        }

        return 'votre poids sante';
    }
}
