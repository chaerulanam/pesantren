<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersProfilModel extends Model
{
    protected $table = 'users_profil';
    protected $primaryKey = 'id';
    protected $returnType = UsersProfilModel::class;
    protected $allowedFields = ['user_id', 'profil_id'];

    public function hasprofilusers($profil_id, $user_id)
    {
        if ($this
            ->where('profil_id', $profil_id)
            ->where('user_id', $user_id)->findAll()
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function adduserstoprofil(int $userId, $profilId)
    {
        $data = [
            'user_id'  => (int) $userId,
            'profil_id' => (int) $profilId
        ];

        return (bool) $this->db->table('users_profil')->insert($data);
    }
}