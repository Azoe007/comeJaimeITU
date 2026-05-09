<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codes</title>
</head>
<body>
    <table class="table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Valeur (Ar)</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach(($codes ?? []) as $c): ?>
        <tr>
            <td><code><?= $c['code'] ?></code></td>
            <td><?= number_format($c['valeur_en_ar'], 0, ',', ' ') ?> Ar</td>
            <td><?= $c['type'] ?></td>
            <td>
                <a href="<?= base_url('wallet') ?>" class="btn btn-sm btn-primary">Copier et Utiliser</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
=======
<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<section class="admin-section">
    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">Validation des codes</span>
                <h2>Codes disponibles pour le porte-monnaie</h2>
            </div>
            <button class="admin-btn">Generer un code</button>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Valeur</th>
                        <th>Type</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($codes ?? []) as $c): ?>
                        <tr>
                            <td><code><?= esc($c['code']) ?></code></td>
                            <td><?= number_format((float) $c['valeur_en_ar'], 0, ',', ' ') ?> Ar</td>
                            <td><?= esc($c['type'] ?? 'Standard') ?></td>
                            <td><span class="status-pill status-ok">Disponible</span></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($codes ?? [])): ?>
                        <tr>
                            <td colspan="4">Aucun code disponible pour le moment.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
>>>>>>> 1e02d9c8cf3a64feead10a16f243716aaa72111d
