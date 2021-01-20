<?php

namespace App\Modules\Permission\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Permissions extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "permissions";

}
