<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Statistiques financières -->
    <section class="stats-grid-mini">
        <div class="stat-mini-card">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <span class="label">Revenu total</span>
                <span class="value"><?= number_format($stats['revenue_total'], 0) ?> Ar</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <span class="label">En attente</span>
                <span class="value"><?= number_format($stats['pending_revenue'], 0) ?> Ar</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">❌</div>
            <div class="stat-content">
                <span class="label">Transactions échouées</span>
                <span class="value"><?= $stats['failed_transactions'] ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">👛</div>
            <div class="stat-content">
                <span class="label">Solde total portefeuilles</span>
                <span class="value"><?= number_format($stats['total_wallets_balance'], 0) ?> Ar</span>
            </div>
        </div>
    </section>

    <!-- Transactions -->
    <div class="page-header" style="margin: 2rem 0 1.5rem;">
        <h2>Transactions</h2>
        <div class="header-controls">
                <select id="filterTransStatus" class="filter-select">
                    <option value="">Tous les états</option>
                    <option value="valide">Validé</option>
                    <option value="en cours">En cours</option>
                    <option value="echec">Échoué</option>
                    <option value="annule">Annulé</option>
                </select>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="admin-table transactions-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Régime</th>
                        <th>Montant</th>
                        <th>Réduction</th>
                        <th>État</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $trans): ?>
                        <tr class="trans-row" data-status="<?= esc($trans['etat']) ?>">
                            <td><strong><?= esc($trans['prenom'] . ' ' . $trans['nom']) ?></strong></td>
                            <td><?= esc($trans['email'] ?? 'N/A') ?></td>
                            <td><?= esc($trans['regime_name'] ?? 'N/A') ?></td>
                            <td><strong><?= number_format($trans['montant'] ?? 0, 0) ?> Ar</strong></td>
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
                            <td><?= isset($trans['created_at']) ? (new \DateTime($trans['created_at']))->format('d/m/Y H:i') : 'N/A' ?></td>
                            <td>
                                <button class="btn-small btn-info" onclick="alert('Transaction ID: <?= $trans['id'] ?>')">Détail</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Portefeuilles -->
    <section class="finance-section">
        <div class="section-header">
            <h3>Top 10 portefeuilles</h3>
        </div>

        <div class="table-responsive">
            <table class="admin-table wallets-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Solde</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($wallets, 0, 10) as $wallet): ?>
                        <tr>
                            <td><strong><?= esc($wallet['prenom'] . ' ' . $wallet['nom']) ?></strong></td>
                            <td><?= esc($wallet['email']) ?></td>
                            <td>
                                <span class="solde-badge">
                                    <?= number_format($wallet['solde'] ?? 0, 0) ?> Ar
                                </span>
                            </td>
                            <td>
                                <?php if (($wallet['solde'] ?? 0) > 100000): ?>
                                    <span class="badge badge-success">Élevé</span>
                                <?php elseif (($wallet['solde'] ?? 0) > 0): ?>
                                    <span class="badge badge-warning">Normal</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Vide</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('filterTransStatus')?.addEventListener('change', function(e) {
        const status = e.target.value;
        document.querySelectorAll('.trans-row').forEach(row => {
            if (!status) {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === status ? '' : 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>
