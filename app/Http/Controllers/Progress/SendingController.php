<?php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class SendingController extends Controller
{
    //
    public function index(){
        $auth = Auth::user();
        $data = DB::table('sending_data');
        $data = $data->join('users','users.id','=','sending_data.user_id') ;
                if($auth->customer_id > 0){
                    $data = $data->where('users.customer_id','=',$auth->customer_id);
                }               
                
                $data = $data->select('sending_data.*');
                $data = $data->orderBy('id','desc')->get();
        $view = view('Progress.Sending.listsending');
        $view->with('data',$data);
        return $view;
    }

    public function detail($id)
    {
        # code...
        $data = DB::table('sending_data')
                ->select('sending_data.*',DB::raw('users.name as username'))
                ->join('users','users.id','=','sending_data.user_id')
                ->where('sending_data.id','=',$id)->first();
        return response()->json([
            'status' => 1,
            'data' => $data
        ]);
    }

    public function resend(Request $request)
    {
        # code...
        $id = $request->id;
        $email = $request->email;
        $desc = $request->desc;

        $error = ""; $body_mail_final = "";
        # code...
        $getData = DB::table('sending_data')->where('id',$id)->first();
        
        DB::beginTransaction();
        try{
            $idSending = DB::table('sending_data')->insertGetId([
                'master_id' => $getData->master_id,
                'account' => $getData->account,
                'name' => $getData->name,
                'to' => $email,
                'cc' => $getData->cc,
                'bcc' => $getData->bcc,
                'subject_mail' => $getData->subject_mail,
                'body_mail_base' => $getData->body_mail_base,
                'attachment' => $getData->attachment,
                'password_attach' => $getData->password_attach,
                'user_id' => Auth::id(),
                'resend' => 1,
                'desc' => $desc,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            $body_mail_final = $this->buildCodeVerifymail($idSending,$getData->body_mail_base);

            DB::table('sending_data')->where('id',$idSending)->update([
                'body_mail' => $body_mail_final
            ]);

            DB::commit();
            return response()->json([
                'status' => 1,
                'message' => 'Resending Success'
            ]);
        }catch(Exception $e){
            DB::rollBack(); 
            $error = $e;          
        }
        return response()->json([
            'status' => 2,
            'message' => $error
        ]);        
    }
}
