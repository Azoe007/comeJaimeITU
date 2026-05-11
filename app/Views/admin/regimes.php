<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
    $editingRegime = $editingRegime ?? null;
    $editingConfigs = $editingConfigs ?? [];
    $defaultConfigs = old('config_duree') ? array_map(null, old('config_duree'), old('config_prix')) : [];
    if ($defaultConfigs === [] && $editingConfigs) {
        $defaultConfigs = array_map(static fn($item) => [$item['duree_jours'], $item['prix']], $editingConfigs);
    }
    if ($defaultConfigs === []) {
        $defaultConfigs = [[1, ''], [7, ''], [10, '']];
    }
?>

<div class="admin-page">
    <!-- Formulaire ajout/édition -->
    <div class="form-container">
        <div style="margin-bottom: 1.5rem;">
            <h2><?= $editingRegime ? 'Modifier un régime' : 'Ajouter un régime' ?></h2>
            <p style="color: #999; margin-top: 0.3rem;">Gérez les régimes et leurs tarifications</p>
        </div>

        <form method="post" action="<?= $editingRegime ? base_url('admin/regimes/' . $editingRegime['id'] . '/update') : base_url('admin/regimes') ?>" class="admin-form">
            <?= csrf_field() ?>

            <fieldset class="form-section">
                <legend>Informations du régime</legend>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-input" required><?= esc(old('description', $editingRegime['description'] ?? '', 'raw')) ?></textarea>
                    <?php if (session('errors.description')): ?><small class="form-error">✕ <?= esc(session('errors.description')) ?></small><?php endif; ?>
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Paramètres du régime</legend>
                <div class="admin-form-grid">
                    <div class="form-group">
                        <label class="form-label">Type de régime</label>
                        <select name="type" class="form-input" required>
                            <?php $selectedType = old('type', $editingRegime['type'] ?? 'augmentation', 'raw'); ?>
                            <option value="augmentation" <?= $selectedType === 'augmentation' ? 'selected' : '' ?>>Augmentation de poids</option>
                            <option value="diminution" <?= $selectedType === 'diminution' ? 'selected' : '' ?>>Diminution de poids</option>
                        </select>
                        <?php if (session('errors.type')): ?><small class="form-error">✕ <?= esc(session('errors.type')) ?></small><?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Variation de poids (kg)</label>
                        <input type="number" step="0.01" min="0.01" name="variation" class="form-input" value="<?= esc(old('variation', $editingRegime['variation'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.variation')): ?><small class="form-error">✕ <?= esc(session('errors.variation')) ?></small><?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Durée de base (jours)</label>
                        <input type="number" min="1" name="duree" class="form-input" value="<?= esc(old('duree', $editingRegime['duree'] ?? 1, 'raw')) ?>" required>
                        <?php if (session('errors.duree')): ?><small class="form-error">✕ <?= esc(session('errors.duree')) ?></small><?php endif; ?>
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Composition alimentaire</legend>
                <div class="admin-form-grid">
                    <div class="form-group">
                        <label class="form-label">Pourcentage viande (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="viande" class="form-input" value="<?= esc(old('viande', $editingRegime['viande'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.viande')): ?><small class="form-error">✕ <?= esc(session('errors.viande')) ?></small><?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pourcentage poisson (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="poisson" class="form-input" value="<?= esc(old('poisson', $editingRegime['poisson'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.poisson')): ?><small class="form-error">✕ <?= esc(session('errors.poisson')) ?></small><?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pourcentage volaille (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="volaille" class="form-input" value="<?= esc(old('volaille', $editingRegime['volaille'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.volaille')): ?><small class="form-error">✕ <?= esc(session('errors.volaille')) ?></small><?php endif; ?>
                    </div>
                </div>
                <?php if (session('errors.macros')): ?><small class="form-error">✕ <?= esc(session('errors.macros')) ?></small><?php endif; ?>
            </fieldset>

            <fieldset class="form-section">
                <legend>Tarification par durée</legend>
                <div class="price-config-list" data-price-config-list>
                    <?php foreach ($defaultConfigs as $config): ?>
                        <div class="price-config-row form-grid-2">
                            <input type="number" min="1" name="config_duree[]" placeholder="Durée (jours)" class="form-input" value="<?= esc((string) $config[0], 'raw') ?>" required>
                            <input type="number" min="1" step="0.01" name="config_prix[]" placeholder="Prix (Ar)" class="form-input" value="<?= esc((string) $config[1], 'raw') ?>" required>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn-secondary" data-add-price-row style="margin-top: 0.8rem;">+ Ajouter un palier</button>
                <?php if (session('errors.configs')): ?><small class="form-error">✕ <?= esc(session('errors.configs')) ?></small><?php endif; ?>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary"><?= $editingRegime ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:6px"><polyline points="20 6 9 17 4 12"/></svg> Mettre à jour' : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:6px"><polyline points="20 6 9 17 4 12"/></svg> Créer le régime' ?></button>
                <a href="<?= base_url('admin/regimes') ?>" class="btn-ghost">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Tableau des régimes -->
    <div class="table-container">
        <div class="table-header">
            <h3>Régimes existants</h3>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Variation</th>
                        <th>Composition (V/P/Vo)</th>
                        <th>Tarifications</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($regimes ?? []) as $regime): ?>
                        <tr>
                            <td><strong><?= esc($regime['description']) ?></strong></td>
                            <td>
                                <span class="badge <?= $regime['type'] === 'augmentation' ? 'badge-warning' : 'badge-info' ?>">
                                    <?= $regime['type'] === 'augmentation' ? '▲ Augmentation' : '▼ Diminution' ?>
                                </span>
                            </td>
                            <td><?= esc((string) $regime['variation']) ?> kg / <?= esc((string) $regime['duree']) ?> j</td>
                            <td><?= number_format((float) $regime['viande'], 1) ?>% / <?= number_format((float) $regime['poisson'], 1) ?>% / <?= number_format((float) $regime['volaille'], 1) ?>%</td>
                            <td>
                                <small style="display: block; line-height: 1.4;">
                                    <?php foreach (($regime['configs'] ?? []) as $config): ?>
                                        <span><?= esc((string) $config['duree_jours']) ?>j: <?= number_format((float) $config['prix'], 0, ',', ' ') ?> Ar</span><br>
                                    <?php endforeach; ?>
                                </small>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="<?= base_url('admin/regimes?edit=' . $regime['id']) ?>" class="btn-small btn-view"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L21 3z"/></svg> Modifier</a>
                                    <form method="post" action="<?= base_url('admin/regimes/' . $regime['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-small btn-danger" style="color: #e74c3c; background: rgba(231, 76, 60, 0.15);"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg> Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($regimes ?? [])): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #999; padding: 2rem;">
                                Aucun régime enregistré. <br>
                                <small>Commencez par en créer un ci-dessus.</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.querySelector('[data-add-price-row]');
        const list = document.querySelector('[data-price-config-list]');
        
        if (addButton && list) {
            addButton.addEventListener('click', function() {
                const row = document.createElement('div');
                row.className = 'price-config-row form-grid-2';
                row.innerHTML = '<input type="number" min="1" name="config_duree[]" placeholder="Durée (jours)" class="form-input" required><input type="number" min="1" step="0.01" name="config_prix[]" placeholder="Prix (Ar)" class="form-input" required>';
                list.appendChild(row);
            });
        }
    });
</script>
<?= $this->endSection() ?>
