<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Page header -->
    <div class="page-header">
        <h2>Paramètres système</h2>
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
