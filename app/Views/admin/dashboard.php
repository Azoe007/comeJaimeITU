<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="admin-page dashboard-page">
    <!-- Header avec statistiques principales -->
    <section class="stats-grid">
        <div class="stat-card stat-card-users">
            <div class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="icon-svg">
                    <path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 1a3.5 3.5 0 1 0-3.5-3.5A3.5 3.5 0 0 0 8 12Zm8 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm-8 0c-.34 0-.72.02-1.13.06A4.8 4.8 0 0 0 3 18v2h4v-2c0-.76.16-1.45.44-2Z" />
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Utilisateurs</span>
                <span class="stat-value"><?= number_format($stats['total_users']) ?></span>
                <span class="stat-change">+<?= number_format($stats['total_users_gold']) ?> Gold</span>
            </div>
        </div>

        <div class="stat-card stat-card-transactions">
            <div class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="icon-svg">
                    <path d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm2 0v2h14V6Zm0 5v5h14v-5Zm2 2h5v1H7Z" />
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Transactions</span>
                <span class="stat-value"><?= number_format($stats['total_transactions']) ?></span>
                <span class="stat-change">Valides : ✓</span>
            </div>
        </div>

        <div class="stat-card stat-card-revenue">
            <div class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="icon-svg">
                    <path d="M12 1.75A10.25 10.25 0 1 0 22.25 12 10.26 10.26 0 0 0 12 1.75Zm1 16.75v1.5h-2V18.5a4.52 4.52 0 0 1-3.75-2.25l1.7-1a2.86 2.86 0 0 0 2.55 1.5c1 0 1.75-.44 1.75-1.2 0-.92-.86-1.22-2.2-1.64C10.6 13.49 8.5 12.85 8.5 10.3c0-1.77 1.27-3.12 3.25-3.49V5.25h2v1.55a4.15 4.15 0 0 1 2.95 1.92l-1.62 1.08a2.46 2.46 0 0 0-2.18-1.1c-1.06 0-1.7.47-1.7 1.14 0 .82.85 1.11 2.3 1.56 1.95.6 3.95 1.29 3.95 3.81 0 1.95-1.39 3.27-3.5 3.59Z" />
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Revenu Total</span>
                <span class="stat-value"><?= number_format($stats['revenue_total'], 0) ?> Ar</span>
                <span class="stat-change">+12% ce mois</span>
            </div>
        </div>

        <div class="stat-card stat-card-programmes">
            <div class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="icon-svg">
                    <path d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm0 2v14h8V5Zm1.5 3h5v2h-5Zm0 4h5v2h-5Zm0 4h3v2h-3Z" />
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Programmes</span>
                <span class="stat-value"><?= number_format($stats['total_programmes']) ?></span>
                <span class="stat-change">Actifs</span>
            </div>
        </div>
    </section>

    <!-- Graphes principales -->
    <section class="charts-section">
        <div class="chart-container chart-users-by-month">
            <div class="chart-header">
                <h3>Inscriptions par mois</h3>
                <span class="chart-period">Derniers 12 mois</span>
            </div>
            <canvas id="chartUsersMonth"></canvas>
        </div>

        <div class="chart-container chart-revenue-by-month">
            <div class="chart-header">
                <h3>Revenus par mois</h3>
                <span class="chart-period">Derniers 12 mois</span>
            </div>
            <canvas id="chartRevenueMonth"></canvas>
        </div>
    </section>

    <!-- Graphes secondaires -->
    <section class="charts-secondary">
        <div class="chart-container chart-small">
            <div class="chart-header">
                <h3>Distribution des objectifs</h3>
            </div>
            <canvas id="chartObjectifs"></canvas>
        </div>

        <div class="chart-container chart-small">
            <div class="chart-header">
                <h3>Régimes populaires</h3>
            </div>
            <canvas id="chartRegimes"></canvas>
        </div>

        <div class="chart-container chart-small">
            <div class="chart-header">
                <h3>Status transactions</h3>
            </div>
            <canvas id="chartTransactions"></canvas>
        </div>

        <div class="chart-container chart-small">
            <div class="chart-header">
                <h3>Genre utilisateurs</h3>
            </div>
            <canvas id="chartGenre"></canvas>
        </div>
    </section>

    <!-- Tableaux récents -->
    <section class="recent-section">
        <div class="table-container">
            <div class="table-header">
                <h3>Utilisateurs récents</h3>
                <a href="<?= base_url('admin/users') ?>" class="view-all-link">Voir tout →</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Date inscr.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentData['recent_users'] as $user): ?>
                        <tr>
                            <td><strong><?= esc($user['prenom'] . ' ' . $user['nom']) ?></strong></td>
                            <td><?= esc($user['email']) ?></td>
                            <td>
                                <?php if ($user['est_gold']): ?>
                                    <span class="badge badge-gold">GOLD</span>
                                <?php else: ?>
                                    <span class="badge badge-basic">Basic</span>
                                <?php endif; ?>
                            </td>
                            <td><?= isset($user['created_at']) ? (new \DateTime($user['created_at']))->format('d/m/Y') : 'N/A' ?></td>
                            <td>
                                <a href="<?= base_url('admin/users/' . $user['id']) ?>" class="btn-small btn-view">Détails</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Transactions récentes</h3>
                <a href="<?= base_url('admin/finances') ?>" class="view-all-link">Voir tout →</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>État</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentData['recent_transactions'] as $transaction): ?>
                        <tr>
                            <td><strong><?= esc($transaction['prenom'] . ' ' . $transaction['nom']) ?></strong></td>
                            <td><?= number_format($transaction['montant'], 0) ?> Ar</td>
                            <td>
                                <?php 
                                $statusClass = match($transaction['etat']) {
                                    'valide' => 'badge-success',
                                    'en cours' => 'badge-warning',
                                    'echec' => 'badge-danger',
                                    'annule' => 'badge-secondary',
                                    default => 'badge-secondary'
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>">
                                    <?= ucfirst(esc($transaction['etat'])) ?>
                                </span>
                            </td>
                            <td><?= isset($transaction['created_at']) ? (new \DateTime($transaction['created_at']))->format('d/m/Y H:i') : 'N/A' ?></td>
                            <td>
                                <button class="btn-small btn-info" onclick="alert('Détail transaction')">Voir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuration commune
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                labels: { font: { family: '"Manrope", sans-serif', size: 12 } }
            }
        },
        scales: {
            y: { ticks: { font: { family: '"Manrope", sans-serif' } } },
            x: { ticks: { font: { family: '"Manrope", sans-serif' } } }
        }
    };

    // Graphe inscriptions
    const usersData = <?= json_encode($graphData['users_by_month'] ?? []) ?>;
    const monthLabels = usersData.map(d => new Date(d.month || d.created_at).toLocaleDateString('fr-FR', { month: 'short', year: '2-digit' }));
    const userCounts = usersData.map(d => d.count || 0);
    
    if (document.getElementById('chartUsersMonth')) {
        new Chart(document.getElementById('chartUsersMonth'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Utilisateurs',
                    data: userCounts,
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#2ecc71'
                }]
            },
            options: { ...chartDefaults }
        });
    }

    // Graphe revenus
    const revenueData = <?= json_encode($graphData['revenue_by_month'] ?? []) ?>;
    const revenueCounts = revenueData.map(d => d.revenue || 0);
    
    if (document.getElementById('chartRevenueMonth')) {
        new Chart(document.getElementById('chartRevenueMonth'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Revenu (Ar)',
                    data: revenueCounts,
                    backgroundColor: '#3498db',
                    borderRadius: 6
                }]
            },
            options: { ...chartDefaults }
        });
    }

    // Graphe objectifs
    const objectifsData = <?= json_encode($graphData['objectifs_distribution'] ?? []) ?>;
    if (document.getElementById('chartObjectifs') && objectifsData.length > 0) {
        new Chart(document.getElementById('chartObjectifs'), {
            type: 'doughnut',
            data: {
                labels: objectifsData.map(d => d.nom || 'N/A'),
                datasets: [{
                    data: objectifsData.map(d => d.count || 0),
                    backgroundColor: ['#2ecc71', '#e67e22', '#e74c3c', '#9b59b6', '#3498db']
                }]
            },
            options: chartDefaults
        });
    }

    // Graphe régimes
    const regimesData = <?= json_encode($graphData['programmes_by_regime'] ?? []) ?>;
    if (document.getElementById('chartRegimes') && regimesData.length > 0) {
        new Chart(document.getElementById('chartRegimes'), {
            type: 'bar',
            data: {
                labels: regimesData.map(d => d.regime_name || d.description || 'N/A').slice(0, 5),
                datasets: [{
                    label: 'Programmes',
                    data: regimesData.map(d => d.count || 0).slice(0, 5),
                    backgroundColor: '#9b59b6'
                }]
            },
            options: { ...chartDefaults }
        });
    }

    // Graphe status transactions
    const transData = <?= json_encode($graphData['transactions_by_status'] ?? []) ?>;
    if (document.getElementById('chartTransactions') && transData.length > 0) {
        new Chart(document.getElementById('chartTransactions'), {
            type: 'pie',
            data: {
                labels: transData.map(d => d.etat || 'N/A'),
                datasets: [{
                    data: transData.map(d => d.count || 0),
                    backgroundColor: ['#2ecc71', '#f39c12', '#e74c3c', '#95a5a6', '#3498db']
                }]
            },
            options: chartDefaults
        });
    }

    // Graphe genre
    const genreData = <?= json_encode($graphData['users_by_genre'] ?? []) ?>;
    if (document.getElementById('chartGenre') && genreData.length > 0) {
        new Chart(document.getElementById('chartGenre'), {
            type: 'bar',
            data: {
                labels: genreData.map(d => d.genre || 'N/A'),
                datasets: [{
                    label: 'Utilisateurs',
                    data: genreData.map(d => d.count || 0),
                    backgroundColor: ['#e74c3c', '#3498db', '#95a5a6']
                }]
            },
            options: { ...chartDefaults }
        });
    }
</script>

<?= $this->endSection() ?>
