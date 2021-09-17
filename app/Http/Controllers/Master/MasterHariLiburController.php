<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Validator;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;

class MasterHariLiburController extends Controller
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

            if ($request->ajax()) {
                $data = DB::select('EXEC sp_m_hari_libur_selectall');

                return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editmasterharilibur">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger deletemasterharilibur">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('master.masterharilibur');
        }
        else
        {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $id = $request->id;

        if($id == '0'){
            $field = ['tanggal' => 'required|unique:m_hari_libur'];

            $messages = ['tanggal.required' => 'Tanggal harus diisi.', 
                        'tanggal.unique' => 'Tanggal sudah ada.'];
        }else{
            $field = ['tanggal' => 'required|unique:m_hari_libur'];

            $messages = ['tanggal.required' => 'Tanggal harus diisi.', 
                        'tanggal.unique' => 'Tanggal sudah ada.'];
        }
        

        $validator = Validator::make($request->all(), $field, $messages);

        if ($validator->passes()) {
            $parameter = [$request->id, $request->tanggal, $request->session()->get('Nik')];

            DB::insert('EXEC sp_m_hari_libur_insertupdate ?, ?, ?', $parameter);        

            return response()->json(['result' => 'true', 'message'=>'Add Or Edit Hari Libur Successfully']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit($id)
    {
        $parameter = [$id];

        $MasterHariLibur = DB::select('EXEC sp_m_hari_libur_selectone ?', $parameter);

        return response()->json($MasterHariLibur[0]);
    }

    public function destroy($id)
    {
        $parameter = [$id];

        DB::delete('EXEC sp_m_hari_libur_delete ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Delete Hari Libur Successfully']);
    }
}
