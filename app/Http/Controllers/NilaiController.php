<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Nilai;
use DB;
use Input;

class NilaiController extends Controller
{
    public function index()
    {
        $data = DB::table('nilai')
            ->select('nilai.*')
            ->join('karyawan', 'karyawan.kd_kywn', '=', 'nilai.kd_kywn')
            ->join('kriteria', 'kriteria.kd_krt', '=', 'nilai.kd_krt')
            ->where(DB::raw('YEAR(thn_periode)'), date('Y'))
            ->get();

        $jumlah = $this->tahun();
        for($i=0; $i<count($jumlah); $i++) {
            $tahun[] = $jumlah[$i]->tahun;
        }
        if (!isset($tahun)) $tahun = null;

        return view('Admin.Transaksi.Nilai.list_nilai', [
            'nilai' => $data,
            'tahun' => $tahun
        ]);
    }

    public function index2(Request $request)
    {
        $data = DB::table('nilai')
            ->select('nilai.*')
            ->join('karyawan', 'karyawan.kd_kywn', '=', 'nilai.kd_kywn')
            ->join('kriteria', 'kriteria.kd_krt', '=', 'nilai.kd_krt')
            ->where(DB::raw('YEAR(thn_periode)'), $request['tahun'])
            ->get();

        $jumlah = $this->tahun();
        for($i=0; $i<count($jumlah); $i++) {
            $tahun[] = $jumlah[$i]->tahun;
        }

        return view('Admin.Transaksi.Nilai.list_nilai', [
            'nilai' => $data,
            'tahun' => $tahun
        ])->with('thn_periode',$request['tahun']);
    }

    public function create()
    {
        return view('Admin.Transaksi.Nilai.entry_nilai', [
            'karyawan' => Karyawan::all(),
            'kriteria' => Kriteria::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'kd_kywn' => 'required|max:5',
            'kd_krt.*' => 'required|max:5',
            'nilai.*' => 'required|numeric|max:5',
            'tahun_periode' => 'required|date_format:d-m-Y|max:10'
        ]);

        $tahun_periode = date("Y-m-d", strtotime($request['tahun_periode']));
        $tahun = date("Y", strtotime($request['tahun_periode']));
        $kode = DB::table('nilai')->where('kd_kywn', $request['kd_kywn'])->where(DB::raw('YEAR(thn_periode)'),$tahun)->first();
        if ($kode) return redirect()->back()->with('message', 'Data sudah pernah diinput!');

        for($i=0; $i<count($request['kd_krt']); $i++) {
            $data['kd_kywn'] = $request['kd_kywn'];
            $data['kd_krt'] = $request['kd_krt.'.$i];
            $data['nilai_kywn'] = $request['nilai.'.$i];
            $data['thn_periode'] = $tahun_periode;
            $kriteria = Nilai::create($data);
            $kriteria->save();
        }
        return redirect('/transaksi/nilai')->with('message', 'Nilai berhasil ditambah!');
    }

    public function tahun() {
        $jumlah = DB::table('nilai')->select(DB::raw('YEAR(thn_periode) as tahun'))->distinct()->orderBy('tahun')->get();
        return $jumlah;
    }

    public function karyawan($id) {
        $s = DB::table('karyawan')->where('kd_kywn', $id)->first();
        return response()->json(['nama' => $s->nm_kywn, 'jabatan' => $s->jabatan]);
    }
}
