<style type="text/css">
#maps_toko {
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
                <div class="card">
					<div class="header header-title bg-cyan">
                        <h2>Salesman Route Compliance Report</h2>
                    </div>
					<div class="row">
						<div class="container-fluid">
							<div class="col-md-12" style="padding-bottom:0; margin-bottom:0;">
                                <form method="post" action="<?php echo base_url();?>sbi/Route_compliance_report" enctype="multipart/form-data">
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style=" padding-top: 2em; ">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListGsm"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style=" padding-top: 2em; ">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListRsm"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style=" padding-top: 2em; ">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListAsm"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style=" padding-top: 2em; ">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListTso"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style=" padding-top: 2em; ">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListSales"></div>
                                                        </div>
                                                    </div>
									
                                    <div class="col-md-2" style=" padding-top: 2em; ">
                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <b>Pilih Tanggal</b>
                                                                 <input type="text" id="Datepil" name="tanggal" value="<?php echo date('Y')."-".date('m')."-".date('d') ?>" class="form-control" placeholder="Tanggal">
                                                            </div>
                                        </div>
                                    </div>
                                    <div class="row " style=" padding-left: 2em;">
                                        <br/>
                                        <button id="btnFilter" type="submit" class="btn btn-info"><span class="fa fa-eye"></span> View</button>
                                    </div>
                                   
                                </form>

                            </div>
						</div>
                    </div>
					
					<?php if($this->session->userdata("set_tanda") != 0){
					?>
					
					<div class="row" style="margin: 1em 0 2em 0; padding-bottom: 1em;" id="reporting_view">
						<div class="container-fluid">
							<hr>
							<h4 style="font-weight: normal">Laporan kunjungan:  <span style="font-weight: bold"><?= $this->session->userdata("set_sales");?></span><span style="float: right;">Tanggal: <span style="font-weight: bold"><?= $this->session->userdata("set_tanggal");?></span></span></h4> 
							<hr>
						</div>
                        <div class="container-fluid">
							<div class="col-md-6">
								<div id="maps_toko" style="border-style: groove; height:80%;" ></div>
							</div>
							<div class="col-md-6">
								<div style="">
									<div class="table-responsive">
                                                    <table style="font-size: 12px;" id="tableKunjungan" class="table table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Plan Seq</th>
                                                                <th>Customer</th>
                                                                <th>Time in</th>
                                                                <th>Time out</td>
                                                                <th>Duration</th>
                                                                <th>Penugasan</th>
																<th>Detail</th>
                                                            </tr>
                                                        </thead>
														<tbody>
														 <?php foreach ($kunjungans as $listKunjungan) { ?>
															<tr
																<?php if($listKunjungan->TIME_IN == null) {?> style="background-color: rgba(99, 110, 114,0.9); color: #FFF;" <?php }?>
															>
																<td><?= $listKunjungan->SEQUEN ?></td>
																<td><?= strtoupper($listKunjungan->NAMA_TOKO) ?></td>
																<td><?= $listKunjungan->TIME_IN ?></td>
																<td><?= $listKunjungan->TIME_OUT ?></td>
																<td><?= $listKunjungan->WAKTU_KUNJUNGAN ?></td>
																<td><?= $listKunjungan->KETERANGAN ?></td>
																<td>
																	<?php if($listKunjungan->TIME_IN != null) {?>
																	<center>
																	<a target="_blank" href="<?php echo base_url();?>sales/RoutingCanvasing/detail/<?=$listKunjungan->ID_KUNJUNGAN_CUSTOMER; ?>">
																	<button type="button" class="btn btn-info"><span class="fa fa-eye"></span></button></a>
																	</center>
																	<?php }?>
																</td>
															</tr>
														<?php } ?>	
														</tbody>
														<!--
														<tfoot>
															<tr>
																<th colspan="6" style="text-align: center;">TOTAL</th>
															</tr>
															<tr>
																<th>Waktu di toko</th>
																<th>-</th>
																<th >Waktu di perjalanan</th>
																<th>-</th>
																<th>Waktu di lapangan</th>
																<th colspan="2">-</th>
															</tr>
														</tfoot>
														-->
                                                    </table>
                                    </div>
								</div>
							</div>
                        </div>
					</div>
					
					<?php } ?>
					
				</div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDLcPZk5_QNfhUDokPNILm_jnB7-B7yvoY"></script>
<script>
	var baseUrl = "<?php echo base_url(); ?>";

    var marker_black = baseUrl+'assets/map_icons/hitam_big.png';
    var marker_red = baseUrl+'assets/map_icons/merah_big.png';
    var marker_yellow = baseUrl+'assets/map_icons/kuning_big.png';
    var marker_blue = baseUrl+'assets/map_icons/biru_big.png';
    var marker_green = baseUrl+'assets/map_icons/hijau_big.png';
	var marker_sales = baseUrl+'assets/map_icons/sales_biru.png';
	var toko_merah = baseUrl+'assets/map_icons/toko_merah.png';
	var toko_hitam = baseUrl+'assets/map_icons/toko_hitam.png';
	
    var toko_marker = new Array();
	var kunjung_marker = new Array();
    var infowindow = new google.maps.InfoWindow();
	
	$(document).ready(function(){
		$('#Datepil').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#Datepil').blur(); 
		
		ListGsm("#ListGsm");
		ListRsm("#ListRsm");
		ListAsm("#ListAsm");
		ListTso("#ListTso");
		ListSales("#ListSales");
		
        mapsRouteToko();
		var tanda = <?= $this->session->userdata("set_tanda");?>;
		
		if(tanda == 0){
			$('#reporting_view').hide();
		} else {
			//mapsRouteToko();
			$('#reporting_view').show();
		}
		
		$('#tableKunjungan').DataTable({
			"lengthMenu": [ [10], [10] ]
		});
    });
	
	function hidden_marker(map) {
        for (var i = 0; i < area_marker.length; i++) {
            area_marker[i].setMap(map);
        }
    }

    function hidden_marker_toko(map) {
        for (var i = 0; i < toko_marker.length; i++) {
            toko_marker[i].setMap(map);
        }
    }
	
	function mapsRouteToko(){
		var id_sales = '<?= $this->session->userdata("set_id_sales");?>';
		var tanggalan = '<?= $this->session->userdata("set_tanggal");?>';
		var options = {
            zoom: 11,
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        console.log(id_sales);
		console.log(tanggalan);
        map = new google.maps.Map(document.getElementById('maps_toko'), options);
		///*
		$.ajax({
            "url" : "<?php echo base_url('sbi/Route_compliance_report/koordinatKunjungan'); ?>",
            "type" : "POST", 
            "dataType" : "JSON",
            data: {
                "sales" : id_sales, 
                "tanggal" : tanggalan
            }, 
            success: function(datas){
				var koorkunjung = new Array();
				var koortoko = new Array();
				var count = 0; 
				var texty ;
				$(datas).each(function(kesy, vals){
					count++;
					if(vals.TIME_IN == null){
                        markerIconToko = toko_hitam;
						texty = 'X';
                    } else {
                        markerIconToko = toko_merah;
						texty = count.toString();
                    }  
					console.log(texty);
					var toko_lat = vals.LOKASI_LATITUDE;
                    var toko_long = vals.LOKASI_LONGITUDE;
					tokoMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(toko_lat, toko_long),
                        map: map,
                        draggable: false,
                        animation: google.maps.Animation.DROP,
						icon: {url: markerIconToko, labelOrigin: { x: 16.7, y: -8}},
                        label: {text: vals.NAMA_TOKO.toUpperCase(), color: 'black',  fontSize: '10px'}
                    });
					
					var valueToPush1 = { };
					
					valueToPush1['lat'] = parseFloat(toko_lat);
					valueToPush1['lng'] = parseFloat(toko_long);
					
					if(toko_lat != null){
						koortoko.push(valueToPush1);
					}
					
					var sales_lat = vals.CHECKIN_LATITUDE;
                    var sales_long = vals.CHECKIN_LONGITUDE;
					salesMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(sales_lat, sales_long),
                        map: map,
                        draggable: false,
                        animation: google.maps.Animation.DROP,
						icon: {url: marker_sales, labelOrigin: { x: 19, y: 15}},
                        label: {text: texty, color: 'white',  fontSize: '11px'},
						zIndex: google.maps.Marker.MAX_ZINDEX + 1
                    });
					
					var valueToPush = { };
					
					valueToPush['lat'] = parseFloat(sales_lat);
					valueToPush['lng'] = parseFloat(sales_long);
					
					if(sales_lat != null){
						koorkunjung.push(valueToPush);
					}
					
					console.log(koorkunjung);
				});
				
				
				var flightPath = new google.maps.Polyline({
					  path: koorkunjung,
					  geodesic: true,
					  strokeColor: '#FF0000',
					  strokeOpacity: 1.0,
					  strokeWeight: 3
				});
				flightPath.setMap(map);
				map.setCenter(new google.maps.LatLng(koortoko[0]));
			}
		});
		//*/
	}
	
	function ListGsm(key){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Route_compliance_report/List_gsm",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];
				//console.log(response);
                var type_list = '<b>Filter GSM</b>';
                type_list += '<select id="listGsmVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pilih GSM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listGsmVal", function(){
		var gsm = $(this).val();
		ListRsm("#ListRsm", gsm);
        ListAsm("#ListAsm", gsm, null);
		ListTso("#ListTso", gsm, null, null);
		ListSales("#ListSales", gsm, null, null, null);
		console.log(gsm);
    });
	
	function ListRsm(key, gsm = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Route_compliance_report/List_rsm",
            type: 'POST',
			data: {
					"gsm" : gsm
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];
				//console.log(response);
                var type_list = '<b>Filter SSM</b>';
                type_list += '<select id="listRsmVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pilih SSM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listRsmVal", function(){
		var rsm = $(this).val();
        ListAsm("#ListAsm", null, rsm);
		ListTso("#ListTso", null, rsm, null);
		ListSales("#ListSales", null, rsm, null, null);
		console.log(rsm);
    });
	
	function ListAsm(key, gsm = null, rsm = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Route_compliance_report/List_asm",
            type: 'POST',
			data: {
					"gsm" : gsm,
					"rsm" : rsm
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data']; 
				//console.log(response);
                var type_list = '<b>Filter SM</b>';
                type_list += '<select id="listAsmVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pilih SM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+response[i][1]+'</option>';
					//console.log(response[i][0]);
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listAsmVal", function(){
		var asm = $(this).val();
        ListTso("#ListTso", null, null , asm);
		ListSales("#ListSales", null, null , asm, null);
		console.log(asm);
    });
	
	function ListTso(key, gsm = null, rsm = null, asm = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Route_compliance_report/List_tso",
            type: 'POST',
			data: {
					"gsm" : gsm,
					"rsm" : rsm,
					"asm" : asm
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data']; 
				//console.log(response);
                var type_list = '<b>Filter SO</b>';
                type_list += '<select id="listTsoVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pilih SO</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listTsoVal", function(){
		var tso = $(this).val();
        ListSales("#ListSales", null, null, null , tso);
		console.log(tso);
    });
	
	function ListSales(key, gsm = null, rsm = null, asm = null, tso = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Route_compliance_report/List_sales",
            type: 'POST',
			data: {
					"gsm" : gsm,
					"rsm" : rsm,
					"asm" : asm,
					"tso" : tso
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data']; 
				//console.log(response);
                var type_list = '<b>Filter Sales</b>';
                type_list += '<select id="listSalesVal" name="sales" class="form-control selectpicker show-tick"  data-live-search="true" required>';
                type_list += '<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Pilih Sales</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'-'+response[i][1]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
</script>