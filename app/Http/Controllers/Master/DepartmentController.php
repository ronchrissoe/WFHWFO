<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Helper\Menu;
use Illuminate\Contracts\Events\Dispatcher;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    public function dept(Department $dept, Request $request, Dispatcher $events)
    {
        if ($request->session()->has('UserID')) {
            $parameter = [$request->session()->get('Nik')];
            $role = DB::select('EXEC sp_m_role_selectone ?', $parameter);
            $dept = $dept::join('m_user', 'm_user.nik', 'm_department.dept_head')
                ->join('m_user as direk', 'direk.nik', 'm_department.direktur')
                ->select('direk.full_name as direk', 'm_user.full_name as head', 'm_department.department', 'm_department.dept_head', 'm_department.direktur','m_department.id')
                ->get();
            $user = DB::table('m_user')->get();
            if(!empty($role)){
                Menu::getmenu($events, $role[0]->role);
            }else{
                Menu::getmenu($events, "none");
            }
            return view('master.masterdepartment', compact('dept', 'user'));
        }
        else{
            return back();
        }

    }
    public function update(Department $dept, Request $req, $code)
    {
        $code = Crypt::decrypt($code);
        $dept = $dept->where('id', $code)->update([
            'department' => $req->dept,
            'dept_head' => $req->head,
            'direktur' => $req->direktur
        ]);
        Alert::success('Berhasil', 'Data Department Berhasil Diubah');
        return back();
    }
}
