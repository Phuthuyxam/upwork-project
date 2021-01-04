<?php


namespace App\Modules\Permission\Seeder;
use App\Modules\Permission\Model\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run() {
        $roles = [
            [
                'id' => 1,
                'name' => 'SupperAdmin',
                'desc' => 'is root permission',
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'desc' => ''
            ]
        ];
        try {
            foreach ($roles as $role) {
                Roles::created($role);
            }
        } catch (\Throwable $th) {

        }
    }
}
