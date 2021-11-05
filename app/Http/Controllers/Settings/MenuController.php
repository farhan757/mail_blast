<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;


class MenuController extends Controller
{
    //
    public function menu($id=0)
    {        
        $user_id = Auth::id();
        $menus = DB::table('menu_to_user')
                ->join('menus','menus.id','=','menu_to_user.menu_id')
                ->where('menus.active','=',1)->where('menu_to_user.user_id','=',$user_id)
                ->where('menus.parent','=',$id)
                ->orderBy('menus.order','ASC')->get();
        return $menus;
    }
}
