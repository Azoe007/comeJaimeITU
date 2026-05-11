<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page user-detail-page">
    <div class="detail-header">
        <div class="detail-title">
            <h2><?= esc($user['prenom'] . ' ' . $user['nom']) ?></h2>
            <span class="detail-email"><?= esc($user['email']) ?></span>
        </div>
        <?php if ($user['est_gold']): ?>
            <span class="badge badge-gold badge-large">👑 GOLD</span>
        <?php else: ?>
            <span class="badge badge-basic badge-large">Basic</span>
        <?php endif; ?>
    </div>

    <!-- Informations personnelles -->
    <section class="detail-section">
        <h3>Informations personnelles</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">Prénom</span>
                <span class="value"><?= esc($user['prenom']) ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Nom</span>
                <span class="value"><?= esc($user['nom']) ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Email</span>
                <span class="value"><?= esc($user['email']) ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Genre</span>
                <span class="value"><?= esc($user['genre'] ?? 'N/A') ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Date naissance</span>
                <span class="value"><?= isset($user['date_naissance']) ? (new \DateTime($user['date_naissance']))->format('d/m/Y') : 'N/A' ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Inscrit le</span>
                <span class="value"><?= isset($user['created_at']) ? (new \DateTime($user['created_at']))->format('d/m/Y à H:i') : 'N/A' ?></span>
            </div>
        </div>
    </section>

    <!-- Statistiques utilisateur -->
    <section class="detail-section">
        <h3>Statistiques</h3>
        <div class="stats-mini-grid">
            <div class="stat-mini">
                <span class="stat-icon">📋</span>
                <span class="stat-value"><?= $stats['programmes'] ?></span>
                <span class="stat-label">Programmes</span>
            </div>
            <div class="stat-mini">
                <span class="stat-icon">💳</span>
                <span class="stat-value"><?= $stats['transactions'] ?></span>
                <span class="stat-label">Transactions</span>
            </div>
            <div class="stat-mini">
                <span class="stat-icon">❤️</span>
                <span class="stat-value"><?= $stats['health_records'] ?></span>
                <span class="stat-label">Données santé</span>
            </div>
            <div class="stat-mini">
                <span class="stat-icon">💰</span>
                <span class="stat-value"><?= number_format($stats['total_spent'], 0) ?> Ar</span>
                <span class="stat-label">Dépensé</span>
            </div>
        </div>
    </section>

    <!-- Programmes de l'utilisateur -->
    <?php if (!empty($programmes)): ?>
        <section class="detail-section">
            <h3>Programmes en cours</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Régime</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programmes as $prog): ?>
                            <tr>
                                <td><?= esc($prog['regime_name'] ?? 'N/A') ?></td>
                                <td><?= isset($prog['date_debut']) ? (new \DateTime($prog['date_debut']))->format('d/m/Y') : 'N/A' ?></td>
                                <td><?= isset($prog['date_fin']) ? (new \DateTime($prog['date_fin']))->format('d/m/Y') : 'N/A' ?></td>
                                <td><?= number_format($prog['prix_total'] ?? 0, 0) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

    <!-- Transactions -->
    <?php if (!empty($transactions)): ?>
        <section class="detail-section">
            <h3>Historique transactions</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Réduction</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $trans): ?>
                            <tr>
                                <td><?= isset($trans['created_at']) ? (new \DateTime($trans['created_at']))->format('d/m/Y H:i') : 'N/A' ?></td>
                                <td><?= number_format($trans['montant'] ?? 0, 0) ?> Ar</td>
                                <td><?= number_format($trans['reduction'] ?? 0, 0) ?> Ar</td>
                                <td>
                                    <?php 
                                    $statusClass = match($trans['etat']) {
                                        'valide' => 'badge-success',
                                        'en cours' => 'badge-warning',
                                        'echec' => 'badge-danger',
                                        'annule' => 'badge-secondary',
                                        default => 'badge-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= ucfirst(esc($trans['etat'])) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

    <!-- Historique santé -->
    <?php if (!empty($healthHistory)): ?>
        <section class="detail-section">
            <h3>Historique santé</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Poids (kg)</th>
                            <th>Taille (cm)</th>
                            <th>IMC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($healthHistory as $health): ?>
                            <tr>
                                <td><?= isset($health['created_at']) ? (new \DateTime($health['created_at']))->format('d/m/Y') : 'N/A' ?></td>
                                <td><?= number_format($health['poids'] ?? 0, 1) ?></td>
                                <td><?= number_format($health['taille'] ?? 0, 1) ?></td>
                                <td>
                                    <?php 
                                    $poids = $health['poids'] ?? 0;
                                    $taille = ($health['taille'] ?? 0) / 100;
                                    $imc = $taille > 0 ? round($poids / ($taille * $taille), 1) : 0;
                                    ?>
                                    <strong><?= $imc ?></strong>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

    <div class="detail-actions">
        <a href="<?= base_url('admin/users') ?>" class="btn-secondary">← Retour</a>
    </div>
</div>

<?= $this->endSection() ?>
