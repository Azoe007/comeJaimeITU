<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\RegimeModel;

class SuggestionController extends BaseController
{
    protected RegimeModel $regimeModel;
    protected ActiviteSportiveModel $activiteSportiveModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
        $this->activiteSportiveModel = new ActiviteSportiveModel();
    }

    public function index(): string
    {
        $funnel = session('objectif_funnel') ?? [];

        if (empty($funnel['objectif_nom'])) {
            return redirect()->to(base_url('objectif/diagnostic'));
        }

        $suggestions = $this->buildSuggestions($funnel);
        session()->set('generated_suggestions', $suggestions);

        return view('suggestion/index', [
            'pageTitle' => 'Suggestions personnalisees - Health Coach',
            'objectifLabel' => $this->buildObjectiveLabel($funnel['objectif_type'] ?? 'ideal', $funnel['target_kg'] ?? null),
            'suggestions' => $suggestions,
        ]);
    }

    public function detail(int $index): string
    {
        $funnel = session('objectif_funnel') ?? [];
        $suggestions = session('generated_suggestions') ?? $this->buildSuggestions($funnel);
        $suggestion = $suggestions[$index] ?? null;

        if ($suggestion === null) {
            return redirect()->to(base_url('suggestion'));
        }

        return view('suggestion/detail', [
            'pageTitle' => 'Detail programme - Health Coach',
            'suggestion' => $suggestion,
            'objectifLabel' => $this->buildObjectiveLabel($funnel['objectif_type'] ?? 'ideal', $funnel['target_kg'] ?? null),
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

    protected function buildSuggestions(array $funnel): array
    {
        $objectifType = $funnel['objectif_type'] ?? 'ideal';
        $regimeType = $objectifType === 'augmenter' ? 'augmentation' : 'diminution';
        $regimes = $this->regimeModel->where('type', $regimeType)->findAll();
        $activites = $this->activiteSportiveModel->findAll();

        if ($objectifType === 'ideal') {
            $regimes = $this->regimeModel->findAll();
        }

        if (empty($regimes)) {
            return $this->fallbackSuggestions($funnel);
        }

        $targetKg = (float) ($funnel['target_kg'] ?? 0);
        $suggestions = [];
        $activityIndex = 0;

        foreach (array_values($regimes) as $index => $regime) {
            $variation = (float) ($regime['variation'] ?? 0);
            $duree = (int) ($regime['duree'] ?? 15);
            $basePrice = max(12000, (int) round($duree * 1200 + abs($variation) * 2500));
            $activity = $activites[$activityIndex] ?? null;
            $activityIndex++;

            $withActivity = $activity !== null && ($objectifType !== 'augmenter' || $index % 2 === 0);
            $activityLabel = $withActivity ? (string) $activity['description'] : 'Sans activite sportive obligatoire';
            $activityMeta = $withActivity
                ? ((int) ($activity['frequence'] ?? 3)) . ' seances / semaine - ' . ((int) ($activity['duree'] ?? 30)) . ' min'
                : 'Programme nutritionnel seul';

            $suggestions[] = [
                'id' => $index,
                'title' => $this->buildRegimeTitle($regime, $index),
                'description' => (string) ($regime['description'] ?? 'Programme nutritionnel personnalise.'),
                'goalText' => $this->buildObjectiveLabel($objectifType, $targetKg ?: null),
                'duree' => $duree,
                'prix' => $basePrice,
                'prixGold' => (int) round($basePrice * 0.85),
                'regime' => $this->buildRegimeTitle($regime, $index),
                'sport' => $activityLabel,
                'activityMeta' => $activityMeta,
                'withActivity' => $withActivity,
                'tags' => [
                    $withActivity ? 'Avec activite' : 'Sans activite',
                    ucfirst((string) ($regime['type'] ?? 'equilibre')),
                    $duree . ' jours',
                ],
                'macros' => [
                    'viande' => (float) ($regime['viande'] ?? 0),
                    'poisson' => (float) ($regime['poisson'] ?? 0),
                    'volaille' => (float) ($regime['volaille'] ?? 0),
                ],
                'variation' => $variation,
            ];
        }

        return array_slice($suggestions, 0, 6);
    }

    protected function buildRegimeTitle(array $regime, int $index): string
    {
        $title = trim((string) ($regime['description'] ?? ''));
        if ($title !== '') {
            return mb_strimwidth($title, 0, 42, '...');
        }

        return 'Programme ' . ($index + 1);
    }

    protected function fallbackSuggestions(array $funnel): array
    {
        $objectifType = $funnel['objectif_type'] ?? 'ideal';
        $goalText = $this->buildObjectiveLabel($objectifType, $funnel['target_kg'] ?? null);

        return [
            [
                'id' => 0,
                'title' => 'Equilibre Vital 15 jours',
                'description' => 'Programme simple pour ajuster rapidement votre trajectoire de poids.',
                'goalText' => $goalText,
                'duree' => 15,
                'prix' => 24000,
                'prixGold' => 20400,
                'regime' => 'Equilibre Vital',
                'sport' => 'Marche active + cardio doux',
                'activityMeta' => '3 seances / semaine - 30 min',
                'withActivity' => true,
                'tags' => ['Avec activite', 'Equilibre', '15 jours'],
                'macros' => ['viande' => 40, 'poisson' => 30, 'volaille' => 30],
                'variation' => $objectifType === 'augmenter' ? 2 : -2,
            ],
            [
                'id' => 1,
                'title' => 'Reset Nutrition 21 jours',
                'description' => 'Version plus structuree pour une progression visible sur trois semaines.',
                'goalText' => $goalText,
                'duree' => 21,
                'prix' => 28000,
                'prixGold' => 23800,
                'regime' => 'Reset Nutrition',
                'sport' => 'Sans activite sportive obligatoire',
                'activityMeta' => 'Programme nutritionnel seul',
                'withActivity' => false,
                'tags' => ['Sans activite', 'Nutrition', '21 jours'],
                'macros' => ['viande' => 35, 'poisson' => 35, 'volaille' => 30],
                'variation' => $objectifType === 'augmenter' ? 2.5 : -3,
            ],
            [
                'id' => 2,
                'title' => 'Forme Durable 30 jours',
                'description' => 'Programme plus complet avec activite encadree et progression plus stable.',
                'goalText' => $goalText,
                'duree' => 30,
                'prix' => 36000,
                'prixGold' => 30600,
                'regime' => 'Forme Durable',
                'sport' => 'Renforcement leger + marche rapide',
                'activityMeta' => '4 seances / semaine - 40 min',
                'withActivity' => true,
                'tags' => ['Avec activite', 'Progressif', '30 jours'],
                'macros' => ['viande' => 30, 'poisson' => 40, 'volaille' => 30],
                'variation' => $objectifType === 'augmenter' ? 4 : -4,
            ],
        ];
    }
}
