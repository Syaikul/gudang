<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil semua user + role
        $builder = $db->table('users');
        $builder->select('users.id as userid, username, email, name');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();
        $data['users'] = $query->getResult();

        // Cek jika ada query param 'edit'
        $editUserId = $this->request->getGet('edit');
        if ($editUserId) {
            // Ambil user yang diedit
            $builder = $db->table('users');
            $builder->select('users.id, username, email');
            $builder->where('users.id', $editUserId);
            $editUser = $builder->get()->getRow();

            // Ambil role user yang sekarang
            $builder = $db->table('auth_groups_users');
            $builder->select('group_id');
            $builder->where('user_id', $editUserId);
            $group = $builder->get()->getRow();

            // Ambil semua role
            $builder = $db->table('auth_groups');
            $roles = $builder->get()->getResult();

            // Simpan role_id di editUser supaya mudah
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

        return redirect()->to('/user')->with('success', 'Data user berhasil diperbarui');
    }
}
