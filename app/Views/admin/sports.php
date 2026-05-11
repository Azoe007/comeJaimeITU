<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<?php $editingSport = $editingSport ?? null; ?>

<section class="admin-section">
    <?php if (session()->has('success')): ?><div class="admin-flash success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session()->has('error')): ?><div class="admin-flash error"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">CRUD Sports</span>
                <h2><?= $editingSport ? 'Modifier une activite sportive' : 'Ajouter une activite sportive' ?></h2>
            </div>
            <?php if ($editingSport): ?><a class="admin-ghost" href="<?= base_url('admin/sports') ?>">Nouvelle activite</a><?php endif; ?>
        </div>

        <form method="post" action="<?= $editingSport ? base_url('admin/sports/' . $editingSport['id'] . '/update') : base_url('admin/sports') ?>" class="admin-form">
            <?= csrf_field() ?>
            <label>
                <span>Description</span>
                <textarea name="description" rows="3"><?= esc(old('description', $editingSport['description'] ?? '', 'raw')) ?></textarea>
                <?php if (session('errors.description')): ?><small class="form-error"><?= esc(session('errors.description')) ?></small><?php endif; ?>
            </label>

            <div class="admin-form-grid">
                <label>
                    <span>Diminution de poids (kg)</span>
                    <input type="number" step="0.01" min="0.01" name="diminution_poids" value="<?= esc(old('diminution_poids', $editingSport['diminution_poids'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.diminution_poids')): ?><small class="form-error"><?= esc(session('errors.diminution_poids')) ?></small><?php endif; ?>
                </label>
                <label>
                    <span>Frequence (fois/semaine)</span>
                    <input type="number" min="1" name="frequence" value="<?= esc(old('frequence', $editingSport['frequence'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.frequence')): ?><small class="form-error"><?= esc(session('errors.frequence')) ?></small><?php endif; ?>
                </label>
                <label>
                    <span>Duree (jours)</span>
                    <input type="number" min="1" name="duree" value="<?= esc(old('duree', $editingSport['duree'] ?? '', 'raw')) ?>" required>
                    <?php if (session('errors.duree')): ?><small class="form-error"><?= esc(session('errors.duree')) ?></small><?php endif; ?>
                </label>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn"><?= $editingSport ? 'Mettre a jour l activite' : 'Ajouter l activite' ?></button>
            </div>
        </form>
    </div>

    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">Catalogue</span>
                <h2>Activites sportives existantes</h2>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Diminution</th>
                        <th>Frequence</th>
                        <th>Duree</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($sports ?? []) as $sport): ?>
                        <tr>
                            <td><?= esc($sport['description']) ?></td>
                            <td><?= esc((string) $sport['diminution_poids']) ?> kg</td>
                            <td><?= esc((string) $sport['frequence']) ?> / semaine</td>
                            <td><?= esc((string) $sport['duree']) ?> jour(s)</td>
                            <td>
                                <div class="action-pills">
                                    <a href="<?= base_url('admin/sports?edit=' . $sport['id']) ?>">Modifier</a>
                                    <form method="post" action="<?= base_url('admin/sports/' . $sport['id'] . '/delete') ?>" onsubmit="return confirm('Supprimer cette activite ?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="danger">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($sports ?? [])): ?>
                        <tr><td colspan="5">Aucune activite sportive enregistree.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
