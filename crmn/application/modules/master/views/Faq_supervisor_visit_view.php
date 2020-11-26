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
						<h2>FAQ Supervisor Visit</h2> 
					</div>
					<div class="body" style="margin: 0 1em 0 1em;">
                        <div class="row">
						
							<button id="btn_add" class="btn btn-success" style="margin-bottom: 1em; margin-top: 0.5em 0 0.5em 0;"><i class="glyphicon glyphicon-plus"></i> FAQ (Frequently Asked Questions)</button>

							<table id="table_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 5%;">No.</th>
										
										<th>Pertanyaan</th>
										<th>Jawaban</th>
										
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$count = 1;
								foreach($faqs as $dt){?>
									<tr>
										<td><?= $count++;?></td>
										
										<td><?= $dt->PERTANYAAN; ?> </td>
										<td><?= $dt->JAWABAN; ?> </td>
										<td>
										<center>
											<button class="btn btn-warning" id="edit_produk" dt_id_faq="<?= $dt->ID_FAQ;?>" dt_tanya="<?= $dt->PERTANYAAN;?>" dt_jawab="<?= $dt->JAWABAN;?>" dt_create_at="<?= $dt->CREATE_AT;?>"><i class="glyphicon glyphicon-pencil"></i></button>
											<button class="btn btn-danger" id="hapus_produk" dt_id_faq="<?= $dt->ID_FAQ;?>" dt_tanya="<?= $dt->PERTANYAAN;?>" dt_jawab="<?= $dt->JAWABAN;?>"><i class="glyphicon glyphicon-remove"></i></button>
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
			$('.modal-title').text('Tambah FAQ (Frequently Asked Questions)'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Faq_supervisor_visit/action_add_data";
		});
		
		$(document).on("click", "#edit_produk", function(){
			var dt_id_faq 		= $(this).attr("dt_id_faq");
			var dt_tanya		= $(this).attr("dt_tanya");
			var dt_jawab		= $(this).attr("dt_jawab");
			var dt_create_at		= $(this).attr("dt_create_at");
			
			$("#id_faq").val(dt_id_faq);
			$("#tanya").val(dt_tanya);
			$("#jawab").val(dt_jawab);
			$("#create_at").text('Create at: ' +dt_create_at);
			//console.log(datakus);
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Edit FAQ (Frequently Asked Questions):'); // Set Title to Bootstrap modal title 
			document.getElementById("form").action = "<?php echo site_url(); ?>master/Faq_supervisor_visit/action_update_data";
		});
		
		$(document).on("click", "#hapus_produk", function(){
			$("#modal_hapus").modal('show');
			var dt_id_faq 		= $(this).attr("dt_id_faq");
			var dt_tanya		= $(this).attr("dt_tanya");
			var dt_jawab		= $(this).attr("dt_jawab");
			//console.log(dt_id_radius_area);
			$("#id_faq1").val(dt_id_faq);
			//$('.modal-title').text('Hapus Validasi Harga Produk: '+dt_nm_produk); 
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
					<input type="hidden" id="id_faq" name="id_faq" >
					
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Pertanyaan : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
									<textarea id="tanya" name="tanya" rows="4" cols="50" class="form-control" placeholder="Masukkan pertanyaan" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 form-control-label">
                            <label for="Radius Lock">Jawaban : </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
                            <div class="form-group">
                                <div class="form-line">
                                   <textarea id="jawab" name="jawab" rows="6" cols="50" class="form-control" placeholder="Masukkan jawaban" required></textarea>
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
			<form id="form_hapus" class="form-horizontal" action="<?php echo site_url(); ?>master/Faq_supervisor_visit/action_delete_data" method="post">
			<div class="modal-body form">
				<div class="form-body">
					<input type="hidden" id="id_faq1" name="id_faq1">
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