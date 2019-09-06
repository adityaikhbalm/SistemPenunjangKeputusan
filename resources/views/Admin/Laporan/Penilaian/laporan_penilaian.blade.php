@extends('layout')

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Laporan Penilaian Karyawan</h3>
            </div>
            @if ($errors->has('tahun2'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('tahun2') }}
                </div>
            @endif
            <div class="card">
                {{ Form::open(['route'=> 'laporan.penilaian.store', 'method' => 'POST']) }}
                <div class="card-body">
                    <div class="col-md-3" style="padding-left:0; padding-right:0; display:inline-block; white-space: nowrap;">
                        {{ Form::label('title_nama', 'Tahun Periode') }}<br/>
                        <select class="form-control" name="tahun" style="background: url(/assets/images/down-arrow.png) no-repeat 98% 50%; display:inline-block; white-space: nowrap;" required>
                            <option value="">Pilih Tahun</option>
                            @if (isset($tahun))
                                @foreach ($tahun as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                        &nbsp;s/d&nbsp;
                        <select class="form-control" name="tahun2" style="background: url(/assets/images/down-arrow.png) no-repeat 98% 50%; display:inline-block; white-space: nowrap;" required>
                            <option value="">Pilih Tahun</option>
                            @if (isset($tahun))
                                @foreach ($tahun as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    {{Form::submit('Proses',['class' => 'btn btn-primary'])}}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
