<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Daftar User
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<section class="content">
    <div class="row">
        <div class="col-md-7">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4>Daftar User</h4>
                <a href="<?= site_url('user?add=new'); ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-user-plus"></i> Tambah Akun
                </a>
            </div>

            <table class="table table-striped table-bordered" style="width:100%;" id='normal'>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Username</th>
                        <th style="width: 40%;">Email</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Hapus</th>
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
                            <td>
                                <a href="<?= site_url('user/delete/' . $user->userid); ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-5">
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
            <?php elseif (request()->getGet('add') === 'new') : ?>

                <h3>Tambah User Baru</h3>

                <?php if (session('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= site_url('user/create'); ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                            name="email"
                            class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                            value="<?= old('email') ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text"
                            name="username"
                            class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                            value="<?= old('username') ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                            name="password"
                            class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="pass_confirm">Konfirmasi Password</label>
                        <input type="password"
                            name="pass_confirm"
                            class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>"
                            required>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <a href="<?= site_url('user'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Buat Akun</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>