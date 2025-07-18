<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;



class User extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // semua user + role
        $builder = $db->table('users');
        $builder->select('users.id as userid, username, email, name');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $builder->where('users.deleted_at', null);
        $query = $builder->get();
        $data['users'] = $query->getResult();


        $editUserId = $this->request->getGet('edit');
        if ($editUserId) {
            // user yang diedit
            $builder = $db->table('users');
            $builder->select('users.id, username, email');
            $builder->where('users.id', $editUserId);
            $editUser = $builder->get()->getRow();

            // role user yang sekarang
            $builder = $db->table('auth_groups_users');
            $builder->select('group_id');
            $builder->where('user_id', $editUserId);
            $group = $builder->get()->getRow();

            // semua role
            $builder = $db->table('auth_groups');
            $roles = $builder->get()->getResult();


            $editUser->role_id = $group ? $group->group_id : null;

            $data['editUser'] = $editUser;
            $data['roles'] = $roles;
        }

        return view('user/userlist', $data);
    }

    public function update()
    {
        $db = \Config\Database::connect();

        $id = $this->request->getPost('id');
        $username = $this->request->getPost('username');
        $role_id = $this->request->getPost('role');

        // Update username
        $builder = $db->table('users');
        $builder->where('id', $id);
        $builder->update(['username' => $username]);

        // Update role di auth_groups_users
        $builder = $db->table('auth_groups_users');
        $builder->where('user_id', $id);
        $exists = $builder->get()->getRow();

        if ($exists) {
            $builder->where('user_id', $id);
            $builder->update(['group_id' => $role_id]);
        } else {
            $builder->insert(['user_id' => $id, 'group_id' => $role_id]);
        }


        $currentUser = user();
        if ($currentUser && $currentUser->id == $id) {
            $auth = service('authentication');
            $auth->logout();
            $auth->login($currentUser); // Untuk refresh role
        }

        cache()->clean();

        return redirect()->to('/user')->with('success', 'Data user berhasil diperbarui');
    }
    public function create()
    {
        $users = new UserModel();

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'email'          => $this->request->getPost('email'),
            'username'       => $this->request->getPost('username'),
            'password'       => $this->request->getPost('password'),
            'active'         => 1,
            'activate_hash'  => null,
        ];

        $user = new \Myth\Auth\Entities\User($data);

        $users = $users->withGroup('user');

        if (! $users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        return redirect()->to('/user')->with('success', 'User baru berhasil dibuat.');
    }


    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to('/user')->with('error', 'User ID tidak ditemukan.');
        }

        $userModel = new \Myth\Auth\Models\UserModel();


        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        // agar tidak bisa hapus user sendiri
        if (user() && user()->id == $id) {
            return redirect()->to('/user')->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }


        if (! $userModel->delete($id)) {
            return redirect()->to('/user')->with('error', 'Gagal menghapus user.');
        }

        return redirect()->to('/user')->with('success', 'User berhasil dihapus.');
    }
}
