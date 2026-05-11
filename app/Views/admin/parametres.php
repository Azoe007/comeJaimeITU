<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

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
            <form method="post" action="<?= base_url('admin/parametres') ?>" class="admin-form">
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
    </div>
</section>

<?= $this->endSection() ?>
