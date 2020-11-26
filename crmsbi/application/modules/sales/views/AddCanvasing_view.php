<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Add Schedule Canvassing</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <a href="<?php echo base_url("sales/RoutingCanvasing"); ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                                <a href=""><button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> Import Excel</button></a>
                                <hr/>
                                <div class="card">
                                    <div class="body">
                                    <div id="notif-success"></div>
                                        <form class="form-horizontal" method="post">

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label" style="float: left;">
                                                    <label for="name">Date Planned : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" id="plannedDate" class="datepicker form-control" placeholder="Please choose a date...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label" style="float: left;">
                                                    <?php 
                                                    $idJenisUser = $this->session->userdata("id_jenis_user");
                                                    $idRegion = $this->session->userdata("id_region");

                                                    if($idJenisUser == "1001" || $idJenisUser == "1005"){ ?>
                                                        <label for="name">KAM / AM Name : </label>
                                                    <?php } else if($idJenisUser == "1002" || $idJenisUser == "1007" || $idJenisUser == "1003"){ ?>
                                                        <label for="name">Sales Name : </label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <?php if($idJenisUser == "1001" || $idJenisUser == "1005"){ ?>

                                                                <select id="listSales" name="sales" class="form-control show-tick" data-live-search="true">
                                                                    <option value="">Choose KAM / AM</option>
                                                                    <?php
                                                                        foreach ($sales as $salesKey => $salesValue) { 

                                                                        	if($idRegion == "1001"){
                                                                    ?>
                                                                            <option data-iddistributor="<?php echo $salesValue->KODE_DISTRIBUTOR; ?>" value="<?php echo $salesValue->ID_USER; ?>"><?php echo $salesValue->NAMA; ?></option>
                                                                    <?php } else{ ?>
                                                                    	<option data-idarea="<?php echo str_replace("AREA ", "", $salesValue->USER_AREA);  ?>" value="<?php echo $salesValue->ID_USER; ?>"><?php echo $salesValue->NAMA; ?></option>
                                                                    <?php } } ?>
                                                                </select>

                                                            <?php } else if($idJenisUser == "1002" || $idJenisUser == "1007" || $idJenisUser == "1003"){ ?>

                                                                <select id="listSales" name="sales" class="form-control show-tick" data-live-search="true">
                                                                    <option value="">Choose Sales</option>
                                                                    <?php
                                                                        foreach ($sales as $salesKey => $salesValue) { ?>
                                                                            <option data-idarea="<?php echo str_replace("AREA ", "", $salesValue->USER_AREA);  ?>" data-iduser="<?php echo $salesValue->ID_USER; ?>" value="<?php echo $salesValue->ID_USER; ?>"><?php echo $salesValue->NAMA; ?></option>
                                                                    <?php } ?>
                                                                </select>

                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label" style="float: left;">
                                                    <label for="name">Customer : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-10 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <!-- <select id="listCustomer" class="itemName form-control" style="width:500px" name="itemName"></select> -->

                                                        <div id="label">Pilih Sales Terlebih Dahulu</div>
                                                        <div id="selectCustomer"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label" style="float: left;">
                                                    <label for="name">Keterangan (Penugasan) : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <select id="penugasan" class="form-control selectpicker show-tick" multiple>
                                                            <option>Pilih Penugasan</option>
                                                            <option value="canvassing">Canvassing</option>
                                                            <option value="penagihan">Penagihan</option>
                                                            <option value="lain-lain">Lain-Lain</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="form-penugasan" style="display: none;">
                                                        <div class="form-line">
                                                            <input id="lain-lain" type="text" class="form-control" placeholder="Penugasan Lain Lain">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10 col-xs-12">
                                                    <button id="addNewSchedule" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Schedule</button>
                                                    &nbsp;
                                                    <a href="<?php echo base_url('sales/RoutingCanvasing'); ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script>

    $(".itemName").select2({
        placeholder: "--- Select Customer ---",
        ajax: {
            url: "<?php echo base_url() ?>sales/RoutingCanvasing/searchToko",
            dataType: "JSON",
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $(document).ready(function(e){
        $('#plannedDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    });

    $(document).on("change", "#listSales", function(){
        <?php if($idJenisUser == "1001" ||$idJenisUser == "1005"){ ?>
        	<?php if($idRegion == "1001"){ ?>
        		var idDistributor = $(this).find(':selected').data('iddistributor');
                var idUser = $(this).find(':selected').data('iduser');
            	listCustomer("#selectCustomer", idDistributor, null, idUser);
        	<?php } else { ?>
                var idUser = $(this).find(':selected').data('iduser');
        		var idArea = $(this).find(':selected').data('idarea');
            	listCustomer("#selectCustomer", null, idArea, idUser);
        	<?php } ?>
        <?php } else if($idJenisUser == "1002" || $idJenisUser == "1007" || $idJenisUser == "1003"){ ?>
            var idDistributor = "<?php echo $this->session->userdata("kode_dist"); ?>";
            var idUser = $(this).find(':selected').data('iduser');
            var idArea = $(this).find(':selected').data('idarea');
            listCustomer("#selectCustomer", idDistributor, idArea, idUser);
        <?php } ?>
    });

    $(document).on("change", "#penugasan", function(){
        var penugasan = $("#penugasan").val();
        var texts = penugasan.toString();
        if(texts.search(/lain-lain/) >= 0){
            $("#form-penugasan").css("display", "block");
        } else {
            $("#form-penugasan").css("display", "none");
        }
    });

    $(document).on("click", "#addNewSchedule", function(e){
        e.preventDefault();
        var plannedDate = $("#plannedDate").val();
        var idSales = $("#listSales").val();
        var idCustomer = $("#listCustomer").val();
        var penugasan = $("#penugasan").val();
        var lain = $("#lain-lain").val();

        $.ajax({
            url: "<?php echo base_url(); ?>sales/RoutingCanvasing/actionAddCanvassing",
            type: "POST",
            data: {
                "planned_date": plannedDate,
                "id_surveyor": idSales,
                "id_customer": idCustomer,
                "keterangan" : penugasan,
                "keterangan_lain" : lain
            },
            beforeSend: function(xhr){
                $("#addNewSchedule").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
            },
            success: function(data){
                var json = JSON.parse(data);
                $("#addNewSchedule").html("<i class='fa fa-save'></i> Save Schedule");
                if(json.status == "success"){
                    $(".btn-danger").html('<i class="fa fa-arrow-left"></i> Back');
                    $("#notif-success").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success !</strong> Added New Schedule Canvassing success.</div>');
                    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
                        $(".alert-success").slideUp(500);
                    });
                } else {
                    $("#notif-success").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error !</strong> '+json.message+'</div>');
                    $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
                        $(".alert-danger").slideUp(500);
                    });
                }
            }
        })
    });

    function listCustomer(key, idDistributor = null, idArea = null, idUser = null){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/RoutingCanvasing/listCustomer",
		    type: 'POST',
		    data: {
		    	"id_distributor" : idDistributor,
		    	"id_area" : idArea,
                "id_user" : idUser
		    },
			dataType: 'JSON',
            beforeSend: function(xhr){
                $("#label").html("Mohon Tunggu dalam Proses Pengambilan Data Customer");
            },
		    success: function(data){
                $("#label").html("");
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listCustomer" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option>Choose Customer</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_CUSTOMER']+'">'+response[i]['ID_CUSTOMER']+' - '+response[i]['NAMA_TOKO']+' - '+response[i]['ALAMAT']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }
</script>