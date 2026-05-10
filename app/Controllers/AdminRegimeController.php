<?php

namespace App\Controllers;

use App\Models\ConfigRegimeModel;
use App\Models\RegimeModel;

class AdminRegimeController extends BaseController
{
    protected RegimeModel $regimeModel;
    protected ConfigRegimeModel $configRegimeModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
        $this->configRegimeModel = new ConfigRegimeModel();
    }

    public function index()
    {
        $regimes = $this->regimeModel->orderBy('id', 'DESC')->findAll();
        $editingId = (int) ($this->request->getGet('edit') ?? 0);
        $editingRegime = $editingId > 0 ? $this->regimeModel->find($editingId) : null;

        return view('admin/regimes', [
            'pageTitle' => 'CRUD Regimes - Health Coach',
            'pageHeading' => 'Gestion des regimes',
            'breadcrumb' => 'Regimes',
            'activeMenu' => 'regimes',
            'regimes' => $this->hydrateRegimes($regimes),
            'editingRegime' => $editingRegime,
            'editingConfigs' => $editingRegime ? $this->configRegimeModel->where('id_regime', $editingId)->orderBy('duree_jours', 'ASC')->findAll() : [],
        ]);
    }

    public function store()
    {
        $payload = $this->extractRegimePayload();
        $priceConfigs = $this->extractPriceConfigs();
        $errors = $this->validateRegimePayload($payload, $priceConfigs);

        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $this->regimeModel->insert($payload);
        $regimeId = (int) $this->regimeModel->getInsertID();

        foreach ($priceConfigs as $config) {
            $this->configRegimeModel->insert([
                'id_regime' => $regimeId,
                'duree_jours' => $config['duree_jours'],
                'prix' => $config['prix'],
            ]);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Impossible de creer le regime.');
        }

        $db->transCommit();
        return redirect()->to(base_url('admin/regimes'))->with('success', 'Regime cree avec succes.');
    }

    public function update(int $id)
    {
        $regime = $this->regimeModel->find($id);
        if (! $regime) {
            return redirect()->to(base_url('admin/regimes'))->with('error', 'Regime introuvable.');
        }

        $payload = $this->extractRegimePayload();
        $priceConfigs = $this->extractPriceConfigs();
        $errors = $this->validateRegimePayload($payload, $priceConfigs);

        if ($errors !== []) {
            return redirect()->to(base_url('admin/regimes?edit=' . $id))->withInput()->with('errors', $errors);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $this->regimeModel->update($id, $payload);
        $this->configRegimeModel->where('id_regime', $id)->delete();
        foreach ($priceConfigs as $config) {
            $this->configRegimeModel->insert([
                'id_regime' => $id,
                'duree_jours' => $config['duree_jours'],
                'prix' => $config['prix'],
            ]);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->to(base_url('admin/regimes?edit=' . $id))->withInput()->with('error', 'Impossible de mettre a jour le regime.');
        }

        $db->transCommit();
        return redirect()->to(base_url('admin/regimes'))->with('success', 'Regime mis a jour avec succes.');
    }

    public function delete(int $id)
    {
        $regime = $this->regimeModel->find($id);
        if (! $regime) {
            return redirect()->to(base_url('admin/regimes'))->with('error', 'Regime introuvable.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();
        $this->configRegimeModel->where('id_regime', $id)->delete();
        $this->regimeModel->delete($id);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->to(base_url('admin/regimes'))->with('error', 'Impossible de supprimer le regime.');
        }

        $db->transCommit();
        return redirect()->to(base_url('admin/regimes'))->with('success', 'Regime supprime avec succes.');
    }

    protected function extractRegimePayload(): array
    {
        return [
            'description' => trim((string) $this->request->getPost('description')),
            'viande' => (float) $this->request->getPost('viande'),
            'poisson' => (float) $this->request->getPost('poisson'),
            'volaille' => (float) $this->request->getPost('volaille'),
            'variation' => (float) $this->request->getPost('variation'),
            'duree' => (int) $this->request->getPost('duree'),
            'type' => (string) $this->request->getPost('type'),
        ];
    }

    protected function extractPriceConfigs(): array
    {
        $durations = $this->request->getPost('config_duree') ?? [];
        $prices = $this->request->getPost('config_prix') ?? [];
        $configs = [];

        foreach ($durations as $index => $duration) {
            $duree = (int) $duration;
            $prix = (float) ($prices[$index] ?? 0);
            if ($duree > 0 && $prix > 0) {
                $configs[] = ['duree_jours' => $duree, 'prix' => $prix];
            }
        }

        return $configs;
    }

    protected function validateRegimePayload(array $payload, array $priceConfigs): array
    {
        $errors = [];

        if ($payload['description'] === '') {
            $errors['description'] = 'La description est requise.';
        }
        if (! in_array($payload['type'], ['augmentation', 'diminution'], true)) {
            $errors['type'] = 'Le type du regime est invalide.';
        }
        if ($payload['duree'] <= 0) {
            $errors['duree'] = 'La duree doit etre superieure a zero.';
        }
        if ($payload['variation'] <= 0) {
            $errors['variation'] = 'La variation doit etre superieure a zero.';
        }

        $macroTotal = $payload['viande'] + $payload['poisson'] + $payload['volaille'];
        foreach (['viande', 'poisson', 'volaille'] as $field) {
            if ($payload[$field] < 0 || $payload[$field] > 100) {
                $errors[$field] = 'Chaque pourcentage doit etre compris entre 0 et 100.';
            }
        }
        if (abs($macroTotal - 100) > 0.001) {
            $errors['macros'] = 'La somme viande + poisson + volaille doit etre egale a 100%.';
        }

        if ($priceConfigs === []) {
            $errors['configs'] = 'Ajoutez au moins un prix variant selon la duree.';
        }

        $seenDurations = [];
        foreach ($priceConfigs as $config) {
            if (isset($seenDurations[$config['duree_jours']])) {
                $errors['configs'] = 'Chaque duree de prix doit etre unique.';
                break;
            }
            $seenDurations[$config['duree_jours']] = true;
        }

        return $errors;
    }

    protected function hydrateRegimes(array $regimes): array
    {
        foreach ($regimes as &$regime) {
            $regime['configs'] = $this->configRegimeModel
                ->where('id_regime', (int) $regime['id'])
                ->orderBy('duree_jours', 'ASC')
                ->findAll();
        }

        return $regimes;
    }
}
