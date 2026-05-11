<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page">
    <!-- Statistiques programmes -->
    <section class="stats-grid-mini">
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                    <line x1="2" y1="17" x2="22" y2="17"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Total programmes</span>
                <span class="value"><?= $stats['total_programmes'] ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Programmes actifs</span>
                <span class="value"><?= $stats['active_programmes'] ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="7"/>
                    <path d="M8 15h8a4 4 0 0 1 4 4v3H4v-3a4 4 0 0 1 4-4z"/>
                    <path d="M12 1l3.29 6.71H23l-5.64 4.29 2.34 7H12l-5.64-4.29L8.7 7.71H1L4.29 1z" fill="currentColor"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="label">Régime favori</span>
                <span class="value"><?= esc($stats['top_regime']['description'] ?? 'N/A') ?></span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
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
                                    echo '<span class="badge badge-success"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="display:inline;vertical-align:middle;margin-right:4px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Actif</span>';
                                } elseif ($fin && $now > $fin) {
                                    echo '<span class="badge badge-secondary"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px"><polyline points="20 6 9 17 4 12"/></svg> Terminé</span>';
                                } else {
                                    echo '<span class="badge badge-info"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> À venir</span>';
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
