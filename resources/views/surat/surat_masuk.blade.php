@extends('layouts.admin_LTE_layout')

@section('header')
    <!-- DataTables -->
  <link rel="stylesheet" href="<?=url('/')?>/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=url('/')?>/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

@endsection

@section('modal')
    {{-- modal tambah surat --}}

<div class="modal fade" id="modal_tambah_surat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">TAMBAH SURAT MASUK</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/post_surat_masuk" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Nomor Surat</label>
              <div class="col-sm-10">
                <input name="no_surat" type="text" class="form-control" id="inputEmail3" placeholder="Nomor Surat" required>
              </div>
            </div>
            <div class="form-group">
              <label>Date:</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input name="tgl_masuk" type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 col-form-label">Perihal</label>
              <div class="col-sm-10">
                <textarea name="perihal" id="" cols="30" rows="10" class="form-control"></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 col-form-label">Arsip</label>
              <div class="col-sm-10">
                <input type="file" name="file">
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
        
      </div>
    </div>
  </div>
  
  {{-- end modal tambah surat --}}
@endsection

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Surat Masuk </h3>

      <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
          <button type="button" data-toggle="modal" data-target="#modal_tambah_surat">Input Surat Masuk</button>
        </div>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th>No Surat</th>
          <th>Tgl masuk</th>
          <th>Arsip</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
          @php
              $no = 1;
          @endphp
          @foreach ($surat_masuk as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->nomor_surat}}</td>
                <td>{{$data->tgl_masuk}}</td>
                <td>
                  <a class="btn btn-primary" href="<?=url('/')?>/arsip_surat_masuk/{{$data->arsip}}" download role="button">Download</a>
                </td>
                <td>
                  <a class="btn btn-danger" href="/hapus_surat_masuk/{{$data->id}}" role="button">Hapus</a>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection

@section('footer')

<!-- DataTables -->
<script src="<?=url('/')?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=url('/')?>/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=url('/')?>/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=url('/')?>/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        });
        $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        });
    });
</script>
<script type="text/javascript">
</script>
  

@endsection