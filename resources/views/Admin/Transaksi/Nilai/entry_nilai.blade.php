@extends('layout')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
@endsection

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                    <a href="{{ URL::previous() }}" class="btn btn-info">< Kembali</a><br/><br/>
                <h3 class="section-title">Entry Nilai Alternatif</h3>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
            @if(session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session()->get('message') }}
                    </div>
                @endif
            <div class="card">
                <br/>
                <div class="card-body">
                    <div class="container" style="padding-left:0; padding-right:0">
                        {{ Form::open(['route'=> 'nilai.store', 'method' => 'POST']) }}
                        <div class="row">
                            <div class="col-md-12">
                                <h2 style="text-align:center">Karyawan</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        {{ Form::label('title_nama', 'Kode Karyawan') }}
                                        <select class="form-control" name="kd_kywn" style="background: url(/assets/images/down-arrow.png) no-repeat 98% 50%;">
                                            <option>Pilih Karyawan</option>
                                            @foreach ($karyawan as $item)
                                                @if (Input::old('kd_kywn') == $item->kd_kywn)
                                                    <option value="{{ $item->kd_kywn }}" selected>{{ $item->kd_kywn }}</option>
                                                @else
                                                    <option value="{{ $item->kd_kywn }}">{{ $item->kd_kywn }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <br/>
                                        {{ Form::label('title_nama', 'Nama Karyawan') }}
                                        {{ Form::text('nm_kywn', '', ['class' => 'form-control', 'readonly']) }}
                                        <br/>
                                        {{ Form::label('title_nama', 'Jabatan') }}
                                        {{ Form::text('jabatan', '', ['class' => 'form-control', 'readonly']) }}
                                        <br/>
                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::label('title_nama', 'Tahun Periode') }}<br/>
                                        {{ Form::text('tahun_periode', '', ['class' => 'form-control', 'data-date-format' => 'dd-mm-yyyy']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 style="text-align:center">Kriteria</h2>
                                <div class="row">
                                    <div class="col-md-8">
                                        @foreach ($kriteria as $item)
                                            {{ Form::hidden('kd_krt[]', $item->kd_krt, ['class' => 'form-control']) }}
                                        @endforeach
                                        @foreach ($kriteria as $item)
                                            {{ Form::text('nm_krt[]', $item->kd_krt.' - '.$item->nm_krt, ['class' => 'form-control', 'readonly']) }}
                                        @endforeach
                                    </div>
                                    <div class="col-md-4">
                                        @foreach ($kriteria as $item)
                                            {{ Form::text('nilai[]', '', ['class' => 'form-control', 'id' => 'nilai', 'placeholder' => 'maksimal 5']) }}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        {{Form::submit('Simpan',['class' => 'btn btn-primary'])}}
                        {{Form::reset('Reset',['class' => 'btn btn-danger'])}}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
            });
        };
    }(jQuery));

    $('input[name="nilai[]"]').inputFilter(function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 5);
    });

    $('input[name="tahun_periode"]').datepicker();
    $('select[name="kd_kywn"]').change(function() {
        var kode = $(this,':selected').val();
        var url = 'get/'+kode;
        if ($(this,':selected').val() == 'Pilih Karyawan') {
            $('input[name="nm_kywn"]').val('');
            $('input[name="jabatan"]').val('');
        }
        else {
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: url,
                success: function (data) {
                    $('input[name="nm_kywn"]').val(data.nama);
                    $('input[name="jabatan"]').val(data.jabatan);
                },
                error: function() {
                    console.log(data);
                }
            });
        }
    })
</script>
@endsection
