@extends('layouts.admin_LTE_layout')

@section('header')
<!-- DataTables -->
<link rel="stylesheet" href="<?=url('/')?>/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=url('/')?>/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

@endsection

@section('modal')

<div class="modal fade" tabindex="-1" role="dialog" id="modal_pilih_asn">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/surat_tugas/{{$id}}/post_asn_bertugas" method="post">
        {{ csrf_field() }}
        <div class="modal-body">
          <input type="text" name="id_asn" id="id_asn" hidden>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Nama ASN</label>
            <select name="" class="form-control" id="nama_asn">
              <option value="">Pilih ASN</option>
              @php
                  $no=0;
              @endphp
              @foreach ($data_asn as $data)

                <option value="{{$no++}}">{{$data['nama']}}</option>

              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Bidang</label>
            <input name="" type="text" class="form-control" id="bidang" placeholder="Bidang" readonly>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Sub_bidang</label>
            <input type="text" class="form-control" id="sub_bidang" placeholder="Sub Bidang" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data ASN Bertugas </h3>

    <div class="card-tools">
      <div class="input-group input-group-sm" style="width: 150px;">
        <div onclick="tambah_asn()" class="btn btn-primary" data-toggle="modal" data-target="#modal_pilih_asn">Tambah ASN</div>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Bidang</th>
          <th>Sub Bidang</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @php
        $no = 1;
        @endphp
        @foreach ($asn as $data)
        <tr>
          <td>{{$no++}}</td>
          <td>{{$data['nama']}}</td>
          <td>{{$data['bidang']}}</td>
          <td>{{$data['sub_bidang']}}</td>
          <td>
            <div class="btn-group">
              <button type="button" class="btn btn-info">Action</button>
              <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu" role="menu" style="">
                <div class="dropdown-item" onclick='ubah_data("", "")'>Ubah</div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item" onclick='hapus_data("")' href="#">Hapus</div>
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
<script>
  $('#nama_asn').change(function(){
    var index = $(this).val();
    var data_asn = <?php echo json_encode($data_asn)?>;
    console.log(data_asn[index]);
    $('#bidang').val(data_asn[index]['bidang']);
    $('#sub_bidang').val(data_asn[index]['sub_bidang']);
    $('#id_asn').val(data_asn[index]['id']);
  })
</script>



@endsection