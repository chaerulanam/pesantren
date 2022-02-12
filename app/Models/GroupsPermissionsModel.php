<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsPermissionsModel extends Model
{
    protected $table = 'auth_groups_permissions';
    protected $primaryKey = 'id';
    protected $returnType = GroupsPermissionsModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['group_id', 'permission_id'];

    public function hasgrouppermisiion($group_id, $permission_id)
    {
        if ($this
            ->where('group_id', $group_id)
            ->where('permission_id', $permission_id)->findAll()
        ) {
            return true;
        } else {
            return false;
        }
    }
}