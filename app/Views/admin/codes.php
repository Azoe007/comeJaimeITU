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
                    <tr><td>HC-1000-A</td><td>10 000 Ar</td><td><span class="status-pill status-ok">Disponible</span></td><td>-</td></tr>
                    <tr><td>HC-2500-B</td><td>25 000 Ar</td><td><span class="status-pill status-warn">Utilise</span></td><td>Rakoto Jaime</td></tr>
                    <tr><td>HC-5000-C</td><td>50 000 Ar</td><td><span class="status-pill status-danger">Bloque</span></td><td>-</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
