<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $editingSport = $editingSport ?? null; ?>

<div class="admin-page">
    <!-- Formulaire ajout/édition -->
    <div class="form-container">
        <div style="margin-bottom: 1.5rem;">
            <h2><?= $editingSport ? 'Modifier une activité sportive' : 'Ajouter une activité sportive' ?></h2>
            <p style="color: #999; margin-top: 0.3rem;">Gérez les activités sportives et leurs effets</p>
        </div>

        <form method="post" action="<?= $editingSport ? base_url('admin/sports/' . $editingSport['id'] . '/update') : base_url('admin/sports') ?>" class="admin-form">
            <?= csrf_field() ?>

            <fieldset class="form-section">
                <legend>Informations de l'activité</legend>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-input" required><?= esc(old('description', $editingSport['description'] ?? '', 'raw')) ?></textarea>
                    <?php if (session('errors.description')): ?><small class="form-error">✕ <?= esc(session('errors.description')) ?></small><?php endif; ?>
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Paramètres d'efficacité</legend>
                <div class="admin-form-grid">
                    <div class="form-group">
                        <label class="form-label">Diminution de poids (kg)</label>
                        <input type="number" step="0.01" min="0.01" name="diminution_poids" class="form-input" value="<?= esc(old('diminution_poids', $editingSport['diminution_poids'] ?? '', 'raw')) ?>" required>
                        <small class="form-hint">Perte de poids par semaine</small>
                        <?php if (session('errors.diminution_poids')): ?><small class="form-error">✕ <?= esc(session('errors.diminution_poids')) ?></small><?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fréquence (fois/semaine)</label>
                        <input type="number" min="1" max="7" name="frequence" class="form-input" value="<?= esc(old('frequence', $editingSport['frequence'] ?? '', 'raw')) ?>" required>
                        <small class="form-hint">Nombre de séances recommandées par semaine</small>
                        <?php if (session('errors.frequence')): ?><small class="form-error">✕ <?= esc(session('errors.frequence')) ?></small><?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Durée du programme (jours)</label>
                        <input type="number" min="1" name="duree" class="form-input" value="<?= esc(old('duree', $editingSport['duree'] ?? '', 'raw')) ?>" required>
                        <small class="form-hint">Durée totale du programme de sport</small>
                        <?php if (session('errors.duree')): ?><small class="form-error">✕ <?= esc(session('errors.duree')) ?></small><?php endif; ?>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary"><?= $editingSport ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:6px"><polyline points="20 6 9 17 4 12"/></svg> Mettre à jour' : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:6px"><polyline points="20 6 9 17 4 12"/></svg> Créer l\'activité' ?></button>
                <a href="<?= base_url('admin/sports') ?>" class="btn-ghost">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Tableau des sports -->
    <div class="table-container">
        <div class="table-header">
            <h3>Activités sportives existantes</h3>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Perte de poids</th>
                        <th>Fréquence/semaine</th>
                        <th>Durée du programme</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($sports ?? []) as $sport): ?>
                        <tr>
                            <td><strong><?= esc($sport['description']) ?></strong></td>
                            <td>
                                <span class="badge badge-success">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px">
                                        <path d="M3 12h4l4 8 4-8h4M3 8h18"/>
                                    </svg> <?= number_format((float) $sport['diminution_poids'], 2) ?> kg/sem
                                </span>
                            </td>
                            <td><?= number_format((int) $sport['frequence']) ?>x/semaine</td>
                            <td><?= number_format((int) $sport['duree']) ?> jours</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="<?= base_url('admin/sports?edit=' . $sport['id']) ?>" class="btn-small btn-view"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L21 3z"/></svg> Modifier</a>
                                    <form method="post" action="<?= base_url('admin/sports/' . $sport['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-small btn-danger" style="color: #e74c3c; background: rgba(231, 76, 60, 0.15);"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg> Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($sports ?? [])): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #999; padding: 2rem;">
                                Aucune activité sportive enregistrée. <br>
                                <small>Commencez par en créer une ci-dessus.</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
