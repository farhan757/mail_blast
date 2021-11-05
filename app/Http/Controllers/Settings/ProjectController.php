<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
class ProjectController extends Controller
{
    //
    public function index()
    {
        # code...
        $auth = Auth::user();
        $data = DB::table('project');
        $data = $data->join('customer','customer.id','=','project.customer_id');
            
        if($auth->customer_id > 0) {
            $data = $data->where('project.customer_id','=',$auth->customer_id); 
        }           
        $data = $data->select('customer.cust_name','project.*');                
        $data = $data->orderBy('project.id','DESC');
        $data = $data->get();
        
        $view = view('Settings.Project.index');
        $view->with('data',$data);
        return $view;
    }

    public function form()
    {
        # code...
        $auth = Auth::user();
        $customer = $this->getCustomer();
        $body = DB::table('body_email');
        $body = $body->leftJoin('users','users.id','=','body_email.user_id');
        if($auth->customer_id > 0){
            $body = $body->where('users.customer_id','=',$auth->customer_id);
        }
        $body = $body->select('body_email.*');         
        $body = $body->get();
        $view = view('Settings.Project.form');
        $view->with('customer',$customer);
        $view->with('body',$body);

        return $view;
    }

    public function formEdit($id)
    {
        # code...
        $auth = Auth::user();
        $customer = $this->getCustomer();
        $edit = DB::table('project')->where('id',$id)->first();
        $body = DB::table('body_email');
        $body = $body->leftJoin('users','users.id','=','body_email.user_id');
        if($auth->customer_id > 0){
            $body = $body->where('users.customer_id','=',$auth->customer_id);
        }
        $body = $body->select('body_email.*');
        $body = $body->get();
        $view = view('Settings.Project.form');
        $view->with('customer',$customer);
        $view->with('body',$body);
        $view->with('edit',$edit);

        return $view;
    }

    public function update(Request $request)
    {
        # code...
        DB::table('project')->where('id',$request->id)->update([
            'customer_id' => $request->customer,
            'body_mail_id' => $request->body_email,
            'pro_name' => $request->project,
            'desc' => $request->desc,
            'updated_at' => Carbon::now()
        ]);
        
        return redirect()->route('settings.project');
    }

    public function save(Request $request)
    {
        # code...
        DB::table('project')->insert([
            'customer_id' => $request->customer,
            'body_mail_id' => $request->body_email,
            'pro_name' => $request->project,
            'desc' => $request->desc,
            'created_at' => Carbon::now()
        ]);
        
        return redirect()->route('settings.project');        
    }

    public function delete($id)
    {
        # code...
        DB::table('project')->where('id',$id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Delete success'
        ]);        
    }

    public function getbodyEmail($id)
    {
        # code...
        $data = DB::table('body_email')->where('id',$id)->first();

        if(is_null($data)){
            return response()->json([
                'status' => 2                
            ]);
        }else{
            return response()->json([
                'status' => 1,
                'data' => $data
            ]);
        }
    }
}
