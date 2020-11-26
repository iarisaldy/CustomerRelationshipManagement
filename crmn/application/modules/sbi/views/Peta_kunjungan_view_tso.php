<style type="text/css">
#maps_toko {
    height: 510px;
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
                        <h2>Peta Kunjungan Toko</h2>
                    </div>
                    <div class="body">
                        <div class="row">
							<div class="col-md-12" style="padding-bottom:0; margin-bottom:0;">
                                <form >
                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Awal</b>
													<input type="text" id="startDate" value="<?php echo date('Y-m-d', strtotime('-14 days')); ?>" class="form-control" placeholder="Tanggal Awal">
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tanggal Akhir</b>
													<input type="text" id="endDate" value="<?php $currentDateTime = date('Y-m-d'); echo $currentDateTime; ?>" class="form-control" placeholder="Tanggal Akhir">
												</div>
											</div>
										</div>
                                    <div class="col-md-2" style=" padding-top: 2em;">
                                        <button id="btnFilter" type="button" class="btn btn-info"><span class="fa fa-eye"></span> View</button>
                                    </div>
                                </form>
									<div class="col-md-12" id="load_data" ></div>
                                    <div class="col-md-12" style="float: right; border-style: double; padding-top: 1.5em; ">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/hijau_big.png">
										</div>
										<div class="col-lg-2 col-md-11 col-sm-11 col-xs-11" >
											<p>: Dikunjungi 1-3  Hari </br>&nbsp; [<span id="A">0</span>]</p>
										</div> 
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/kuning_big.png">
										</div>
										<div class="col-lg-2 col-md-11 col-sm-11 col-xs-11" >
											<p>: Kunjungan Trakhir 4-7 Hari </br>&nbsp; [<span id="B">0</span>]</p>
										</div>  
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/merah_big.png">
										</div> 
										<div class="col-lg-2 col-md-11 col-sm-11 col-xs-11" >
											<p>: Kunjungan Trakhir > 7 Hari </br> &nbsp; [<span id="C">0</span>]</p>
										</div>  
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/hitam_big.png">
										</div>
										<div class="col-lg-2 col-md-11 col-sm-11 col-xs-11" >
											<p>: Tidak dikunjungi </br>&nbsp; [<span id="D">0</span>]</p>
										</div> 
                                    </div>
                                    <div class="col-md-1 col-xs-12" style="float: right; border-style: double; padding-top: 1.5em; display: none;">
                                        <center>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/biru.png" width="87%">
										</div>
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" style="padding: 0 0 0 0">
											<p style="font-weight: bold;font-size:12.5px" id="in_area">AREA</p>
										</div>  
                                        </center>
                                    </div>
                            </div>
							
                            <div class="container-fluid">
                                <div id="maps_toko" style="border-style: groove; "></div>
                                <div> 
                                    <p style="color: red;" id="note_note">
                                    
                                    </p>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDLcPZk5_QNfhUDokPNILm_jnB7-B7yvoY"></script>
<script type="text/javascript">
	var baseUrl = "<?php echo base_url(); ?>";

    var marker_black = baseUrl+'assets/map_icons/hitam_big.png';
    var marker_red = baseUrl+'assets/map_icons/merah_big.png';
    var marker_yellow = baseUrl+'assets/map_icons/kuning_big.png';
    var marker_blue = baseUrl+'assets/map_icons/biru_big.png';
    var marker_green = baseUrl+'assets/map_icons/hijau_big.png';

    var area_marker = new Array();
    var toko_marker = new Array();
    var infowindow = new google.maps.InfoWindow();

    $(document).ready(function(){
        mapsToko();
		$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    });
	
	$(document).on("click", "#btnFilter", function(){
		mapsToko();
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
    
    function mapsToko(){
		
		$("#load_data").html('<br><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center><br>');
		
        var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
        
        var options = {
            zoom: 8,
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('maps_toko'), options);
		$.ajax({
			"url" : "<?php echo base_url('sbi/Peta_kunjungan/petaTokoTso'); ?>",
			"type" : "POST", 
			"dataType" : "JSON",
			data: {
				"stardate" : startDate, 
				"enddate"  : endDate
			},
			success: function(datas){
				//console.log(datas);
				var koortoko = new Array();
				$(datas).each(function(kesy, vals){
					if(vals.MARKER == "BLACK"){
						markerIconToko = marker_black;
					}else if(vals.MARKER == "GREEN"){
						markerIconToko = marker_green;
					} 
					else if(vals.MARKER == "YELLO"){
						markerIconToko = marker_yellow;
					}else{
						markerIconToko = marker_red;
					}
					 
					var info_cus = 
						'<div class="blog-card">'+
						'<div class="description">'+
						'<h5 style="margin-top:6px;text-align: center;margin-bottom:15px;">'+vals.NAMA_TOKO+' ('+vals.KD_CUSTOMER+')</h5>'+
						'<p class="summary" style="margin-top: -10px;"></p>'+
						'<div style="width: 450px; height: 150px; overflow-y: scroll;">'+
							'<table class="table" style="font-size:13px;">'+
								 '<tr>'+
									'<td class="text-head">Sales</td>'+
									'<td class="text-val">'+vals.SALES+'</td>'+
								'</tr>'+
								'<tr>'+
									'<td class="text-head">Alamat</td>'+
									'<td class="text-val">'+vals.ALAMAT+', Kec. '+vals.NAMA_KECAMATAN+', Kab. '+vals.NAMA_DISTRIK+'</td>'+
								'</tr>'+
								'<tr>'+
									'<td class="text-head">Pemilik / Telp.</td>'+
									 '<td class="text-val" id="hh">'+vals.PEMILIK+' / '+vals.TELP_TOKO+' </td>'+
								'</tr>'+
								'<tr>'+
									'<td class="text-head">Area</td>'+
									'<td class="text-val">'+vals.AREA+'</td>'+
								'</tr>'+
								'<tr>'+
									'<td class="text-head">Kapasitas Gudang Toko</td>'+
									'<td class="text-val">'+vals.KAPASITAS_ZAK+'</td>'+
								'</tr>'+
							'</table>'+
							'<table id="tableJadwal" class="table table-bordered table-striped" style="font-size:13px;"></table>'+
						'</div>'+
						'</div>'+
						'</div>';
					
					$('#A').text(vals.A);
					$('#B').text(vals.B);
					$('#C').text(vals.C);
					$('#D').text(vals.OFF_JADWAL);
					
				   // $('#in_area').text(vals.AREA);
					var note = "SUMMARY: Total Toko[ "+vals.JUMLAH_TOKO+" ] Total Kunjungan [ "+vals.JUMLAH_KUNJUNGAN+" ] Data Dispay [ "+vals.ON_KOOR+" ]";
					if(vals.OFF_KOOR != 0){
						$('#note_note').text(note);
					}
					var idsurvey = vals.ID_KUNJUNGAN_CUSTOMER;
					var toko_lat = vals.LATITUDE;
					var toko_long = vals.LONGITUDE;
					
					

					tokoMarker = new google.maps.Marker({
						position: new google.maps.LatLng(toko_lat, toko_long),
						map: map,
						draggable: false,	
						animation: google.maps.Animation.DROP,
						icon : markerIconToko
					});
					var valueToPush1 = { };
	
					valueToPush1['lat'] = parseFloat(toko_lat);
					valueToPush1['lng'] = parseFloat(toko_long);
					
					if(toko_lat != null){
						koortoko.push(valueToPush1);
					}
					map.setCenter(new google.maps.LatLng(koortoko[0]));
					toko_marker.push(tokoMarker);

					tokoMarker.addListener( 'click', (function(tokoMarker, info_cus, infowindow){
						
						return function() {
							$.ajax({
								"url" : "<?php echo base_url('sbi/Peta_kunjungan/dataSurvey'); ?>",
								"type" : "POST", 
								"dataType" : "JSON",
								data: {
									"survey"   : idsurvey
								},
								success: function(dataJadwal){
									var tableJadwal = '';

									tableJadwal += '<tr><th>Produk</th><th>Stok toko</th><th>Volume pembelian</th><th>harga Pembelian</th><th>Tanggal Pembelian</th><th>Volume penjualan</th><th>Harga penjualan</th></tr>';
									if(dataJadwal.status == "success"){
										for(var j = 0; j < dataJadwal.data.length; j++){
											tableJadwal += '<tr><td>'+dataJadwal.data[j]['NAMA_PRODUK']+'</td><td>'+dataJadwal.data[j]['STOK_SAAT_INI']+'</td><td>'+dataJadwal.data[j]['VOLUME_PEMBELIAN']+'</td><td>'+dataJadwal.data[j]['HARGA_PEMBELIAN']+'</td><td>'+dataJadwal.data[j]['TGL_PEMBELIAN']+'</td><td>'+dataJadwal.data[j]['VOLUME_PENJUALAN']+'</td><td>'+dataJadwal.data[j]['HARGA_PENJUALAN']+'</td></tr>';
										}
									} else {
										tableJadwal += "<tr><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th></tr>";
									}
									
									$("#tableJadwal").html(tableJadwal);
								}
							});

							if(!tokoMarker.open){
								infowindow.setContent(info_cus);
								infowindow.open(map,tokoMarker);
								tokoMarker.open = true;
							} else {
								infowindow.close();
								tokoMarker.open = false;
							}

							google.maps.event.addListener(map, 'click', function() {
								infowindow.close();
								tokoMarker.open = false;
							});
						};
					})(tokoMarker,info_cus,infowindow)); 

				});
				
				$("#load_data").html('<center><p>Proses Pemuatan Data Selesai. Berikut Ini Data Pemetaan  Kunjungan Customer [Tanggal: '+startDate+' - '+endDate+'] </p></center>');
								
								
			}
		});
    }
</script>