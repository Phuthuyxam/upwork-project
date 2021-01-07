<?php


namespace App\Modules\User\Repositories;


use App\Core\Glosary\PaginationConfigs;
use App\Core\Glosary\RoleConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends EloquentRepository
{


    public function getModel()
    {
        return User::class;
    }

    public function getAll()
    {
        return $this->_model->where('role', '<>', RoleConfigs::SUPPERADMIN['VALUE'])->paginate(PaginationConfigs::DEFAULT['VALUE']);
    }

    public function delete($id, $trash = true)
    {
        DB::beginTransaction();
        try {
            // update user
            $this->_model->find($id)->userMeta()->delete();
            $deleteUser = parent::delete($id, $trash);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
}
