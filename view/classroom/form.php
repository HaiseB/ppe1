    <div class="form-group">
        <label for="name">Nom de la salle</label>
        <input type="text" required class="form-control" name="name"
            value="<?= isset($classroom['name']) ? h($classroom['name']) : ''; ?>">
    </div>
    <div class="form-group">
        <label for="number_places">Nombre de places</label>
        <input type="int" required class="form-control" name="number_places"
            value="<?= isset($classroom['number_places']) ? h($classroom['number_places']) : ''; ?>">
    </div>
    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="computerized" id="customSwitch1"
                <?= isset($classroom['computerized']) ? isCheckedComputerized($classroom['computerized'])? ' checked=""' : '' : '';   ?> >
            <label for="customSwitch1" class="custom-control-label">Informatisée</label>
        </div>
    </div>
    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="locked_at" id="customSwitch2"
                <?= isset($classroom['locked_at']) ? isCheckedLocked_at($classroom['locked_at'])? ' checked=""' : '' : '';   ?> >
            <label for="customSwitch2" class="custom-control-label">Verrouillée</label>
        </div>
    </div>