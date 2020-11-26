<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2> Customer Mapping </h2>
                    </div>
                    <div class="body">
                        
                            <div class="container-fluid">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="" method="post">
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                Filter Sales
                                                                <select id="listSalesTso" name="sales" class="form-control show-tick">
                                                                    <option value="">Pilih Sales</option>
                                                                    <?php
                                                                    foreach ($list_sales as $dtSales) { ?>
                                                                    <option value="<?php echo $dtSales->ID_USER; ?>"><?php echo $dtSales->NAMA; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <b>&nbsp;</b><br/>
                                                        <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                        <button style="float: right;" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" onclick="exportTableToExcel('tableMapping')"><span class="fa fa-file-excel-o"></span> Export </button>
                                                    </div>
													
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="tableMapping" class="table table-striped table-bordered" width="100%" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
                                                                <th>Nama Sales</th>
																<th>Kode Customer</th>
                                                                <th>Nama Customer</th>
																<th>Alamat</th>
                                                                <th>Distributor</th>
                                                                <th>TSO</th>
                                                                <th>ASM</td>
                                                                <th>RSM</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        <div>
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

<script>

    $('document').ready(function(){
        $("#tableMapping").dataTable();
        listMapping(null);
    });

    $(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
        
        var sales_tso = $("#listSalesTso").val();
        
        //console.log(salesDistributor);
        listMapping(sales_tso);
    });

    function listMapping(sales = null){
        $('#tableMapping').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sbi/Mapping_customer/List_mapping'); ?>",
                type: "POST",
                data: {
                    "sales_tso" : sales
                }
            },
        });
    }
	
	$(document).on("click", "#btnExport", function(e){
        e.preventDefault();
        
    });

</script>