<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ReadVerifyController extends Controller
{
    //
    public function index($code,Request $request)
    {
        
        # code...
        $img = DB::table('tmp_verify_read')->where('code_verify','=',$code)->first();
        if(!is_null($img)){
            DB::table('tmp_history_read')->insert([
                'sending_id' => $img->sending_id,
                'ip' => $request->ipinfo->ip,
                'created_at' => Carbon::now()
            ]);
            DB::table('sending_data')->where('id',$img->sending_id)
            ->increment('read',1,['read_at' => Carbon::now()]);
        }
        //$file = file_get_contents(public_path().'/img/img.png');
        //return response($file)->header('Content-type','image/png');
        return redirect('storage/photos/1/images.jpg');
    }

    public function gif()
    {
        # code...
        $file = public_path().'/img/img.png';
        return response()->download($file, 'img.png');
    }
}
