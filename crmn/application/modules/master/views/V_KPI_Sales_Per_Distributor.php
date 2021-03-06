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
					<h3>Data Index KPI Sales <small>(Data per Distributor)</small></h3>
					<hr />
					
					<ul class="nav nav-tabs" style="float: right;">
						<li class="nav-item" >
							<a class="nav-link" href="#"><b style="color: #0097e6;" disabled="disabled">(Data per Distributor)</b></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#1">Data per Area</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#2">Data per Provinsi</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#3">Data per Sales</a>
						</li>
					</ul>
					

					<button id="btn_add" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em;"><i class="glyphicon glyphicon-plus"></i> Tambah Index KPI</button>

					<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
					  	<thead>
							<tr>
						 		<th>NO.</th>
								<th>DISTRIBUTOR</th>
								<th>VISIT</th>
								<th>CUSTOMER ACTIVE</th>
								<th>NOO</th>
								<th>VOLUME</th>
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
					  	foreach($index_kpi as $dt){?>
					  		<tr>
							    <td><?= $count++;?></td>
							    <td>
									<?php 
										$this_dist = $this->M_KPI_Sales_Per_Distributor->get_distributor($dt->ID_DISTRIBUTOR);
										echo $this_dist->NAMA_DISTRIBUTOR;
									?>
								</td>
							    <td><?= $dt->VISIT;?></td>
								<td><?= $dt->CUSTOMER_AKTIVE;?></td>
								<td><?= $dt->NOO;?></td>
								<td><?= $dt->VOLUME_SEL_OUT;?></td>
								<!--
							    <td><?= $dt->CREATE_DATE;?></td>
								
							    <td><?= $dt->CREATE_BY;?></td>
							    <td><?= $dt->UPDATE_DATE;?></td>
							    <td><?= $dt->UPDATE_BY;?></td>
								-->
							    <td>
								<center>
									<button class="btn btn-warning" id="edit_index" dt_index="<?= $dt->NO_INDEX;?>" dt_dist="<?= $dt->ID_DISTRIBUTOR;?>" dt_visit="<?= $dt->VISIT;?>" dt_c_a="<?= $dt->CUSTOMER_AKTIVE;?>" dt_noo="<?= $dt->NOO;?>" dt_vso="<?= $dt->VOLUME_SEL_OUT;?>" dt_create_at="<?= $dt->CREATE_DATE;?>"><i class="glyphicon glyphicon-pencil"></i></button>
						 			<button class="btn btn-danger" id="hapus_index" dt_index="<?= $dt->NO_INDEX;?>" dt_kpi="<?= $this_dist->NAMA_DISTRIBUTOR; ?>"><i class="glyphicon glyphicon-remove"></i></button>
								</center>
					   			</td>
					 		</tr>
							
					 	<?php }?>
				   		</tbody>
				   		<tfoot>
							<tr>
					  			<th>NO.</th>
								<th>DISTRIBUTOR</th>
								<th>VISIT</th>
								<th>CUSTOMER ACTIVE</th>
								<th>NOO</th>
								<th>VOLUME</th>
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
			$("#create_at").text('');
			$('#form').get(0).reset(); // reset form on modals
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Tambah Index KPI per Distributor'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/KPI_Sales_Per_Distributor/action_add_data";
		});
		
		$(document).on("click", "#edit_index", function(){
			var distributor = $(this).attr("dt_dist");
			var dt_id_index = $(this).attr("dt_index");
			var dt_visit 		= $(this).attr("dt_visit");
			var dt_c_a			= $(this).attr("dt_c_a");
			var dt_noo			= $(this).attr("dt_noo");
			var dt_vso			= $(this).attr("dt_vso");
			var dt_create_at	= $(this).attr("dt_create_at");
			
			selectedOption(distributor);
			
			$("#id_index1").val(dt_id_index);
			$("#visit").val(dt_visit);
			$("#c_a").val(dt_c_a);
			$("#noo").val(dt_noo);
			$("#vso").val(dt_vso);
			
			$("#create_at").text('Create at: ' +dt_create_at);
			
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Edit Index KPI per Distributor:'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/KPI_Sales_Per_Distributor/action_update_data";
		});
		
		$(document).on("click", "#hapus_index", function(){
			$("#modal_hapus").modal('show');
			var dt_kpi 		= $(this).attr("dt_kpi");
			var dt_id_index = $(this).attr("dt_index");
			$("#id_index").val(dt_id_index);
			$('.modal-title').text('Hapus Index KPI Sales : '+dt_kpi); 
		});
	
	});
	
	function selectedOption(pilihan){
		$("#id_dist").val(pilihan).change();
	}

</script>

<!-- Bootstrap modal add -->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Form</h3>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_index1" name="id_index">
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Distributor : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="mdb-select md-form" name="id_dist" id="id_dist" required>
										<option value="" disabled selected>Masukkan pilihan distributor</option>
										<?php 
										foreach($distributors as $dt_dist){?>
											<option  value="<?= $dt_dist->KODE_DISTRIBUTOR; ?>"><?= $dt_dist->NAMA_DISTRIBUTOR; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Visit : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="visit" class="form-control"  name="visit" placeholder="Masukkan visit" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Costumer Active : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="c_a" class="form-control"  name="c_a" placeholder="Masukkan costumer active" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">NOO : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="noo" class="form-control"  name="noo" placeholder="Masukkan data NOO" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Volume Sel Out : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="vso" class="form-control"  name="vso" placeholder="Masukkan volume sel out" required>
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
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Hapus  </h3>
			</div>
			<form id="form_hapus" class="form-horizontal" action="<?php echo site_url(); ?>master/KPI_Sales_Per_Distributor/action_delete_data" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_index" name="id_index">
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