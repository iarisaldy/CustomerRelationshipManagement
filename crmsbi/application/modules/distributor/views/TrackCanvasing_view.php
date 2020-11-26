<style>
    #mapsTrackCanvasing {
    	margin-top: 12px;
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
				<div class="card">
					<div class="header header-title">
						<h2>Tracking Canvasing</h2>
					</div>

					<div class="body">
						<div class="row">
							<div class="container-fluid">
                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            		<form>
                            			<div class="row clearfix">
                            				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            					<div class="form-group">
                            						<div class="form-line" id="filterDistributor"></div>
                            					</div>
                            				</div>
                            				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            					<div class="form-group">
                            						<div class="form-line" id="filterSalesDistributor"></div>
                            					</div>
                            				</div>
                            				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            					<div class="form-group">
                            						<div class="form-line">
                            							<b>Tanggal Awal</b>
                            							<input type="text" id="startDate" value="<?php echo date('Y')."-".date('m')."-".date('d') ?>" class="form-control" placeholder="Tanggal Awal">
                            						</div>
                            					</div>
                            				</div>
                            				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                            					<div class="form-group">
                            						<div class="form-line">
                            							<b>Tanggal Akhir</b>
                            							<input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-t"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
                            						</div>
                            					</div>
                            				</div>
                            				<div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                            					<b>&nbsp</b><br/>
                            					<button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                            				</div>
                            			</div>
                            		</form>
                            		<div class="card"><div id="mapsTrackCanvasing"></div></div>
                            		<img src="<?php echo base_url('assets/map_icons/hijau_big.png') ?>"> Start Marker
                            		<img src="<?php echo base_url('assets/map_icons/kuning_big.png') ?>"> Road Marker
                            		<img src="<?php echo base_url('assets/map_icons/merah_big.png') ?>"> End Marker
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
<script type="text/javascript">
    var infoWindow = new google.maps.InfoWindow();
    var beachMarker = new Array();

	$("document").ready(function(){
		$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $("#startDate, #endDate").blur(); 

		initMap([{lat: -7.1756625, lng: 112.6519365 }]);
		var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user') ?>";
		if(idJenisUser == "1002" || idJenisUser == "1003" || idJenisUser == "1007"){
			var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
			filterDistributor("#filterDistributor", idDistributor, "readonly");
			filterSalesDistributor("#filterSalesDistributor", idDistributor);
		} else {
			filterDistributor("#filterDistributor", "", "");
			filterSalesDistributor("#filterSalesDistributor", 0);
		}
	});

	function initMap(koordinat = null, id = null) {
		var baseUrl = "<?php echo base_url(); ?>";
		var map = new google.maps.Map(document.getElementById("mapsTrackCanvasing"), {
			zoom: 13,
			center: koordinat[0],
			mapTypeId : google.maps.MapTypeId.ROADMAP
		});

		var flightPlanCoordinates = koordinat;
		var image = baseUrl+'assets/map_icons/kuning_big.png';
		var image_green = baseUrl+'assets/map_icons/hijau_big.png';
		var image_red = baseUrl+'assets/map_icons/merah_big.png';

		var startMarker = new google.maps.Marker({
			position: flightPlanCoordinates[0],
			map: map,
			icon: image_green
		});

        startMarker.addListener('click', function() {
            $.ajax({
                url: "<?php echo base_url(); ?>distributor/TrackCanvasing/detailCanvasing/"+id[0]['id_kunjungan'],
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    var contentString = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+data.data[0]['NAMA_TOKO']+'</h3>'+
                    '<div id="bodyContent">'+
                    '<li> <b>Tanggal kunjungan :</b> '+data.data[0]['TGL_KUNJUNGAN']+'</li>'+
                    '<li> <b>Durasi kunjungan :</b> '+data.data[0]['DURASI_KUNJUNGAN']+' Menit</li>'+
                    '<li> <b>Keterangan :</b> '+data.data[0]['KETERANGAN']+'</li>'+
                    '</div>'+
                    '</div>';

                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });

                    infowindow.open(map, startMarker);
                }
            });
        });

		var lengthArray = flightPlanCoordinates.length;
		var endMarker = new google.maps.Marker({
			position: flightPlanCoordinates[lengthArray-1],
			map: map,
			icon: image_red
		});

        endMarker.addListener('click', function(){
            lastArrray = id.length - 1;
            $.ajax({
                url: "<?php echo base_url(); ?>distributor/TrackCanvasing/detailCanvasing/"+id[lastArrray]['id_kunjungan'],
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    var contentString = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+data.data[0]['NAMA_TOKO']+'</h3>'+
                    '<div id="bodyContent">'+
                    '<li> <b>Tanggal kunjungan : </b> '+data.data[0]['TGL_KUNJUNGAN']+'</li>'+
                    '<li> <b>Durasi kunjungan : </b> '+data.data[0]['DURASI_KUNJUNGAN']+' Menit</li>'+
                    '<li> <b>Keterangan : </b> '+data.data[0]['KETERANGAN']+'</li>'+
                    '</div>'+
                    '</div>';

                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });

                    infowindow.open(map, endMarker);
                }
            });
        });

		for(var i = 1; i < flightPlanCoordinates.length - 1; i++){
			tokoMarker = new google.maps.Marker({
				position: flightPlanCoordinates[i],
				map: map,
				icon: image
	        });

            beachMarker.push(tokoMarker);
            tokoMarker.addListener('click', function(){
                console.log(idCanvasing);
            });
		}

		var flightPath = new google.maps.Polyline({
			path: flightPlanCoordinates,
			geodesic: true,
			strokeColor: "#FF0000",
			strokeOpacity: 0.5,
			strokeWeight: 6
        });

        flightPath.setMap(map);
    }

    $(document).on("click", "#btnFilter", function(e){
    	var idSalesDistributor = $("#listSalesDistributor").val();
    	var startDate = $("#startDate").val();
    	var endDate = $("#endDate").val();
    	$.ajax({
    		url: "<?php echo base_url(); ?>distributor/TrackCanvasing/canvasing/"+idSalesDistributor,
		    type: "POST",
		    data: {
		    	"id_sales" : idSalesDistributor,
		    	"start_date" : startDate,
		    	"end_date" : endDate
		    },
			dataType: "JSON",
		    success: function(data){
		    	initMap(data.data, data.kunjungan);
		    }
    	});
    });

    $(document).on("change", "#listDistributor", function(e){
    	e.preventDefault();
    	filterSalesDistributor("#filterSalesDistributor", $(this).val());
    });

    function filterDistributor(key, value, option){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/FilterSurvey/distributor",
		    type: "GET",
			dataType: "JSON",
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Distributor</b>';
                if(option != ""){
                	type_list += '<select id="listDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true" disabled="true">';
                } else {
                	type_list += '<select id="listDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                }

                type_list += '<option value="">Pilih Distributor</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['KODE_DISTRIBUTOR']+' - '+response[i]['NAMA_DISTRIBUTOR']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $("#listDistributor").val(value);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function filterSalesDistributor(key, idDistributor, value){
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/salesDistributor/"+idDistributor,
            type: "GET",
            dataType: "JSON",
            success: function(data){
            	var type_list = '';

            	if(data.status == "success"){
            		var response = data['data'];
            		type_list += '<b>Sales Distributor</b>';
            		type_list += '<select id="listSalesDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
            		type_list += '<option value="">Pilih SalesMan</option>';
            		for (var i = 0; i < response.length; i++) {
            			type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
            		}
            		type_list += '</select>';
            	} else {
            		type_list += '<b>Sales Distributor</b>';
            		type_list += '<select id="listSalesDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
            		type_list += '<option value="">Pilih SalesMan</option>';
            		type_list += "</select>";
            	}

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>