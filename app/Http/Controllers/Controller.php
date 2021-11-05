<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $dir_FileUpload = "/var/www/mail_blast/storage/app/uploaded/incomingFiles";
    
    function getInfoCust($id=0){

        $query = DB::table('customer');
        
            $query = $query->where('id',$id);
               
        return $query->first(); 
    }

    function getCustomer($id=0){

        $auth = Auth::user();
        $query = DB::table('customer');
        if($auth->customer_id > 0 ){
            $id = $auth->customer_id;
            $query->where('id',$id);            
        }else{
            if($id > 0){
                $id = $auth->customer_id;
                $query->where('id',$id);
            }
        }
        return $query->get();        
    }

    function getProject($id=0){
        $query = DB::table('project');
        if($id > 0){
            $query->where('customer_id',$id);
        }

        return response()->json($query->get());        
    }

    function getMasterData(){
        $data = DB::table('master_data')
                ->select('project.pro_name','customer.cust_name','master_data.*',DB::raw('count(*) as jml'))
                ->join('project','master_data.project_id','=','project.id')
                ->join('customer','master_data.customer_id','=','customer.id')
                ->leftJoin('detail_data','master_data.id','=','detail_data.master_id')
                ->groupBy('master_data.id')
                ->get();

        return response()->json($data);
    }

    function readText($file_name, $delimited='|') {
        $error = array();
        $error['error']="Error :";
        $return = array();
        $file = fopen($file_name, 'r');
        $cntf=0;
        while (!feof($file)) {
            $err = 0;
            $cntf++;
            $text = fgets($file);
            if($cntf>1 && $text!="") {
                $index = $cntf-1;
                $texts = explode($delimited, $text);
                $tmpret = array();
                $tmpret['account'] = $texts[0];
                $tmpret['name'] = $texts[1];
                $tmpret['to'] = $texts[2];
                $tmpret['cc'] = $texts[3];
                $tmpret['bcc'] = $texts[4];
                $tmpret['attachment'] = $texts[5];
                $tmpret['password_attach'] = $texts[6];

                if($err==1) {
                    array_push($error, $text);
                } else {
                    array_push($return, $tmpret);
                }
            }
        }
        fclose($file);

        if(count($error)>2) {
            return $error;
        } else
        return $return;
    }   
    
    function insertToMasterData($data) {
        //DB::beginTransaction();
        try{
            return DB::table('master_data')            
            ->insertGetId([
                'customer_id'=>$data['customer_id'],
                'project_id'=>$data['project_id'],
                'cycle'=>$data['cycle'],
                'file_name'=>$data['file_name'],
                'path'=>$data['path'],
                'part'=>$data['part'],
                'user_id'=>$data['user_id'],
                'created_at'=>Carbon::now()
            ]);
            //DB::commit();
        }catch(Exception $e){
            //DB::rollBack();
            return $e;
        }
    }  
    
    function insertToDetail($data, $id_prod) {
        DB::beginTransaction();
        try{
            $tmp_id = DB::table('detail_data')
            ->insertGetId([
                'master_id'=>$id_prod,
                'account'=>$data['account'],
                'name'=>$data['name'],
                'to'=>$data['to'],
                'cc'=>$data['cc'],
                'bcc'=>$data['bcc'],
                'attachment'=>$data['attachment'],
                'password_attach'=>$data['password_attach'],
                'created_at'=>Carbon::now()
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack(); 
            $tmp_id = $e;           
        }
        return $tmp_id;
    }    

    function getCodeVerify($id){
        DB::beginTransaction();
        try{
            $code = Str::random(32);
            DB::table('tmp_verify_read')->insert([
                'code_verify' => $code,
                'sending_id' => $id,
                'created_at' => Carbon::now()
            ]);
            DB::commit();
            return $code;
        }catch(Exception $e){
            DB::rollBack();
            $this->getCodeVerify($id);
        }
    }

    public function getCounter($code) {
    	$tmp = DB::table('table_counter')
    	->where('keys','=',$code)
    	->select('counter')
    	->first();
    	if($tmp) {
	    	$counter = $tmp->counter+1;
	    	DB::table('table_counter')
	    	->where('keys','=',$code)
	    	->update([
	    		'counter'=>$counter
	    	]);
    	} else {
    		$counter=1;
    		DB::table('table_counter')
    		->insert([
    			'keys'=>$code,
    			'counter'=>$counter
    		]);
    	}

    	return $counter;
    }

    function gencode(){
        $counter = str_pad($this->getCounter('gen_code') ,5,'0',STR_PAD_LEFT);

        return 'SET-'.$counter;        
    }    
    
    function buildCodeVerifymail($id,$contentmail)
    {
        # code...
        $code = $this->getCodeVerify($id);
        $read_flag = str_replace('#READ FLAG#',$code,$contentmail);
        return $read_flag;
    }

    function buildMail($data,$contentmail){

        $tmp = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

            #BODYMAIL#';

        $array = json_decode(json_encode($data), true);
        $settingan = DB::table('variable_detail')->where('master_vid',$contentmail->mv_id)->get();

        $subject = $contentmail->subject;

        foreach($settingan as $value){
            $subject = str_replace($value->nm_variable,$array[$value->nm_field],$subject);
        }

        $bodymail = $contentmail->body_mail;
        foreach($settingan as $value){
            $bodymail = str_replace($value->nm_variable,$array[$value->nm_field],$bodymail);
        }

        $bodymail = str_replace("#BODYMAIL#",$bodymail,$tmp);

        $arr = array(
            'subject' => $subject,
            'bodymail' => $bodymail
            );

        return $arr;
    }

    function getset(Request $request)
    {
        # code...
        $data = DB::table('variable_detail')->where('master_vid',$request->input('id'))->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
