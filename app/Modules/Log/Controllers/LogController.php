<?php


namespace App\Modules\Log\Controllers;


use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;

class LogController extends Controller
{
    public function index(){
        $audits = [];
        $messages = [];
        if (count(Audit::all())) {
            $audits = DB::table('audits')->paginate(15);
            foreach ($audits as $value) {
                $messages[] = $this->getLogMessage($value);
            }
        }

        return view('Log::index',compact('audits','messages'));
    }

    private function getLogMessage($audit){
        $postType = ['App\Modules\Post\Model\Translations\Ar\PostAr','App\Modules\Post\Model\Post'];
        $message = '';
        if ($audit) {
            $user =  DB::table('users')->where('id',$audit->user_id)->first();
            $table = $audit->auditable_type;

            if ($audit->event == 'created') {
                if (in_array($table,$postType)) {
                    $record = $table::find($audit->auditable_id);
                    if ($record) {
                        if ($record->post_type == PageTemplateConfigs::POST['NAME']){
                            $message = $user->name.' has <b>'.$audit->event.'</b> <i>'. $record->post_title.'</i> hotel';
                        }else{
                            $message = $user->name.' has <b>'.$audit->event.'</b> <i>'. $record->post_title.'</i> page';
                        }
                    }
                }
            }
        }
        return $message;
    }

//    private function getMessage($event,) {
//
//    }
}
