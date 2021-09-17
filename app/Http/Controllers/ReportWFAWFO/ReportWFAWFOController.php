<?php

namespace App\Http\Controllers\ReportWFAWFO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel;
use App\Exports\ReportWFAWFOExport;
use Illuminate\Support\Facades\Route;

class ReportWFAWFOController extends Controller
{
    public function test(Request $request, Dispatcher $events)
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

            $parameter2 = [$request->get('nik'), $request->get('department'), $request->get('tanggalmulai'), $request->get('tanggalselesai')];
            $data = collect(DB::select('EXEC sp_t_wfawfo_selectalldashboard ?, ?, ?, ?', $parameter2));
            $datas = $data->sortBy('full_name')->groupBy('full_name');
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

            $periode = DB::table('m_periode')->latest()->first();
            $wfh = $data->where('kerja', 'Work From Home')->count()/$data->count()*100;
            $wfo = $data->where('kerja', 'Work From Office')->count()/$data->count()*100;
            $luar = $data->where('kerja', 'Dinas Luar')->count()/$data->count()*100;
            $max = DB::table('m_kerja')->where('kdkerja','WFO')->first();

            $dates = $data->whereBetween('tanggal', [$periode->tgl_awal, $periode->tgl_akhir])->sortBy('tanggal')->groupBy('tanggal');

            return view('reportwfawfo.new', compact('nama', 'departemen', 'data', 'dates', 'datas', 'user','wfh', 'wfo', 'luar', 'max'));
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

            $parameter2 = [$request->get('nik'), $request->get('department'), $request->get('tanggalmulai'), $request->get('tanggalselesai')];
            $data = collect(DB::select('EXEC sp_t_wfawfo_selectalldashboard ?, ?, ?, ?', $parameter2));
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

            return view('reportwfawfo.filter', compact('nama', 'departemen', 'data', 'dates', 'filter', 'user','wfh', 'wfo', 'luar', 'max'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function percentage(Request $request)
    {
        if ($request->ajax()) {
            $parameter = [$request->department, $request->tanggalmulai, $request->tanggalselesai];
            $percentage = DB::select('EXEC sp_t_wfawfo_selectpercentagereportwfawfo ?, ?, ?', $parameter);

            return response()->json($percentage[0]);
        }
    }

    public function exportexcel($departemen = null, $tanggalmulai = null, $tanggalselesai = null)
    {
        if ($departemen == 'null'){
            $departemen = null;
        }

        $result = DB::select('EXEC sp_periode_select');
        $nama_excel = "Report_WFH-WFO" . $result[0]->Result . ".xlsx";
        return (new ReportWFAWFOExport($departemen, $tanggalmulai, $tanggalselesai))->download($nama_excel);
    }

    /* public function index(Request $request, Dispatcher $events)
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

                $parameter2 = [$request->get('department'), $request->get('tanggalmulai'), $request->get('tanggalselesai')];
                $data = DB::select('EXEC sp_t_wfawfo_selectallreportwfawfo ?, ?, ?', $parameter2);

                return Datatables::of($data)
                    ->make(true);
            }

            $departemen = DB::table('m_department')
                                    ->select('department')
                                    ->orderBy('department', 'asc')
                                    ->where('department', '<>', 'Empty')
                                    ->pluck('department','department');

            return view('reportwfawfo.reportwfawfo', compact('departemen'));
        }
        else
        {
            return redirect('/');
        }
    } */

}
