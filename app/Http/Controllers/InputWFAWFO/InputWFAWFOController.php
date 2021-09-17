<?php

namespace App\Http\Controllers\InputWFAWFO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;
use RealRashid\SweetAlert\Facades\Alert;

class InputWFAWFOController extends Controller
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
                // $parameter2 = [$request->session()->get('Nik'), $request->get('tanggalmulai'), $request->get('tanggalselesai')];
                // $data = DB::select('EXEC sp_t_wfawfo_selectall ?, ?, ?', $parameter2);

                $parameter2 = [$request->session()->get('Nik')];
                $data = collect(DB::select('EXEC sp_t_wfawfo_selectall ?', $parameter2));
                $datas = $data->sortBy('tanggal');
                
                return Datatables::of($datas)
                    ->addColumn('action', function($row){
                            if ($row->status == "OPEN" || $row->status == "REJECTED") {
                                $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editwfawfo">Edit</a>';
                                return $actionBtn;
                            }
                        })
                    ->addColumn('badge', function($row){
                            if ($row->status == "OPEN") {
                                $Btn = '<button type="button" class="btn btn-primary">OPEN</button>';
                            }
                            elseif ($row->status == "REJECTED") {
                                $Btn = '<button type="button" class="btn btn-danger">REJECTED</button>';
                            }
                            else{
                                $Btn = '<button type="button" class="btn btn-success">APPROVED</button>';
                            }
                            return $Btn;
                        })
                    ->rawColumns(['action', 'badge'])
                    ->make(true);
            }



            $lokkerja = DB::table('m_kerja')
                                ->orderBy('kerja', 'asc')
                                ->pluck("kerja","kdkerja");

            $makansiang = DB::table('m_makanan')
                                ->orderBy('makanan', 'asc')
                                ->pluck("makanan","kdmakanan");

            return view('inputwfawfo.inputwfawfo', compact('lokkerja', 'makansiang'));
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
        // $kdkerja = $request->kdkerja;

        // if($kdkerja == 'WFO'){
        //     $field = ['tanggal' => 'required', 'kdkerja' => 'required', 'kdmakanan' => 'required'];

        //     $messages = ['tanggal.required' => 'Tanggal harus dipilih.',
        //                 'kdkerja.required' => 'Lokasi Kerja harus dipilih.',
        //                 'kdmakanan.required' => 'Makan Siang harus dipilih.'];
        // }else {
        //     $field = ['tanggal' => 'required', 'kdkerja' => 'required'];

        //     $messages = ['tanggal.required' => 'Tanggal harus dipilih.',
        //                 'kdkerja.required' => 'Lokasi Kerja harus dipilih.'];
        // }

        // $validator = Validator::make($request->all(), $field, $messages);

        // if ($validator->passes()) {
        //     $parameter = [$request->id
        //             , $request->tanggal
        //             , $request->session()->get('Nik')
        //             , $request->kdkerja
        //             , $request->kdmakanan];

        //     DB::insert('EXEC sp_t_wfawfo_insertupdate ?, ?, ?, ?, ?', $parameter);

        //     return response()->json(['result' => 'true', 'message'=>'Add Or Edit WFA WFO Successfully']);
        // }

        // return response()->json(['error' => $validator->errors()->all()]);

        $id = $request->id;

        if($id == '0'){
            $no_tran = DB::select('EXEC sp_no_tran_select');

            $parameter = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')];

            DB::insert('EXEC sp_t_wfawfo_h_insert ?, ?', $parameter);

            $keterangan = $request->keterangan;

            if($keterangan != 'Hari Libur'){
                $parameter2 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal
                            , $request->kdkerja
                            , $request->kdmakanan
                            , $keterangan
                            , $request->alert];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter2);
            }

            $keterangan2 = $request->keterangan2;

            if($keterangan2 != 'Hari Libur'){
                $parameter3 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal2
                            , $request->kdkerja2
                            , $request->kdmakanan2
                            , $keterangan2
                            , $request->alert2];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter3);
            }

            $keterangan3 = $request->keterangan3;

            if($keterangan3 != 'Hari Libur'){
                $parameter4 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal3
                            , $request->kdkerja3
                            , $request->kdmakanan3
                            , $keterangan3
                            , $request->alert3];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter4);
            }

            $keterangan4 = $request->keterangan4;

            if($keterangan4 != 'Hari Libur'){
                $parameter5 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal4
                            , $request->kdkerja4
                            , $request->kdmakanan4
                            , $keterangan4
                            , $request->alert4];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter5);
            }

            $keterangan5 = $request->keterangan5;

            if($keterangan5 != 'Hari Libur'){
                $parameter6 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal5
                            , $request->kdkerja5
                            , $request->kdmakanan5
                            , $keterangan5
                            , $request->alert5];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter6);
            }

            $keterangan6 = $request->keterangan6;

            if($keterangan6 != 'Hari Libur'){
                $parameter7 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal6
                            , $request->kdkerja6
                            , $request->kdmakanan6
                            , $keterangan6
                            , $request->alert6];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter7);
            }

            $keterangan7 = $request->keterangan7;

            if($keterangan7 != 'Hari Libur'){
                $parameter8 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal7
                            , $request->kdkerja7
                            , $request->kdmakanan7
                            , $keterangan7
                            , $request->alert7];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter8);
            }

            $keterangan8 = $request->keterangan8;

            if($keterangan8 != 'Hari Libur'){
                $parameter9 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal8
                            , $request->kdkerja8
                            , $request->kdmakanan8
                            , $keterangan8
                            , $request->alert8];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter9);
            }

            $keterangan9 = $request->keterangan9;

            if($keterangan9 != 'Hari Libur'){
                $parameter10 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal9
                            , $request->kdkerja9
                            , $request->kdmakanan9
                            , $keterangan9
                            , $request->alert9];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter10);
            }

            $keterangan10 = $request->keterangan10;

            if($keterangan10 != 'Hari Libur'){
                $parameter11 = [$no_tran[0]->no_tran
                            , $request->session()->get('Nik')
                            , $request->tanggal10
                            , $request->kdkerja10
                            , $request->kdmakanan10
                            , $keterangan10
                            , $request->alert10];

                DB::insert('EXEC sp_t_wfawfo_d_insert ?, ?, ?, ?, ?, ?, ?', $parameter11);
            }

            $parameter12 = [$no_tran[0]->no_tran];

            DB::insert('EXEC sp_send_email_wfawfo ?', $parameter12);

            Alert::success('Jadwal Behasil Ditambahkan');
            return back();
        }else{
            $parameter13 = [$request->idupdate
                            , $request->session()->get('Nik')
                            , $request->kdkerjaupdate
                            , $request->kdmakananupdate
                            , $request->keterangan
                            , $request->alert];

            DB::insert('EXEC sp_t_wfawfo_d_update ?, ?, ?, ?, ?, ?', $parameter13);

            $parameter14 = [$id];

            DB::insert('EXEC sp_send_email_wfawfo_update ?', $parameter14);

            Alert::success('Jadwal Behasil Diubah');
            return back();
        }
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

        $transaksiwfawfo = DB::select('EXEC sp_t_wfawfo_selectone ?', $parameter);

        return response()->json($transaksiwfawfo[0]);
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
    public function destroy(Request $request, $id)
    {
        $parameter = [$id, $request->session()->get('Nik')];

        DB::delete('EXEC sp_t_wfawfo_delete ?, ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Delete WFA WFO Successfully']);
    }

    public function tanggal(Request $request){
        if ($request->ajax()) {
            $tanggal = DB::select('EXEC sp_tanggal_select');

            return response()->json($tanggal);
        }
    }

    public function maksimumwfawfo(Request $request){
        if ($request->ajax()) {
            $parameter = [ $request->session()->get('SubDepartment')
                        , $request->tanggal
                        , $request->kdkerja];

            $kdkerja = DB::select('EXEC sp_maksimum_wfawfo_select ?, ?, ?', $parameter);

            return response()->json($kdkerja);
        }
    }

    public function maksimumupdatewfawfo(Request $request){
        if ($request->ajax()) {
            $parameter = [ $request->session()->get('SubDepartment')
                        , $request->tanggal
                        , $request->kdkerja
                        , $request->session()->get('Nik')];

            $kdkerja = DB::select('EXEC sp_maksimum_update_wfawfo_select ?, ?, ?, ?', $parameter);

            return response()->json($kdkerja);
        }
    }

    public function cek_department(Request $request){
        if ($request->ajax()) {
            $parameter = [$request->department];

            $result = DB::select('EXEC sp_cek_department ?', $parameter);

            return response()->json($result);
        }
    }

    public function cek_jadwal_wfhwfo(Request $request){
        if ($request->ajax()) {
            $parameter = [$request->nik];

            $result = DB::select('EXEC sp_cek_jadwal_wfhwfo ?', $parameter);

            return response()->json($result);
        }
    }
}
