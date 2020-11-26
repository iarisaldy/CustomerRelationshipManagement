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
					<div class="header header-title" >
					<h2>Data Index KPI Sales <small style="color: #fff;">(Data per Sales)</small></h2>
					</div>
					
					<div class="body" style="margin: 1em;">
                        <div class="row">
							<ul class="nav nav-tabs" style="float: right;">
								
								<li class="nav-item">
									<a class="nav-link" href="<?php echo site_url(); ?>master/KPI_Sales_SBI_Per_Distributor">Data per Distributor</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo site_url(); ?>master/KPI_Sales_Per_Area">Data per Area</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo site_url(); ?>master/KPI_Sales_Per_Provinsi">Data per Provinsi</a>
								</li>
								<li class="nav-item" >
									<a class="nav-link" href="#"><b style="color: #0097e6;" disabled="disabled">(Data per Sales)</b></a>
								</li>
							</ul>
							

							<button id="btn_add" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em;"><i class="glyphicon glyphicon-plus"></i> Tambah Index KPI</button>

							<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>NO.</th>
										<th>SALES</th>
										<th>VISIT</th>
										<th>CUSTOMER ACTIVE</th>
										<th>NOO</th>
										<th>VOLUME</th>
										<th>HARGA</th>
										<th>REVENUE</th>
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
												$this_sales = $this->M_KPI_Sales_Per_Sales->get_sales($dt->ID_SALES);
												echo $this_sales->NAMA;
											?>
										</td>
										<td><?= $dt->VISIT;?></td>
										<td><?= $dt->CUSTOMER_AKTIVE;?></td>
										<td><?= $dt->NOO;?></td>
										<td><?= $dt->VOLUME_SEL_OUT;?></td>
										<td><?= $dt->HARGA;?></td>
										<td><?= $dt->REVENUE;?></td>
										<!--
										<td><?= $dt->CREATE_DATE;?></td>
										
										<td><?= $dt->CREATE_BY;?></td>
										<td><?= $dt->UPDATE_DATE;?></td>
										<td><?= $dt->UPDATE_BY;?></td>
										-->
										<td>
										<center>
											<button class="btn btn-warning" id="edit_index" dt_index="<?= $dt->NO_INDEX;?>" dt_sales="<?= $dt->ID_SALES;?>" dt_visit="<?= $dt->VISIT;?>" dt_c_a="<?= $dt->CUSTOMER_AKTIVE;?>" dt_noo="<?= $dt->NOO;?>" dt_vso="<?= $dt->VOLUME_SEL_OUT;?>" dt_harga="<?= $dt->HARGA;?>" dt_revenue="<?= $dt->REVENUE;?>" dt_create_at="<?= $dt->CREATE_DATE;?>"><i class="glyphicon glyphicon-pencil"></i></button>
											<button class="btn btn-danger" id="hapus_index" dt_index="<?= $dt->NO_INDEX;?>" dt_kpi="<?= $this_sales->NAMA; ?>"><i class="glyphicon glyphicon-remove"></i></button>
										</center>
										</td>
									</tr>
									
								<?php }?>
								</tbody>
								<tfoot>
									<tr>
										<th>NO.</th>
										<th>SALES</th>
										<th>VISIT</th>
										<th>CUSTOMER ACTIVE</th>
										<th>NOO</th>
										<th>VOLUME</th>
										<th>HARGA</th>
										<th>REVENUE</th>
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
			$('.modal-title').text('Tambah Index KPI per Sales'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/KPI_Sales_Per_Sales/action_add_data";
		});
		
		$(document).on("click", "#edit_index", function(){
			var sales 			= $(this).attr("dt_sales");
			var dt_id_index 	= $(this).attr("dt_index");
			var dt_visit 		= $(this).attr("dt_visit");
			var dt_c_a			= $(this).attr("dt_c_a");
			var dt_noo			= $(this).attr("dt_noo");
			var dt_vso			= $(this).attr("dt_vso");
			var dt_harga		= $(this).attr("dt_harga");
			var dt_revenue		= $(this).attr("dt_revenue");
			var dt_create_at	= $(this).attr("dt_create_at");
			
			selectedOption(sales);
			
			$("#id_index1").val(dt_id_index);
			$("#visit").val(dt_visit);
			$("#c_a").val(dt_c_a);
			$("#noo").val(dt_noo);
			$("#vso").val(dt_vso);
			$("#harga").val(dt_harga);
			$("#revenue").val(dt_revenue);
			
			$("#create_at").text('Create at: ' +dt_create_at);
			
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Edit Index KPI per Sales:'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/KPI_Sales_Per_Sales/action_update_data";
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
		$("#id_sales").val(pilihan).change();
	}

</script>

<!-- Bootstrap modal add & edit-->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #8c7ae6; padding-bottom:1.5em;">
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
                                    <select class="mdb-select md-form" name="id_sales" id="id_sales" required>
										<option value="" disabled selected>Masukkan pilihan Sales</option>
										<?php 
										foreach($saless as $dt_sales){?>
											<option  value="<?= $dt_sales->ID_USER; ?>"><?= $dt_sales->NAMA; ?></option>
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
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Harga : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="harga" class="form-control" name="harga" placeholder="Masukkan harga" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Revenue : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="revenue" class="form-control" name="revenue" placeholder="Masukkan revenue" required>
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
				<h3 class="modal-title">Hapus  </h3>
			</div>
			<form id="form_hapus" class="form-horizontal" action="<?php echo site_url(); ?>master/KPI_Sales_Per_Sales/action_delete_data" method="post">
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