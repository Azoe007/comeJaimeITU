<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<section class="admin-section">
    <div class="admin-card" data-reveal="up">
        <div class="section-head">
            <div>
                <span class="admin-kicker">CRUD Regimes</span>
                <h2>Catalogue des regimes</h2>
            </div>
            <button class="admin-btn">Ajouter un regime</button>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Duree</th>
                        <th>Variation poids</th>
                        <th>Viande</th>
                        <th>Poisson</th>
                        <th>Volaille</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Equilibre quotidien</td>
                        <td>30 jours</td>
                        <td>-3 kg / +1 kg</td>
                        <td>40%</td>
                        <td>30%</td>
                        <td>30%</td>
                        <td>24 000 Ar</td>
                        <td><div class="action-pills"><span>Modifier</span><span class="danger">Supprimer</span></div></td>
                    </tr>
                    <tr>
                        <td>Masse controlee</td>
                        <td>45 jours</td>
                        <td>+4 kg</td>
                        <td>35%</td>
                        <td>20%</td>
                        <td>45%</td>
                        <td>32 000 Ar</td>
                        <td><div class="action-pills"><span>Modifier</span><span class="danger">Supprimer</span></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
