<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DetailController extends Controller
{
    //
    public function index()
    {
        # code...

        $customer = $this->getCustomer();
        $view = view('Report.Detail.form');
        $view->with('customer',$customer);
        return $view;
    }    

    public function export(Request $request)
    {
        # code...
        $data = DB::table('master_data');
        $data = $data->leftJoin('sending_data','sending_data.master_id','=','master_data.id');        
        $data = $data->leftJoin('customer','customer.id','=','master_data.customer_id');
        $data = $data->leftJoin('project','project.id','=','master_data.project_id');
        $data = $data->select('customer.cust_name','project.pro_name','master_data.cycle','master_data.part','sending_data.*');

        if($request->customer > 0){
            $data = $data->where('master_data.customer_id','=',$request->customer);
        }

        $data = $data->where('sending_data.created_at','>=',$request->cyc1.' 00:00:00');
        $data = $data->where('sending_data.created_at','<=',$request->cyc2.' 23:59:59');        
        $data = $data->get();
        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Project');
        $sheet->setCellValue('D1', 'Cycle');
        $sheet->setCellValue('E1', 'Part');
        $sheet->setCellValue('F1', 'Account');
        $sheet->setCellValue('G1', 'Name');
        $sheet->setCellValue('H1', 'to');
        $sheet->setCellValue('I1', 'cc');
        $sheet->setCellValue('J1', 'bcc');
        $sheet->setCellValue('K1', 'sent');
        $sheet->setCellValue('L1', 'sent_at');
        $sheet->setCellValue('M1', 'msg_error_send');
        $sheet->setCellValue('N1', 'read');
        $sheet->setCellValue('O1', 'read_at');
        $sheet->setCellValue('P1', 'resend');
        $sheet->setCellValue('Q1', 'desc');
        $sheet->setCellValue('R1', 'created_at');
        $sheet->setCellValue('S1', 'updated_at');

        $cntr = 1;
        foreach ($data as $val) {
            # code...
            $cntr++;
            $sheet->setCellValue('A'.$cntr, $cntr-1);
            $sheet->setCellValue('B'.$cntr, $val->cust_name);
            $sheet->setCellValue('C'.$cntr, $val->pro_name);
            $sheet->setCellValue('D'.$cntr, $val->cycle);
            $sheet->setCellValue('E'.$cntr, $val->part);
            $sheet->setCellValue('F'.$cntr, $val->account);
            $sheet->setCellValue('G'.$cntr, $val->name);
            $sheet->setCellValue('H'.$cntr, $val->to); 
            $sheet->setCellValue('I'.$cntr, $val->cc); 
            $sheet->setCellValue('J'.$cntr, $val->bcc); 
            $sheet->setCellValue('K'.$cntr, $val->sent); 
            $sheet->setCellValue('L'.$cntr, $val->send_at); 
            $sheet->setCellValue('M'.$cntr, $val->msg_error_send); 
            $sheet->setCellValue('N'.$cntr, $val->read); 
            $sheet->setCellValue('O'.$cntr, $val->read_at); 
            $sheet->setCellValue('P'.$cntr, $val->resend); 
            $sheet->setCellValue('Q'.$cntr, $val->desc); 
            $sheet->setCellValue('R'.$cntr, $val->created_at);     
            $sheet->setCellValue('S'.$cntr, $val->updated_at);        
        }

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Detail.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$objWriter->save('php://output');

    }    
}
