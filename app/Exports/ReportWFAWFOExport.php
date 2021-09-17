<?php

namespace App\Exports;

use App\Models\Master\MasterKerja;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class ReportWFAWFOExport implements WithHeadings, FromArray
{
    use Exportable;

    public function __construct($departemen, $tanggalmulai, $tanggalselesai)
    {
        $this->departemen = $departemen;
        $this->tanggalmulai = $tanggalmulai;
        $this->tanggalselesai = $tanggalselesai;
    }

    public function array(): array
    {
        $parameter = [$this->departemen, $this->tanggalmulai, $this->tanggalselesai];
        $data = DB::select('EXEC sp_t_wfawfo_selectallreportwfawfo_excel ?, ?, ?', $parameter);

        $dataarray = [];
        
        foreach ($data as $datasatuan){
            $dataarray[] = [$datasatuan->tanggal,
                            $datasatuan->nik,
                            $datasatuan->full_name,
                            $datasatuan->department,
                            $datasatuan->kerja,
                            $datasatuan->makanan];
        }

        return [$dataarray];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nik',
            'Nama',
            'Departemen',
            'Jadwal Kerja',
            'Makan Siang',
        ];
    }
}
