<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Master.Karyawan.list_karyawan', [
            'karyawan' => Karyawan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Master.Karyawan.entry_karyawan');
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
            'jabatan' => 'required|max:35',
        ]);

        $data['kd_kywn'] = $this->GenerateKode();
        $data['nm_kywn'] = $request['nama'];
        $data['jabatan'] = $request['jabatan'];
        $karyawan = Karyawan::create($data);
        $karyawan->save();
        return redirect('/master/karyawan')->with('message', 'Karyawan berhasil ditambah!');
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
        return view('Admin.Master.Karyawan.edit_karyawan', ['data' => Karyawan::find($id)]);
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
        $request->validate([
            'nama' => 'required|max:40',
            'jabatan' => 'required|max:35'
        ]);

        $karyawan = Karyawan::find($id);
        $karyawan->nm_kywn = $request->nama;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->save();
        return redirect('/master/karyawan')->with('message', 'Karyawan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $s = Karyawan::find($id);
        if ($s != null)
            $s->delete();

        return redirect()->back()->with('message', 'Karyawan berhasil dihapus!');
    }

    private function GenerateKode()
    {
        $query = DB::table('karyawan')
            ->select(DB::raw('ifnull(max(convert(right(kd_kywn, 3), signed integer)), 0) as kode, ifnull(length(max(convert(right(kd_kywn, 3)+1, signed integer))), 0) as panjang'))
            ->first();

        if ($query) {
            $next_number = $query->kode + 1;
            if ($query->kode != 0) { // jika nomor sudah pernah ada
                if ($query->panjang == 1) {
                    $urutan = 'KY00' . $next_number;
                } else if ($query->panjang == 2) {
                    $urutan = 'KY0' . $next_number;
                } else {
                    $urutan = 'KY' . $next_number;
                }
            } else {
                $urutan = 'KY001';
            }
        }

        return $urutan;
    }
}
