<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<<<<<<< Updated upstream
<div class="admin-page">
    <!-- Page header -->
    <div class="page-header">
        <h2>Paramètres système</h2>
=======
<?php $parametres = $parametres ?? ['prix_gold' => 30000, 'duree_gold' => 30, 'reduction_gold' => 15]; ?>

<section class="admin-section">
    <?php if (session()->has('success')): ?><div class="admin-flash success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session()->has('error')): ?><div class="admin-flash error"><?= esc(session('error')) ?></div><?php endif; ?>

    <div class="admin-grid">
        <article class="admin-card" data-reveal="up">
            <div class="section-head">
                <div>
                    <span class="admin-kicker">Parametres</span>
                    <h2>Regles metier</h2>
                </div>
            </div>
            <form method="post" action="<?= base_url('admin/settings') ?>" class="admin-form">
                <?= csrf_field() ?>
                <div class="admin-form-grid">
                    <label>
                        <span>Prix Gold (Ar)</span>
                        <input type="number" step="0.01" min="1" name="prix_gold" value="<?= esc(old('prix_gold', $parametres['prix_gold'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.prix_gold')): ?><small class="form-error"><?= esc(session('errors.prix_gold')) ?></small><?php endif; ?>
                    </label>
                    <label>
                        <span>Duree Gold (jours)</span>
                        <input type="number" min="1" name="duree_gold" value="<?= esc(old('duree_gold', $parametres['duree_gold'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.duree_gold')): ?><small class="form-error"><?= esc(session('errors.duree_gold')) ?></small><?php endif; ?>
                    </label>
                    <label>
                        <span>Reduction Gold (%)</span>
                        <input type="number" step="0.01" min="0" max="100" name="reduction_gold" value="<?= esc(old('reduction_gold', $parametres['reduction_gold'] ?? '', 'raw')) ?>" required>
                        <?php if (session('errors.reduction_gold')): ?><small class="form-error"><?= esc(session('errors.reduction_gold')) ?></small><?php endif; ?>
                    </label>
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn">Mettre a jour les parametres</button>
                </div>
            </form>

            <div class="list-stack" style="margin-top: 1.5rem;">
                <div class="list-item"><strong>Prix Gold</strong><span><?= number_format((float) ($parametres['prix_gold'] ?? 0), 0, ',', ' ') ?> Ar</span></div>
                <div class="list-item"><strong>Duree Gold</strong><span><?= esc((string) ($parametres['duree_gold'] ?? 0)) ?> jours</span></div>
                <div class="list-item"><strong>Remise Gold</strong><span><?= esc((string) ($parametres['reduction_gold'] ?? 0)) ?>%</span></div>
            </div>
        </article>

        <article class="admin-card" data-reveal="up">
            <div class="section-head">
                <div>
                    <span class="admin-kicker">Operations sensibles</span>
                    <h2>Zone de suppression</h2>
                </div>
            </div>
            <div class="action-pills">
                <span class="danger">Supprimer codes expires</span>
                <span class="danger">Purger transactions en echec</span>
            </div>
        </article>
>>>>>>> Stashed changes
    </div>

    <!-- Règles métier -->
    <div class="form-container">
        <h3 style="margin-bottom: 1.5rem; color: var(--admin-dark);">Règles métier</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="padding: 1rem; background: var(--admin-light); border-radius: 8px;">
                <div style="color: #999; font-size: 0.9rem; margin-bottom: 0.5rem;">Prix Gold</div>
                <div style="font-size: 1.3rem; font-weight: 600; color: var(--admin-primary);">49 000 Ar</div>
            </div>
            <div style="padding: 1rem; background: var(--admin-light); border-radius: 8px;">
                <div style="color: #999; font-size: 0.9rem; margin-bottom: 0.5rem;">Remise Gold</div>
                <div style="font-size: 1.3rem; font-weight: 600; color: var(--admin-primary);">15%</div>
            </div>
            <div style="padding: 1rem; background: var(--admin-light); border-radius: 8px;">
                <div style="color: #999; font-size: 0.9rem; margin-bottom: 0.5rem;">IMC idéal</div>
                <div style="font-size: 1.3rem; font-weight: 600; color: var(--admin-primary);">18.5 - 24.9</div>
            </div>
        </div>
    </div>

    <!-- Opérations sensibles -->
    <div class="form-container" style="border-top: 2px solid #fee; background: rgba(231, 76, 60, 0.02);">
        <h3 style="margin-bottom: 1.5rem; color: #e74c3c;">Opérations sensibles</h3>
        <p style="color: #999; margin-bottom: 1rem; font-size: 0.9rem;">
            Les opérations suivantes sont permanentes et ne peuvent pas être annulées.
        </p>
        <div style="display: flex; flex-direction: column; gap: 0.8rem;">
            <button class="btn-danger" style="text-align: left; justify-content: flex-start;">
                Supprimer les codes expirés
            </button>
            <button class="btn-danger" style="text-align: left; justify-content: flex-start;">
                Purger les transactions échouées
            </button>
            <button class="btn-danger" style="text-align: left; justify-content: flex-start;">
                Régénérer le cache
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
