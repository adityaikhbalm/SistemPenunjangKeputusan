@extends('layout')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Table Data Nilai Alternatif</h3>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <?php
                                    if(isset($thn_periode) ) $ora=$thn_periode;
                                    else $ora = '';
                                ?>
                                <div class="col-md-3" style="padding-left:0; padding-right:0">
                                    {{ Form::open(['id' => 'list_nilai','method' => 'GET']) }}
                                    <select class="form-control" name="tahun" style="background: url(/assets/images/down-arrow.png) no-repeat 98% 50%;">
                                        <option>Pilih Tahun</option>
                                        @if (isset($tahun))
                                            @foreach ($tahun as $item)
                                                @if ($ora == $item)
                                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                                @else
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        <br/>
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Karyawan</th>
                                    <th>Kode Kriteria</th>
                                    <th>Nilai</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nilai as $item)
                                    <tr>
                                        <td>{{$item->kd_kywn}}</td>
                                        <td>{{$item->kd_krt}}</td>
                                        <td>{{$item->nilai_kywn}}</td>
                                        @php
                                          $parts = explode('-', $item->thn_periode);
                                        @endphp
                                        <td>{{$parts[0]}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <a href="/transaksi/nilai/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o">
                        </i>Tambah Nilai Alternatif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$('#list_nilai').on('change', function(ev){
    if (ev.target.selectedIndex > 0)
    $('#list_nilai').attr('action', "/transaksi/nilai/periode").submit();
})
$('#bootstrap-data-table').dataTable( {
    "pageLength": 10
} );
</script>
@endsection
