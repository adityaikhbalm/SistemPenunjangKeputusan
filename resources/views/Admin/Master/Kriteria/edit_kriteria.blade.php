@extends('layout')


@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <a href="{{ URL::previous() }}" class="btn btn-info">< Kembali</a><br/><br/>
                <h3 class="section-title">Ubah Data Kriteria</h3>
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
                        {{ Form::open(['route'=> array('kriteria.update', $data->kd_krt), 'method' => 'POST']) }}
                        {{ Form::label('title_nama', 'Kode Kriteria') }}
                        {{ Form::text('kode', $data->kd_krt, ['required' => 'required', 'class' => 'form-control', 'id' => 'kode_kriteria', 'maxlength' => '5', 'readonly']) }}
                        <br/>
                        {{ Form::label('title_nama', 'Nama Kriteria') }}
                        {{ Form::text('nama', $data->nm_krt, ['required' => 'required', 'class' => 'form-control', 'id' => 'nama_kriteria', 'maxlength' => '20']) }}
                        <br/>
                        {{ Form::label('title_nama', 'Bobot') }}
                        {{ Form::number('bobot', $data->bobot, ['required' => 'required', 'class' => 'form-control', 'id' => 'bobot', 'max' => '10']) }}
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
