<?= $this->extend('layouts/back') ?>
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

<section class="admin-section">
    <?php if (session()->has('success')): ?><div class="admin-flash success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session()->has('error')): ?><div class="admin-flash error"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">CRUD Regimes</span>
                <h2><?= $editingRegime ? 'Modifier un regime' : 'Ajouter un regime' ?></h2>
            </div>
            <?php if ($editingRegime): ?><a class="admin-ghost" href="<?= base_url('admin/regimes') ?>">Nouveau regime</a><?php endif; ?>
        </div>

        <form method="post" action="<?= $editingRegime ? base_url('admin/regimes/' . $editingRegime['id'] . '/update') : base_url('admin/regimes') ?>" class="admin-form">
            <?= csrf_field() ?>
            <label>
                <span>Description</span>
                <textarea name="description" rows="3"><?= esc(old('description', $editingRegime['description'] ?? '', 'raw')) ?></textarea>
                <?php if (session('errors.description')): ?><small class="form-error"><?= esc(session('errors.description')) ?></small><?php endif; ?>
            </label>

            <div class="admin-form-grid">
                <label>
                    <span>Type</span>
                    <select name="type" required>
                        <?php $selectedType = old('type', $editingRegime['type'] ?? 'augmentation', 'raw'); ?>
                        <option value="augmentation" <?= $selectedType === 'augmentation' ? 'selected' : '' ?>>Augmentation</option>
                        <option value="diminution" <?= $selectedType === 'diminution' ? 'selected' : '' ?>>Diminution</option>
                    </select>
                    <?php if (session('errors.type')): ?><small class="form-error"><?= esc(session('errors.type')) ?></small><?php endif; ?>
                </label>
                <label>
                    <span>Variation de poids (kg)</span>
                    <input type="number" step="0.01" min="0.01" name="variation" value="<?= esc(old('variation', $editingRegime['variation'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.variation')): ?><small class="form-error"><?= esc(session('errors.variation')) ?></small><?php endif; ?>
                </label>
                <label>
                    <span>Duree de base (jours)</span>
                    <input type="number" min="1" name="duree" value="<?= esc(old('duree', $editingRegime['duree'] ?? 1, 'raw')) ?>" required>
                    <?php if (session('errors.duree')): ?><small class="form-error"><?= esc(session('errors.duree')) ?></small><?php endif; ?>
                </label>
            </div>

            <div class="admin-form-grid">
                <label>
                    <span>% viande</span>
                    <input type="number" step="0.01" min="0" max="100" name="viande" value="<?= esc(old('viande', $editingRegime['viande'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.viande')): ?><small class="form-error"><?= esc(session('errors.viande')) ?></small><?php endif; ?>
                </label>
                <label>
                    <span>% poisson</span>
                    <input type="number" step="0.01" min="0" max="100" name="poisson" value="<?= esc(old('poisson', $editingRegime['poisson'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.poisson')): ?><small class="form-error"><?= esc(session('errors.poisson')) ?></small><?php endif; ?>
                </label>
                <label>
                    <span>% volaille</span>
                    <input type="number" step="0.01" min="0" max="100" name="volaille" value="<?= esc(old('volaille', $editingRegime['volaille'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.volaille')): ?><small class="form-error"><?= esc(session('errors.volaille')) ?></small><?php endif; ?>
                </label>
            </div>
            <?php if (session('errors.macros')): ?><small class="form-error"><?= esc(session('errors.macros')) ?></small><?php endif; ?>

            <div class="price-config-box">
                <div class="section-head compact">
                    <div>
                        <span class="admin-kicker">Prix variables</span>
                        <h2>Paliers de prix selon la duree</h2>
                    </div>
                </div>
                <div class="price-config-list" data-price-config-list>
                    <?php foreach ($defaultConfigs as $config): ?>
                        <div class="price-config-row">
                            <input type="number" min="1" name="config_duree[]" placeholder="Duree (jours)" value="<?= esc((string) $config[0], 'raw') ?>" required>
                            <input type="number" min="1" step="0.01" name="config_prix[]" placeholder="Prix (Ar)" value="<?= esc((string) $config[1], 'raw') ?>" required>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="admin-ghost" data-add-price-row>Ajouter un palier</button>
                <?php if (session('errors.configs')): ?><small class="form-error"><?= esc(session('errors.configs')) ?></small><?php endif; ?>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn"><?= $editingRegime ? 'Mettre a jour le regime' : 'Ajouter le regime' ?></button>
            </div>
        </form>
    </div>

    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">Catalogue</span>
                <h2>Regimes existants</h2>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Variation</th>
                        <th>Macros</th>
                        <th>Prix par duree</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($regimes ?? []) as $regime): ?>
                        <tr>
                            <td><?= esc($regime['description']) ?></td>
                            <td><?= esc($regime['type']) ?></td>
                            <td><?= esc((string) $regime['variation']) ?> kg / <?= esc((string) $regime['duree']) ?> jour(s)</td>
                            <td>V <?= esc((string) $regime['viande']) ?>% | P <?= esc((string) $regime['poisson']) ?>% | Vo <?= esc((string) $regime['volaille']) ?>%</td>
                            <td>
                                <div class="inline-stack">
                                    <?php foreach (($regime['configs'] ?? []) as $config): ?>
                                        <span><?= esc((string) $config['duree_jours']) ?>j : <?= number_format((float) $config['prix'], 0, ',', ' ') ?> Ar</span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td>
                                <div class="action-pills">
                                    <a href="<?= base_url('admin/regimes?edit=' . $regime['id']) ?>">Modifier</a>
                                    <form method="post" action="<?= base_url('admin/regimes/' . $regime['id'] . '/delete') ?>" onsubmit="return confirm('Supprimer ce regime ?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="danger">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($regimes ?? [])): ?>
                        <tr><td colspan="6">Aucun regime enregistre.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.querySelector('[data-add-price-row]');
    const list = document.querySelector('[data-price-config-list]');
    if (!addButton || !list) return;

    addButton.addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'price-config-row';
        row.innerHTML = '<input type="number" min="1" name="config_duree[]" placeholder="Duree (jours)" required><input type="number" min="1" step="0.01" name="config_prix[]" placeholder="Prix (Ar)" required>';
        list.appendChild(row);
    });
});
</script>
<?= $this->endSection() ?>
