@extends('layouts.admin_LTE_layout')

@section('header')
<!-- DataTables -->
<link rel="stylesheet" href="<?=url('/')?>/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=url('/')?>/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

@endsection

@section('modal')
{{-- modal --}}
<!-- Large modal -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form class="striped-rows" enctype="multipart/form-data" action="{{url()->current()}}/store" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="text-center" style="display: flex; flex-direction: column; justify-content: center; align-content: center;">
            <div style="width: 100%;"><h4 class="card-title" style="width: 100%; text-align: center; margin-bottom: 1em;">Masukan data Instansi</h4></div>
            <div><i class="fas fa-user fa-4x mb-3 "></i></div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="nama_jenis_proyek">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required placeholder="Nomor Surat">
              </div>
              <div class="form-group">
                <label for="nama_jenis_proyek">Upload Surat Tugas</label>
                <input type="file" class="form-control" id="berkas_surat_tugas" name="berkas_surat_tugas" placeholder="Nama Alias">
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between ">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-dark">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Admin </h3>

    <div class="card-tools">
      <div class="input-group input-group-sm">
        <div onclick="tambah_asn()" class="btn btn-primary">Tambah Surat Tugas</div>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nomor Surat</th>
          <th>Tugas</th>
          <th>Asn Bertugas</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @php
        $no = 1;
        @endphp
        @foreach ($surat_tugas as $row)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$row['nomor']}}</td>
          <td><a href="<?=url('/')?>/surat-tugas/{{$row['id']}}/tugas" class="btn btn-primary">{{$row['jumlah_tugas']}} Tugas</a></td>
          <td><a href="<?=url('/')?>/surat-tugas/{{$row['id']}}/asn" class="btn btn-success">{{$row['jumlah_asn']}} ASN</a></td>
          <td></td>
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

  function tambah_asn(){
    $("#modal-tambah").modal('show');
  }
</script>



@endsection