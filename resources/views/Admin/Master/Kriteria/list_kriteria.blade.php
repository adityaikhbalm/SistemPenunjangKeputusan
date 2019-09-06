@extends('layout')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="basicform">
                <h3 class="section-title">Table Data Kriteria</h3>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Kriteria</th>
                                    <th>Nama Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $item)
                                    <tr>
                                        <td>{{$item->kd_krt}}</td>
                                        <td>{{$item->nm_krt}}</td>
                                        <td>{{$item->bobot}}</td>

                                        <td style="text-align:center">
                                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Hapus</a>

                                            <a href="kriteria/{{$item->kd_krt}}/edit" class="btn btn-primary"><i class="fa fa-edit">Ubah</i></a>
                                        </td>
                                        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {{Form::open(['route'=> array('kriteria.destroy',$item->kd_krt), 'method' => 'POST'])}}
                                                {{Form::hidden('_method','DELETE')}}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        Hapus data kriteriaf
                                                    </div>
                                                    <div class="modal-body">
                                                        Yakin ingin menghapus {{$item->nm_krt}}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                                {{Form::close()}}
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    <a href="/master/kriteria/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o">
                        </i>Tambah Kriteria Baru
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
$('#bootstrap-data-table').dataTable( {
    "pageLength": 10
} );
</script>
@endsection
