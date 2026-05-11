<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Tableau des codes -->
    <div class="table-container">
        <div class="table-header">
            <h3>Codes de recharge</h3>
            <span class="view-all-link">Gestion des codes utilisateurs</span>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Valeur</th>
                        <th>État</th>
                        <th>Utilisateur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($codes ?? []) as $c): ?>
                        <?php
                            $statusClass = 'badge-success';
                            $statusLabel = '✓ Disponible';
                            $statusIcon = '🟢';
                            if ((int) $c['id_statut_code'] === 2) {
                                $statusClass = 'badge-warning';
                                $statusLabel = '⚠️ Utilisé';
                                $statusIcon = '🟡';
                            } elseif ((int) $c['id_statut_code'] === 3) {
                                $statusClass = 'badge-danger';
                                $statusLabel = '❌ Bloqué';
                                $statusIcon = '🔴';
                            }
                            $userLabel = trim(($c['prenom'] ?? '') . ' ' . ($c['nom'] ?? ''));
                            if ($userLabel === '') {
                                $userLabel = '-';
                            }
                        ?>
                        <tr>
                            <td>
                                <code style="background: var(--admin-light); padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.9rem;">
                                    <?= esc($c['code']) ?>
                                </code>
                            </td>
                            <td><strong><?= number_format((float) $c['valeur_en_ar'], 0, ',', ' ') ?> Ar</strong></td>
                            <td><span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                            <td><?= esc($userLabel) ?></td>
                            <td>
                                <?php if ((int) $c['id_statut_code'] === 1): ?>
                                    <a href="#" class="btn-small btn-view">📋 Voir</a>
                                <?php else: ?>
                                    <small style="color: #999;">Traité</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($codes ?? [])): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #999; padding: 2rem;">
                                Aucun code enregistré
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Statistiques codes -->
    <section class="stats-grid-mini" style="margin-top: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-icon">🎟️</div>
            <div class="stat-content">
                <span class="label">Total codes</span>
                <span class="value"><?= count($codes ?? []) ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">✓</div>
            <div class="stat-content">
                <span class="label">Codes disponibles</span>
                <span class="value"><?= count(array_filter($codes ?? [], fn($c) => (int) $c['id_statut_code'] === 1)) ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">✓✓</div>
            <div class="stat-content">
                <span class="label">Codes utilisés</span>
                <span class="value"><?= count(array_filter($codes ?? [], fn($c) => (int) $c['id_statut_code'] === 2)) ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">❌</div>
            <div class="stat-content">
                <span class="label">Codes bloqués</span>
                <span class="value"><?= count(array_filter($codes ?? [], fn($c) => (int) $c['id_statut_code'] === 3)) ?></span>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
