<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterMakanan;
use DataTables;
use DB;
use Validator;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;

class MasterMakananController extends Controller
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
                //$data = MasterMakanan::latest()->get();

                $data = DB::select('EXEC sp_m_makanan_selectall');

                return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editmastermakanan">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger deletemastermakanan">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('master.mastermakanan');
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
            $field = ['kdmakanan' => 'required|unique:m_makanan'
                    , 'makanan' => 'required'];

            $messages = ['kdmakanan.required' => 'Kode Makan Siang harus diisi.',
                        'makanan.required' => 'Makan Siang harus diisi.', 
                        'kdmakanan.unique' => 'Kode Makan Siang sudah ada.'];
        }else{
            $field = ['makanan' => 'required'];

            $messages = ['makanan.required' => 'Makan Siang harus diisi.'];
        }
        

        $validator = Validator::make($request->all(), $field, $messages);

        if ($validator->passes()) {

            // MasterMakanan::updateOrCreate(['id' => $request->id],
            //     ['makanan' => $request->makanan]); 
              
            $parameter = [$request->id, $request->kdmakanan, $request->makanan, $request->session()->get('Nik')];

            DB::insert('EXEC sp_m_makanan_insertupdate ?, ?, ?, ?', $parameter);     

            return response()->json(['result' => 'true', 'message'=>'Add Or Edit Makan Siang Successfully']);
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
        //$MasterMakanan = MasterMakanan::find($id);

        $parameter = [$id];

        $MasterMakanan = DB::select('EXEC sp_m_makanan_selectone ?', $parameter);

        return response()->json($MasterMakanan[0]);
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
        //MasterMakanan::find($id)->delete();

        $parameter = [$id];

        DB::delete('EXEC sp_m_makanan_delete ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Delete Makan Siang Successfully']);
    }
}
