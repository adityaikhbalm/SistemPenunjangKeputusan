<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class LaporanController extends Controller
{
    public function index_kinerja(){
        $jumlah = $this->tahun();
        for($i=0; $i<count($jumlah); $i++) {
            $tahun[] = $jumlah[$i]->tahun;
        }
        if (!isset($tahun)) $tahun = null;

        return view('Admin.Laporan.Kinerja.laporan_kinerja', [
            'tahun' => $tahun
        ]);
    }

    public function index_penilaian(){
        $jumlah = $this->tahun();
        for($i=0; $i<count($jumlah); $i++) {
            $tahun[] = $jumlah[$i]->tahun;
        }
        if (!isset($tahun)) $tahun = null;

        return view('Admin.Laporan.Penilaian.laporan_penilaian', [
            'tahun' => $tahun
        ]);
    }

    function tahun() {
        $jumlah = DB::table('nilai')->select(DB::raw('YEAR(thn_periode) as tahun'))->distinct()->orderBy('tahun')->get();
        return $jumlah;
    }

    public function LaporanKinerja(Request $request){
        $tahun = $request->input('tahun');
        if (!DB::table('hasil')->select(DB::raw('YEAR(thn_periode) as tahun'))->whereYear('thn_periode',$tahun)->first()) return redirect()->back()->with('message','Periode : '.$tahun.' belum ada nilai perhitungan');

        $ret = array();

        $nilai = DB::table('nilai')
                ->join('karyawan', 'nilai.kd_kywn', '=', 'karyawan.kd_kywn')
                ->where(DB::raw('YEAR(thn_periode)'), $tahun)
                ->get();

        $hasil = DB::table('hasil')
                ->join('karyawan', 'hasil.kd_kywn', '=', 'karyawan.kd_kywn')
                ->where(DB::raw('YEAR(thn_periode)'), $tahun)
                ->orderBy('hasil.nilai_akhir', 'DESC')
                ->get();

        foreach($nilai as $val){
            $ret['nilai'][$val->kd_kywn][$val->kd_krt] = $val->nilai_kywn;
            $ret['nilai'][$val->kd_kywn]['nama'] = $val->nm_kywn;
        }

        foreach($hasil as $val){
            $ret['hasil'][$val->kd_kywn]['nilai'] = $val->nilai_akhir;
            $ret['hasil'][$val->kd_kywn]['nama'] = $val->nm_kywn;
            $ret['hasil'][$val->kd_kywn]['jabatan'] = $val->jabatan;
        }

        $ret['tahun'] = $tahun;
        Session::put('data', $ret);

        $kriteria = DB::table('kriteria')->count();

        return view('Admin.Laporan.Kinerja.hasil_laporan_kinerja', [
            'data' => $ret,
            'tahun' => $tahun
        ]);
    }

    public function LaporanPenilaian(Request $request){
        $this->validate($request, [
            'tahun' => 'required',
            'tahun2' => 'required|greater_than_field:tahun',
        ],
        [
                'tahun2.greater_than_field' => 'Tahun Akhir Harus sama atau Lebih dari Tahun Awal'
        ]);

        $tahun = array();
        for($nYear = $request['tahun']; $nYear <= $request['tahun2']; $nYear++) {
            $tahun[] = $nYear;
        }

        $ret = array();

        for($i=0; $i<count($tahun); $i++) {
            $hasil[] = DB::table('hasil')
                ->join('karyawan', 'hasil.kd_kywn', '=', 'karyawan.kd_kywn')
                ->whereYear('thn_periode', $tahun[$i])
                ->orderBy('hasil.nilai_akhir', 'DESC')
                ->limit(5)
                ->get();
            if($hasil[$i]->isEmpty()) $tahun_kosong[] = $tahun[$i];
        }

        $j=0;
        for($i=0; $i<count($tahun); $i++) {
            if ($hasil[$i]->count()) {
                $tahun[$j] = $tahun[$i];
                foreach($hasil[$i] as $val){
                    $ret[$j]['hasil'][$val->kd_kywn]['nilai'] = $val->nilai_akhir;
                    $ret[$j]['hasil'][$val->kd_kywn]['nama'] = $val->nm_kywn;
                    $ret[$j]['hasil'][$val->kd_kywn]['jabatan'] = $val->jabatan;
                }
                $j++;
            }
        }

        Session::put('data', $ret);
        Session::put('tahun', $tahun);

        if(empty($tahun_kosong)) $tahun_kosong = '';

        return view('Admin.Laporan.Penilaian.hasil_laporan_penilaian', [
            'data' => $ret,
            'tahun' => $tahun,
            'tahun_kosong' => $tahun_kosong
        ]);
    }

    public function cetak_kinerja(){
        $data = Session::get('data');

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_html_kinerja($data));
        return $pdf->stream('laporan_kinerja_karyawan_'.$data['tahun'].'.pdf',array('Attachment'=>0));
    }

    public function cetak_penilaian(){
        $data = Session::get('data');
        $tahun = Session::get('tahun');

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_html_penilaian($data,$tahun));
        return $pdf->stream('laporan_penilaian_karyawan_'.$tahun[0].'.pdf',array('Attachment'=>0));
    }

    public function convert_html_kinerja($data){
        // return dd($data)
        $html = '
        <table style="width: 100%; margin: 0px auto; border:none; text-align:center">
            <tr>
                <th>
                    <img src="assets/images/logo_pt.png" width="300px">
                </th>
            </tr>
            <tr>
                <td><p>Jl. Rawa Bugel No.4 RT.006 RW.002 Kelurahan Marga Mulya<br/>Kecamatan Bekasi Utara-Kota Bekasi</p></td>
            </tr>
        </table>
        <hr width="90%"/>
        <div style="margin-left:6%;margin-right:5%">
            <h3 style="text-align:center">
                LAPORAN KINERJA KARYAWAN<br/>
                PERIODE '.$data['tahun'].'
            </h3>
        </div>
        <table cellspacing="0" border="1px" style="text-align:center;" align="center">
            <thead>
                <tr>
                    <th>Kode Karyawan</th>
                    <th>Nama Karyawan</th>';
                    foreach ($data['nilai'] as $item){
                        foreach ($item as $key => $item2){
                            if($key != 'nama')
                                $html .= '<th>'.$key.'</th>';
                        }
                        break;
                    }
                $html .=
                '</tr>
            </thead>
            <tbody>';
                foreach ($data['nilai'] as $key => $item){
                    $html .= '<tr>
                        <td>'.$key.'</td>
                        <td>'.$item['nama'].'</td>';
                        foreach ($item as $key2 => $item2){
                            if($key2 != 'nama'){
                                $html .= '<td>'.$item2.'</td>';
                            }
                        }
                    $html .= '</tr>';
                }
                $html .= '
            </tbody>
        </table>
        <br />
        <center>
        <h2>Ranking Karyawan</h2>
        <table cellspacing="0" border="1px" style="text-align:center;" align="center">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Kode Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>';
                $rank = 1;
                foreach ($data['hasil'] as $key => $item){
                $html .= '<tr>
                        <td>'.$rank.'</td>
                        <td>'.$key.'</td>
                        <td>'.$item['nama'].'</td>
                        <td>'.$item['jabatan'].'</td>
                        <td>'.$item['nilai'].'</td>
                    </tr>';
                    $rank++;
                }
                $html .='
            </tbody>
        </table>
        </center>
    ';

        return $html;
    }

    public function convert_html_penilaian($data,$tahun){
        // return dd($data)
        $html = '
        <style>
        .page-break { page-break-after: always; }
        </style>
        <table style="width: 100%; margin: 0px auto; border:none; text-align:center">
            <tr>
                <th>
                    <img src="assets/images/logo_pt.png" width="300px">
                </th>
            </tr>
            <tr>
                <td><p>Jl. Rawa Bugel No.4 RT.006 RW.002 Kelurahan Marga Mulya<br/>Kecamatan Bekasi Utara-Kota Bekasi</p></td>
            </tr>
        </table>
        <hr width="90%"/>
        <div style="margin-left:6%;margin-right:5%">
            <h3 style="text-align:center">
                LAPORAN PENILAIAN KARYAWAN<br/>
                PERIODE '.$tahun[0].'-'.$tahun[count($tahun)-1].'
            </h3>
        </div>
        ';
        $no = 1;
        for($i=0; $i<count($data); $i++) {
            $html .= '
            <center>
            <h3>Tahun Periode : '.$tahun[$i].'</h3>
            <table cellspacing="0" border="1px" style="text-align:center;" align="center">
                <thead>
                    <tr>
                        <th>Kode Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody>';
                    $rank = 1;
                    foreach ($data[$i]['hasil'] as $key => $item){
                    $html .= '<tr>
                            <td>'.$key.'</td>
                            <td>'.$item['nama'].'</td>
                            <td>'.$item['jabatan'].'</td>
                            <td>'.$item['nilai'].'</td>
                        </tr>';
                        $rank++;
                    }
                    $html .='
                </tbody>
            </table><br/>
            </center>';
            if( $no == 3 ) {
                ;$html .='<div class="page-break"></div>';
                $no=1;
            }
            else {
                $no++;
            }
        }
        ;'
    ';
        return $html;
    }
}
