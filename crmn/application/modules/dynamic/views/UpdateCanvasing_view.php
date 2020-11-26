<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Update Schedule Canvassing</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <a href="<?php echo base_url("sales/RoutingCanvasing"); ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                                <hr/>
                                <div class="card">
                                    <div class="body">
                                    <div id="notif-success"></div>
                                        <form class="form-horizontal" method="post">

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Date Planned : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" id="plannedDate" value="<?php echo $canvassing->TGL_RENCANA_KUNJUNGAN; ?>" class="datepicker form-control" placeholder="Please choose a date...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Sales Name : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select id="listSales" name="sales" class="form-control show-tick"  data-live-search="true">
                                                                <option value="">Choose Sales</option>
                                                                <?php
                                                                    foreach ($sales as $salesKey => $salesValue) { ?>
                                                                        <option data-idarea="<?php echo str_replace("AREA ", "", $salesValue->USER_AREA);  ?>" value="<?php echo $salesValue->ID_USER; ?>" <?php if($salesValue->ID_USER == $canvassing->ID_USER){ echo "selected";} ?>><?php echo $salesValue->NAMA; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Customer : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div id="selectCustomer"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Keterangan (Penugasan) : </label>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <select id="penugasan" class="form-control selectpicker show-tick" multiple>
                                                            <option>Pilih Penugasan</option>
                                                            <option value="canvassing">Canvassing</option>
                                                            <option value="penagihan">Penagihan</option>
                                                            <option value="lain-lain">Lain-lain</option>
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
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button id="updateNewSchedule" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Schedule</button>
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
    $(document).ready(function(e){
        $('#plannedDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        var idArea = $(this).find(':selected').data('idarea');
        var idDistributor = "<?php echo $this->session->userdata("kode_dist"); ?>";
        setTimeout(function(){
            listCustomer("#selectCustomer", idDistributor, idArea, <?php echo $canvassing->ID_TOKO ?>);
        },4000)
        
        $("#penugasan").val(<?php echo "['".str_replace(" , ", "','",$canvassing->KETERANGAN)."']"; ?>);
        $("#penugasan").selectpicker("refresh");
    });

    $(document).on("change", "#listSales", function(){
        var idArea = $(this).find(':selected').data('idarea');
        var idDistributor = "<?php echo $this->session->userdata("kode_dist"); ?>";
        listCustomer("#selectCustomer", idDistributor, idArea);
    });

    $(document).on("click", "#updateNewSchedule", function(e){
        e.preventDefault();
        var plannedDate = $("#plannedDate").val();
        var idSales = $("#listSales").val();
        var idCustomer = $("#listCustomer").val();
        var keterangan = $("#penugasan").val();

        $.ajax({
            url: "<?php echo base_url(); ?>sales/RoutingCanvasing/actionUpdateCanvassing",
            type: "POST",
            data: {
                "id_kunjungan_customer": <?php echo $canvassing->ID_KUNJUNGAN_CUSTOMER; ?>,
                "planned_date": plannedDate,
                "id_surveyor": idSales,
                "id_customer": idCustomer,
                "keterangan" : keterangan
            },
            success: function(data){
                var json = JSON.parse(data);
                if(json.status == "success"){
                    $("#notif-success").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Added New Schedule Canvassing success.</div>');
                    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
                        $(".alert-success").slideUp(500);
                    });
                }
            }
        })
    });

    function listCustomer(key, idDistributor, idArea, val = null){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/RoutingCanvasing/listCustomer/"+idDistributor+"/"+idArea,
		    type: 'GET',
			dataType: 'JSON',
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listCustomer" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option>Choose Customer</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_CUSTOMER']+'">'+response[i]['NAMA_TOKO']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $("#listCustomer").val(val);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }
</script>