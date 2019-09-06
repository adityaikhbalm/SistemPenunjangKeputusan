<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;
use DB;

class PerhitunganController extends Controller
{
    public function index()
    {
        $jumlah = $this->tahun();
        for($i=0; $i<count($jumlah); $i++) {
            $tahun[] = $jumlah[$i]->tahun;
        }
        if (!isset($tahun)) $tahun = null;

        return view('Admin.Transaksi.Perhitungan.list_perhitungan', [
            'tahun' => $tahun
        ]);
    }

    public function store(Request $request)
    {
        $kriteria = $data = DB::table('kriteria')->select('bobot','kd_krt')->get();
        $total_kriteria = 0;
        foreach($kriteria as $item) {
            $total_kriteria = $total_kriteria + $item->bobot;
        }
        foreach($kriteria as $item) {
            $bobot_kriteria[] = round($item->bobot/$total_kriteria,3);
        }

        $data = DB::table('nilai as a')
        ->select('a.*','b.nm_kywn')
        ->join('karyawan as b', 'b.kd_kywn', '=', 'a.kd_kywn')
        ->join('kriteria as c', 'c.kd_krt', '=', 'a.kd_krt')
        ->where(DB::raw('YEAR(thn_periode)'), $request['tahun'])
        ->orderBy('a.kd_kywn', 'ASC')
        ->orderBy('a.kd_krt', 'ASC')
        ->get();

        $jumlah = count($data)/count($kriteria);
        $alternatif = array();
        $alternatif2 = array();

        $ulang = 0;
        $no = 0;
        foreach($data as $item) {
            $alternatif[$no][$ulang] = $item->nilai_kywn;
            $alternatif2[$no][$ulang] = $item->nilai_kywn;
            if ($ulang == count($kriteria)-1) {
                $no++;
                $ulang = 0;
            }
            else $ulang++;
        }
        $max = 0;
        for($i=0; $i<count($kriteria); $i++) {
            for($j=0; $j<$jumlah; $j++) {
                if ($alternatif[$j][$i] > $max) {
                    $max = $alternatif[$j][$i];
                    $tampung[$i] = $max;
                }
            }
            $max = 0;
        }
        for($i=0; $i<count($kriteria); $i++) {
            for($j=0; $j<$jumlah; $j++) {
                $alternatif[$j][$i] = round($alternatif[$j][$i]/$tampung[$i],2);
            }
        }

        for($i=0; $i<$jumlah; $i++) {
            $hasil[] = 0;
        }

        $no = 0;
        for($i=0; $i<count($kriteria); $i++) {
            for($j=0; $j<$jumlah; $j++) {
                $hasil[$j] = $hasil[$j] + round($alternatif[$j][$i]*$bobot_kriteria[$i],3);
            }
        }

        $no = 0;
        for($i=0; $i<count($hasil); $i++) {
            Hasil::where('kd_kywn', $data[$no]->kd_kywn)->where('thn_periode', $data[$no]->thn_periode)->delete();
            $no+=count($kriteria);
        }
        $no = 0;
        for($i=0; $i<count($hasil); $i++) {
            $format['kd_kywn'] = $data[$no]->kd_kywn;
            $format['thn_periode'] = $data[$no]->thn_periode;
            $format['nilai_akhir'] = $hasil[$i];
            $simpan = Hasil::create($format);
            $simpan->save();
            $no+=count($kriteria);
        }

        $ranking = DB::table('hasil as a')
        ->select('nm_kywn','nilai_akhir')
        ->join('karyawan as b', 'b.kd_kywn', '=', 'a.kd_kywn')
        ->whereYear('thn_periode', $request['tahun'])
        ->groupBy('nm_kywn')
        ->orderBy('nilai_akhir', 'DESC')
        ->get();

        return view('Admin.Transaksi.Perhitungan.hasil_perhitungan', [
            'data' => $data,
            'alternatif' => $alternatif,
            'alternatif2' => $alternatif2,
            'hasil' => $hasil,
            'ranking' => $ranking,
            'kriteria' => $kriteria
        ])->with('thn_periode',$request['tahun']);
    }

    public function tahun() {
        $jumlah = DB::table('nilai')->select(DB::raw('YEAR(thn_periode) as tahun'))->distinct()->orderBy('tahun')->get();
        return $jumlah;
    }
}
