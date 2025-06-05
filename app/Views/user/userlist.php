<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Daftar User
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped table-bordered" style="width:100%;" id='normal'>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Username</th>
                        <th style="width: 40%;">Email</th>
                        <th>Role</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= esc($user->username); ?></td>
                            <td><?= esc($user->email); ?></td>
                            <td><?= esc($user->name); ?></td>
                            <td>
                                <a href="<?= site_url('user?edit=' . $user->userid); ?>" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <?php if (isset($editUser)) : ?>
                <h3>Edit User</h3>
                <form action="<?= site_url('user/update'); ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $editUser->id ?>">

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="<?= esc($editUser->username); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Email (tidak bisa diedit)</label>
                        <input type="email" value="<?= esc($editUser->email); ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= $role->id; ?>" <?= ($role->id == $editUser->role_id) ? 'selected' : ''; ?>>
                                    <?= esc($role->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <a href="<?= site_url('user'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>