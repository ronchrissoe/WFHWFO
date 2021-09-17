<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;
use DB;

class ProfileController extends Controller
{
    public function index(Request $request, Dispatcher $events)
    {
        if ($request->session()->has('UserID')) 
        {
            $parameter = [$request->session()->get('Nik')];

            $role = DB::select('EXEC sp_m_role_selectone ?', $parameter);

            if(!empty($role)){
                Menu::getmenu($events, $role[0]->role);
            }else{
                Menu::getmenu($events, "none");
            }

            return view('profile.profile');
        }
        else
        {
            return redirect('/');
        }
        
    }
}
