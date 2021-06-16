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
                <label for="nama_jenis_proyek">Tugas</label>
                <textarea class="form-control" id="nama" name="nama" required placeholder="Nomor Surat" rows="3"></textarea>
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

<div class="modal fade" id="modal-ubah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form class="striped-rows" enctype="multipart/form-data" action="{{url()->current()}}/update" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="text-center" style="display: flex; flex-direction: column; justify-content: center; align-content: center;">
            <div style="width: 100%;"><h4 class="card-title" style="width: 100%; text-align: center; margin-bottom: 1em;">Masukan data Instansi</h4></div>
            <div><i class="fas fa-user fa-4x mb-3 "></i></div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="nama_jenis_proyek">Tugas</label>
                <input type="text" name="id" id="ubah_id" hidden>
                <textarea class="form-control" id="ubah_nama" name="nama" required placeholder="Nomor Surat" rows="3"></textarea>
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

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-trash fa-4x mb-3 "></i>
                    <h4>Apakah Yakin Ingin Menghapus Kategori Ini ?
                    </h4>

                </div>
            </div>

            <div class="modal-footer justify-content-between ">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{url()->current()}}/delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="id_hapus" required>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>

            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

@endsection


@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Admin </h3>

    <div class="card-tools">
      <div class="input-group input-group-sm" style="width: 150px;">
        <div onclick="tambah_asn()" class="btn btn-primary">Tambah ASN</div>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Tugas</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @php
        $no = 1;
        @endphp
        @foreach ($tugas as $row)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$row->nama}}</td>
          <td>
            <div class="btn-group">
              <button type="button" class="btn btn-info">Action</button>
              <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu" role="menu" style="">
                <div class="dropdown-item" onclick='ubah_data("{{$row->id}}", "{{$row->nama}}")'>Ubah</div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item" onclick='hapus_data("{{$row->id}}")' href="#">Hapus</div>
              </div>
            </div>
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

  function ubah_data(id, nama){
    $("#ubah_id").val(id);
    $("#ubah_nama").val(nama);
    $("#modal-ubah").modal('show');
  }

  function hapus_data(id){
    $("#id_hapus").val(id);
    $("#modal-hapus").modal('show');
  }
</script>



@endsection