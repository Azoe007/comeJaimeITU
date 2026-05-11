<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-page users-page">
    <div class="page-header">
        <h2>Gestion des utilisateurs</h2>
        <div class="header-controls">
            <input type="text" placeholder="Rechercher..." class="search-input" id="searchUsers">
            <select class="filter-select" id="filterStatus">
                <option value="">Tous les statuts</option>
                <option value="gold">Gold</option>
                <option value="basic">Basic</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table users-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Genre</th>
                    <th>Statut</th>
                    <th>Date inscription</th>
                    <th>Programmes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="user-row" data-user-id="<?= $user['id'] ?>">
                        <td><strong><?= esc($user['prenom'] . ' ' . $user['nom']) ?></strong></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['genre'] ?? 'N/A') ?></td>
                        <td>
                            <?php if ($user['est_gold']): ?>
                                <span class="badge badge-gold">👑 GOLD</span>
                            <?php else: ?>
                                <span class="badge badge-basic">Basic</span>
                            <?php endif; ?>
                        </td>
                        <td><?= isset($user['created_at']) ? (new \DateTime($user['created_at']))->format('d/m/Y') : 'N/A' ?></td>
                        <td><span class="count-badge">0</span></td>
                        <td>
                            <a href="<?= base_url('admin/users/' . $user['id']) ?>" class="btn-small btn-view">Voir profil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table-pagination">
        <p>Affichage de <strong><?= count($users) ?></strong> utilisateurs</p>
    </div>
</div>

<script>
    document.getElementById('searchUsers')?.addEventListener('keyup', function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    document.getElementById('filterStatus')?.addEventListener('change', function(e) {
        const status = e.target.value;
        document.querySelectorAll('.user-row').forEach(row => {
            if (!status) {
                row.style.display = '';
            } else {
                const badge = row.querySelector('.badge');
                const matches = (status === 'gold' && badge.classList.contains('badge-gold')) ||
                               (status === 'basic' && badge.classList.contains('badge-basic'));
                row.style.display = matches ? '' : 'none';
            }
        });
    });
</script>

<?= $this->endSection() ?>
