@extends('layout')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Hasil Keputusan Karyawan Terbaik</h3>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <input type="hidden" name="index2" value="{{ isset($index2) ? $index2 : '' }}">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
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
                                    {{ Form::open(['id' => 'list_keputusan','method' => 'GET']) }}
                                    <select id="tahun" class="form-control" name="tahun" style="background: url(/assets/images/down-arrow.png) no-repeat 98% 50%;">
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
                                    <th>Nama Karyawan</th>
                                    <th>Total Nilai</th>
                                    <th>Keputusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{$item->kd_kywn}}</td>
                                        <td>{{$item->nm_kywn}}</td>
                                        <td>{{$item->nilai_akhir}}</td>
                                        <td><input type="checkbox" name="kd_kywn" value="{{$item->kd_kywn}}" class="custom-control-input" style="margin-top:-5px;z-index:1;opacity:1"/></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <button type="button" id="cetak" class="btn btn-primary" formtarget="_blank">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $('input[name=kd_kywn]').click(function(e) {
        $('input[name=kd_kywn]').not(this).prop('checked', false);
    });
    $('#list_keputusan').on('change', function(ev){
        if (ev.target.selectedIndex > 0)
        $('#list_keputusan').attr('action', "/transaksi/keputusan/periode").submit();
    })
    $('#bootstrap-data-table').dataTable( {
        "pageLength": 10
    });
    $('#cetak').click(function() {
        if ($('input[name=kd_kywn]').is(':checked')) {
            var kode = $('input[name=kd_kywn]:checked').map(function(){
                return this.value;
            }).get()

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {_token : $('meta[name="csrf-token"]').attr('content')},
                url: '{{ route('keputusan.no_surat') }}',
                type: 'POST',
                success: function (response) {
                    var tahun = '2019';
                    if ($("#tahun option:selected").index() > 0) tahun = $('#tahun').find(":selected").text();
                    if ($('input[name=index2]').val()) window.location.href='cetak/kode='+kode+'&tahun='+tahun;
                    else window.location.href='keputusan/cetak/kode='+kode+'&tahun='+tahun;
                },
                error: function (response) {

                }
            });
        }
    });
</script>
@endsection
