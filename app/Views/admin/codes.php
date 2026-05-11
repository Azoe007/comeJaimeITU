<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Statistiques des codes -->
    <section class="stats-grid-mini">
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                    <line x1="3" y1="9" x2="21" y2="9"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Total codes</span>
                <span class="value"><?= $stats['total_codes'] ?? 0 ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Disponibles</span>
                <span class="value"><?= $stats['available_codes'] ?? 0 ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Utilisés</span>
                <span class="value"><?= $stats['used_codes'] ?? 0 ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Bloqués</span>
                <span class="value"><?= $stats['blocked_codes'] ?? 0 ?></span>
            </div>
        </div>
    </section>

    <!-- Page header -->
    <div class="page-header" style="margin: 2rem 0 1.5rem;">
        <h2>Codes de recharge</h2>
    </div>

    <!-- Tableau des codes -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Valeur</th>
                        <th>État</th>
                        <th>Utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($codes ?? []) as $c): ?>
                        <?php
                            $statusClass = 'badge-success';
                            $statusLabel = 'Disponible';
                            if ((int) $c['id_statut_code'] === 2) {
                                $statusClass = 'badge-warning';
                                $statusLabel = 'Utilisé';
                            } elseif ((int) $c['id_statut_code'] === 3) {
                                $statusClass = 'badge-danger';
                                $statusLabel = 'Bloqué';
                            }
                            $userLabel = trim(($c['prenom'] ?? '') . ' ' . ($c['nom'] ?? ''));
                            if ($userLabel === '') {
                                $userLabel = '-';
                            }
                        ?>
                        <tr>
                            <td><code style="background: var(--admin-light); padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.9rem;"><?= esc($c['code']) ?></code></td>
                            <td><strong><?= number_format((float) $c['valeur_en_ar'], 0, ',', ' ') ?> Ar</strong></td>
                            <td><span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                            <td><?= esc($userLabel) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($codes ?? [])): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999; padding: 2rem;">
                                Aucun code enregistré.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
