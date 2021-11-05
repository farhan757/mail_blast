<?php

namespace App\Http\Controllers\StartEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class ListUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $auth = Auth::user();
        $data = DB::table('master_data');
        $data = $data->select('project.pro_name','customer.cust_name','master_data.*',DB::raw('count(*) as jml'));
        $data = $data->join('project','master_data.project_id','=','project.id');
        $data = $data->join('customer','master_data.customer_id','=','customer.id');
        $data = $data->leftJoin('detail_data','master_data.id','=','detail_data.master_id');
        $data = $data->leftJoin('users','users.id','=','master_data.user_id');

                if($auth->customer_id > 0){
                    $data = $data->where('users.customer_id','=',$auth->customer_id); 
                }
                               
                $data = $data->orderBy('master_data.id','desc');
                $data = $data->groupBy('master_data.id');
                $data = $data->get();
                        
        return view('StartEmail.listupload.listupload')->with('data',$data);
    }

    public function detail($id){
        $data = DB::table('master_data')
                ->select('project.pro_name','customer.cust_name',DB::raw('users.name as username'),'master_data.*')
                ->join('project','master_data.project_id','=','project.id')
                ->join('customer','master_data.customer_id','=','customer.id')
                ->join('users','master_data.user_id','=','users.id')
                ->where('master_data.id',$id)
                ->first();
        $count = DB::table('detail_data')->where('master_id',$id)->count();               
        $detail = DB::table('detail_data')->where('master_id',$id)->get();

        return response()->json([
            'data' => $data,
            'detail' => $detail,
            'count' => $count
        ]);
    }

    public function delete($id){
        $msg ="";
        DB::beginTransaction();
        try
        {
            DB::table('master_data')->where('id',$id)->delete();            
            DB::table('detail_data')->where('master_id',$id)->delete(); 
            DB::commit();
            return response()->json([
                    'status' => 1,
                    'message' => 'delete success'
                ]);             
        }catch(Exception $e){
            DB::rollBack();
            $msg = $e;
        }     
        return response()->json([
            'status' => 2,
            'message' => $e
        ]);            
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
