<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
{
    //
    public function index()
    {
        # code...
        $data = User::all();
        return view('Settings.User.index')->with('user',$data);
    }

    public function form(Type $var = null)
    {
        # code...
        $data = DB::table('customer')->get();
        return view('Settings.User.form')->with('customer',$data);
    }

    public function delete($id)
    {
        # code...
        DB::table('user')->where('id',$id)->delete();
        DB::table('menu_to_user')->where('user_id',$id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Success'
        ]);
    }
}
