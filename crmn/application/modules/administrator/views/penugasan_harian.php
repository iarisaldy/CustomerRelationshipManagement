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
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="<?php echo base_url("administrator/Penugasan/addCanvasing") ?>" class="btn btn-sm btn-info waves-effect waves-light pull-left"><i class="fa fa-plus"></i> Tambah Penugasan Harian</a>
                                <br/>&nbsp;
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="" method="post">
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <b>Distributor</b>
                                                                <select id="listDistributor" name="distributor" class="form-control show-tick">
                                                                    <option value="">Pilih Distributor</option>
                                                                    <?php
                                                                    foreach ($list_distributor as $ListJenisValue) { ?>
                                                                    <option value="<?php echo $ListJenisValue->KODE_DISTRIBUTOR; ?>"><?php echo $ListJenisValue->NAMA_DISTRIBUTOR; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                            
                                                                <b>Sales</b>
                                                                <select id="listSalesDistributor" name="sales" class="form-control show-tick">
                                                                    <option value="">Pilih Sales</option>
                                                                    <?php
                                                                    foreach ($list_sales as $ListJenisValue) { ?>
                                                                    <option value="<?php echo $ListJenisValue->ID_SALES; ?>"><?php echo $ListJenisValue->NAMA; ?></option>
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
                                                        <button class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" onclick="exportTableToExcel('tableKunjungan')"><span class="fa fa-file-excel-o"></span> Export </button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="tableKunjungan" class="table table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
                                                                <th>Surveyor</th>
                                                                <th>Posisi</th>
                                                                <th>Distributor</th>
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
        listKunjungan(null, null, startDate, endDate);

        // filterJenisUser("#filterJenisUser");
        // filterDistributor("#filterDistributor");
        // filterProvinsi("#filterProvinsi");
        // filterSalesDistributor("#filterSalesDistributor");
        $('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $("#startDate, #endDate").blur(); 
		
							
    });

    $(document).on("click", "#btnUpdateCanvassing", function(e){
        var idKunjungan = $(this).data("kunjungan");
        window.location.href = "<?php echo base_url(); ?>sales/RoutingCanvasing/updateCanvasing/"+idKunjungan;
    });

    $(document).on("click", "#btnExport", function(e){
        e.preventDefault();
        var posisi = $("#listJenisUser").val();
        var distributor = $("#listDistributor").val();
        var provinsi = $("#listProvinsi").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var salesDistributor = $("#listSalesDistributor").val();
        window.open("<?php echo base_url()?>sales/ExportSurvey/canvassing?posisi="+posisi+"&dist="+distributor+"&prov="+provinsi+"&start="+startDate+"&end="+endDate+"&sales="+salesDistributor,"_blank");
    });

    $(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
        var posisi = $("#listJenisUser").val();
        var distributor = $("#listDistributor").val();
        var provinsi = $("#listProvinsi").val();
        var salesDistributor = $("#listSalesDistributor").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        //console.log(salesDistributor);
        listKunjungan(distributor, salesDistributor, startDate, endDate);
    });
    
    $(document).on("click", "#btnDeleteCanvassing", function(e){
        var r = confirm("Yakin ingin menghapus data kunjungan ?");
        var idKunjungan = $(this).data("kunjungan");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url(); ?>sales/RoutingCanvasing/deleteCanvassing",
                type: "POST",
                data: {
                    "id_kunjungan_customer" : idKunjungan
                },
                success: function(data){
                    listKunjungan();
                    var startDate = $("#startDate").val();
                    var endDate = $("#endDate").val();
                    listKunjungan(null, null, null, startDate, endDate);
                }
            });
        }
    });

    function listKunjungan(distributor = null, sales = null, startDate = null, endDate = null){
        $('#tableKunjungan').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Penugasan/listCanvassing'); ?>",
                type: "POST",
                data: {
                	"distributor" : distributor,
                    "sales_distributor" : sales,
                    "start_date" : startDate,
                    "end_date" : endDate
                }
            },
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
	
	var filename = 'Penugasan Sales '+uniq_title+' ('+todayDate+ ' '+todayTime+')';
    
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