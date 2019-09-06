@extends('layout')


@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <a href="{{ URL::previous() }}" class="btn btn-info">< Kembali</a><br/><br/>
                <h3 class="section-title">Entry Data Kriteria</h3>
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
                    {{ Form::open(['route'=> 'kriteria.store', 'method' => 'POST']) }}
                        {{ Form::label('title_nama', 'Nama Kriteria') }}
                        {{ Form::text('nama', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'nama_kriteria', 'maxlength' => '20']) }}
                        <br/>
                        {{ Form::label('title_nama', 'Bobot') }}
                        {{ Form::number('bobot', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'bobot', 'max' => '10']) }}
                        <br/>

                        {{Form::submit('Simpan',['class' => 'btn btn-primary'])}}
                        {{Form::reset('Reset',['class' => 'btn btn-danger'])}}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
