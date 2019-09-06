<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use DB;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Master.Kriteria.list_kriteria', [
            'kriteria' => Kriteria::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Master.Kriteria.entry_kriteria');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:40',
            'bobot' => 'required|numeric|max:10',
        ]);

        $data['kd_krt'] = $this->GenerateKode();
        $data['nm_krt'] = $request['nama'];
        $data['bobot'] = $request['bobot'];
        $kriteria = Kriteria::create($data);
        $kriteria->save();
        return redirect('/master/kriteria')->with('message', 'kriteria berhasil ditambah!');
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
        return view('Admin.Master.Kriteria.edit_kriteria', ['data' => DB::table('kriteria')->where('kd_krt', $id)->first()]);
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
        $request->validate([
            'nama' => 'required|max:40',
            'bobot' => 'required|numeric|max:10'
        ]);

        DB::table('kriteria')->where('kd_krt',$id)->update(array(
            'nm_krt' => $request->nama,
            'bobot' => $request->bobot,
        ));
        return redirect('/master/kriteria')->with('message', 'Kriteria berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $s = DB::table('kriteria')->where('kd_krt', $id)->first();
        if ($s != null)
            DB::table('kriteria')->where('kd_krt', $id)->delete();

        return redirect()->back()->with('message', 'Karyawan berhasil dihapus!');
    }

    private function GenerateKode()
    {
        $query = DB::table('kriteria')
            ->select(DB::raw('ifnull(max(convert(right(kd_krt, 3), signed integer)), 0) as kode, ifnull(length(max(convert(right(kd_krt, 3)+1, signed integer))), 0) as panjang'))
            ->first();

        if ($query) {
            $next_number = $query->kode + 1;
            if ($query->kode != 0) { // jika nomor sudah pernah ada
                if ($query->panjang == 1) {
                    $urutan = 'KR00' . $next_number;
                } else if ($query->panjang == 2) {
                    $urutan = 'KR0' . $next_number;
                } else {
                    $urutan = 'KR' . $next_number;
                }
            } else {
                $urutan = 'KR001';
            }
        }

        return $urutan;
    }
}
