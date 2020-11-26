<style type="text/css">
#maps {
	height: 480px;
	position: relative;
	overflow: hidden;
	width: 100%;
}
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
            <div class="card" style="padding-bottom: 0;">
					<div class="header bg-cyan">
                        <h2 style="padding-top: 0.2em;">CUSTOMER PROFIL </h2>
                    </div>
					
                    <div class="body">
                        <div class="row">
                            
                            	
                            		<div class="col-md-12">
										
										<div class="col-xs-12 col-sm-8">
											<div class="card">
												<div class="header bg-pink">
													<center><h2 style="padding-top: 0.2em;">DETAIL CUSTOMER</h2></center>
												</div>
												<div class="body">
													<div class="col-md-2">
														<img class="img-responsive" style="width: 100%;" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/shop-icon.png">
														
													</div>
													<div class="col-md-10"><h2><?= $dt_customer[0]['NAMA_TOKO']; ?></h2>
													<p>Kode / ID : <?= $id; ?></p>
													</div>
													<br>
													<hr>
													<div>
														<ul class="nav nav-tabs" role="tablist">
															<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>Informasi Profil</b></a></li>
															<li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab"><b>Mapping Customer</b></a></li>
															<li role="presentation"><a href="#His_Kunjung" aria-controls="His_Kunjung" role="tab" data-toggle="tab"><b>Histori Kunjungan</b></a></li>
														</ul>
														<div class="tab-content">
															<div role="tabpanel" class="tab-pane fade in active" id="home">
																<div class="block-header">
																	<h2>
																		<i class="fa fa-user"></i> &nbsp; NAMA PEMILIK
																		<small><?= $dt_customer[0]['NAMA_PEMILIK'] ?></small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		<i class="fa fa-phone"></i> &nbsp; TELEPON
																		<small>
																		<?php if($dt_customer[0]['TELP_TOKO'] != null){
																			echo $dt_customer[0]['TELP_TOKO'];
																		} else {
																			echo "-";
																		} ?>
																		</small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		<i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp; ALAMAT
																		<small><?= $dt_customer[0]['ALAMAT'] ?>, <?= $dt_customer[0]['NAMA_KECAMATAN'] ?>, <?= $dt_customer[0]['NAMA_DISTRIK'] ?>, <?= $dt_customer[0]['NAMA_PROVINSI'] ?> [<?= $dt_customer[0]['NAMA_AREA'] ?> - REGION <?= $dt_customer[0]['NEW_REGION']?>] </small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		<i class="fa fa-cubes" aria-hidden="true"></i> &nbsp; KAPASITAS TOKO
																		<small><b>
																		<?php if($dt_customer[0]['KAPASITAS_ZAK'] != null){
																			echo $dt_customer[0]['KAPASITAS_ZAK']. " Zak";
																		} else {
																			echo "-";
																		} ?>  </b></small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		<i class="fa fa-calendar-check-o" aria-hidden="true"></i> &nbsp; UPDATE KUNJUNGAN TERAKHIR 
																		
																		<?php if($dt_kunjung != false){ ?>
																		<a target="_blank" href="<?php echo base_url();?>sales/RoutingCanvasing/detail/<?= $dt_kunjung[0]['ID_KUNJUNGAN_CUSTOMER'] ;?>" ><span style="float:right;margin-top: 1em;" type="button" class="btn btn-sm bg-blue waves-effect"><i class="fa fa-external-link" aria-hidden="true"></i> &nbsp; Detail Kunjungan</span></a>
																		<small><?= $dt_kunjung[0]['UPDATEKUNJUNGAN'] ?> </small>
																		<?php } else { echo "<small>Belum Ada Kunjungan</small>"; } ?>
																		
																	</h2>
																	
																</div>
															</div>
															<div role="tabpanel" class="tab-pane fade in" id="profile_settings">
																<div class="block-header">
																	<h2>
																		DISTRIBUTOR
																		<small>
																			<?php 
																			if($dt_mapping != false){
																				$a = 1;
																				foreach($dt_mapping as $mapping){
																					echo "[".$a++."] ".$mapping['NAMA_DISTRIBUTOR']." &nbsp; ";
																				} 
																			} else {
																				echo "-";
																			} ?>
																		</small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		SALES
																		<small>
																		<?php
																		if($dt_mapping != false){
																			$b = 1;
																			foreach($dt_mapping as $mapping){
																				echo "[".$b++."] ".$mapping['NAMA_SALES']." &nbsp; ";
																			} 
																		} else {
																			echo "-";
																		} ?>
																		</small>
																	</h2>
																</div>
																<hr>
																<!--
																<div class="block-header" >
																	<h2>
																		TSO
																		<small>
																		<?php 
																		if($dt_mapping != false){
																			$c = 1;
																			foreach($dt_mapping as $mapping){
																				echo "[".$c++."] ".$mapping['NAMA_TSO']." &nbsp; ";
																			} 
																		} else {
																			echo "-";
																		} ?>
																		</small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		ASM
																		<small>
																		<?php 
																		if($dt_mapping != false){
																			$d = 1;
																			foreach($dt_mapping as $mapping){
																				echo "[".$d++."] ".$mapping['NAMA_ASM']." &nbsp; ";
																			}
																		} else {
																			echo "-";
																		} ?>
																		</small>
																	</h2>
																</div>
																<hr>
																<div class="block-header">
																	<h2>
																		RSM
																		<small>
																		<?php 
																		if($dt_mapping != false){
																			$e = 1;
																			foreach($dt_mapping as $mapping){
																				echo "[".$e++."] ".$mapping['NAMA_RSM']." &nbsp; ";
																			} 
																		} else {
																			echo "-";
																		} ?>
																		</small>
																	</h2>
																</div>
																-->
															</div>
															<div role="tabpanel" class="tab-pane fade in" id="His_Kunjung">
																<div class="block-header">
																	<div class="table-responsive">
																		<table style="font-size: 10px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_report">
																			<thead class="w">
																				<tr>
																					<th width="2%">No</th>
																					<th>Rencana Kunjungan</th>
																					<th>Supervisor</th>
																					<th>Dikunjungi</th>
																					<th>Penugasan</th>
																					<th style="text-align:center;">Detail</th>
																				</tr>
																			</thead>
																			<tbody class="y" id="show_data">
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
														
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-4">
											<div class="card">
												<div class="header bg-pink">
													<center><h2 style="padding-top: 0.2em;">KOORDINAT LOKASI 
													<b style="color: yellow;">
													<?php 
													if($dt_customer[0]['LONGITUDE'] != null){
														if($dt_customer[0]['KOORDINAT_LOCK'] == 1){
															echo "[LOCKED]";
														} else {
															echo "[UNLOCKED]";
														} 
													} else {
														echo "<p style='margin-top: 10em;color:red;'>[BELUM DITENTUKAN]</p>";
													}
													?>
													
													</b></h2></center>
												</div>
												<div class="body">
													<div id="maps" style="border-style: groove;"></div>
													<?php if($dt_customer[0]['LONGITUDE'] != null){ ?>
													<center><p>Lng: <?= $dt_customer[0]['LONGITUDE'] ?> | Ltd: <?= $dt_customer[0]['LATITUDE'] ?></p></center>
													<?php if($this->session->userdata('id_jenis_user') == '1009'){ ?>
														
														<?php if($dt_customer[0]['KOORDINAT_LOCK'] == 1){ ?>
															 <a href="<?php echo base_url();?>customer/Profil/set_unlock" onClick="return doconfirm();"><button type="button" class="btn btn-block btn-lg btn-info waves-effect"><i class="fa fa-unlock" aria-hidden="true"></i> &nbsp; UNLOCK</button></a>
														<?php } else { ?>
															 <a href="<?php echo base_url();?>customer/Profil/set_lock" onClick="return doconfirm();"><button type="button" class="btn btn-block btn-lg bg-red waves-effect"><i class="fa fa-lock" aria-hidden="true"></i> &nbsp; LOCK</button></a>
														<?php }
														}
													}
													?>
														
												</div>
											</div>
										</div>
                                    </div>
                            	
                            	
                            	
                           
                    </div>
                </div>
				
			</div>
		</div>
    </div>
</section>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDLcPZk5_QNfhUDokPNILm_jnB7-B7yvoY"></script>
<script>
	$('document').ready(function(){
		load_data(<?= $id; ?>);
		
		//console.log(<?= $id; ?>);
	
		var latitude = <?= $dt_customer[0]['LATITUDE'] ?>;
        var longitude = <?= $dt_customer[0]['LONGITUDE'] ?>;
        var myLatLng = {lat: latitude, lng: longitude};
        
        var options = {
            zoom: 16,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: false
		};
        
        map = new google.maps.Map(document.getElementById('maps'), options);
        var marker = {
            position: myLatLng,
            map: map,
        }
            
        mapmarker = new google.maps.Marker(marker);
		mapmarker.setAnimation(google.maps.Animation.BOUNCE);
	});

	function doconfirm(){
		job=confirm("Apakah Anda Yakin?");
		if(job!=true)
		{
			return false;
		}
	}
	
	function load_data(customer_in){
		$("#show_data").html('<tr><td colspan="11"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>customer/Profil/HisKunjungan',
			type: 'POST',
			dataType : 'json',
			data: {
				"customer" : customer_in
			},
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					var status = "";
					var button = "";
					
					if(data[i].DIKUNJUNGI == null){
						status = '<td>Tidak Dikunjungi</td>';
						button = '<td style="text-align: center;">-</td>';
					} else {
						status = '<td>'+data[i].DIKUNJUNGI+'</td>';
						button = '<td><center><a target="_blank" href="<?php echo base_url();?>sales/RoutingCanvasing/detail/'+data[i].ID_KUNJUNGAN+'"><button type="button" class="btn btn-info"><span class="fa fa-eye"></span></button></a></center></td>';
					}
					
					html += '<tr class='+c+'>'+
					'<td>'+no+'</td>'+
					'<td>'+data[i].RENCANA+'</td>'+
					'<td>'+data[i].NAMA_USER+'</td>'+
					status+
					'<td>'+data[i].KETERANGAN+'</td>'+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$('#show_data').html(html);
				$("#daftar_report").dataTable({
					"aLengthMenu": [5]
				});
			},
			error: function(){
			}
		});
	}
	
	
</script>
