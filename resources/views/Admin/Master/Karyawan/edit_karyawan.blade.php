@extends('layout')


@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <a href="{{ URL::previous() }}" class="btn btn-info">< Kembali</a><br/><br/>
                <h3 class="section-title">Ubah Data Karyawan</h3>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route'=> array('karyawan.update', $data->kd_kywn), 'method' => 'POST']) }}
                        {{ Form::label('title_nama', 'Kode Karyawan') }}
                        {{ Form::text('kode', $data->kd_kywn, ['required' => 'required', 'class' => 'form-control', 'id' => 'kode_karyawan', 'maxlength' => '5', 'readonly']) }}
                        <br/>
                        {{ Form::label('title_nama', 'Nama Karyawan') }}
                        {{ Form::text('nama', $data->nm_kywn, ['required' => 'required', 'class' => 'form-control', 'id' => 'nama_karyawan', 'maxlength' => '40']) }}
                        <br/>
                        {{ Form::label('title_nama', 'Jabatan') }}
                        {{ Form::text('jabatan', $data->jabatan, ['required' => 'required', 'class' => 'form-control', 'id' => 'jabatan', 'maxlength' => '35']) }}
                        <br/>

                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit('Ubah',['class' => 'btn btn-primary'])}}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
