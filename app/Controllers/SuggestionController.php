<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\ConfigRegimeModel;
use App\Models\ObjectifHistoryModel;
use App\Models\ParametreModel;
use App\Models\ProgrammeModel;
use App\Models\RegimeModel;
use App\Models\TransactionModel;
use App\Models\WalletModel;

class SuggestionController extends BaseController
{
    protected RegimeModel $regimeModel;
    protected ActiviteSportiveModel $activiteSportiveModel;
    protected ConfigRegimeModel $configRegimeModel;
    protected ObjectifHistoryModel $objectifHistoryModel;
    protected WalletModel $walletModel;
    protected ProgrammeModel $programmeModel;
    protected TransactionModel $transactionModel;
    protected ParametreModel $parametreModel;
    protected array $goldSettings;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
        $this->activiteSportiveModel = new ActiviteSportiveModel();
        $this->configRegimeModel = new ConfigRegimeModel();
        $this->objectifHistoryModel = new ObjectifHistoryModel();
        $this->walletModel = new WalletModel();
        $this->programmeModel = new ProgrammeModel();
        $this->transactionModel = new TransactionModel();
        $this->parametreModel = new ParametreModel();
        $this->goldSettings = $this->getGoldSettings();
    }

    public function index()
    {
        $funnel = session('objectif_funnel') ?? [];

        if (empty($funnel['objectif_nom'])) {
            return redirect()->to(base_url('objectif/diagnostic'));
        }

        $context = $this->getObjetcifUser($funnel);
        $suggestions = $this->buildSuggestions($context);

        session()->set('temporary_programmes', $suggestions);

        return view('suggestion/index', [
            'pageTitle' => 'Suggestions personnalisees - Health Coach',
            'objectifLabel' => $context['label'],
            'suggestions' => $suggestions,
            'context' => $context,
        ]);
    }

    public function detail(string $key)
    {
        $funnel = session('objectif_funnel') ?? [];
        $context = $this->getObjetcifUser($funnel);
        $suggestions = session('temporary_programmes') ?? $this->buildSuggestions($context);
        $suggestion = $this->findSuggestion($suggestions, $key);

        if ($suggestion === null) {
            return redirect()->to(base_url('suggestion'));
        }

        return view('suggestion/detail', [
            'pageTitle' => 'Detail programme - Health Coach',
            'suggestion' => $suggestion,
            'objectifLabel' => $context['label'],
            'isLoggedIn' => (bool) session('isLoggedIn'),
        ]);
    }

    public function saveSelection(string $key)
    {
        $suggestions = session('temporary_programmes') ?? [];
        $suggestion = $this->findSuggestion($suggestions, $key);

        if ($suggestion === null) {
            return redirect()->to(base_url('suggestion'))->with('error', 'Programme temporaire introuvable.');
        }

        session()->set('selected_temp_programme', $suggestion);
        session()->remove('pending_objectif_history_id');

        if (! session('isLoggedIn')) {
            session()->set('redirect_after_auth', base_url('objectif/commande'));
            return redirect()->to(base_url('login'))->with('error', 'Connectez-vous ou inscrivez-vous pour continuer la commande.');
        }

        $this->ensureObjectifHistory((int) session('user_id'), session('objectif_funnel') ?? []);
        return redirect()->to(base_url('objectif/commande'));
    }

    public function commande()
    {
        $userId = (int) session('user_id');
        if ($userId <= 0) {
            session()->set('redirect_after_auth', base_url('objectif/commande'));
            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour valider votre commande.');
        }

        $suggestion = session('selected_temp_programme');
        $funnel = session('objectif_funnel') ?? [];

        if (! is_array($suggestion) || $suggestion === []) {
            return redirect()->to(base_url('suggestion'))->with('error', 'Aucun programme temporaire selectionne.');
        }

        $historyId = $this->ensureObjectifHistory($userId, $funnel);
        $walletBalance = (int) ($this->walletModel->get_solde($userId) ?? 0);
        $priceToPay = (bool) session('is_gold') ? (int) $suggestion['prixGold'] : (int) $suggestion['prix'];

        return view('suggestion/commande', [
            'pageTitle' => 'Valider ma commande - Health Coach',
            'suggestion' => $suggestion,
            'walletBalance' => $walletBalance,
            'priceToPay' => $priceToPay,
            'isGold' => (bool) session('is_gold'),
            'goldReduction' => $this->getGoldReduction(),
            'canAfford' => $walletBalance >= $priceToPay,
            'historyId' => $historyId,
        ]);
    }

    public function payer()
    {
        $userId = (int) session('user_id');
        if ($userId <= 0) {
            session()->set('redirect_after_auth', base_url('objectif/commande'));
            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour payer ce programme.');
        }

        $suggestion = session('selected_temp_programme');
        if (! is_array($suggestion) || $suggestion === []) {
            return redirect()->to(base_url('suggestion'))->with('error', 'Programme temporaire introuvable.');
        }

        $priceToPay = (bool) session('is_gold') ? (int) $suggestion['prixGold'] : (int) $suggestion['prix'];
        $balance = (int) ($this->walletModel->get_solde($userId) ?? 0);

        if ($balance < $priceToPay) {
            return redirect()->to(base_url('objectif/commande'))->with('error', 'Solde insuffisant pour commander ce programme.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            if (! $this->walletModel->retirer_solde($userId, $priceToPay)) {
                $db->transRollback();
                return redirect()->to(base_url('objectif/commande'))->with('error', 'Solde insuffisant pour commander ce programme.');
            }

            $today = date('Y-m-d');
            $dateFin = date('Y-m-d', strtotime('+' . max(0, ((int) $suggestion['duree']) - 1) . ' days'));
            $programmePayload = [
                'id_user' => $userId,
                'id_regime' => (int) $suggestion['id_regime'],
                'id_activite1' => $suggestion['id_activite1'] ?? null,
                'id_activite2' => $suggestion['id_activite2'] ?? null,
                'prix_total' => $priceToPay,
                'date_debut' => $today,
                'date_fin' => $dateFin,
                'duree_jours' => (int) $suggestion['duree'],
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->programmeModel->insert($programmePayload);
            $programmeId = (int) $this->programmeModel->getInsertID();

            if ($programmeId <= 0) {
                $db->transRollback();
                return redirect()->to(base_url('objectif/commande'))->with('error', 'Impossible de creer le programme.');
            }

            $this->transactionModel->insert([
                'id_user' => $userId,
                'id_programme' => $programmeId,
                'montant' => $priceToPay,
                'reduction' => (bool) session('is_gold') ? $this->getGoldReduction() : 0,
                'etat' => 'valide',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to(base_url('objectif/commande'))->with('error', 'Impossible de finaliser la transaction.');
            }

            $db->transCommit();
            $transactions = session('demo_wallet_transactions') ?? [];
            $transactions[] = [
                'label' => 'Commande programme ' . $suggestion['title'],
                'amount' => '-' . number_format((float) $priceToPay, 0, ',', ' ') . ' Ar',
                'status' => 'Valide',
            ];
            session()->set('demo_wallet_transactions', $transactions);
            session()->remove('selected_temp_programme');
            session()->remove('temporary_programmes');
            session()->remove('redirect_after_auth');

            return redirect()->to(base_url('mon-objectif'))->with('success', 'Programme commande avec succes.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to(base_url('objectif/commande'))->with('error', 'Une erreur est survenue pendant la commande.');
        }
    }

    protected function ensureObjectifHistory(int $userId, array $funnel): ?int
    {
        $existing = session('pending_objectif_history_id');
        if ($existing) {
            return (int) $existing;
        }

        $objectifId = (int) ($funnel['objectif_id'] ?? 0);
        if ($objectifId <= 0) {
            return null;
        }

        $poids = (float) ($funnel['poids'] ?? 0);
        $taille = (float) ($funnel['taille'] ?? 0);
        $poidsObjectif = null;
        $objectifType = (string) ($funnel['objectif_type'] ?? '');
        $targetKg = (float) ($funnel['target_kg'] ?? 0);

        if ($objectifType === 'reduire') {
            $poidsObjectif = $poids - $targetKg;
        } elseif ($objectifType === 'augmenter') {
            $poidsObjectif = $poids + $targetKg;
        } elseif ($objectifType === 'ideal' && $taille > 0) {
            $tailleM = $taille / 100;
            $poidsObjectif = round(22 * $tailleM * $tailleM, 2);
        }

        if ($poidsObjectif === null || $poidsObjectif <= 0) {
            $context = $this->getObjetcifUser($funnel);
            if ($context['type'] === 'reduire') {
                $poidsObjectif = $poids - (float) $context['targetKg'];
            } else {
                $poidsObjectif = $poids + (float) $context['targetKg'];
            }
        }

        $this->objectifHistoryModel->insert([
            'id_user' => $userId,
            'id_objectif' => $objectifId,
            'poids_kg' => $poids,
            'taille_cm' => $taille,
            'poids_objectif' => $poidsObjectif,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $historyId = (int) $this->objectifHistoryModel->getInsertID();
        session()->set('pending_objectif_history_id', $historyId);

        return $historyId ?: null;
    }

    protected function getObjetcifUser(array $funnel): array
    {
        $type = $funnel['objectif_type'] ?? 'ideal';
        $tailleCm = (float) ($funnel['taille'] ?? 0);
        $poidsKg = (float) ($funnel['poids'] ?? 0);
        $targetKg = isset($funnel['target_kg']) ? (float) $funnel['target_kg'] : 0.0;

        if ($type === 'ideal' && $tailleCm > 0 && $poidsKg > 0) {
            $tailleM = $tailleCm / 100;
            $poidsIdeal = 22 * $tailleM * $tailleM;
            $delta = round($poidsIdeal - $poidsKg, 2);
            $targetKg = abs($delta);
            $type = $delta >= 0 ? 'augmenter' : 'reduire';
        }

        $targetKg = max(0.1, $targetKg ?: 0.1);

        return [
            'type' => $type,
            'targetKg' => $targetKg,
            'label' => $this->buildObjectiveLabel($type, $targetKg, $funnel['objectif_type'] ?? 'ideal'),
            'sourceType' => $funnel['objectif_type'] ?? 'ideal',
            'poids' => $poidsKg,
            'taille' => $tailleCm,
        ];
    }

    protected function buildObjectiveLabel(string $resolvedType, float $targetKg, string $sourceType): string
    {
        if ($sourceType === 'ideal') {
            return 'votre poids sante';
        }

        $prefix = $resolvedType === 'augmenter' ? '+' : '-';
        return $prefix . rtrim(rtrim(number_format($targetKg, 1, '.', ''), '0'), '.') . ' kg';
    }

    protected function buildSuggestions(array $context): array
    {
        $regimeType = $context['type'] === 'augmenter' ? 'augmentation' : 'diminution';
        $regimes = $this->regimeModel->where('type', $regimeType)->findAll();
        $activites = $context['type'] === 'reduire' ? $this->activiteSportiveModel->findAll() : [];
        $configByRegime = $this->indexRegimeConfigs();
        $programmes = [];

        foreach ($regimes as $regime) {
            $programmes[] = $this->makeProgramme($context, $regime, [], $configByRegime);
            foreach ($activites as $activite) {
                $programmes[] = $this->makeProgramme($context, $regime, [$activite], $configByRegime);
            }
            for ($i = 0; $i < count($activites); $i++) {
                for ($j = $i + 1; $j < count($activites); $j++) {
                    $programmes[] = $this->makeProgramme($context, $regime, [$activites[$i], $activites[$j]], $configByRegime);
                }
            }
        }

        $programmes = array_values(array_filter($programmes));
        usort($programmes, static fn(array $a, array $b): int => [$a['gap'], $a['duree'], $a['prix']] <=> [$b['gap'], $b['duree'], $b['prix']]);

        $seen = [];
        $unique = [];
        foreach ($programmes as $programme) {
            $fingerprint = $programme['id_regime'] . '-' . implode('-', $programme['activityIds']) . '-' . $programme['duree'];
            if (isset($seen[$fingerprint])) {
                continue;
            }
            $seen[$fingerprint] = true;
            $unique[] = $programme;
            if (count($unique) === 6) {
                break;
            }
        }

        return $unique;
    }

    protected function makeProgramme(array $context, array $regime, array $activites, array $configByRegime): ?array
    {
        $regimeEffectPerDay = $this->valeurParJour((float) $regime['variation'], (int) $regime['duree']);
        $activityEffectPerDay = 0.0;
        foreach ($activites as $activite) {
            $activityEffectPerDay += $this->valeurParJour((float) $activite['diminution_poids'], (int) $activite['duree']);
        }

        $totalEffectPerDay = $regimeEffectPerDay + $activityEffectPerDay;
        if ($totalEffectPerDay <= 0) {
            return null;
        }

        $targetKg = $context['targetKg'];
        $duree = max(1, (int) ceil($targetKg / $totalEffectPerDay));
        $variationAtteinte = round($totalEffectPerDay * $duree, 2);
        $gap = round(abs($targetKg - $variationAtteinte), 2);
        $regimePrice = $this->resolveRegimePrice((int) $regime['id'], $duree, $configByRegime, $regime);
        $activityPrice = $this->estimateActivityPrice($activites, $duree);
        $prix = (int) round($regimePrice + $activityPrice);

        $activityNames = array_map(static fn(array $item): string => (string) $item['description'], $activites);
        $activityIds = array_map(static fn(array $item): int => (int) $item['id'], $activites);
        $hasActivity = $activityNames !== [];
        $key = 'p_' . md5(json_encode(['regime' => $regime['id'], 'activities' => $activityIds, 'duree' => $duree, 'target' => $targetKg, 'type' => $context['type']]));

        $goldFactor = $this->getGoldFactor();

        return [
            'key' => $key,
            'id_regime' => (int) $regime['id'],
            'id_activite1' => $activityIds[0] ?? null,
            'id_activite2' => $activityIds[1] ?? null,
            'activityIds' => $activityIds,
            'title' => $this->buildProgrammeTitle($regime, $duree, $hasActivity),
            'description' => (string) $regime['description'],
            'goalText' => $context['label'],
            'duree' => $duree,
            'prix' => $prix,
            'prixGold' => (int) round($prix * $goldFactor),
            'regime' => $this->buildRegimeTitle($regime),
            'sport' => $hasActivity ? implode(' + ', $activityNames) : 'Sans activite sportive',
            'activityMeta' => $this->buildActivityMeta($activites),
            'withActivity' => $hasActivity,
            'tags' => [$gap <= 0.2 ? 'Exact' : 'Approche la plus proche', $hasActivity ? 'Avec activite' : 'Sans activite', $duree . ' jours'],
            'macros' => ['viande' => (float) $regime['viande'], 'poisson' => (float) $regime['poisson'], 'volaille' => (float) $regime['volaille']],
            'variation' => $context['type'] === 'augmenter' ? $variationAtteinte : -$variationAtteinte,
            'variationAbs' => $variationAtteinte,
            'gap' => $gap,
            'temporary' => true,
            'engineSummary' => $this->buildEngineSummary($context['targetKg'], $regimeEffectPerDay, $activityEffectPerDay, $duree, $variationAtteinte, $regimePrice, $activityPrice),
        ];
    }

    protected function getGoldSettings(): array
    {
        $defaults = [
            'prix_gold' => 30000,
            'duree_gold' => 30,
            'reduction_gold' => 15,
        ];

        $current = $this->parametreModel->orderBy('id', 'DESC')->first();

        return array_merge($defaults, $current ?? []);
    }

    protected function getGoldReduction(): float
    {
        $value = (float) ($this->goldSettings['reduction_gold'] ?? 0);

        return min(100.0, max(0.0, $value));
    }

    protected function getGoldFactor(): float
    {
        $reduction = $this->getGoldReduction();
        $factor = 1 - ($reduction / 100);

        return min(1.0, max(0.0, $factor));
    }

    protected function valeurParJour(float $variation, int $duree): float
    {
        return abs($variation) / max(1, $duree);
    }

    protected function indexRegimeConfigs(): array
    {
        $rows = $this->configRegimeModel->findAll();
        $indexed = [];
        foreach ($rows as $row) {
            $indexed[(int) $row['id_regime']][] = ['duree_jours' => (int) $row['duree_jours'], 'prix' => (float) $row['prix']];
        }
        foreach ($indexed as &$configs) {
            usort($configs, static fn(array $a, array $b): int => $a['duree_jours'] <=> $b['duree_jours']);
        }
        return $indexed;
    }

    protected function resolveRegimePrice(int $regimeId, int $duree, array $configByRegime, array $regime): float
    {
        $configs = $configByRegime[$regimeId] ?? [];
        if ($configs === []) {
            return $this->estimateRegimePrice($regime, $duree);
        }
        foreach ($configs as $config) {
            if ($config['duree_jours'] === $duree) {
                return $config['prix'];
            }
        }
        $previous = null;
        foreach ($configs as $config) {
            if ($config['duree_jours'] > $duree) {
                if ($previous === null) {
                    return round(($config['prix'] / max(1, $config['duree_jours'])) * $duree, 2);
                }
                $durationGap = $config['duree_jours'] - $previous['duree_jours'];
                $priceGap = $config['prix'] - $previous['prix'];
                $ratio = ($duree - $previous['duree_jours']) / max(1, $durationGap);
                return round($previous['prix'] + ($priceGap * $ratio), 2);
            }
            $previous = $config;
        }
        $last = end($configs);
        $beforeLast = count($configs) > 1 ? $configs[count($configs) - 2] : null;
        if ($beforeLast !== null) {
            $durationGap = max(1, $last['duree_jours'] - $beforeLast['duree_jours']);
            $slope = ($last['prix'] - $beforeLast['prix']) / $durationGap;
            return round($last['prix'] + (($duree - $last['duree_jours']) * $slope), 2);
        }
        return round(($last['prix'] / max(1, $last['duree_jours'])) * $duree, 2);
    }

    protected function estimateRegimePrice(array $regime, int $duree): float
    {
        $baseDay = max(2000, 1800 + ((float) $regime['viande'] * 8) + ((float) $regime['poisson'] * 10) + ((float) $regime['volaille'] * 7));
        return round($baseDay * $duree, 2);
    }

    protected function estimateActivityPrice(array $activites, int $duree): float
    {
        $total = 0.0;
        foreach ($activites as $activite) {
            $cycle = max(1, (int) $activite['duree']);
            $blocks = max(1, (int) ceil($duree / $cycle));
            $total += 1200 * max(1, (int) $activite['frequence']) * $blocks;
        }
        return $total;
    }

    protected function buildProgrammeTitle(array $regime, int $duree, bool $hasActivity): string
    {
        return $this->buildRegimeTitle($regime) . ' - ' . $duree . ' jours' . ($hasActivity ? ' avec activite' : ' sans activite');
    }

    protected function buildRegimeTitle(array $regime): string
    {
        $title = trim((string) ($regime['description'] ?? ''));
        return $title !== '' ? mb_strimwidth($title, 0, 44, '...') : 'Regime #' . $regime['id'];
    }

    protected function buildActivityMeta(array $activites): string
    {
        if ($activites === []) {
            return 'Programme nutritionnel seul';
        }
        $parts = [];
        foreach ($activites as $activite) {
            $parts[] = (string) $activite['description'] . ' - ' . (int) $activite['frequence'] . ' fois/semaine sur ' . (int) $activite['duree'] . ' jour(s)';
        }
        return implode(' | ', $parts);
    }

    protected function buildEngineSummary(float $targetKg, float $regimeEffectPerDay, float $activityEffectPerDay, int $duree, float $variationAtteinte, float $regimePrice, float $activityPrice): string
    {
        return 'Objectif ' . $targetKg . ' kg, regime ' . round($regimeEffectPerDay, 3) . ' kg/jour, activites ' . round($activityEffectPerDay, 3) . ' kg/jour, total ' . round($variationAtteinte, 2) . ' kg en ' . $duree . ' jours, prix regime ' . round($regimePrice, 2) . ' Ar, prix activites ' . round($activityPrice, 2) . ' Ar.';
    }

    protected function findSuggestion(array $suggestions, string $key): ?array
    {
        foreach ($suggestions as $suggestion) {
            if (($suggestion['key'] ?? '') === $key) {
                return $suggestion;
            }
        }
        return null;
    }
}
