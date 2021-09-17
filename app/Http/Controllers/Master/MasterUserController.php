<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MasterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, Dispatcher $events, Department $dept)
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
            $dept = $dept->get();
            if ($request->ajax()) {
                //$data = MasterKerja::latest()->get();

                $data = DB::select('EXEC sp_m_user_selectall');

                return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editmasteruser">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger deletemasteruser">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('master.masteruser', compact('dept'));
        }
        else
        {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;

        if($id == '0'){
            $field = ['user_id' => 'required|unique:m_user'
                , 'password' => 'required'
                , 'nik' => 'required|unique:m_user'
                , 'full_name' => 'required'
                , 'department' => 'required'
                , 'subdepartment' => 'required'
                , 'title' => 'required'
                , 'mail' => 'required'
                , 'company' => 'required'
                , 'manager_name' => 'required'];

            $messages = ['user_id.required' => 'Username harus diisi.',
                        'password.required' => 'Password harus diisi.',
                        'nik.required' => 'Nik harus diisi.',
                        'full_name.required' => 'Nama Lengkap harus diisi.',
                        'department.required' => 'Departemen harus diisi.',
                        'subdepartment.required' => 'Sub Departemen harus diisi.',
                        'title.required' => 'Jabatan harus diisi.',
                        'mail.required' => 'Email harus diisi.',
                        'company.required' => 'Perusahaan harus diisi.',
                        'manager_name.required' => 'Atasan Langsung harus diisi.',
                        'user_id.unique' => 'Username sudah ada.',
                        'nik.unique' => 'Nik sudah ada.'];
        }else{
            $field = ['password' => 'required'
                , 'full_name' => 'required'
                , 'department' => 'required'
                , 'subdepartment' => 'required'
                , 'title' => 'required'
                , 'mail' => 'required'
                , 'company' => 'required'
                , 'manager_name' => 'required'];

            $messages = ['password.required' => 'Password harus diisi.',
                        'full_name.required' => 'Nama Lengkap harus diisi.',
                        'department.required' => 'Departemen harus diisi.',
                        'subdepartment.required' => 'Sub Departemen harus diisi.',
                        'title.required' => 'Jabatan harus diisi.',
                        'mail.required' => 'Email harus diisi.',
                        'company.required' => 'Perusahaan harus diisi.',
                        'manager_name.required' => 'Atasan Langsung harus diisi.'];
        }

        $validator = Validator::make($request->all(), $field, $messages);

        if ($validator->passes()) {

            $parameter = [$request->id
                        , $request->user_id
                        , $request->password
                        , $request->nik
                        , $request->full_name
                        , $request->department
                        , $request->subdepartment
                        , $request->title
                        , $request->mail
                        , $request->company
                        , $request->manager_name
                        , $request->session()->get('Nik')];

            DB::insert('EXEC sp_m_user_insertupdate ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $parameter);

            return response()->json(['result' => 'true', 'message'=>'Add Or Edit User Successfully']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameter = [$id];

        $MasterUser = DB::select('EXEC sp_m_user_selectone_edit ?', $parameter);

        return response()->json($MasterUser[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameter = [$id];

        DB::delete('EXEC sp_m_user_delete ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Delete User Successfully']);
    }

    public function generate_nik(Request $request){
        if ($request->ajax()) {
            $nik = DB::select('EXEC sp_generate_nik_select');

            return response()->json($nik);
        }
    }
}
