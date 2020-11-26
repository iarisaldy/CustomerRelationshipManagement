<?php if($this->session->userdata('status_act') != NULL){ ?>
    <div class="alert alert-success" role="alert" style="position: fixed; top: 72px; right:4%; width: 45%; vertical-align: middle; border-radius: 0.3em;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
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
<?php $this->session->set_userdata('status_act', null); } ?>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="card">
					<div class="header header-title">
						<h2>Data Master Reason</h2>
					</div>
					
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
					<button id="btn_add" class="btn btn-success" style="margin-bottom: 1em;"><i class="glyphicon glyphicon-plus"></i> Tambah Master Reason</button>

					<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
					  	<thead>
							<tr>
						 		<th>NO.</th>
								<th>ID MR</th>
								<th>NAMA</th>
								<th>DESKRIPSI</th>
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
					  	foreach($master_reasons as $dt){?>
					  		<tr>
							    <td><?= $count++;?></td>
							    <td><?= $dt->ID_MR;?></td>
							    <td><?= $dt->NM_MASTER_REASON;?></td>
								<td><?= $dt->DISCRIPTION;?></td>
								<!--
							    <td><?= $dt->CREATE_DATE;?></td>
							    <td><?= $dt->CREATE_BY;?></td>
							    <td><?= $dt->UPDATE_DATE;?></td>
							    <td><?= $dt->UPDATE_BY;?></td>
								-->
							    <td>
								<center>
									<button class="btn btn-warning" id="edit_mr" dt_deskripsi="<?= $dt->DISCRIPTION;?>" dt_nama="<?= $dt->NM_MASTER_REASON;?>" dt_id="<?= $dt->ID_MR;?>"><i class="glyphicon glyphicon-pencil"></i></button>
						 			<button class="btn btn-danger" id="hapus_mr" dt_id="<?= $dt->ID_MR;?>"><i class="glyphicon glyphicon-remove"></i></button>
								</center>
					   			</td>
					 		</tr>
							
					 	<?php }?>
				   		</tbody>
				   		<tfoot>
							<tr>
					  			<th>NO.</th>
					  			<th>ID MR</th>
					  			<th>NAMA</th>
								<th>DESKRIPSI</th>
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
		$('#table_data').DataTable();
		
		$(document).on("click", "#btn_add", function(){
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Master_Reason/action_add_mr";
			$('#form')[0].reset(); // reset form on modals
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Tambah Master Reason'); // Set Title to Bootstrap modal title
		});
		
		$(document).on("click", "#edit_mr", function(){
			$('.modal-title').text('Edit Master Reason'); 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Master_Reason/action_update_mr";
			$("#modal_form").modal('show');
			
			var id_mr = $(this).attr("dt_id");
			var nama_mr = $(this).attr("dt_nama");
			var deskripsi = $(this).attr("dt_deskripsi");
			
			//pengisisan valus textfield
			$("#id_mr_lama").val(id_mr);
			$("#id_mr").val(id_mr);
			$("#nama_mr").val(nama_mr);
			document.getElementById("deskripsi").value = deskripsi;
		});
		
		$(document).on("click", "#hapus_mr", function(){
			$("#modal_hapus").modal('show');
			var id_mr = $(this).attr("dt_id");
			$("#kode").val(id_mr);
			$('.modal-title').text('Hapus Master Reason: '+id_mr); 
			document.getElementById("form_hapus").action = "<?php echo site_url(); ?>master/Master_Reason/action_delete_mr/"+id_mr;
		});
		
	});

</script>

<!-- Bootstrap modal add & update mr-->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Form  </h3>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_mr_lama" name="id_mr_lama">
					<!--<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">ID MR : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="id_mr" class="form-control" name="id_mr" placeholder="Masukkan ID MR" required>
                                </div>
                            </div>
                        </div>
                    </div>-->
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Nama : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama_mr" class="form-control"  name="nama_mr" placeholder="Masukkan nama MR" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Deskripsi : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<textarea id="deskripsi" name="deskripsi" rows="5" class="form-control" placeholder="Masukkan deskripsi" required></textarea>
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
<!-- End Bootstrap modal sdd & update mr-->

<!-- Bootstrap modal delete mr-->
<div class="modal fade" id="modal_hapus" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Hapus </h3>
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
<!-- End Bootstrap modal delete mr-->

