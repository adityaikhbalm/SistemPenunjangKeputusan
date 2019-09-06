@extends('layout')


@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Hasil Perhitungan Periode : <?php if(isset($thn_periode) ) echo $thn_periode; ?></h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" style="padding-left:0; padding-right:0">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <h3>Nilai Alternatif</h3>
                                    <thead>
                                        <tr>
                                            <th>Kode Karyawan</th>
                                            <th>Nama Karyawan</th>
                                            @foreach ($kriteria as $item)
                                                <th>{{ $item->kd_krt }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                          $nama = 0;
                                        @endphp
                                        @for ($i=0; $i<count($hasil); $i++)
                                            <tr>
                                                <td>{{$data[$nama]->kd_kywn}}</td>
                                                <td>{{$data[$nama]->nm_kywn}}</td>
                                                @for ($j=0; $j<count($alternatif[0]); $j++)
                                                    <td>{{$alternatif2[$i][$j]}}</td>
                                                @endfor
                                            </tr>
                                            @php
                                              $nama+=count($alternatif[0]);
                                            @endphp
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12" style="padding-left:0; padding-right:0">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <h3>Normalisasi</h3>
                                    <thead>
                                        <tr>
                                            <th>Kode Karyawan</th>
                                            <th>Nama Karyawan</th>
                                            @foreach ($kriteria as $item)
                                                <th>{{ $item->kd_krt }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                          $no = 0;
                                        @endphp
                                        @for ($i=0; $i<count($hasil); $i++)
                                            <tr>
                                                <td>{{$data[$no]->kd_kywn}}</td>
                                                <td>{{$data[$no]->nm_kywn}}</td>
                                                @for ($j=0; $j<count($alternatif[0]); $j++)
                                                    <td>{{$alternatif[$i][$j]}}</td>
                                                @endfor
                                            </tr>
                                            @php
                                              $no+=count($alternatif[0]);
                                            @endphp
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6" style="padding-left:0">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <h3>Hasil Nilai</h3>
                                    <thead>
                                        <tr>
                                            <th>Kode Karyawan</th>
                                            <th>Nama Karyawan</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                          $no = 0;
                                        @endphp
                                        @for ($i=0; $i<count($hasil); $i++)
                                            <tr>
                                                <td>{{$data[$no]->kd_kywn}}</td>
                                                <td>{{$data[$no]->nm_kywn}}</td>
                                                <td>{{$hasil[$i]}}</td>
                                            </tr>
                                            @php
                                              $no+=count($alternatif[0]);
                                            @endphp
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6" style="padding-right:0">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <h3>Perankingan</h3>
                                    <thead>
                                        <tr>
                                            <th>Ranking</th>
                                            <th>Nama Karyawan</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i=0; $i<count($ranking); $i++)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>{{$ranking[$i]->nm_kywn}}</td>
                                                <td>{{$ranking[$i]->nilai_akhir}}</td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
