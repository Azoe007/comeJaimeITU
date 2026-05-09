<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<section class="admin-section">
    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">CRUD Sports</span>
                <h2>Activites sportives</h2>
            </div>
            <button class="admin-btn">Ajouter une activite</button>
        </div>

        <div class="list-stack">
            <article class="list-item"><strong>Cardio doux</strong><span>3 sessions / semaine</span></article>
            <article class="list-item"><strong>Marche active</strong><span>45 min / jour</span></article>
            <article class="list-item"><strong>Renforcement musculaire</strong><span>4 sessions / semaine</span></article>
            <article class="list-item"><strong>Natation</strong><span>2 sessions / semaine</span></article>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
