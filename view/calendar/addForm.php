        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Titre</label>
                    <input id="name" type="text" required class="form-control" name="name" value="<?= isset($data['name']) ? h($data['name']) : ''; ?>">
                    <?php if(isset($errors['name'])): ?>
                        <small class="help-block text-muted "><?= $errors['name']; ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input id="date" type="date" required class="form-control" name="date" value="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
                    <?php if(isset($errors['date'])): ?>
                        <small class="help-block text-muted "><?= $errors['date']; ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="start">Démarrage</label>
                    <input id="start" type="time" required class="form-control" name="start" placeholder="HH:MM" value="<?= isset($data['start']) ? h($data['start']) : ''; ?>">
                    <?php if(isset($errors['start'])): ?>
                        <small class="form-text text-muted "><?= $errors['start']; ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="end">Fin</label>
                    <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM" value="<?= isset($data['end']) ? h($data['end']) : ''; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="number_places">Nombre de place</label>
                    <input id="number_places" type="int" required class="form-control" name="number_places" value="<?= isset($data['number_places']) ? h($data['number_places']) : ''; ?>">
                    <?php if(isset($errors['number_places'])): ?>
                        <small class="help-block text-muted "><?= $errors['number_places']; ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="computerized" id="customSwitch1"
                    <?= isset($classroom['computerized']) ? isCheckedComputerized($classroom['computerized'])? ' checked=""' : '' : '';   ?> >
                <label for="customSwitch1" class="custom-control-label">Informatisée</label>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" class="form-control" name="description" ><?= isset($data['description']) ? h($data['description']) : ''; ?></textarea>
        </div>