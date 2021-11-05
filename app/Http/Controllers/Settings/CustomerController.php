<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    //

    public function index()
    {
        # code...
        $data = DB::table('customer')
                ->orderBy('customer.id','DESC')->get();
        
        $view = view('Settings.Customer.index');
        $view->with('data',$data);
        return $view;
    }

    public function form()
    {
        # code...
        $view = view('Settings.Customer.form');

        return $view;
    }

    public function formEdit($id)
    {
        # code...
        $edit = DB::table('customer')->where('id',$id)->first();

        $view = view('Settings.Customer.form');
        $view->with('edit',$edit);

        return $view;
    }

    public function update(Request $request)
    {
        # code...
        DB::table('customer')->where('id',$request->id)->update([
            'cust_name' => $request->customer,
            'cust_alamat' => $request->alamat,
            'cust_telp' => $request->telp,                        
            'updated_at' => Carbon::now()
        ]);
        
        return redirect()->route('settings.customer');
    }

    public function save(Request $request)
    {
        # code...
        DB::table('customer')->insert([
            'cust_name' => $request->customer,
            'cust_alamat' => $request->alamat,
            'cust_telp' => $request->telp,            
            'created_at' => Carbon::now()
        ]);
        
        return redirect()->route('settings.customer');        
    }

    public function delete($id)
    {
        # code...
        DB::table('customer')->where('id',$id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Delete success'
        ]);        
    }
}
