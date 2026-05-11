<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Statistiques santé -->
    <section class="stats-grid-mini">
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9h18v2H3zm0 4h18v2H3zm0-8h18v2H3z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Poids moyen</span>
                <span class="value"><?= number_format($stats['avg_weight'], 1) ?> kg</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20"/>
                    <path d="M8 6h8M8 18h8"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Taille moyenne</span>
                <span class="value"><?= number_format($stats['avg_height'], 1) ?> cm</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h4l4-8 4 8h4M3 16h18"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Poids max</span>
                <span class="value"><?= number_format($stats['max_weight'], 1) ?> kg</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h4l4 8 4-8h4M3 8h18"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Poids min</span>
                <span class="value"><?= number_format($stats['min_weight'], 1) ?> kg</span>
            </div>
        </div>
    </section>

    <!-- Historique santé -->
    <div class="page-header" style="margin: 2rem 0 1.5rem;">
        <h2>Données de santé</h2>
        <div class="header-controls">
                <input type="text" placeholder="Rechercher utilisateur..." id="searchHealth" class="search-input">
            </div>
        </div>

        <div class="table-responsive">
            <table class="admin-table health-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Date</th>
                        <th>Poids (kg)</th>
                        <th>Taille (cm)</th>
                        <th>IMC</th>
                        <th>Catégorie IMC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($healthData as $health): ?>
                        <tr class="health-row" data-user="<?= esc($health['prenom'] . ' ' . $health['nom']) ?>">
                            <td><strong><?= esc($health['prenom'] . ' ' . $health['nom']) ?></strong></td>
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
                            <td>
                                <?php 
                                if ($imc < 18.5) {
                                    echo '<span class="badge badge-info">Insuffisant</span>';
                                } elseif ($imc < 25) {
                                    echo '<span class="badge badge-success">Normal</span>';
                                } elseif ($imc < 30) {
                                    echo '<span class="badge badge-warning">Surpoids</span>';
                                } else {
                                    echo '<span class="badge badge-danger">Obésité</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Objectifs -->
    <div style="margin-top: 2rem;">
        <div class="section-header">
            <h3>Objectifs santé</h3>
        </div>

        <div class="table-responsive">
            <table class="admin-table objectifs-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Objectif</th>
                        <th>Poids actuel</th>
                        <th>Objectif poids</th>
                        <th>Taille (cm)</th>
                        <th>Progression</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($objectifs as $obj): ?>
                        <tr>
                            <td><strong><?= esc($obj['prenom'] . ' ' . $obj['nom']) ?></strong></td>
                            <td><?= esc($obj['objectif_name'] ?? 'N/A') ?></td>
                            <td><?= number_format($obj['poids_kg'] ?? 0, 1) ?> kg</td>
                            <td><?= number_format($obj['poids_objectif'] ?? 0, 1) ?> kg</td>
                            <td><?= number_format($obj['taille_cm'] ?? 0, 1) ?></td>
                            <td>
                                <?php 
                                $poids_current = $obj['poids_kg'] ?? 0;
                                $poids_obj = $obj['poids_objectif'] ?? 0;
                                $diff = abs($poids_obj - $poids_current);
                                $percent = $poids_obj > 0 ? min(100, max(0, ($diff / $poids_obj) * 100)) : 0;
                                ?>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= $percent ?>%"></div>
                                </div>
                                <span class="progress-text"><?= round($percent) ?>%</span>
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
    document.getElementById('searchHealth')?.addEventListener('keyup', function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.health-row').forEach(row => {
            const user = row.dataset.user.toLowerCase();
            row.style.display = user.includes(query) ? '' : 'none';
        });
    });
</script>
<?= $this->endSection() ?>
