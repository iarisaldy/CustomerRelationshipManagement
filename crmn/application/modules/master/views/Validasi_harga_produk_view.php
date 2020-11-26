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
						<h2>Validasi Harga Produk</h2> 
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
						
							<button id="btn_add" class="btn btn-warning" style="margin-bottom: 1em; margin-top: 0.5em 0 0.5em 0;"><i class="glyphicon glyphicon-plus"></i> Tambah harga produk</button>

							<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 5%;">No.</th>
										
										<th>ID PRODUK</th>
										<th>Nama Produk</th>
										<th>Harga Beli</th>
										<th>Harga Jual</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$count = 1;
								foreach($validasi_hargas as $dt){?>
									<tr>
										<td><?= $count++;?></td>
										
										<td><?= $dt->ID_PRODUK;?></td>
										
										<td>
											<?php 
												$this_produk = $this->Validasi_harga_produk_model->get_produk($dt->ID_PRODUK);
												echo $this_produk->NAMA_PRODUK;
											?>
										</td>
										<td><?= $dt->HARGA_BELI_MIN; ?> s/d <?= $dt->HARGA_BELI_MAX; ?></td>
										<td><?= $dt->HARGA_JUAL_MIN; ?> s/d <?= $dt->HARGA_JUAL_MAX; ?></td>
										<td>
										<center>
											<button class="btn btn-warning" id="edit_produk" dt_id_produk="<?= $dt->ID_PRODUK;?>" dt_nama_produk="<?= $this_produk->NAMA_PRODUK;?>" dt_hb_min="<?= $dt->HARGA_BELI_MIN;?>" dt_hb_max="<?= $dt->HARGA_BELI_MAX;?>" dt_hj_min="<?= $dt->HARGA_JUAL_MIN;?>" dt_hj_max="<?= $dt->HARGA_JUAL_MAX;?>"  dt_create_at="<?= $dt->CREATE_AT;?>"><i class="glyphicon glyphicon-pencil"></i></button>
											<button class="btn btn-danger" id="hapus_produk" dt_id_produk="<?= $dt->ID_PRODUK; ?>" dt_nama_produk="<?= $this_produk->NAMA_PRODUK;?>"><i class="glyphicon glyphicon-remove"></i></button>
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
			$('.modal-title').text('Tambah Validasi Harga Produk'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Validasi_harga_produk/action_add_data";
		});
		
		$(document).on("click", "#edit_produk", function(){
			var dt_id_produk 		= $(this).attr("dt_id_produk");
			var dt_nama_produk	 	= $(this).attr("dt_nama_produk");
			var dt_hb_min			= $(this).attr("dt_hb_min");
			var dt_hb_max			= $(this).attr("dt_hb_max");
			var dt_hj_min			= $(this).attr("dt_hj_min");
			var dt_hj_max			= $(this).attr("dt_hj_max");
			var dt_create_at		= $(this).attr("dt_create_at");
			
			$("#id_produk").val(dt_id_produk).change();
			$("#id_produk").prop("disabled", true);
			var datakus = $("#id_produk_hide").val(dt_id_produk);
			$("#hb_min").val(dt_hb_min);
			$("#hb_max").val(dt_hb_max);
			$("#hj_min").val(dt_hj_min);
			$("#hj_max").val(dt_hj_max);
			$("#create_at").text('Create at: ' +dt_create_at);
			//console.log(datakus);
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Edit Validasi harga produk:'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Validasi_harga_produk/action_update_data";
		});
		
		$(document).on("click", "#hapus_produk", function(){
			$("#modal_hapus").modal('show');
			var dt_produk 			= $(this).attr("dt_id_produk");
			var dt_nm_produk		= $(this).attr("dt_nama_produk");
			//console.log(dt_id_radius_area);
			$("#id_produk1").val(dt_produk);
			$('.modal-title').text('Hapus Validasi Harga Produk: '+dt_nm_produk); 
		});
		
	});
	
</script>

<!-- Bootstrap modal add & edit-->
<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0.5em;">
			<div class="modal-header" style="background-color: #FF9600;color: white; padding-bottom:1.5em;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title">Form</h2>
			</div>
			<form id="form" class="form-horizontal" action="/" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0.5em;">
						<input type="hidden" id="id_produk_hide" name="id_produk_hide" >
						
						<label for="nama">Pilih Produk</label>
						<div class="form-group" style="margin-left: 0.3em;">
							<select class="form-control show-tick" name="id_produk" id="id_produk" required>
                                <option value="" disabled selected>Masukkan pilihan produk</option>
								<?php 
									foreach($produks as $dt_produk){?>
										<option  value="<?= $dt_produk->ID_PRODUK; ?>"><?= $dt_produk->NAMA_PRODUK; ?></option>
								<?php } ?>
							</select>	
						</div>
					</div>
					
					
					<div  >
					<br>
					<!-- 
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="name">Pilih Produk : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="mdb-select md-form" name="id_produk" id="id_produk" required>
										<option value="" disabled selected>Masukkan pilihan produk</option>
										<?php 
										foreach($produks as $dt_produk){?>
											<option  value="<?= $dt_produk->ID_PRODUK; ?>"><?= $dt_produk->NAMA_PRODUK; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                        </div>
					-->
                    </div>
					
					<div class="row clearfix" style="padding-top: 2em;">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Harga Beli : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="hb_min" class="form-control" name="hb_min" placeholder="Masukkan harga beli minimal" required>
                                </div>
                            </div>
							<div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="hb_max" class="form-control" name="hb_max" placeholder="Masukkan harga beli maksimal" required>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Harga Jual : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="hj_min" class="form-control" name="hj_min" placeholder="Masukkan harga jual minimal" required>
                                </div>
                            </div>
							<div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="hj_max" class="form-control" name="hj_max" placeholder="Masukkan harga jual maksimal" required>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="create_at" style="float: left; padding: 0.5em 0 0 0.5em"> </span>
				<button type="submit" class="btn btn-info">Simpan</button>
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
			<form id="form_hapus" class="form-horizontal" action="<?php echo site_url(); ?>master/Validasi_harga_produk/action_delete_data" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_produk1" name="id_produk1">
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