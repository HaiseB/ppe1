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
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" class="form-control" name="description" ><?= isset($data['description']) ? h($data['description']) : ''; ?></textarea>
        </div>