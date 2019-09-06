@extends('layout')


@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">
                    Laporan Penilaian Karyawan Periode : <?php if (isset($tahun)) echo $tahun[0].' s/d '.$tahun[count($tahun)-1]; ?>
                </h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" style="padding-left:0; padding-right:0">
                                @for ($i=0; $i<count($data); $i++)
                                    <h3>Tahun Periode : {{ $tahun[$i] }}</h3>
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kode Karyawan</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>Total Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $rank = 1; @endphp
                                            @foreach ($data[$i]['hasil'] as $key => $item)
                                                <tr>
                                                    <td>{{$key}}</td>
                                                    <td>{{$item['nama']}}</td>
                                                    <td>{{$item['jabatan']}}</td>
                                                    <td>{{$item['nilai']}}</td>
                                                </tr>
                                                @php $rank++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br/>
                                @endfor
                                @if (count($tahun) != count($data))
                                <h3>Periode :
                                    @php
                                        $no = 0;
                                        $len = count($tahun_kosong);
                                    @endphp
                                    @for ($i=0; $i<count($tahun_kosong); $i++)
                                        {{ $tahun_kosong[$i] }}
                                        @if ($i != $len - 1), @endif
                                    @endfor
                                belum ada nilai perhitungan</h3>
                                @endif
                            </div>
                        </div>
                        <br />
                        <a href="/laporan/penilaian/cetak" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
