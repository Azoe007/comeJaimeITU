<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<section class="admin-section">
    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">Validation des codes</span>
                <h2>Suivi des recharges utilisateurs</h2>
            </div>
            <button class="admin-btn">Valider un lot</button>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Valeur</th>
                        <th>Etat</th>
                        <th>Utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($codes ?? []) as $c): ?>
                        <?php
                            $statusClass = 'status-ok';
                            $statusLabel = 'Disponible';
                            if ((int) $c['id_statut_code'] === 2) {
                                $statusClass = 'status-warn';
                                $statusLabel = 'Utilise';
                            } elseif ((int) $c['id_statut_code'] === 3) {
                                $statusClass = 'status-danger';
                                $statusLabel = 'Bloque';
                            }
                            $userLabel = trim(($c['prenom'] ?? '') . ' ' . ($c['nom'] ?? ''));
                            if ($userLabel === '') {
                                $userLabel = '-';
                            }
                        ?>
                        <tr>
                            <td><code><?= esc($c['code']) ?></code></td>
                            <td><?= number_format((float) $c['valeur_en_ar'], 0, ',', ' ') ?> Ar</td>
                            <td><span class="status-pill <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                            <td><?= esc($userLabel) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($codes ?? [])): ?>
                        <tr>
                            <td colspan="4">Aucun code pour le moment.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
