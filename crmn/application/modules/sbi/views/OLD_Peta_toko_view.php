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
                        <h2>Peta Toko</h2>
                    </div>
                    <div class="body">
                        <div class="row">
							<div class="col-md-12" style="padding-bottom:0; margin-bottom:0;">
                                <form method="post" action="<?php echo base_url();?>sbi/Peta_toko" enctype="multipart/form-data">
                                    <div class="col-md-2" style=" padding-top: 2em; ">
                                        Filter Tahun : 
                                       <select id="filterTahun" name="filterTahun" class="form-control show-tick" data-size="5">
													
													<?php for($j=date('Y')-4;$j<=date('Y');$j++){ ?>
													<option value="<?php echo $j; ?>" 
														<?php if($this->session->userdata("set_tahun") == $j){ 
																	echo "selected";
																} ?>>
													<?php echo $j; ?>
													</option>
													<?php } ?>
										</select>
                                    </div>
                                    <div class="col-md-2" style=" padding-top: 2em; ">
                                        Filter Bulan : 
                                        <select id="filterBulan" name="filterBulan" class="form-control show-tick" data-size="5">
													<?php 
													for($j=1;$j<=12;$j++){
														$dateObj   = DateTime::createFromFormat('!m', $j);
														$monthName = $dateObj->format('F');
														?>
														<option value="<?php echo $j; ?>" <?php if($j == $this->session->userdata("set_bulan")){ echo "selected";} ?>><?php echo $monthName; ?></option>
													<?php } ?>
										</select>
                                    </div>
                                    <div class="col-md-1" style=" padding-top: 2em;">
                                        <br/>
                                        <button id="btnFilter" type="submit" class="btn btn-info"><span class="fa fa-eye"></span> View</button>
                                    </div>
                                </form>
                                    <div class="col-md-4" style="float: right; border-style: double; padding-top: 1.5em; ">
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
                                    <div class="col-md-1 col-xs-12" style="float: right; border-style: double; padding-top: 1.5em;">
                                        <center>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
											<img src="<?php echo base_url(); ?>assets/img/map_icons/biru.png" width="87%">
										</div>
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" style="padding: 0 0 0 0">
											<p style="font-weight: bold;font-size:12.5px" id="in_area">AREA</p>
										</div>  
                                        </center>
                                    </div>
                            </div>
							
                            <div class="container-fluid">
                                <div id="maps_toko" style="border-style: groove;"></div>
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
        //petaToko();
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
        var bulan = <?= $this->session->userdata("set_bulan");?>;//$('#filterBulan option:selected').val();
        var tahun = <?= $this->session->userdata("set_tahun");?>;//$('#filterTahun option:selected').val();
        
        //filter buan tahunn belum bisa
        
        var options = {
            zoom: 5,
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('maps_toko'), options);

        $.ajax({
            "url" : "<?php echo base_url('sbi/Peta_toko/masterAreaTso'); ?>",
            "type" : "GET",
            "dataType" : "JSON",
            success: function(data){
                var marker, i;

                $(data).each(function (key, val) {
                    var area_lat = val.LATITUDE;
                    var area_long = val.LONGITUDE;
                    var id_area = val.KD_AREA;
                    var nm_area = val.NAMA_AREA;
                    var areaku = nm_area.split(" ");
                    console.log(id_area);
                    marker = new google.maps.Marker({
	                   	width:50,
	                    position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
	                    map: map,
	                    draggable: false,
                        animation: google.maps.Animation.DROP,
                        icon: {url: marker_blue, labelOrigin: { x: 16.7, y: 11.5}},
                        label: {text: areaku[1], color: 'white',  fontSize: '12px'} 
                    }); 
                     
                    area_marker.push(marker);
                    google.maps.event.addListener(marker, 'click', function() {
                        map.setZoom(10);
                        hidden_marker(null); 
                        map.setCenter(new google.maps.LatLng(area_lat, area_long));
//cek point 1
                        $.ajax({
                            //"url" : "<?php echo base_url('smi/PetaToko/stokToko'); ?>/"+id_area,
                            //console.log(id_area);
                            "url" : "<?php echo base_url('sbi/Peta_toko/petaToko'); ?>",
                            "type" : "POST", 
                            "dataType" : "JSON",
                            data: {
                                "bulan" : bulan, 
                                "tahun" : tahun,
                                "area"  : id_area
                            }, 
                            success: function(datas){
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
                                    
                                    $('#on_kunjungan').text(vals.ON_JADWAL);
                                    $('#off_kunjungan').text(vals.OFF_JADWAL);
                                    $('#in_area').text(vals.AREA);
                                    var note = "NOTE: Terdapat [ "+vals.OFF_KOOR+"/"+vals.TOT_TOKO+" ] Toko/Customer yang belum memiliki koordinat lokasi pada [ "+vals.AREA+" ].";
                                    if(vals.OFF_KOOR != 0){
                                        $('#note_note').text(note);
                                    }
                                    var idCustomer = vals.KD_CUSTOMER;
                                    var toko_lat = vals.LATITUDE;
                                    var toko_long = vals.LONGITUDE

                                    tokoMarker = new google.maps.Marker({
                                        position: new google.maps.LatLng(toko_lat, toko_long),
                                        map: map,
                                        draggable: false,
                                        animation: google.maps.Animation.DROP,
                                        icon : markerIconToko
                                    });

                                    toko_marker.push(tokoMarker);

                                    tokoMarker.addListener( 'click', (function(tokoMarker, info_cus, infowindow){
                                    	
                                        return function() {
                                        	$.ajax({
	                                    		"url" : "<?php echo base_url('sbi/Peta_toko/jadwalKunjunganToko'); ?>",
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
                            }
                        });
//akhir cek point 1
                    });
                });
            }
        });
    }

    function mapsToko1(){
        var bulan	= $('#filterBulan option:selected').val();
        var tahun = $('#filterTahun option:selected').val();
        var options = {
            zoom: 5,
            center: new google.maps.LatLng(-1.000000, 118.745817),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('maps_toko'), options);

        $.ajax({
            "url" : "<?php echo base_url('sbi/Peta_toko/petaToko'); ?>",
            "type" : "POST",
            "dataType" : "JSON",
            data: {
                "bulan" : bulan,
                "tahun" : tahun
            },
            success: function(data){
                var marker, i;

                $(data).each(function (key, val) {
                    var nm_toko = val.NAMA_TOKO;
                    var area_lat = val.LATITUDE;
                    var area_long = val.LONGITUDE;
                    var area = val.AREA;
                    var marker_set;
                    if(val.MARKER == "BLACK"){
                        marker_set = marker_black;
                    } else if(val.MARKER == "RED"){
                        marker_set = marker_red;
                    }
                    	marker = new google.maps.Marker({
	                    	width:50,
	                        position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
	                        map: map,
	                        draggable: false,
	                        animation: google.maps.Animation.DROP,        //BOUNCE
                            icon: {url: marker_set, labelOrigin: { x: 16.7, y: 11.5}},
	                    });

                    area_marker.push(marker);
                    google.maps.event.addListener(marker, 'click', function() {
                        map.setZoom(10);
                        hidden_marker(null); 
                        map.setCenter(new google.maps.LatLng(area_lat, area_long));

                        $.ajax({
                            "url" : "<?php echo base_url('smi/PetaToko/stokToko'); ?>/"+id_area,
                            "type" : "GET",
                            "dataType" : "JSON",
                            success: function(datas){
                                $(datas).each(function(kesy, vals){
                                    if(vals.MARKER == "BLACK"){
                                        markerIconToko = marker_black;
                                    } else if(vals.MARKER == "RED"){
                                        markerIconToko = marker_red;
                                    } else if(vals.MARKER == "GREEN"){
                                        markerIconToko = marker_green;
                                    } else if(vals.MARKER == "BLUE"){
                                        markerIconToko = marker_blue;
                                    } else if(vals.MARKER == "YELLOW"){
                                        markerIconToko = marker_yellow;
                                    }
                                    
                                    var info_cus = 
                                        '<div class="blog-card">'+
                                        '<div class="description">'+
                                        '<h5 style="margin-top:6px;text-align: center;margin-bottom:15px;">'+vals.NAMA_TOKO+'</h5>'+
                                        '<p class="summary" style="margin-top: -10px;"></p>'+
                                        '<div style="width: 350px; height: 150px; overflow-y: scroll;">'+
                                            '<table class="table" style="font-size:13px;">'+
                                                '<tr>'+
                                                    '<td class="text-head">Koordinat</td>'+
                                                    '<td class="text-val">'+vals.LATITUDE+', '+vals.LONGITUDE+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td class="text-head">Kapasitas</td>'+
                                                    '<td class="text-val">'+vals.KAPASITAS+' Zak</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td class="text-head">Update Terakhir</td>'+
                                                    '<td class="text-val" id="tglUpdate"></td>'+
                                                '</tr>'+
                                            '</table>'+
                                            '<table id="tableStok" class="table table-bordered table-striped" style="font-size:13px;"></table>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>';

                                    var idCustomer = vals.ID_CUSTOMER;
                                    var toko_lat = vals.LATITUDE;
                                    var toko_long = vals.LONGITUDE

                                    tokoMarker = new google.maps.Marker({
                                        position: new google.maps.LatLng(toko_lat, toko_long),
                                        map: map,
                                        draggable: false,
                                        animation: google.maps.Animation.DROP,
                                        icon : markerIconToko
                                    });

                                    toko_marker.push(tokoMarker);

                                    tokoMarker.addListener( 'click', (function(tokoMarker, info_cus, infowindow){
                                    	
                                        return function() {
                                        	$.ajax({
	                                    		"url" : "<?php echo base_url('smi/PetaToko/toko'); ?>/"+idCustomer,
	                                    		"type" : "GET",
	                                    		"dataType" : "JSON",
	                                    		success: function(dataStok){
	                                    			var tableStok = '';

	                                    			tableStok += '<tr><th>Produk</th><th>Stok<sub>/zak</sub></th></tr>';
	                                    			if(dataStok.status == "success"){
                                                        $("#tglUpdate").html(dataStok.data[0].TGL_UPDATE);
	                                    				for(var j = 0; j < dataStok.data.length; j++){
		                                    				tableStok += '<tr><th>'+dataStok.data[j]['JENIS_PRODUK']+'</th><th>'+dataStok.data[j]['STOK_SAAT_INI']+'</th></tr>';
		                                    			}
	                                    			} else {
                                                        $("#tglUpdate").html("-");
	                                    				tableStok += "<tr><th>-</th><th>-</th></tr>";
	                                    			}
	                                    			
	                                    			$("#tableStok").html(tableStok);
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
                            }
                        })
                    });
                });
            }
        });

        
    }
</script>