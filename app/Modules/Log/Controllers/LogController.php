<?php


namespace App\Modules\Log\Controllers;


use App\Core\Glosary\MetaKey;
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
                $user = DB::table('users')->where('id',$value->user_id)->first();

                if ($user) {
                    if ($value->event == 'deleted') {
                        $item = json_decode($value->old_values);
                        $type = PostType::display($item->post_type);
                        $messages[] = $user->name . ' has ' . $value->event . ' ' . $item->post_title.' '. $type;
                    }elseif ($value->event == 'created'){
                        $item = json_decode($value->new_values);
                        $type = PostType::display($item->post_type);
                        $messages[] = $user->name . ' has ' . $value->event . ' ' . $item->post_title.' '. $type;
                    }else{
                        $item = json_decode($value->old_values);
                        $type = PostType::display($item->post_type);
                        $messages[] = $user->name . ' has ' . $value->event . ' ' . $item->post_title.' '. $type;
                    }
                }
            }
        }

        return view('Log::index',compact('audits','messages'));
    }
}
