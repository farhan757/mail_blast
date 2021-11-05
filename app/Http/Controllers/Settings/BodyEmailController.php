<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class BodyEmailController extends Controller
{
    //
    public function index()
    {
        # code...
        $auth = Auth::user();
        $data = DB::table('body_email');
        $data = $data->select('users.name','body_email.*');
        $data = $data->leftJoin('users','users.id','=','body_email.user_id');
        if($auth->customer_id > 0){
            $data = $data->where('users.customer_id','=',$auth->customer_id);
        }
                         
        $data = $data->get();
        
        return view('Settings.BodyEmail.index')->with('data',$data);
    }

    public function save(Request $request)
    {
        # code...
        $content = $request->konten;
        $content .= "<p><img alt='.' src='http://mailblast.xptlp.co.id/api/verify/#READ FLAG#' style='height:1px; opacity:0.0; width:1px; color:#ffffff;' /></p>";
        DB::table('body_email')->insert([
            'mv_id' => $request->setting,
            'body_mail' => $content, 
            'subject' => $request->subject,
            'user_id' => Auth::id(),
            'created_at' => Carbon::now()
        ]);

        /*return response()->json([
            'status' => 1,
            'message' => 'berhasil'
        ]);*/
        return redirect()->back();
    }

    public function showid($id)
    {
        # code...
        $auth = Auth::user();
        $data = DB::table('body_email')->where('id',$id)->first();
        $mvid = DB::table('master_variable');
        $mvid = $mvid->select('master_variable.*');
        $mvid = $mvid->leftJoin('users','users.id','=','master_variable.user_id');
        if ($auth->customer_id > 0){ 
            $mvid = $mvid->where('users.customer_id','=',$auth->customer_id); 
        }              
                
        $mvid = $mvid->get();
        return view('Settings.BodyEmail.form')->with('data',$data)->with('setting',$mvid);
    }

    public function show()
    {
        # code... 
        $auth = Auth::user(); 
        $mvid = DB::table('master_variable');  
        $mvid = $mvid->select('master_variable.*');
        $mvid = $mvid->leftJoin('users','users.id','=','master_variable.user_id');
        if ($auth->customer_id > 0){ 
            $mvid = $mvid->where('users.customer_id','=',$auth->customer_id); 
        }              
                
        $mvid = $mvid->get();    
        return view('Settings.BodyEmail.form')->with('setting',$mvid);
    }    

    public function update(Request $request)
    {
        # code...
        DB::table('body_email')->where('id',$request->id)->update([
            'mv_id' => $request->setting,
            'body_mail' => $request->konten,
            'subject' => $request->subject,
            'user_id' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);
        //$data = DB::table('body_email')->where('id',$request->id)->first();

        return redirect()->back();       
    }

    public function delete($id)
    {
        # code...
        DB::table('body_email')->where('id',$id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Delete success'
        ]);
    }


}
