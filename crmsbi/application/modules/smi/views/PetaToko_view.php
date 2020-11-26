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
                            <div class="container-fluid">
                                <div id="maps_toko"></div>
                                <br/>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 legenda">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" >
                                        <img src="<?php echo base_url(); ?>assets/img/map_icons/merah_new.png">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" >
                                        <p>: Stok Level < 30%</p>
                                    </div>                                  
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 legenda" >
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" >
                                        <img src="<?php echo base_url(); ?>assets/img/map_icons/kuning_new.png">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" >
                                        <p>: Stok Level 30% - 70%</p>
                                    </div>                                  
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 legenda" >
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" >
                                        <img src="<?php echo base_url(); ?>assets/img/map_icons/hijau_new.png">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" >
                                        <p>: Stok Level 70% - 100%</p>
                                    </div>                                  
                                </div>  
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 legenda" s>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <img src="<?php echo base_url(); ?>assets/img/map_icons/biru_new.png">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" >
                                        <p>: Stok Level > 100%</p>
                                    </div>  
                                </div>                              
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 legenda" >
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" >
                                        <img src="<?php echo base_url(); ?>assets/img/map_icons/hitam.png">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" >
                                        <p>: Kapasitas Gudang 0</p>
                                    </div>                                  
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
        var options = {
            zoom: 5,
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('maps_toko'), options);

        $.ajax({
            "url" : "<?php echo base_url('smi/PetaToko/masterArea'); ?>",
            "type" : "GET",
            "dataType" : "JSON",
            success: function(data){
                var marker, i;

                $(data).each(function (key, val) {
                    var area_lat = val.LATITUDE;
                    var area_long = val.LONGITUDE;
                    var id_area = val.KD_AREA;
                    var flag = val.FLAG_DONE;

                    if(flag == "Y"){
                    	marker = new google.maps.Marker({
	                    	width:50,
	                        position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
	                        map: map,
	                        draggable: false,
	                        animation: google.maps.Animation.DROP,
	                        icon : marker_green
	                    });
                    } else {
                    	marker = new google.maps.Marker({
	                    	width:50,
	                        position: new google.maps.LatLng(val.LATITUDE, val.LONGITUDE),
	                        map: map,
	                        draggable: false,
	                        animation: google.maps.Animation.DROP,
                            icon: marker_red
	                    });
                    }

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

        google.maps.event.addListener(map, 'zoom_changed', function () {
            var zoom = map.getZoom();
            if(zoom == 7){
                $.ajax({
                    "url" : "<?php echo base_url('smi/PetaToko/masterArea'); ?>",
                    "type" : "GET",
                    "dataType" : "JSON",
                    success: function(dataToko){
                        for (i = 0; i < dataToko.length; i++) {
                            area_marker[i].setMap(map);
                            hidden_marker_toko(null);
                        }
                    }
                })
            }
        })
    }
</script>