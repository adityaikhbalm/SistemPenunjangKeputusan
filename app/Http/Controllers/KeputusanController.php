<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class KeputusanController extends Controller
{
    public function index()
    {
      $data = DB::table('hasil as a')
      ->select('b.kd_kywn','nm_kywn','nilai_akhir')
      ->join('karyawan as b', 'b.kd_kywn', '=', 'a.kd_kywn')
      ->where(DB::raw('YEAR(thn_periode)'), date('Y'))
      ->groupBy('nm_kywn')
      ->orderBy('nilai_akhir', 'DESC')
      ->get();

      $jumlah = $this->tahun();
      for($i=0; $i<count($jumlah); $i++) {
          $tahun[] = $jumlah[$i]->tahun;
      }
      if (!isset($tahun)) $tahun = null;

      return view('Admin.Transaksi.Keputusan.list_keputusan', [
          'data' => $data,
          'tahun' => $tahun
      ]);
    }

    public function index2(Request $request)
    {
      $data = DB::table('hasil as a')
      ->select('b.kd_kywn','nm_kywn','nilai_akhir')
      ->join('karyawan as b', 'b.kd_kywn', '=', 'a.kd_kywn')
      ->where(DB::raw('YEAR(thn_periode)'), $request['tahun'])
      ->groupBy('nm_kywn')
      ->orderBy('nilai_akhir', 'DESC')
      ->get();

      $jumlah = $this->tahun();
      for($i=0; $i<count($jumlah); $i++) {
          $tahun[] = $jumlah[$i]->tahun;
      }

      return view('Admin.Transaksi.Keputusan.list_keputusan', [
          'data' => $data,
          'tahun' => $tahun,
          'index2' => 1
      ])->with('thn_periode',$request['tahun']);
    }

    public function no_surat() {
        $kode = $this->GenerateKode();
        DB::table('sk')->insert(['no_sk' => $kode, 'tgl_sk' => date('Y-m-d')]);
    }

    public function cetak($request) {
        $kode  = DB::table('sk')->select('no_sk')->latest('no_sk')->first();
        $test = explode('&', $request);
        $id = explode('=', $test[0]);
        $tahun = explode('=', $test[1]);

        $data = DB::table('hasil as a')
        ->select('a.kd_kywn','nm_kywn','jabatan','nilai_akhir','thn_periode')
        ->join('karyawan as b', 'b.kd_kywn', '=', 'a.kd_kywn')
        ->where('a.kd_kywn', $id[1])
        ->whereYear('thn_periode',$tahun[1])
        ->orderBy('nilai_akhir', 'DESC')
        ->first();

        $parts = explode('-', $data->thn_periode);

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
                SURAT KEPUTUSAN KARYAWAN TERBAIK<br/>
                No: SKK.'.$kode->no_sk.'/PT-GMJ/'.date('m/Y').'
            </h3>
            <p>Berdasarkan hasil dari perhitungan kinerja karyawan, dengan mempertimbangkan keputusan dari direktur. Maka hasil keputusan karyawan terbaik dengan data sebagai berikut:</p>
            <br/>
            <div><p style="display:inline;margin-right:4px">Kode Karyawan</p><p style="display:inline"> : </p><p style="display:inline">'.$data->kd_kywn.'</p></div>
            <div><p style="display:inline;">Nama Karyawan</p><p style="display:inline"> : </p><p style="display:inline">'.$data->nm_kywn.'</p></p>
            <div><p style="display:inline;margin-right:60px">Jabatan</p><p style="display:inline"> : </p><p style="display:inline">'.$data->jabatan.'</p></p>
            <div><p style="display:inline;margin-right:6px">Nilai Karyawan</p><p style="display:inline"> : </p><p style="display:inline">'.$data->nilai_akhir.'</p></p>
            <br/>
            <p><span>Pada Periode '.$parts[0].' telah terpilih sebagai karyawan terbaik PT. Giri Mukti Jaya.</p>
            <br/>
            <div style="text-align:right;">
                <div>Jakarta, '.date('d-m-Y').'</div>
                <div style="padding-right:25px">Mengetahui</div>
                <div style="margin-top:90px; padding-right:37px">Direktur</div>
            </div>
        </div>';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream('surat_keputusan.pdf',array('Attachment'=>0));
    }

    public function tahun() {
        $jumlah = DB::table('nilai')->select(DB::raw('YEAR(thn_periode) as tahun'))->distinct()->orderBy('tahun')->get();
        return $jumlah;
    }

    private function GenerateKode()
    {
        $query = DB::table('sk')
            ->select(DB::raw('ifnull(max(convert(right(no_sk, 3), signed integer)), 0) as kode, ifnull(length(max(convert(right(no_sk, 3)+1, signed integer))), 0) as panjang'))
            ->first();

        if ($query) {
            $next_number = $query->kode + 1;
            if ($query->kode != 0) { // jika nomor sudah pernah ada
                if ($query->panjang == 1) {
                    $urutan = '00' . $next_number;
                } else {
                    $urutan = '0' . $next_number;
                }
            } else {
                $urutan = '001';
            }
        }

        return $urutan;
    }
}
