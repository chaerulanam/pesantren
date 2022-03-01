<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class All extends Seeder
{
    public function run()
    {
        $this->call('Opsi');
        $this->call('Admin');
        // $this->call('Users');
        $this->call('Groups');
        $this->call('GroupsUsers');
        $this->call('Permissions');
        $this->call('GroupsPermissions');
        $this->call('MasterJadwal');
        $this->call('MasterKelas');
        $this->call('MasterPelajaran');
        $this->call('MasterTahun');
        $this->call('MasterTagihan');
        // $this->call('Profil');
        // $this->call('UsersProfil');
    }
}