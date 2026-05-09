<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<section class="admin-section">
    <div class="admin-stats">
        <article class="metric-card" data-reveal="up"><strong>128</strong><span>utilisateurs actifs</span></article>
        <article class="metric-card" data-reveal="up"><strong>37</strong><span>abonnements Gold</span></article>
        <article class="metric-card" data-reveal="up"><strong>14</strong><span>codes valides aujourd'hui</span></article>
        <article class="metric-card" data-reveal="up"><strong>9</strong><span>regimes en catalogue</span></article>
    </div>

    <div class="admin-grid">
        <article class="admin-card" data-reveal="up">
            <div class="section-head">
                <div>
                    <span class="admin-kicker">Statistiques</span>
                    <h2>Performance des ventes</h2>
                </div>
            </div>
            <div class="chart-bars">
                <span style="height:58%">Jan</span>
                <span style="height:78%">Fev</span>
                <span style="height:48%">Mar</span>
                <span style="height:92%">Avr</span>
                <span style="height:70%">Mai</span>
            </div>
        </article>

        <article class="admin-card" data-reveal="up">
            <div class="section-head">
                <div>
                    <span class="admin-kicker">Tableau croise</span>
                    <h2>Objectifs les plus demandes</h2>
                </div>
            </div>
            <div class="list-stack">
                <div class="list-item"><strong>Reduction de poids</strong><span>41%</span></div>
                <div class="list-item"><strong>IMC ideal</strong><span>36%</span></div>
                <div class="list-item"><strong>Prise de poids</strong><span>23%</span></div>
            </div>
        </article>
    </div>
</section>

<?= $this->endSection() ?>
