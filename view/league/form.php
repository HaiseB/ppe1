<div class="form-group">
            <label for="name">Nom de la Ligue</label>
            <input type="text" required class="form-control" name="name"
                value="<?= isset($league['name']) ? h($league['name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="sport">Sport pratiqué</label>
            <input type="text" required class="form-control" name="sport"
                value="<?= isset($league['sport']) ? h($league['sport']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="phone_number">Numéro de téléphone</label>
            <input type="int" required class="form-control" name="phone_number"
                value="<?= isset($league['phone_number']) ? h($league['phone_number']) : ''; ?>">
        </div>
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="locked_at" id="customSwitch1"
                    <?= isset($league['locked_at']) ? isCheckedLocked_at($league['locked_at'])? ' checked=""' : '' : '';   ?> >
                <label for="customSwitch1" class="custom-control-label">Verrouillée</label>
            </div>
        </div>