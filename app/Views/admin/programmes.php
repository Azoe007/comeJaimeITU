<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Statistiques programmes -->
    <section class="stats-grid-mini">
        <div class="stat-mini-card">
            <div class="stat-icon">📋</div>
            <div class="stat-content">
                <span class="label">Total programmes</span>
                <span class="value"><?= $stats['total_programmes'] ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">⚡</div>
            <div class="stat-content">
                <span class="label">Programmes actifs</span>
                <span class="value"><?= $stats['active_programmes'] ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">🏆</div>
            <div class="stat-content">
                <span class="label">Régime favori</span>
                <span class="value"><?= esc($stats['top_regime']['description'] ?? 'N/A') ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">💵</div>
            <div class="stat-content">
                <span class="label">Prix moyen</span>
                <span class="value"><?= number_format($stats['average_programme_price'], 0) ?> Ar</span>
            </div>
        </div>
    </section>

    <!-- Tous les programmes -->
    <div class="page-header" style="margin: 2rem 0 1.5rem;">
        <h2>Programmes en cours</h2>
        <div class="header-controls">
                <input type="text" placeholder="Rechercher..." id="searchProgrammes" class="search-input">
                <select id="filterRegime" class="filter-select">
                    <option value="">Tous les régimes</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= $regime['id'] ?>"><?= esc($regime['description'] ?? 'N/A') ?></option>
                    <?php endforeach; ?>
                </select>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="admin-table programmes-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Régime</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($programmes as $prog): ?>
                        <tr class="prog-row" data-regime-id="<?= $prog['id_regime'] ?>">
                            <td><strong><?= esc($prog['prenom'] . ' ' . $prog['nom']) ?></strong></td>
                            <td><?= esc($prog['regime_name'] ?? 'N/A') ?></td>
                            <td><?= isset($prog['date_debut']) ? (new \DateTime($prog['date_debut']))->format('d/m/Y') : 'N/A' ?></td>
                            <td><?= isset($prog['date_fin']) ? (new \DateTime($prog['date_fin']))->format('d/m/Y') : 'N/A' ?></td>
                            <td><strong><?= number_format($prog['prix_total'] ?? 0, 0) ?> Ar</strong></td>
                            <td>
                                <?php 
                                $now = new \DateTime();
                                $debut = isset($prog['date_debut']) ? new \DateTime($prog['date_debut']) : null;
                                $fin = isset($prog['date_fin']) ? new \DateTime($prog['date_fin']) : null;
                                
                                if ($debut && $fin && $debut <= $now && $now <= $fin) {
                                    echo '<span class="badge badge-success">🔥 Actif</span>';
                                } elseif ($fin && $now > $fin) {
                                    echo '<span class="badge badge-secondary">✓ Terminé</span>';
                                } else {
                                    echo '<span class="badge badge-info">⏳ À venir</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/users/' . $prog['id_user']) ?>" class="btn-small btn-view">Profil client</a>
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
    document.getElementById('searchProgrammes')?.addEventListener('keyup', function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.prog-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    document.getElementById('filterRegime')?.addEventListener('change', function(e) {
        const regimeId = e.target.value;
        document.querySelectorAll('.prog-row').forEach(row => {
            if (!regimeId) {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.regimeId == regimeId ? '' : 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>
