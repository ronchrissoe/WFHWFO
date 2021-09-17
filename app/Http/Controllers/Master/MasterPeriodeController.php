<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Validator;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;

class MasterPeriodeController extends Controller
{
    public function index(Request $request, Dispatcher $events){
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
                $data = DB::select('EXEC sp_m_periode_selectall');

                return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editmasterperiode">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger deletemasterperiode">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            $status = DB::table('m_status_periode')
                                ->select('kdstatusperiode', 'statusperiode')
                                ->orderBy('statusperiode', 'asc')
                                ->pluck('statusperiode','kdstatusperiode');

            return view('master.masterperiode', compact('status'));
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
            $field = ['tgl_awal' => 'required|unique:m_periode'
                    , 'tgl_akhir' => 'required|unique:m_periode'
                    , 'kdstatusperiode' => 'required'];

            $messages = ['tgl_awal.required' => 'Tanggal Awal harus diisi.', 
                        'tgl_akhir.required' => 'Tanggal Akhir harus diisi.', 
                        'kdstatusperiode.required' => 'Status harus dipilih.', 
                        'tgl_awal.unique' => 'Tanggal Awal sudah ada.',
                        'tgl_akhir.unique' => 'Tanggal Akhir sudah ada.'];
        }else{
            $field = ['kdstatusperiode' => 'required'];

            $messages = ['kdstatusperiode.required' => 'Status harus dipilih.'];
        }
        

        $validator = Validator::make($request->all(), $field, $messages);

        if ($validator->passes()) {

            $parameter = [$request->id, $request->tgl_awal, $request->tgl_akhir, $request->kdstatusperiode, $request->session()->get('Nik')];

            DB::insert('EXEC sp_m_periode_insertupdate ?, ?, ?, ?, ?', $parameter);        

            return response()->json(['result' => 'true', 'message'=>'Add Or Edit Periode Successfully']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit($id)
    {
        //$MasterKerja = MasterKerja::find($id);

        $parameter = [$id];

        $MasterPeriode = DB::select('EXEC sp_m_periode_selectone ?', $parameter);

        return response()->json($MasterPeriode[0]);
    }

    public function destroy($id)
    {
        //MasterKerja::find($id)->delete();

        $parameter = [$id];

        DB::delete('EXEC sp_m_periode_delete ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Delete Periode Successfully']);
    }
}