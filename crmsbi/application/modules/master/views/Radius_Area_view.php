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


<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="card">
					<div class="header header-title">
						<h2>Setting Radius Lock Area</h2>
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
						
							<button id="btn_add" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em 0 0.5em 0;"><i class="glyphicon glyphicon-plus"></i> Tambah Setting Radius Area</button>

							<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 5%;">No.</th>
										<!--
										<th>Kode Area</th>
										-->
										<th>Nama Area</th>
										<th>Radius Lock</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$count = 1;
								foreach($radius_areas as $dt){?>
									<tr>
										<td><?= $count++;?></td>
										<!--
										<td><?= $dt->ID_AREA;?></td>
										-->
										<td>
											<?php 
												$this_area = $this->Master_Radius_Area_model->get_area($dt->ID_AREA);
												echo $this_area->NAMA_AREA;
											?>
										</td>
										<td><?= $dt->RADIUS_LOCK; ?></td>
										<td>
										<center>
											<button class="btn btn-warning" id="edit_radius" dt_id_radius_area="<?= $dt->ID_RADIUS_AREA;?>" dt_area="<?= $dt->ID_AREA;?>" dt_radius_lock="<?= $dt->RADIUS_LOCK;?>"  dt_create_at="<?= $dt->CREATED_AT;?>"><i class="glyphicon glyphicon-pencil"></i></button>
											<button class="btn btn-danger" id="hapus_radius" dt_id_radius_area="<?= $dt->ID_RADIUS_AREA;?>" dt_area="<?= $this_area->NAMA_AREA; ?>"><i class="glyphicon glyphicon-remove"></i></button>
										</center>
										</td>
									</tr>
								<?php }?>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
				
			</div>
        </div>
    </div>
</section>

<script>

	$(document).ready(function() {
    	$('#table_data').DataTable();
		
		$(document).on("click", "#btn_add", function(){
			$("#create_at").text('');
			$('#form').get(0).reset(); // reset form on modals
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Tambah Setting Radius Lock Area'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Radius_Area/action_add_data";
		});
		
		$(document).on("click", "#edit_radius", function(){
			var area 				= $(this).attr("dt_area");
			var dt_id_radius_area 	= $(this).attr("dt_id_radius_area");
			var dt_radius_lock		= $(this).attr("dt_radius_lock");
			var dt_create_at		= $(this).attr("dt_create_at");
			
			$("#id_area").val(area).change();
			$("#id_radius_area").val(dt_id_radius_area);
			$("#radius_lock").val(dt_radius_lock);
			
			$("#create_at").text('Create at: ' +dt_create_at);
			
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Edit Radius Lock Area:'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Radius_Area/action_update_data";
		});
		
		$(document).on("click", "#hapus_radius", function(){
			$("#modal_hapus").modal('show');
			var dt_area 			= $(this).attr("dt_area");
			var dt_id_radius_area 	= $(this).attr("dt_id_radius_area");
			//console.log(dt_id_radius_area);
			$("#id_radius_area1").val(dt_id_radius_area);
			$('.modal-title').text('Hapus Setting Radius Lock: '+dt_area); 
		});
		
	});
	
</script>

<!-- Bootstrap modal add & edit-->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title">Form</h2>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_radius_area" name="id_radius_area">
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Pilih Area : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="mdb-select md-form" name="id_area" id="id_area" required>
										<option value="" disabled selected>Masukkan pilihan Area</option>
										<?php 
										foreach($areas as $dt_area){?>
											<option  value="<?= $dt_area->ID_AREA; ?>"><?= $dt_area->NAMA_AREA; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Radius Lock : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="radius_lock" class="form-control" name="radius_lock" placeholder="Masukkan radius lock" required>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="create_at" style="float: left; padding: 0.5em 0 0 0.5em"> </span>
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal add-->

<!-- Bootstrap modal delete-->
<div class="modal fade" id="modal_hapus" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title">Hapus  </h2>
			</div>
			<form id="form_hapus" class="form-horizontal" action="<?php echo site_url(); ?>master/Radius_Area/action_delete_data" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_radius_area1" name="id_radius_area1">
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
<!-- End Bootstrap modal delete-->