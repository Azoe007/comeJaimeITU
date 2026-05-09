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
                <a href="<?= base_url('wallet') ?>" class="btn btn-sm btn-primary">Utiliser</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>