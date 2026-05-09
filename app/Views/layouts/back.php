<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle ?? 'Administration - Health Coach') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/back-office.css') ?>">
</head>
<body class="admin-shell">
    <div class="admin-layout">
        <aside class="admin-sidebar" data-reveal="left">
            <a class="admin-brand" href="<?= base_url('admin') ?>">
                <span>HC</span>
                <div>
                    <strong>Health Coach</strong>
                    <small>Back Office</small>
                </div>
            </a>

            <nav class="admin-nav">
                <a href="<?= base_url('admin') ?>" class="<?= ($activeMenu ?? '') === 'dashboard' ? 'is-active' : '' ?>">Tableau de bord</a>
                <a href="<?= base_url('admin/regimes') ?>" class="<?= ($activeMenu ?? '') === 'regimes' ? 'is-active' : '' ?>">Regimes</a>
                <a href="<?= base_url('admin/sports') ?>" class="<?= ($activeMenu ?? '') === 'sports' ? 'is-active' : '' ?>">Sports</a>
                <a href="<?= base_url('admin/codes') ?>" class="<?= ($activeMenu ?? '') === 'codes' ? 'is-active' : '' ?>">Codes</a>
                <a href="<?= base_url('admin/settings') ?>" class="<?= ($activeMenu ?? '') === 'settings' ? 'is-active' : '' ?>">Parametres</a>
            </nav>

            <div class="admin-note">
                <strong>Acces securise</strong>
                <p>Validation des codes, CRUD et suivi des ventes au meme endroit.</p>
            </div>
        </aside>

        <main class="admin-main">
            <header class="admin-topbar" data-reveal="down">
                <div>
                    <span class="admin-kicker"><?= esc($breadcrumb ?? 'Administration') ?></span>
                    <h1><?= esc($pageHeading ?? 'Back Office') ?></h1>
                </div>
                <a class="admin-ghost" href="<?= base_url('/') ?>">Voir le Front</a>
            </header>

            <?= $this->renderSection('content') ?>

            <footer class="admin-footer">
                <span>Health Coach Back Office</span>
                <span>Dashboard, CRUD, validation des codes et parametres metier.</span>
            </footer>
        </main>
    </div>

    <script src="<?= base_url('assets/js/back-office.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
