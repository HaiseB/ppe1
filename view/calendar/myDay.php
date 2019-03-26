
<div class="jumbotron container">
    <h1>Voici ce que vous avez de prévu aujourd'hui <?= $_SESSION['auth']['username']; ?></h1>
    <br>
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col"></th>
            <th scope="col">Salle</th>
            <th scope="col">Cours</th>
            <th scope="col">Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= 11; $i++): ?>
                <tr>
                <th scope="row"><?= 7+$i; ?> h 00</th>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
                </tr>
                <tr>
                <th scope="row"><?= 7+$i; ?> h 30</th>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>

<i class="fas fa-arrow-alt-circle-up"></i>
<i class="fas fa-arrow-alt-circle-down"></i>ss