@extends('layout')

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Laporan Kinerja Karyawan</h3>
            </div>
            @if(session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="card">
                {{ Form::open(['route'=> 'laporan.kinerja.store', 'method' => 'POST']) }}
                <div class="card-body">
                    <div class="col-md-3" style="padding-left:0; padding-right:0">
                        {{ Form::label('title_nama', 'Tahun Periode') }}
                        <select class="form-control" name="tahun" style="background: url(/assets/images/down-arrow.png) no-repeat 98% 50%;" required>
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
