<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Koperasi</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <span class="logo-lg"><b>KOPERASI</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left info">
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="treeview active">
          <a href="<?php echo base_url('Home'); ?>">
            <i class="fa fa-dashboard"></i> <span>Menu</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">DATA KOPERASI</h3>
            </div>
            
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover" id="datakoprasi">
                <tr>
                  <th>No KTP</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Usia</th>
                  <th>Foto</th>
                  <th>Alamat</th>
                  <th>AKSI</th>
                </tr>
                <tbody id="show_data">  
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<!-- modaltambah -->
<div class="modal fade" id="form_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="defaultModalLabel">Tambah Data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
            <input type="hidden" name="id" id="id_data">
            <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">No KTP : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="no_ktp" class="form-control" name="no_ktp" placeholder="NO KTP">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">NAMA : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="nama" class="form-control" name="nm" placeholder="NAMA">
                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">JENIS KELAMIN : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="jenis_kelamin" class="form-control" name="jns_kelamin" placeholder="JENIS KELAMIN">
                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">TANGGAL LAHIR : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="tanggal_lahir" class="datepicker form-control" name="tg_lahir" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">FOTO : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="foto" value="" class="form-control" name="ft"placeholder="FOTO">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">ALAMAT : </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" id="alamat" value="" class="form-control" name="alm" placeholder="DD-MM-YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn" id="btn_tambah"> Ya</button>
                <button type="button" class="btn" data-dismiss="modal" id="close">Tidak</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Data -->
<div class="modal fade" id="modal_hapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title" id="defaultModalLabel">Hapus Data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <h4>Apakah anda Ingin Menghapus Data Ini ?</h4>
                    <input type="hidden" name="id_hapus" id="id_hapus">
                  </div>
                </div>
            </div>
            <div class="modal-footer bg-red">
                <button type="button" class="btn" id="Hapus_Data"> Ya</button>
                <button type="button" class="btn" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="https://adminlte.io">PT.SISI</a></strong>
  </footer>
</div>

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script type="text/javascript">

$(document).ready(function(){
  tampil_data_barang();   //pemanggilan fungsi tampil barang.
  //$('#datakprasi').dataTable();
          
//fungsi tampil barang
function tampil_data_barang(){
    $.ajax({
      type  : 'GET',
      url   : '<?php echo base_url()?>index.php/welcome/dataall',
      async : true,
      dataType : 'json',
      success : function(data){
      var html = '';
      var i;
      for(i=0; i<data.length; i++){
        html += '<tr>'+
        '<td>'+data[i].no_ktp+'</td>'+
        '<td>'+data[i].nama+'</td>'+
        '<td>'+data[i].jenis_kelamin+'</td>'+
        '<td>'+data[i].tanggal_lahir+'</td>'+
        '<td>'+data[i].foto+'</td>'+
        '<td>'+data[i].alamat+'</td>'+
        '<td style="text-align:right;">'+
        '<a href="javascript:;" class="btn btn-info btn-xs item_edit" id="'+data[i].no_ktp+'">Edit</a>'+' '+
        '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" id="'+data[i].no_ktp+'">Hapus</a>'+
        '</td>'+
        '</tr>';
      }
        $('#show_data').html(html);
    }
  });
}

// $('#show_data').on('click','.item_edit', function(){
//   var id = $("#id");
//   $("#id_hapus").val(id);
// });


// $('#show_data').on('click','.item_edit', function(){
//   $.ajax({
//     type : "GET",
//     url  : "<?php echo base_url('index.php/welcome/Ajax_get_data_id')?>",
//     dataType : "JSON",
//       success: function(data){
//         console.log(data);
    //   $.each(data,function(no_ktp, nama, jenis_kelamin, tanggal_lahir, foto, alamat){
    //   $('#form_tambah').modal('show');
    //   $('[name="no_ktp"]').val(data.no_ktp);
    //   $('[name="nm"]').val(data.nama);
    //   $('[name="jns_kelamin"]').val(data.jenis_kelamin);
    //   $('[name="tg_lahir"]').val(data.tanggal_lahir);
    //   $('[name="ft"]').val(data.foto);
    //   $('[name="alm"]').val(data.alamat);
//     // });
//    }
//   });
//   return false;
// });

$('#tambah').on('click',function(){
  $('#form_tambah').modal('show');
});

 $('#btn_tambah').on('click',function(){
    var noktp=$('#no_ktp').val();
    var nama=$('#nama').val();
    var jeniskelamin=$('#jenis_kelamin').val();
    var tanggallahir=$('#tanggal_lahir').val();
    var foto=$('#foto').val();
    var alamat=$('#alamat').val();
    $.ajax({
      type : "POST",
      url  : "<?php echo base_url()?>index.php/welcome/Ajax_tambah_data",
      dataType : "JSON",
      data : {noktp:noktp , nama:nama, jeniskelamin:jeniskelamin, tanggallahir:tanggallahir, foto:foto, alamat:alamat},
      success: function(data){
                    $('[name="no_ktp"]').val("");
                    $('[name="nm"]').val("");
                    $('[name="jns_kelamin"]').val("");
                    $('[name="tg_lahir"]').val("");
                    $('[name="ft"]').val("");
                    $('[name="alm"]').val("");
                    $('#form_tambah').modal('hide');
                    tampil_data_barang();
        }
      });
      return false;
});

$('#show_data').on('click','.item_hapus',function(){
  var id=$(this).attr('data');
  $('#modal_hapus').modal('show');
  $('[name="no_ktp"]').val(id);
});

// $(document).on("click", "#edit", function(){
//   $("#form_tambah").modal('show');
//   var id=$(this).attr('data');
//     $.ajax({
//     type : "GET",
//     url  : "<?php echo base_url('index.php/welcome/Ajax_get_data_id')?>",
//     dataType : "JSON",
//     data : {id_data:id_data},
//     success: function(data){
//     console.log('data');
//     $.each(data,function(no_ktp, nama, jenis_kelamin, tanggal_lahir, foto, alamat)
//     {
//     $('[name="no_ktp"]').val(data.no_ktp);
//     $('[name="nm"]').val(data.nama);
//     $('[name="jns_kelamin"]').val(data.jenis_kelamin);
//     $('[name="tg_lahir"]').val(data.tanggal_lahir);
//     $('[name="ft"]').val(data.foto);
//     $('[name="alm"]').val(data.alamat);
//     });
//     }
// });
// return false;
// });

$(document).on("click", "#hapus", function(){
  $("#modal_hapus").modal('show');

    $('#hapus_data').on('click',function(){
    var kode=$('#id_hapus').val();
    $.ajax({
    type : "POST",
    url  : "<?php echo base_url('Welcome/Ajax_get_data_id')?>",
    dataType : "JSON",
    data : {kode: kode},
    success: function(data){
    $('#Modal_hapus').modal('hide');
    }
    });
    });
});


// $(document).on("click", "#Save_penambahan_distributor", function(){
//   $("#isi_data_customer_distributor").html('<tr><td colspan="4"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>');
  
//   $.ajax({
//     url: '<?php echo site_url(); ?>distributor/Produk_distributor/Ajax_tambah_data_Produk_dist',
//     type: 'POST',
//     data: {
//       "Id_jenis_produk"     : $("#jenis_produk").val(),
//       "nm_produk"       : $("#nm_produk").val(),
//       "stok"          : $("#stok").val(),
//       "satuan"        : $("#satuan").val(),
//       "hb_satuan"       : $("#hb_satuan").val(),
//       "hj_satuan"       : $("#hj_satuan").val(),
//       "kd_produk_sap"     : $("#kd_produk_sap").val(),
//       "tgl_stok"        : $("#plannedDate").val()
//     },
//     success: function(j){
//       var dt = JSON.parse(j);

//       $("#isi_data_hasil_survey").html(dt.html);
//       $('#Table_distributor').dataTable();
      
//       $("#modal_distributor").modal('hide');
//       //showNotification('bg-blue', 'Data Berhasil Disimpan', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');
//       if(dt.notify=='1'){
//         $("#nm_produk").val("");
//         $("#stok").val("");
//         $("#satuan").val("");
//         $("#hb_satuan").val("");
//         $("#hj_satuan").val("");
//         $("#kd_produk_sap").val("");        
//       }
//     },
//     error: function(){
//       //show_toaster(2,'','Data Gagal Diproses');
//     }
//     });
// });


// $(document).on("click", ".Tambah_stok_history", function(){
  
//   $("#form_tambah_stok_produk_dist").modal("show");
//   idpd = $(this).attr("idpd");
  
//   $('#idpd').val(idpd);
  
  
// });

// $(document).on("click", "#Tambah_stok_history", function(){
  
//   $.ajax({
//     url: '<?php echo site_url(); ?>distributor/Produk_distributor/Ajax_tambah_stok_history',
//     type: 'POST',
//     data: {
//       "id_pd"           : $("#idpd").val(),
//       "stok"          : $("#stok_history").val(),
//       "satuan"        : $("#satuan_history").val(),
//       "hb_satuan"       : $("#hbs_satuan").val(),
//       "hj_satuan"       : $("#hjs_satuan").val(),
//       "tgl_stok"        : $("#tgl_stok_history").val()
//     },
//     success: function(j){
//       var dt = JSON.parse(j);

//       $("#isi_data_hasil_survey").html(dt.html);
//       $('#Table_distributor').dataTable();
//       //showNotification('bg-blue', 'Data Berhasil Disimpan', 'top', 'right', 'animated lightSpeedIn', 'animated lightSpeedOut');
//       if(dt.notify==1){
//         $("#stok_history").val("");
//         $("#satuan_history").val("");
//         $("#hbs_satuan").val("");
//         $("#hjs_satuan").val("");
        
//       }
//       $("#close_update_stok").click();
      
//     },
//     error: function(){
//       //show_toaster(2,'','Data Gagal Diproses');
//     }
//     });
  
});

</script>
</body>
</html>
