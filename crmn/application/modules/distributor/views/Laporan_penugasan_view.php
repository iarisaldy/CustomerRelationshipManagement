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
                        <h2> Penugasan Harian Sales </h2>
                    </div>
                    <div class="body">
                        <div class="row">
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
                                                            
                                                                <b>Sales</b>
                                                                <select id="listSalesDistributor" name="sales" class="form-control show-tick">
                                                                    <option value="0">Pilih Sales</option>
                                                                    <?php
                                                                    foreach ($list_sales as $ListJenisValue) { ?>
                                                                    <option value="<?php echo $ListJenisValue->ID_USER; ?>"><?php echo $ListJenisValue->NAMA; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <b>Tanggal Awal</b>
                                                                <input type="text" id="startDate" value="<?php echo date('Y-m-d') ?>" class="form-control" placeholder="Tanggal Awal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <b>Tanggal Akhir</b>
                                                                <input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-d"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <b>&nbsp;</b><br/>
                                                        <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                        <button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><span class="fa fa-file-excel-o"></span> Export </button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="tableKunjungan" class="table table-striped table-bordered" width="100%" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
																 <th>Distributor</th>
                                                                <th>Surveyor</th>

                                                                <th>Customer / Toko</th>
                                                                <th>Rencana Kunjungan</td>
                                                                <th>Tanggal Kunjungan</th>
                                                                <th>Durasi Kunjungan <sub>/Menit</sub></th>
                                                                <th>Status</th>
                                                                <th>Keterangan</th>
                                                                <th width="15%">Action</th>
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
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script>

    $('document').ready(function(){
        $("#daftar_report").dataTable();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
		
		//var distributor = <?= $this->session->userdata('kd_dist'); ?>; 
		//console.log(distributor);
        listKunjungan( null, startDate, endDate);

        $('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $("#startDate, #endDate").blur(); 
    });
	
	$(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
       
        //var distributor = <?= $this->session->userdata('kd_dist'); ?>; 
       
        var sales = $("#listSalesDistributor").val();
		if(sales == 0){
			sales = null;
		}
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        //console.log(salesDistributor);
        listKunjungan( sales, startDate, endDate);
    });
    
    $(document).on("click", "#btnExport", function(e){
		e.preventDefault();
        var distributor = <?= $this->session->userdata('kd_dist'); ?>; 
        var sales = $("#listSalesDistributor").val();
		if(sales == 0){
			sales = null;
		}
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
       
        window.open("<?php echo base_url()?>distributor/Laporan_penugasan/toExcel?sales="+sales+"&startDate="+startDate+"&endDate="+endDate,"_blank");
    });
	
	function listKunjungan(sales = null, startDate = null, endDate = null){
        $('#tableKunjungan').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('distributor/Laporan_penugasan/listCanvassing'); ?>",
                type: "POST",
                data: {
                    "sales_distributor" : sales,
                    "start_date" : startDate,
                    "end_date" : endDate
                }
            },
        });
    }

</script>