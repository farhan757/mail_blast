<?php

namespace App\Http\Controllers\StartEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Proses\ApprovalController;

class UploadController extends Controller
{
    //
    public function index(){
        $customer = $this->getCustomer();        
        $view = view('StartEmail.upload.form'); 
        $view->with('customer',$customer);
        return $view;
    }

    public function upload(Request $request){
        $customer_id = $request->customer;
        $project_id = $request->project;
        $cycle = $request->datepicker;
        $part = $request->part;
        $user = Auth::user();
        if($request->file('file')->isValid()){
            $file=$request->file('file');
    		$fileName = $file->getClientOriginalName();
    		$pathFile = $this->dir_FileUpload.DIRECTORY_SEPARATOR.$fileName;
    		$file->move($this->dir_FileUpload,$fileName);

            $dataList = array();
            $dataList = $this->readText($pathFile);

			if(array_key_exists('error', $dataList)) {
				return response()->json([
					'status'=>0,
					'message'=>$dataList
				]);									
			} 
            
			$master['customer_id']=$customer_id;
            $master['project_id']=$project_id;
            $master['cycle']=$cycle;            
            $master['file_name']=$fileName;
            $master['path']=$pathFile;
            $master['part']=$part;
            $master['user_id']=$user->id;            
            
            $id_master = $this->insertToMasterData($master);

            foreach($dataList as $value){
                $id_detail = $this->insertToDetail($value, $id_master);
                $kirim = new ApprovalController();
                $kirim->approvedLangsung($id_detail);
            }

            return response()->json([
				'status'=>1,
				'message'=>'Success Upload ..'
			]);	            
        }else{
			return response()->json([
				'status'=>0,
				'message'=>'Error File not valid'
			]);	            
        }
    }
}
