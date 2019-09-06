@extends('layout')


@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Laporan Kinerja Karyawan Periode : <?php if(isset($tahun) ) echo $tahun; ?></h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" style="padding-left:0; padding-right:0">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <h3>Laporan Kinerja Karyawan</h3>
                                    <thead>
                                        <tr>
                                            <th>Kode Karyawan</th>
                                            <th>Nama Karyawan</th>
                                            @foreach ($data['nilai'] as $item)
                                                @foreach ($item as $key => $item2)
                                                    @if($key != 'nama')
                                                        <td>{{$key}}</td>
                                                    @endif
                                                @endforeach
                                                @break
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['nilai'] as $key => $item)
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$item['nama']}}</td>
                                                @foreach ($item as $key2 => $item2)
                                                    @if($key2 != 'nama')
                                                        <td>{{$item2}}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12" style="padding-left:0; padding-right:0">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Ranking</th>
                                            <th>Kode Karyawan</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jabatan</th>
                                            <th>Total Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $rank = 1; @endphp
                                        @foreach ($data['hasil'] as $key => $item)
                                            <tr>
                                                <td>{{$rank}}</td>
                                                <td>{{$key}}</td>
                                                <td>{{$item['nama']}}</td>
                                                <td>{{$item['jabatan']}}</td>
                                                <td>{{$item['nilai']}}</td>
                                            </tr>
                                            @php $rank++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br />
                        <a href="/laporan/kinerja/cetak" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
