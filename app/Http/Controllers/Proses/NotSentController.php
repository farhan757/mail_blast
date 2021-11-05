<?php

namespace App\Http\Controllers\Proses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class NotSentController extends Controller
{
    //
    public function index()
    {
        # code...
        $auth = Auth::user();
        $data = DB::table('notsent_data');
        $data = $data->join('master_data','master_data.id','=','notsent_data.master_id');
        $data = $data->leftJoin('users','users.id','=','master_data.user_id');
        $data = $data->select('notsent_data.*');
        if($auth->customer_id > 0){
            $data = $data->where('users.customer_id','=',$auth->customer_id); 
        }       
        $data = $data->get();
        $view = view('Proses.NotSent.listnoapproval');
        $view->with('data',$data);
        return $view;
    }

    public function detail($id)
    {
        # code...
        $data = DB::table('notsent_data')
                ->select('notsent_data.*',DB::raw('users.name as username'))
                ->join('users','users.id','=','notsent_data.user_id')
                ->where('notsent_data.id','=',$id)->first();
        return response()->json([
            'status' => 1,
            'data' => $data
        ]);        
    }
}
