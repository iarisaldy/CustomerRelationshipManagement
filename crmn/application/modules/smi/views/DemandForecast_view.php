<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2>Demand Forecast <?php $date = date('F'); $date = date('F', strtotime('+30 days', strtotime($date))); echo $date; ?></h2>
                    </div>

                    <div class="body">
                        <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <div class="form-line" id="filterDistributor"></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <b>&nbsp</b><br/>
                                <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <table id="tblDemand" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="12%">ID Customer</th>
                                                <th width="22%">Nama Toko</th>
                                                <th>Kecamatan</th>
                                                <th width="17%">Forecast by System<sub>/zak</sub></th>
                                                <th>Adj Sales</th>
                                                <th>Updated By</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->

                <!-- Modal Update Adjustment Sales -->
                <div class="modal fade" id="modalEditAdjustment" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title">Update Adjustment Sales</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                            <label for="name">Adj Sales : </label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="hidden" id="idAdjSales">
                                                    <input type="hidden" id="idCustomer">
                                                    <input type="hidden" id="idDistributor">
                                                    <input id="adjustmentSalesValue" type="number" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSaveAdj" class="btn btn-sm btn-success waves-effect">SAVE</button>
                                <button type="button" class="btn btn-sm btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Update Adjustment Sales -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("document").ready(function(){
        demandForecastTable("");
        filterDistributor("#filterDistributor");
    });

    $(document).on("click", "#btnFilter", function(e){
        var idDistributor = $("#listDistributor").val();
        demandForecastTable(idDistributor);
    });

    $(document).on("click", "#btnEditAdjust", function(e){
        var idAdj = $(this).data("idadj");
        var idCustomer = $(this).data("idcustomer");
        var idDistributor = $(this).data("iddistributor");

        $.ajax({
            "url" : "<?php echo base_url('smi/demandForecast/detailDemand'); ?>/"+idAdj,
            "type" : "GET",
            "dataType" : "JSON",
            success: function(data){
                $("#idCustomer").val(idCustomer);
                $("#idDistributor").val(idDistributor);
                if(data.status == "success"){
                    $("#idAdjSales").val(data.data[0].ID_ADJ_SALES);
                    $("#adjustmentSalesValue").val(data.data[0].ADJ_SALES);
                } else {
                    $("#idAdjSales").val(0);
                    $("#adjustmentSalesValue").val(0);
                }
            }
        });
        $("#modalEditAdjustment").modal("show");
    });

    $(document).on("click", "#btnSaveAdj", function(e){
        var idCustomer = $("#idCustomer").val();
        var idDistributor = $("#idDistributor").val();
        var idAdj = $("#idAdjSales").val();
        var adjSales = $("#adjustmentSalesValue").val();
        $.ajax({
            "url" : "<?php echo base_url('smi/demandForecast/updateDemandForecast'); ?>",
            "type" : "POST",
            "dataType" : "JSON",
            "data" : {
                "id_customer" : idCustomer,
                "id_distributor" : idDistributor,
                "id_adj_sales" : idAdj,
                "adj_sales" : adjSales
            },
            success: function(data){
                if(data.status == "success"){
                    alert("Berhasil melakukan adjustment demand toko");
                    $("#modalEditAdjustment").modal("hide");
                    demandForecastTable();
                } else {
                    alert(data.message);
                }
            }
        })
    });

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
                type_list += '<option value="">Pilih Distributork</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['KODE_DISTRIBUTOR']+' - '+response[i]['NAMA_DISTRIBUTOR']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function demandForecastTable(idDistributor = null){
        $("#tblDemand").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('smi/demandForecast/dataDemandForecast'); ?>",
                type: "POST",
                data: {
                    "id_distributor" : idDistributor
                }
            }
        });
    }
</script>