<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Paramètres métier -->
    <div class="form-container">
        <div style="margin-bottom: 1.5rem;">
            <h2>Paramètres métier</h2>
            <p style="color: #999; margin-top: 0.3rem;">Configurez les règles de l'application</p>
        </div>

        <div class="admin-form-grid">
            <div class="detail-section">
                <h3>💰 Tarification Gold</h3>
                <div style="padding: 1rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                        <span>Prix d'accès Gold</span>
                        <strong style="font-size: 1.3rem; color: var(--admin-primary);">49 000 Ar</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Remise Gold sur les régimes</span>
                        <strong style="font-size: 1.3rem; color: var(--admin-primary);">15%</strong>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3>📊 Santé & Objectifs</h3>
                <div style="padding: 1rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                        <span>IMC idéal cible</span>
                        <strong style="font-size: 1.2rem;">18,5 - 24,9</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Durée minimale programme</span>
                        <strong style="font-size: 1.2rem;">30 jours</strong>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3>⚙️ Système</h3>
                <div style="padding: 1rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Version API</span>
                        <strong style="font-size: 1.1rem;">v1.0.0</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opérations sensibles -->
    <div class="form-container" style="border-left: 4px solid #e74c3c;">
        <div style="margin-bottom: 1.5rem;">
            <h2>⚠️ Opérations sensibles</h2>
            <p style="color: #999; margin-top: 0.3rem;">Actions de maintenance et nettoyage de base de données</p>
        </div>

        <div class="form-actions">
            <button class="btn-danger" onclick="if(confirm('Cette opération supprimera les codes expirés. Continuer ?')) { alert('Codes expirés supprimés'); }">
                🗑️ Supprimer codes expirés
            </button>
            <button class="btn-danger" onclick="if(confirm('Cette opération purgera les transactions échouées. Continuer ?')) { alert('Transactions purgées'); }">
                🗑️ Purger transactions échouées
            </button>
            <button class="btn-secondary" onclick="if(confirm('Cette opération regénérera le cache. Continuer ?')) { alert('Cache regénéré'); }">
                🔄 Regénérer le cache
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
