<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class FieldController extends Controller
{
    //
    public function index()
    {
        # code...
        $auth = Auth::user();
        $data = DB::table('master_variable');
        $data = $data->select('master_variable.*');
        $data = $data->leftJoin('users','users.id','=','master_variable.user_id');
        if($auth->customer_id >0){
            $data = $data->where('users.customer_id','=',$auth->customer_id);
        }
        
        $data = $data->orderBy('id','DESC')->get();
        $view = view('Settings.VariableField.index');        
        $view->with('data',$data);
        return $view;
    }

    public function form(Request $request)
    {
        # code...
        $field = DB::getSchemaBuilder()->getColumnListing('mail_detail_data');
        $view = view('Settings.VariableField.form');
        if($request->input('code')){
            $detail = DB::table('variable_detail')->where('master_vid',$request->input('code'))->get();
            $view->with('detail',$detail);
            $view->with('code',$request->input('code'));
            $view->with('name',$request->input('name'));
        }
        $view->with('field',$field);
        return $view;
    }

    public function save(Request $request)
    {
        # code...      
        DB::beginTransaction();
        try{

            if(DB::table('master_variable')->where([
				['id','=',$request->code]
			])->exists() == false){
                DB::table('master_variable')->insert([
                    'id' => $request->code,
                    'name' => $request->name_mstr,
                    'user_id' => Auth::id(),
                    'created_at' => Carbon::now()
                ]);
            }
            DB::table('variable_detail')->insert([
                'master_vid' => $request->code,
                'nm_variable' => $request->variable,
                'nm_field' => $request->field
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return response()->json([
            'status'=>1,
            'message'=>'Succes'
        ]); 
             
    }

    public function cancel(Request $request)
    {
        # code...
        DB::beginTransaction();
        try{
            DB::table('master_variable')->where('id','=',$request->code)->delete();
            DB::table('variable_detail')->where('master_vid','=',$request->code)->delete();

            DB::commit();
            return response()->json([
                'status'=>1,
                'message'=>'Succes'
            ]);            
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>2,
                'message'=>'Error'
            ]);            
        }        
    }

    public function deleteItem(Request $request)
    {
        # code...
        DB::beginTransaction();
        try{
            
            DB::table('variable_detail')->where('id','=',$request->code)->delete();

            DB::commit();
            return response()->json([
                'status'=>1,
                'message'=>'Succes'
            ]);            
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>2,
                'message'=>'Error'
            ]);            
        }         
    }   
}
