<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Health Coach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/front-office.css') ?>">
</head>
<body class="app-shell">
    <section class="not-found">
        <div class="container not-found-card" data-reveal="up">
            <span class="eyebrow">Erreur 404</span>
            <h1>La page demandee est introuvable.</h1>
            <p><?php if (ENVIRONMENT !== 'production') : ?><?= esc($message) ?><?php else : ?>Le contenu demande n'existe pas ou a ete deplace.<?php endif; ?></p>
            <a class="btn btn-primary" href="<?= base_url('/') ?>">Retour a l'accueil</a>
        </div>
    </section>
    <script src="<?= base_url('assets/js/front-office.js') ?>"></script>
</body>
</html>
