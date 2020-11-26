<style type="text/css">
#maps_toko {
    height: 480px;
    position: relative;
    overflow: hidden;
    width: 100%;
}
</style>
<?php
	$bulan = date('m');
	$tahun = date('Y');
	
?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title bg-cyan">
                        <h2>Peta Rencana Kunjungan Toko</h2>
                    </div>
                    <div class="body">
                        <div class="row">
							<div class="col-md-12" style="padding-bottom:0; margin-bottom:0;">
                                <form method="post" >
									<div class="col-md-2" style=" padding-top: 3em; ">
                                        Filter TSO/AM/SO : 
                                       <select id="filterTso" name="filterTso" class="form-control selectpicker show-tick" data-size="100" data-live-search="true">
										<?php foreach($tso as $dt_tso){ ?>
											<option value="<?= $dt_tso['ID_SO'];?>-<?= $dt_tso['NAMA_SO']; ?>" <?php if($dt_tso['ID_SO'] == $id_tso_1){ echo "selected";} ?>>[<?= $dt_tso['ID_SO'];?>] <?= $dt_tso['NAMA_SO']; ?></option>
				
										<?php } ?>	
										</select>
                                    </div>
                                    <div class="col-md-1" style=" padding-top: 3em; ">
                                        Tahun : 
                                       <select id="filterTahun" name="filterTahun" class="form-control show-tick" data-size="5">
											<?php for($j=date('Y')-4;$j<=date('Y');$j++){ ?>
												<option value="<?php echo $j; ?>" <?php if($tahun == $j){ 
																	echo "selected";
																} ?> ><?php echo $j; ?></option>
											<?php } ?>
										</select>
                                    </div>
                                    <div class="col-md-2" style=" padding-top: 3em; ">
                                        Bulan : 
                                        <select id="filterBulan" name="filterBulan" class="form-control show-tick" data-size="5">
											<?php 
												for($j=1;$j<=12;$j++){
													$dateObj   = DateTime::createFromFormat('!m', $j);
													$monthName = $dateObj->format('F');
											?>
												<option value="<?php if($j < 10){ echo "0".$j; }else{ echo $j; }  ?>" <?php if($j == $bulan){ echo "selected";} ?>><?php echo $monthName; ?></option>
											<?php } ?>
										</select>
                                    </div>
                                    <div class="col-md-1" style=" padding-top: 3em;">
                                        <br/>
                                        <button id="btnFilter" type="submit" class="btn btn-info"><span class="fa fa-eye"></span> View</button>
                                    </div>
                                </form>
                                    <div id="legend" class="col-md-4" style="float: right; border-style: double; padding-top: 1em; ">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/merah_new.png">
										</div>
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" >
											<p>: Toko yang sudah ada rencana kunjungan [<span id="on_kunjungan">0</span>]</p>
										</div> 
										
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/hitam.png">
										</div>
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" >
											<p>: Toko yang belum ada rencana kunjungan [<span id="off_kunjungan">0</span>]</p>
										</div>  
                                    </div>
                                   
                            </div>
							
                            <div class="container-fluid">
                                 <div id="load_data" ></div>
                                <div id="maps_toko" style="border-style: groove; height: 100%;" ></div>
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
	
	var tso_frist = '<?= $id_tso_1; ?>';
	var nm_tso_frist = '<?= $nm_tso_1; ?>';
	var bulan	= '<?= $bulan; ?>';
	var tahun	= '<?= $tahun; ?>';

    $(document).ready(function(){
        mapsToko(tso_frist, nm_tso_frist, bulan, tahun);
    });
	
	$(document).on("click", "#btnFilter", function(e){
		e.preventDefault();
		var Tso = $('#filterTso option:selected').val();
		
		var exp = Tso.split('-');
		
		var Bulan = $('#filterBulan option:selected').val();
		var Tahun = $('#filterTahun option:selected').val();
		
		mapsToko(exp[0], exp[1], Bulan, Tahun);
	});
	
	function mapsToko(id_tso_in, nm_tso_in, bulan_in, tahun_in){
        $("#load_data").html('<br><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center><br>');
		
		$("#legend").html('<center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center>');
		
		var options = {
            zoom: 8,
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('maps_toko'), options);
		
						$.ajax({
                            //"url" : "<?php echo base_url('smi/PetaToko/stokToko'); ?>/"+id_area,
                            //console.log(id_area);
                            "url" : "<?php echo base_url('sbi/Peta_rencana_kunjungan_toko/petaTokoBaru'); ?>",
                            "type" : "POST", 
                            "dataType" : "JSON",
                            data: {
                                "bulan" : bulan_in, 
                                "tahun" : tahun_in,
                                "tso"	: id_tso_in
                            }, 
                            success: function(datas){
                                var koortoko = new Array();
                                $(datas).each(function(kesy, vals){
                                    
                                    
                                    
                                    if(vals.MARKER == "BLACK"){
                                        markerIconToko = marker_black;
                                    } else {
                                        markerIconToko = marker_red;
                                    }  
                                     
                                    var info_cus = 
                                        '<div class="blog-card">'+
                                        '<div class="description">'+
                                        '<h5 style="margin-top:6px;text-align: center;margin-bottom:15px;">'+vals.NAMA_TOKO+' ('+vals.KD_CUSTOMER+')</h5>'+
                                        '<p class="summary" style="margin-top: -10px;"></p>'+
                                        '<div style="width: 350px; height: 150px; overflow-y: scroll;">'+
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
                                                    '<td class="text-head">Koordinat</td>'+
                                                    '<td class="text-val">'+vals.LATITUDE+', '+vals.LONGITUDE+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td class="text-head">Bulan Kunjungan</td>'+
                                                    '<td class="text-val" id="hh">'+vals.BULAN+' / '+vals.TAHUN+' </td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td class="text-head">Jumlah Kunjungan</td>'+
                                                    '<td class="text-val">'+vals.KUNJUNGAN+'</td>'+
                                                '</tr>'+
                                            '</table>'+
                                            '<table id="tableJadwal" class="table table-bordered table-striped" style="font-size:13px;"></table>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>';
                                    
                                    //$('#on_kunjungan').text(vals.ON_JADWAL);
                                    //$('#off_kunjungan').text(vals.OFF_JADWAL);
                                    // $('#in_area').text(vals.AREA);
									
									$("#legend").html('<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" > <img src="<?php echo base_url(); ?>assets/img/map_icons/merah_new.png"> </div> <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" > <p>: Toko yang sudah ada rencana kunjungan [<span id="on_kunjungan">'+vals.ON_JADWAL+'</span>]</p> </div> <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" > <img src="<?php echo base_url(); ?>assets/img/map_icons/hitam.png"> </div> <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" > <p>: Toko yang belum ada rencana kunjungan [<span id="off_kunjungan">'+vals.OFF_JADWAL+'</span>]</p> </div>');
									
                                    var note = "NOTE: Terdapat [ "+vals.OFF_KOOR+" dari "+vals.TOT_TOKO+" ] Toko/Customer yang belum memiliki koordinat lokasi"; //pada [ "+vals.AREA+" ].";
                                    if(vals.OFF_KOOR != 0){
                                        $('#note_note').text(note);
                                    }
                                    var idCustomer = vals.KD_CUSTOMER;
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
	                                    		"url" : "<?php echo base_url('sbi/Peta_rencana_kunjungan_toko/jadwalKunjunganToko'); ?>",
                                                "type" : "POST", 
                                                "dataType" : "JSON",
                                                data: {
                                                    "bulan" : bulan, 
                                                    "tahun" : tahun,
                                                    "toko"  : idCustomer
                                                },
	                                    		success: function(dataJadwal){
	                                    			var tableJadwal = '';

	                                    			tableJadwal += '<tr><th>Tanggal Kunjungan</th><th>Keterangan</th></tr>';
	                                    			if(dataJadwal.status == "success"){
	                                    				for(var j = 0; j < dataJadwal.data.length; j++){
		                                    				tableJadwal += '<tr><td>'+dataJadwal.data[j]['TGL_RENCANA_KUNJUNGAN']+'</td><td>'+dataJadwal.data[j]['KETERANGAN']+'</td></tr>';
		                                    			}
	                                    			} else {
	                                    				tableJadwal += "<tr><th>-</th><th>-</th></tr>";
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
                                
                                $("#load_data").html('<center><p>Proses Loading Data Selesai. Berikut Ini Data Pemetaan Rencana Kunjungan Customer [Bulan '+bulan_in+' - '+tahun_in+'] [TSO/AM/SO: '+id_tso_in+' - '+nm_tso_in+']:</p></center>');
								

                            }
                        });
	 
	}
	
</script>
