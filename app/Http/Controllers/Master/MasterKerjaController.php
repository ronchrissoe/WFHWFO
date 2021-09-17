<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterKerja;
use DataTables;
use DB;
use Validator;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;

class MasterKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                //$data = MasterKerja::latest()->get();

                $data = DB::select('EXEC sp_m_kerja_selectall');

                return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editmasterkerja">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger deletemasterkerja">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('master.masterkerja');
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
            $field = ['kdkerja' => 'required|unique:m_kerja'
                    , 'kerja' => 'required'
                    , 'maksimum' => 'required'];

            $messages = ['kdkerja.required' => 'Kode Jadwal Kerja harus diisi.', 
                        'kerja.required' => 'Jadwal Kerja harus diisi.', 
                        'maksimum.required' => 'Maksimum harus diisi.', 
                        'kdkerja.unique' => 'Kode Jadwal Kerja sudah ada.'];
        }else{
            $field = ['kerja' => 'required'
                    , 'maksimum' => 'required'];

            $messages = ['kerja.required' => 'Lokasi Kerja harus diisi.', 
                        'maksimum.required' => 'Maksimum harus diisi.'];
        }
        

        $validator = Validator::make($request->all(), $field, $messages);

        if ($validator->passes()) {

            // MasterKerja::updateOrCreate(['id' => $request->id],
            //     ['kerja' => $request->kerja, 'maksimum' => $request->maksimum]);

            $parameter = [$request->id, $request->kdkerja, $request->kerja, $request->maksimum, $request->session()->get('Nik')];

            DB::insert('EXEC sp_m_kerja_insertupdate ?, ?, ?, ?, ?', $parameter);        

            return response()->json(['result' => 'true', 'message'=>'Add Or Edit Jadwal Kerja Successfully']);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$MasterKerja = MasterKerja::find($id);

        $parameter = [$id];

        $MasterKerja = DB::select('EXEC sp_m_kerja_selectone ?', $parameter);

        return response()->json($MasterKerja[0]);
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
        //MasterKerja::find($id)->delete();

        $parameter = [$id];

        DB::delete('EXEC sp_m_kerja_delete ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Delete Jadwal Kerja Successfully']);
    }
}
