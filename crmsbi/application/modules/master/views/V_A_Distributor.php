<?php 
     if($this->session->userdata('status_act') != NULL){ ?>
      <div class="alert alert-success" role="alert" style="position: fixed; top: 72px; right:4%; width: 45%; vertical-align: middle; border-radius: 0.3em;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>INFO!</strong> <?= $this->session->userdata('status_act');?>
      </div>
      <script type="text/javascript">
        $(document).ready (function(){
          window.setTimeout(function() {
              $(".alert").fadeTo(500, 0).slideUp(500, function(){
                  $(this).remove(); 
              });
          }, 6000);
        });
      </script>
      <?php 
        $this->session->set_userdata('status_act', null);
} ?>

<section class="content" style="background-color: #fff; margin-bottom: 1em; padding-bottom: 1em; border-radius: 0.5em;">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="container">
					<h3>Data Distributor <small>(Contains distributor data)</small></h3>
					<hr />
						<button id="btn_add" class="btn btn-success" style="margin-bottom: 1em;"><i class="glyphicon glyphicon-plus"></i> Tambah Distributor</button>

					<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
					  	<thead>
							<tr>
						 		<th>No.</th>
								<th>KODE</th>
								<th>NAMA</th>
								<th>FLAG</th>
								<!--
								<th>CREATE_AT</th>
								<th>CREATE_BY</th>
								<th>UPDATE_AT</th>
								<th>UPDATE_BY</th>
								-->
								<th style="width:25px;">AKSI</th>
							</tr>
					 	</thead>
					 	<tbody>
					 	<?php 
					  	$count = 1;
					  	foreach($distributors as $dt){?>
					  		<tr>
							    <td><?= $count++;?></td>
							    <td><?= $dt->KODE_DISTRIBUTOR;?></td>
							    <td><?= $dt->NAMA_DISTRIBUTOR;?></td>
								<td><?= $dt->FLAG;?></td>
								<!--
							    <td><?= $dt->CREATED_DATE;?></td>
							    <td><?= $dt->CREATED_BY;?></td>
							    <td><?= $dt->UPDATED_DATE;?></td>
							    <td><?= $dt->UPDATED_BY;?></td>
								-->
							    <td>
								<center>
									<button class="btn btn-warning" id="edit_dist" dt_flag="<?= $dt->FLAG;?>" dt_nama="<?= $dt->NAMA_DISTRIBUTOR;?>" dt_kode="<?= $dt->KODE_DISTRIBUTOR;?>"><i class="glyphicon glyphicon-pencil"></i></button>
						 			<button class="btn btn-danger" id="hapus_dist" dt_kode="<?= $dt->KODE_DISTRIBUTOR;?>"><i class="glyphicon glyphicon-remove"></i></button>
								</center>
					   			</td>
					 		</tr>
							
					 	<?php }?>
				   		</tbody>
				   		<tfoot>
							<tr>
					  			<th>No.</th>
					  			<th>KODE</th>
					  			<th>NAMA</th>
								<th>FLAG</th>
								<!--
					  			<th>CREATE_AT</th>
					  			<th>CREATE_BY</th>
					  			<th>UPDATE_AT</th>
					  			<th>UPDATE_BY</th>
								-->
					  			<th style="width:125px;">AKSI</th>
							</tr>
				  		</tfoot>
					</table>
				</div>
			
			</div>
        </div>
    </div>
</section>

<script>
	$(document).ready(function() {
    	$('#table_id').DataTable();
		
		$(document).on("click", "#btn_add", function(){
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Distributor/action_add_dist";
			$('#form')[0].reset(); // reset form on modals
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Tambah Distributor'); // Set Title to Bootstrap modal title 
		});
		
		$(document).on("click", "#edit_dist", function(){
			$('.modal-title').text('Edit Distributor'); 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Distributor/action_update_dist";
			
			var dt_kode = $(this).attr("dt_kode");
			var dt_nama = $(this).attr("dt_nama");
			var dt_flag = $(this).attr("dt_flag");

			$("#kode_lama").val(dt_kode);
			$("#kode_distributor").val(dt_kode);
			$("#nama_distributor").val(dt_nama);
			
			$("#flag").val(dt_flag).change();
			$("#modal_form").modal('show');
		});
		
		$(document).on("click", "#hapus_dist", function(){
			$("#modal_hapus").modal('show');
			var dt_kode = $(this).attr("dt_kode");
			$("#kode").val(dt_kode);
			$('.modal-title').text('Hapus Distributor: '+dt_kode); 
			document.getElementById("form_hapus").action = "<?php echo site_url(); ?>master/Distributor/action_delete_dist/"+dt_kode;
		});
  	});
	
</script>

<!-- Bootstrap modal add & update dist-->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Form Distributor </h3>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="kode_lama" name="kode_lama">
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Kode : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="kode_distributor" class="form-control"  name="kode_distributor" placeholder="Masukkan kode distributor" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Nama : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama_distributor" class="form-control"  name="nama_distributor" placeholder="Masukkan nama distributor" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Flag : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="mdb-select md-form" name="flag" id="flag" required>
										<option value="" disabled selected>Masukkan pilihan</option>
										<option id="SMI" value="SMI">SMI</option>
										<option id="SBI" value="SBI">SBI</option>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			  
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal sdd & update dist-->
 
<!-- Bootstrap modal delete dist-->
<div class="modal fade" id="modal_hapus" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Hapus Distributor </h3>
			</div>
			<form id="form_hapus" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="kode" name="kode">
					<p>Apakah anda yakin ingin menghapus data?</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Ya</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal delete dist-->