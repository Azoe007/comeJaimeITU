<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<section class="admin-section">
    <div class="admin-grid">
        <article class="admin-card" data-reveal="up">
            <div class="section-head">
                <div>
                    <span class="admin-kicker">Parametres</span>
                    <h2>Regles metier</h2>
                </div>
            </div>
            <div class="list-stack">
                <div class="list-item"><strong>Prix Gold</strong><span>49 000 Ar</span></div>
                <div class="list-item"><strong>Remise Gold</strong><span>15%</span></div>
                <div class="list-item"><strong>IMC ideal cible</strong><span>18.5 - 24.9</span></div>
            </div>
        </article>

        <article class="admin-card" data-reveal="up">
            <div class="section-head">
                <div>
                    <span class="admin-kicker">Operations sensibles</span>
                    <h2>Zone de suppression</h2>
                </div>
            </div>
            <div class="action-pills">
                <span class="danger">Supprimer codes expires</span>
                <span class="danger">Purger transactions en echec</span>
            </div>
        </article>
    </div>
</section>

<?= $this->endSection() ?>
