<?php

namespace App\Http\Controllers\ApproveWFAWFO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ApproveWFAWFOController extends Controller
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
                // $parameter2 = [$request->get('nik'), $request->session()->get('Nik')];
            $parameter2 = [$request->session()->get('Nik')
                            , $request->get('nik')
                            , $request->get('tanggalmulai')
                            , $request->get('tanggalselesai')
                            , $request->get('department')];
            $data = collect(DB::select('EXEC sp_t_wfawfo_selectallapprovewfawfo ?, ?, ?, ?, ?', $parameter2));
            $datas = $data->sortBy('full_name')->groupBy('full_name');
            $periode = DB::table('m_periode')->latest()->first();
            $user = DB::table('m_user')->get();

            $dates = $data->whereBetween('tanggal', [$periode->tgl_awal, $periode->tgl_akhir])->sortBy('tanggal')->groupBy('tanggal');
            $total = [''];
            foreach($dates as $date){
                $total[] = $date->where('kerja', 'Work From Office')->count();
            }
            if($data == null){
                $wfh = $data->where('kerja', 'Work From Home')->count()/$data->count()*100;
                $wfo = $data->where('kerja', 'Work From Office')->count()/$data->count()*100;
                $luar = $data->where('kerja', 'Dinas Luar')->count()/$data->count()*100;
            }
            else{
                $wfh = 0;
                $wfo = 0;
                $luar = 0;
            }
            $max = DB::table('m_kerja')->where('kdkerja','WFO')->first();
                /* return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning editwfawfo">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-success approvewfawfo">Approve</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger rejectwfawfo">Reject</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true); */

            $parameter3 = [$request->session()->get('Nik')];

            $dept_head = DB::select('EXEC sp_cek_dept_head_atau_direktur ?', $parameter3);

            if($dept_head[0]->result == "True"){
                $departemen_user_login = DB::table('m_department')
                                                ->select('department')
                                                ->where('department', '<>', 'Empty')
                                                ->where('dept_head', '=', $request->session()->get('Nik'));
            }else{
                $departemen_user_login = DB::table('m_department')
                                                ->select('department')
                                                ->where('department', '<>', 'Empty')
                                                ->where('direktur', '=', $request->session()->get('Nik'));
            }

            $nama = DB::table('m_user')
                            ->select('nik', 'full_name')
                            ->orderBy('full_name', 'asc')
                            ->whereIn('department', $departemen_user_login)
                            ->pluck('full_name','nik');

            $lokkerja = DB::table('m_kerja')
                                ->orderBy('kerja', 'asc')
                                ->pluck("kerja","kdkerja");

            $makansiang = DB::table('m_makanan')
                                ->orderBy('makanan', 'asc')
                                ->pluck("makanan","kdmakanan");

            $departemen = DB::table('m_department')
                                ->select('department')
                                ->orderBy('department', 'asc')
                                ->where('department', '<>', 'Empty')
                                ->whereIn('department', $departemen_user_login)
                                ->pluck('department','department');

            return view('approvewfawfo.approve', compact('nama', 'lokkerja', 'makansiang', 'departemen',
            'data', 'dates', 'datas', 'user', 'max'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function filter(Request $request, Dispatcher $events)
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

            $parameter2 = [$request->session()->get('Nik')
                            , $request->get('nik')
                            , $request->get('tanggalmulai')
                            , $request->get('tanggalselesai')
                            , $request->get('department')];
            $data = collect(DB::select('EXEC sp_t_wfawfo_selectallapprovewfawfo ?, ?, ?, ?, ?', $parameter2));

            $periode = DB::table('m_periode')->latest()->first();

            if (!$request->departemen) {
                $filter = $data->whereBetween('tanggal', [$request->tanggalmulai, $request->tanggalselesai])->groupBy('full_name');
                $dates = $data->whereBetween('tanggal', [$request->tanggalmulai, $request->tanggalselesai])->sortBy('tanggal')->groupBy('tanggal');
            } elseif(!$request->tanggalmulai) {
                $filter = $data->where('department', $request->departemen)->groupBy('full_name');
                $dates = $data->whereBetween('tanggal', [$periode->tgl_awal, $periode->tgl_akhir])->groupBy('tanggal');
            } else {
                $filter = $data->whereBetween('tanggal', [$request->tanggalmulai, $request->tanggalselesai])->where('department', $request->departemen)->groupBy('full_name');
                $dates = $data->whereBetween('tanggal', [$request->tanggalmulai, $request->tanggalselesai])->sortBy('tanggal')->groupBy('tanggal');
            }

            $nama = DB::table('m_user')
                                ->select('nik', 'full_name')
                                ->orderBy('full_name', 'asc')
                                ->select('full_name','nik')
                                ->get();
            $user = DB::table('m_user')->get();
            $departemen = DB::table('m_department')
                                    ->select('department')
                                    ->orderBy('department', 'asc')
                                    ->where('department', '<>', 'Empty')
                                    ->pluck('department','department');

            $lokkerja = DB::table('m_kerja')
                                    ->orderBy('kerja', 'asc')
                                    ->pluck("kerja","kdkerja");

            $makansiang = DB::table('m_makanan')
                                    ->orderBy('makanan', 'asc')
                                    ->pluck("makanan","kdmakanan");

            if($data == null){
                $wfh = $data->where('kerja', 'Work From Home')->count()/$data->count()*100;
                $wfo = $data->where('kerja', 'Work From Office')->count()/$data->count()*100;
                $luar = $data->where('kerja', 'Dinas Luar')->count()/$data->count()*100;
            }
            else{
                $wfh = 0;
                $wfo = 0;
                $luar = 0;
            }
            $max = DB::table('m_kerja')->where('kdkerja','WFO')->first();

            return view('approvewfawfo.filter', compact('nama', 'lokkerja', 'makansiang', 'departemen', 'data', 'dates', 'filter', 'user','wfh', 'wfo', 'luar', 'max'));
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

        }else{
            $parameter = [$id
                            , $request->session()->get('Nik')
                            , $request->kdkerja
                            , $request->kdmakanan
                            , $request->keterangan
                            , $request->alert];

            DB::insert('EXEC sp_t_wfawfo_d_approve_update ?, ?, ?, ?, ?, ?', $parameter);

            return response()->json(['result' => 'true', 'message'=>'Edit WFA WFO Successfully']);
        }
    }

    public function edit($id)
    {
        $parameter = [$id];

        $transaksiwfawfo = DB::select('EXEC sp_t_wfawfo_approve_selectone ?', $parameter);

        return response()->json($transaksiwfawfo[0]);
    }

    public function maksimumupdatewfawfo(Request $request){
        if ($request->ajax()) {
            $parameter = [ $request->subdepartment
                        , $request->tanggal
                        , $request->kdkerja
                        , $request->nik];

            $kdkerja = DB::select('EXEC sp_maksimum_update_wfawfo_select ?, ?, ?, ?', $parameter);

            return response()->json($kdkerja);
        }
    }

    public function approve(Request $request)
    {
        $id = $request->id;

        $parameter = [$id
                    , $request->session()->get('Nik')];

        DB::insert('EXEC sp_t_wfawfo_d_approve ?, ?', $parameter);

        Alert('Jadwal Berhasil di Approve');
        return response()->json(['url'=>url('/approvewfawfo')]);

    }

    public function approveall(Request $request)
    {
        $parameter = [$request->session()->get('Nik')];

        DB::insert('EXEC sp_t_wfawfo_d_approve_all ?', $parameter);

        Alert('Jadwal Berhasil di Approve');
        return response()->json(['url'=>url('/approvewfawfo')]);

    }

    public function percentage(Request $request)
    {
        if ($request->ajax()) {
            $parameter = [$request->session()->get('Nik')
                          , $request->nik
                          , $request->tanggalmulai
                          , $request->tanggalselesai
                          , $request->department];
            $percentage = DB::select('EXEC sp_t_wfawfo_selectpercentageapprovewfawfo ?, ?, ?, ?, ?', $parameter);

            return response()->json($percentage[0]);
        }
    }

    public function reject(Request $request)
    {
        $id = $request->id;

        $parameter = [$id
                    , $request->session()->get('Nik')
                    , $request->keterangan];

        DB::insert('EXEC sp_t_wfawfo_d_reject ?, ?, ?', $parameter);

        return response()->json(['result' => 'true', 'message'=>'Reject WFA WFO Successfully']);

    }
}
