<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard(){
        $auth = Auth::user();
        $sent = DB::table('sending_data');
        $sent = $sent->join('master_data','master_data.id','=','sending_data.master_id');
        $sent = $sent->leftJoin('users','users.id','=','master_data.user_id');
        if($auth->customer_id > 0){
            $sent = $sent->where('users.customer_id','=',$auth->customer_id);
        }          
        $sent = $sent->where('sent',1)->count();

        $fail = DB::table('sending_data');
        $fail = $fail->join('master_data','master_data.id','=','sending_data.master_id');
        $fail = $fail->leftJoin('users','users.id','=','master_data.user_id');
        if($auth->customer_id > 0){
            $fail = $fail->where('users.customer_id','=',$auth->customer_id);
        }          
        $fail = $fail->where('sent',2)->count();

        $mail = DB::table('detail_data');
        $mail = $mail->join('master_data','master_data.id','=','detail_data.master_id');
        $mail = $mail->leftJoin('users','users.id','=','master_data.user_id');
        if($auth->customer_id > 0){ 
            $mail = $mail->where('users.customer_id','=',$auth->customer_id);   
        }                             
        $mail = $mail->count();

        return response()->json([
            'sent' => $sent,
            'fail' => $fail,
            'mail' => $mail
        ]);
    }
}


