<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;
use Illuminate\Contracts\Events\Dispatcher;
use App\Helper\Menu;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
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

            $dates = $data->whereBetween('tanggal', [$periode->tgl_awal, $periode->tgl_akhir])->sortBy('tanggal')->groupBy('tanggal');

            $wfh = $data->where('kerja', 'Work From Home')->count()/$data->count()*100;
            $wfo = $data->where('kerja', 'Work From Office')->count()/$data->count()*100;
            $luar = $data->where('kerja', 'Dinas Luar')->count()/$data->count()*100;
            $max = DB::table('m_kerja')->where('kdkerja','WFO')->first();
            return view('dashboard.test', compact(
                'nama',
                'departemen',
                'data',
                'dates',
                'datas',
                'user',
                'wfh', 'wfo', 'luar', 'max'
            ));
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

            $wfh = $data->where('kerja', 'Work From Home')->count()/$data->count()*100;
            $wfo = $data->where('kerja', 'Work From Office')->count()/$data->count()*100;
            $luar = $data->where('kerja', 'Dinas Luar')->count()/$data->count()*100;

            return view('dashboard.filter', compact('nama', 'departemen', 'data', 'dates', 'filter', 'wfh', 'wfo', 'luar', 'user'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function percentage(Request $request)
    {
        if ($request->ajax()) {
            $parameter = [$request->nik, $request->department, $request->tanggalmulai, $request->tanggalselesai];
            $percentage = DB::select('EXEC sp_t_wfawfo_selectpercentage ?, ?, ?, ?', $parameter);

            return response()->json($percentage[0]);
        }
    }

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

            // $parameter = ['03', '2021'];

            // $data = DB::select('EXEC sp_t_wfawfo_selectalldashboard ?, ?', $parameter);

            // $data = DB::select('EXEC sp_t_wfawfo_selectalldashboard');

            // $data_list = [];

            // foreach ($data as $datasatuan) {
            //     if( $datasatuan->kdkerja == "WFO"){
            //         $data_list[] = \Calendar::event(
            //             $datasatuan->nama,
            //             true,
            //             new \DateTime($datasatuan->tanggal),
            //             new \DateTime($datasatuan->tanggal),
            //             $datasatuan->id
            //         );
            //     }elseif( $datasatuan->kdkerja == "WFA"){
            //         $data_list[] = \Calendar::event(
            //             $datasatuan->nama,
            //             true,
            //             new \DateTime($datasatuan->tanggal),
            //             new \DateTime($datasatuan->tanggal),
            //             $datasatuan->id,
            //             [
            //                 'color' => '#4CAF50',
            //             ]
            //         );
            //     }else{
            //         $data_list[] = \Calendar::event(
            //             $datasatuan->nama,
            //             true,
            //             new \DateTime($datasatuan->tanggal),
            //             new \DateTime($datasatuan->tanggal),
            //             $datasatuan->id,
            //             [
            //                 'color' => '#ff851b',
            //             ]
            //         );
            //     }
            // }

            // $calendar = new Calendar();
            //         $calendar->addEvents($data_list)
            //         ->setOptions([
            //             'locale' => 'esLocale',
            //             'firstDay' => 0,
            //             'displayEventTime' => false,
            //             'selectable' => false,
            //             'initialView' => 'dayGridMonth',
            //             'headerToolbar' => [
            //                 'end' => 'today prev,next dayGridMonth dayGridWeek dayGridDay'
            //             ]
            //             // 'initialDate' => '2021-03-01'
            //         ]);

            // $nama = DB::table('m_user')->pluck('user_id','user_id');

            // $departemen = DB::table('m_user')->distinct('department')->pluck('department','department');

            // return view('dashboard.dashboard', compact('calendar', 'nama', 'departemen'));

            if ($request->ajax()) {
                $parameter2 = [$request->get('nik'), $request->get('department'), $request->get('tanggalmulai'), $request->get('tanggalselesai')];
                $data = DB::select('EXEC sp_t_wfawfo_selectalldashboard ?, ?, ?, ?', $parameter2);
                return Datatables::of($data)
                    ->make(true);
            }

            $nama = DB::table('m_user')
                                ->select('nik', 'full_name')
                                ->orderBy('full_name', 'asc')
                                ->select('full_name','nik')
                                ->get();

            $departemen = DB::table('m_department')
                                    ->select('department')
                                    ->orderBy('department', 'asc')
                                    ->where('department', '<>', 'Empty')
                                    ->pluck('department','department');

            return view('dashboard.dashboard', compact('nama', 'departemen'));
        }
        else
        {
            return redirect('/');
        }
    }
}
