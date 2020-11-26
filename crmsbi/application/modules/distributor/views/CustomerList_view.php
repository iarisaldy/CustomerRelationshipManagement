<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2>List Customer</h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                            // echo $menusValue->ID_MENU;
                         if($menusValue->ID_MENU == '1011'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>
                    
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            		<div class="card">
                                        <div class="body">
                                        	<form>
                                        		<div class="row clearfix">
                                        		<?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                        			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                                                    <div class="form-group">
	                                                        <div class="form-line" id="filterDistributor"></div>
	                                                    </div>
	                                                </div>
	                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                                                    <div class="form-group">
	                                                        <div class="form-line" id="filterProvinsi"></div>
	                                                    </div>
	                                                </div>
	                                            <?php } ?>
	                                            	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                                                    <div class="form-group">
	                                                        <div class="form-line" id="filterLT"></div>
	                                                    </div>
	                                                </div>
	                                                <!-- <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                                                    <div class="form-group">
	                                                        <div class="form-line">
	                                                        	<b>Pilih Cluster</b>
	                                                        	<select id="listCluster" class="form-control show-tick">
	                                                        		<option value="">Pilih Cluster</option>
	                                                        		<option value="super-platinum">Super Platinum</option>
	                                                        		<option value="platinum">Platinum</option>
	                                                        		<option value="gold">Gold</option>
	                                                        		<option value="silver">Silver</option>
	                                                        		<option value="tidak-ada-penjualan">Tidak Ada Penjualan</option>
	                                                        	</select>
	                                                        </div>
	                                                    </div>
	                                                </div> -->
                                        			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                                                    <div class="form-group">
	                                                        <div class="form-line">
	                                                            <b>Tanggal Awal</b>
	                                                            <input type="text" id="startDate" value="<?php echo date('Y')."-".date('m')."-"."01" ?>" class="form-control" placeholder="Tanggal Awal">
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
	                                                    <div class="form-group">
	                                                        <div class="form-line">
	                                                            <b>Tanggal Akhir</b>
	                                                            <input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-t"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                                <div class="col-md-1">
	                                                    <b>&nbsp</b><br/>
	                                                    <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>

	                                                </div>
													<div class="col-md-1">
														<br/>
														<button class="btn btn-success" onclick="exportTableToExcel('tableCustomer')"><span class="fa fa-file-excel-o"></span> Export Excel</button>
													</div>
                                        		</div>
                                        	</form>
                                        	<table id="tableCustomer" class="table table-striped table-bordered" width="100%" border="1">
                                                <thead>
                                                    <tr>
                                                        <th width="3%">No</th>
                                                        <th>ID Customer</th>
                                                        <th>Nama Toko</th>
                                                        <th>Distributor</th>
                                                        <th>Nama Pemilik</th>
                                                        <th>Provinsi</th>
                                                        <th>Kota</td>
                                                        <th>Kecamatan</th>
                                                        <th>Tipe Toko</th>
                                                        <th>Nama LT</th>
                                                        <th>Cluster</th>
                                                        <th>Alamat</th>
                                                        <th>Total Dikunjungi</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                            	</div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->

                <!-- Modal Update Tagging -->
                <div class="modal fade" id="updateTaggingModal" tabindex="-1" role="dialog">
	                <div class="modal-dialog" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header" style="background-color: #00b0e4;color: white;">
	                            <h4 class="modal-title" id="defaultModalLabel">Update Tagging Toko</h4>
	                        </div>
	                        <div class="modal-body">
	                        	<form class="form-horizontal">
	                                <div class="row clearfix">
	                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
	                                        <label for="latitude">Latitude : </label>
	                                    </div>
	                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
	                                        <div class="form-group">
	                                            <div class="form-line">
	                                            	<input type="hidden" id="id_customer">
	                                                <input type="text" id="latitude" class="form-control">
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="row clearfix">
	                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
	                                        <label for="longitude">Longitude : </label>
	                                    </div>
	                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
	                                        <div class="form-group">
	                                            <div class="form-line">
	                                                <input type="text" id="longitude" class="form-control">
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <hr/>
	                            </form>
	                        </div>
	                        <div class="modal-footer">
	                            <button type="button" id="btnSaveUpdateTagging" class="btn btn-sm btn-info waves-effect">SAVE LOCATION</button>
	                            <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <!-- End modal update tagging -->

            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	$("document").ready(function(){
		filterDistributor("#filterDistributor");
        filterProvinsi("#filterProvinsi");
        filterLtDistributor("#filterLT");

		var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user') ?>";
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
		if(idJenisUser == "1002" || idJenisUser == "1003" || idJenisUser == "1005" || idJenisUser == "1007"){
			var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
			listCustomer(idDistributor, null, startDate, endDate);
		} else {
			listCustomer(null, null, startDate, endDate);
		}

		$('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $("#startDate, #endDate, #listCustomer").blur();
	});

	$(document).on("click", "#btnFilter", function(e){
		var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user') ?>";
		if(idJenisUser == "1002" || idJenisUser == "1003" || idJenisUser == "1005" || idJenisUser == "1007"){
			var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
		} else {
			var idDistributor = $("#listDistributor").val();
		}
		
		var idProvinsi = $("#listProvinsi").val();
		var kodeLt = $("#listLt").val();
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
		listCustomer(idDistributor, idProvinsi, startDate, endDate, kodeLt);
	});

	$(document).on("click", "#btnUpdateTagging", function(e){
		e.preventDefault();
		var idCustomer = $(this).data("idcustomer");
		$("#id_customer").val(idCustomer);
		$.ajax({
			url: "<?php echo base_url(); ?>distributor/Customer/detailCustomer/"+idCustomer,
			type: "GET",
			dataType: "JSON",
			success: function(data){
				if(data.status == "error"){
					$("#latitude").val("");
					$("#longitude").val("");
				} else {
					$("#latitude").val(data.data[0].LATITUDE);
					$("#longitude").val(data.data[0].LONGITUDE);
				}
			}
		});
		$("#updateTaggingModal").modal("show");
	});

	$(document).on("click", "#btnSaveUpdateTagging", function(e){
		var idCustomer = $("#id_customer").val();
		var latitude = $("#latitude").val();
		var longitude = $("#longitude").val();

		$.ajax({
			url: "<?php echo base_url(); ?>distributor/Customer/updateTagging",
			type: "POST",
			dataType: "JSON",
			data: {
				"id_customer" : idCustomer,
				"latitude" : latitude,
				"longitude" : longitude
			},
			beforeSend: function(xhr){
				$("#btnSaveUpdateTagging").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
			},
			success: function(data){
				$("#btnSaveUpdateTagging").html("SAVE LOCATION");
				if(data.status == "success"){
					alert("Berhasil mengubah lokasi toko");
					$("#id_customer, #latitude, #longitude").val("");
					$("#updateTaggingModal").modal("hide");
				}
			}
		})
	});

	function listCustomer(idDistributor = null, idProvinsi = null, startDate = null, endDate = null, kodeLt = null, cluster = null){
		$("#tableCustomer").dataTable({
			"lengthMenu": [[-1, 10, 25, 50, 100], ["All", 10, 25, 50, 100]],
			"destroy" : true,
			"ajax" : {
				"url" : "<?php echo base_url('distributor/Customer/listCustomer') ?>",
				"type" : "POST",
				"data" : {
					"id_distributor" : idDistributor,
					"id_provinsi" : idProvinsi,
					"kode_lt" : kodeLt,
					"start_date" : startDate,
					"end_date" : endDate
				}
			}
		});
		// $('#tableCustomer').dataTable({
		// 	"processing": true,
  //           "destroy" : true,
  //           "serverSide": true,
  //           "order": [10, "desc"],
  //           "ajax" : {
  //               url: "<?php echo base_url('distributor/Customer/getDataCustomer'); ?>",
  //               type: "POST",
  //               data: {
  //               	"id_distributor" : idDistributor,
  //               	"id_provinsi" : idProvinsi,
  //               	"kode_lt" : kodeLt,
  //               	"start_date" : startDate,
  //               	"end_date" : endDate
  //               }
  //           },
  //           "columnDefs": [{
  //           	"targets" : [0],
  //           }],
  //           "fixedColumns": {
  //           	leftColumns: 2
  //           }
  //       });
	}

	function filterLtDistributor(key, value){
		var idDistributor = "<?php echo $this->session->userdata('kode_dist'); ?>";
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/FilterSurvey/ltDistributor/"+idDistributor,
		    type: "GET",
			dataType: "JSON",
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Toko LT</b>';
                type_list += '<select id="listLt" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Toko LT</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KD_SAP']+'">'+response[i]['NAMA_TOKO']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

	function filterDistributor(key, value){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/FilterSurvey/distributor",
		    type: "GET",
			dataType: "JSON",
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Distributor</b>';
                type_list += '<select id="listDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Distributor</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['KODE_DISTRIBUTOR']+' - '+response[i]['NAMA_DISTRIBUTOR']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function filterProvinsi(key, value){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/FilterSurvey/provinsi",
		    type: "GET",
			dataType: "JSON",
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Provinsi</b>';
                type_list += '<select id="listProvinsi" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Provinsi</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }
</script>

<script>

function exportTableToExcel(tableID){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	
	var uniq_title = 'mulai '+startDate+' sampai '+endDate;
	
	var objDate = new Date();
	var todayDate = objDate.getDate()+'-'+objDate.getMonth()+'-'+objDate.getFullYear();
	var todayTime = objDate.getHours()+'_'+objDate.getMinutes()+'_'+objDate.getSeconds();
	
	var filename = 'Laporan CRM List Customer '+uniq_title+' ('+todayDate+ ' '+todayTime+')';
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

</script>