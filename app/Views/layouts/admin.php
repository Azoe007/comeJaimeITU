<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle ?? 'Admin - Health Coach') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin-forms.css') ?>">
</head>
<body class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <span class="logo-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M19.14 12.94a7.94 7.94 0 0 0 .06-.94 7.94 7.94 0 0 0-.06-.94l2.03-1.58a.5.5 0 0 0 .12-.63l-1.92-3.32a.5.5 0 0 0-.6-.22l-2.39.96a7.1 7.1 0 0 0-1.63-.94l-.36-2.54a.5.5 0 0 0-.5-.43H9.05a.5.5 0 0 0-.5.43l-.36 2.54c-.58.23-1.12.54-1.63.94l-2.39-.96a.5.5 0 0 0-.6.22L1.65 8.85a.5.5 0 0 0 .12.63L3.8 11.06a7.94 7.94 0 0 0-.06.94c0 .32.02.64.06.94L1.77 14.52a.5.5 0 0 0-.12.63l1.92 3.32a.5.5 0 0 0 .6.22l2.39-.96c.5.39 1.05.71 1.63.94l.36 2.54a.5.5 0 0 0 .5.43h3.9a.5.5 0 0 0 .5-.43l.36-2.54c.58-.23 1.12-.54 1.63-.94l2.39.96a.5.5 0 0 0 .6-.22l1.92-3.32a.5.5 0 0 0-.12-.63ZM12 15.5a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5Z" />
                    </svg>
                </span>
                <span class="logo-text">HC Admin</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="<?= base_url('admin') ?>" class="nav-item <?= ($activeMenu === 'dashboard' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M4 19h16v2H2V3h2Zm2-2h3V9H6Zm5 0h3V5h-3Zm5 0h3v-7h-3Z" />
                    </svg>
                </span>
                <span class="nav-label">Tableau de bord</span>
            </a>
            <a href="<?= base_url('admin/users') ?>" class="nav-item <?= ($activeMenu === 'users' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 1a3.5 3.5 0 1 0-3.5-3.5A3.5 3.5 0 0 0 8 12Zm8 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm-8 0c-.34 0-.72.02-1.13.06A4.8 4.8 0 0 0 3 18v2h4v-2c0-.76.16-1.45.44-2Z" />
                    </svg>
                </span>
                <span class="nav-label">Utilisateurs</span>
            </a>
            <a href="<?= base_url('admin/finances') ?>" class="nav-item <?= ($activeMenu === 'finances' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm2 0v2h14V6Zm0 5v5h14v-5Zm2 2h5v1H7Z" />
                    </svg>
                </span>
                <span class="nav-label">Finances</span>
            </a>
            <a href="<?= base_url('admin/programmes') ?>" class="nav-item <?= ($activeMenu === 'programmes' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm0 2v14h8V5Zm1.5 3h5v2h-5Zm0 4h5v2h-5Zm0 4h3v2h-3Z" />
                    </svg>
                </span>
                <span class="nav-label">Programmes</span>
            </a>
            <a href="<?= base_url('admin/health') ?>" class="nav-item <?= ($activeMenu === 'health' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M12 21s-7-4.35-9.33-8.35A5.83 5.83 0 0 1 12 5.2a5.83 5.83 0 0 1 9.33 7.45C19 16.65 12 21 12 21Z" />
                    </svg>
                </span>
                <span class="nav-label">Santé</span>
            </a>
            <a href="<?= base_url('admin/regimes') ?>" class="nav-item <?= ($activeMenu === 'regimes' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M7 2h2v8H7Zm-2 0h2v8a2 2 0 0 1-2 2H4V2h1Zm9 0h2v10h-2Zm3 0h2v6a4 4 0 0 1-4 4V2h2Zm-7 12h2v8H10Zm4 0h2v8h-2Zm-9 0h2v8H5Z" />
                    </svg>
                </span>
                <span class="nav-label">Régimes</span>
            </a>
            <a href="<?= base_url('admin/sports') ?>" class="nav-item <?= ($activeMenu === 'sports' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 2a8 8 0 0 1 6.39 3.16L15 9l-3-2.15-3 2.15-3.39-1.84A8 8 0 0 1 12 4ZM4 12a7.9 7.9 0 0 1 .46-2.65L8 11l-1 3-3.65.47A7.94 7.94 0 0 1 4 12Zm8 8a7.92 7.92 0 0 1-4.8-1.62L8 15l4 2.5V20Zm8-8a7.94 7.94 0 0 1-.35 2.37L16 15l-1-3 3.54-1.65A7.9 7.9 0 0 1 20 12Zm-8-1.5 2.8 2-1.06 3.28h-3.48L9.2 12.5Z" />
                    </svg>
                </span>
                <span class="nav-label">Sports</span>
            </a>
            <a href="<?= base_url('admin/settings') ?>" class="nav-item <?= ($activeMenu === 'settings' ? 'active' : '') ?>">
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M19.14 12.94a7.94 7.94 0 0 0 .06-.94 7.94 7.94 0 0 0-.06-.94l2.03-1.58a.5.5 0 0 0 .12-.63l-1.92-3.32a.5.5 0 0 0-.6-.22l-2.39.96a7.1 7.1 0 0 0-1.63-.94l-.36-2.54a.5.5 0 0 0-.5-.43H9.05a.5.5 0 0 0-.5.43l-.36 2.54c-.58.23-1.12.54-1.63.94l-2.39-.96a.5.5 0 0 0-.6.22L1.65 8.85a.5.5 0 0 0 .12.63L3.8 11.06a7.94 7.94 0 0 0-.06.94c0 .32.02.64.06.94L1.77 14.52a.5.5 0 0 0-.12.63l1.92 3.32a.5.5 0 0 0 .6.22l2.39-.96c.5.39 1.05.71 1.63.94l.36 2.54a.5.5 0 0 0 .5.43h3.9a.5.5 0 0 0 .5-.43l.36-2.54c.58-.23 1.12-.54 1.63-.94l2.39.96a.5.5 0 0 0 .6-.22l1.92-3.32a.5.5 0 0 0-.12-.63ZM12 15.5a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5Z" />
                    </svg>
                </span>
                <span class="nav-label">Paramètres</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= base_url('admin/logout') ?>" class="btn-logout">
                <span class="logout-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M10 17v-2h4V9h2v8Zm-6 3V4h8v2H6v12h6v2Zm12-6-3-3 3-3 1.4 1.4L19.8 10H24v2h-4.2l1.6 1.6Z" />
                    </svg>
                </span>
                <span class="logout-text">Déconnexion</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-container">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <h1 class="page-heading"><?= esc($pageHeading ?? 'Tableau de bord') ?></h1>
            </div>
            <div class="topbar-right">
                <div class="user-info">
                    <span class="user-name"><?= esc(session('user_prenom') . ' ' . session('user_nom')) ?></span>
                    <span class="user-role">Administrateur</span>
                </div>
                <div class="user-avatar" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="icon-svg">
                        <path d="M12 12.5a4.5 4.5 0 1 0-4.5-4.5 4.5 4.5 0 0 0 4.5 4.5Zm0 2c-4 0-8 2-8 5v1h16v-1c0-3-4-5-8-5Z" />
                    </svg>
                </div>
            </div>
        </header>

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <a href="<?= base_url('admin') ?>">Accueil</a>
            <span class="divider">/</span>
            <span><?= esc($breadcrumb ?? 'Page') ?></span>
        </div>

        <!-- Page Content -->
        <main class="admin-main">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <span class="alert-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" class="icon-svg">
                            <path d="M9.2 16.2 5.5 12.5 4.1 13.9l5.1 5.1L20 8.2l-1.4-1.4Z" />
                        </svg>
                    </span>
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <span class="alert-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" class="icon-svg">
                            <path d="M13.41 12l4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42Z" />
                        </svg>
                    </span>
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p>&copy; 2026 Health Coach - Panneau d'administration</p>
        </footer>
    </div>

    <script src="<?= base_url('assets/js/admin-dashboard.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
