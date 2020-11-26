<style type="text/css">
tr.group,
tr.group:hover {
    background-color: #ddd !important;
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Target KPI Sales</h2>
                    </div>
                    <div class="body">
                        <a href="<?php echo base_url('smi/KeyPerformanceIndicator'); ?>" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Back</a>&nbsp;
                        <a href="<?php echo base_url('sales/TargetSales/AddTargetSales'); ?>" class="btn btn-sm btn-warning">Tambah Target KPI Sales</a>
                        <p>&nbsp;</p>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                    <b>Bulan</b>
                                    <select data-size="5" id="filterBulan" class="form-control show-tick">
                                        <option>Pilih Bulan</option>
                                        <?php for($j=1;$j<=12;$j++){
                                            $dateObj   = DateTime::createFromFormat('!m', $j);
                                            $monthName = $dateObj->format('F');
                                        ?>
                                        <option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                    <b>Tahun</b>
                                    <select id="filterTahun" class="form-control show-tick">
                                        <option>Pilih Tahun</option>
                                        <?php $year = date('Y')-1;
                                            for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php if($i==date('Y')){echo "selected";} ?>><?php echo $i; ?></option>
                                        <?php } ?>    
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <b>&nbsp;</b><br/>
                                    <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                </div>
                            </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <table id="tableTargetSales" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Sales</th>
                                                <th>Distributor</th>
                                                <th>Volume <sub>/Zak</sub></th>
                                                <th>Harga <sub>/Rupiah</sub></th>
                                                <th>Revenue</th>
                                                <th>Kunjungan</th>
                                                <th width="13%">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
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
    var bulan = $("#filterBulan").val();
    var tahun = $("#filterTahun").val();

    $("document").ready(function(){
        listTargetSales(bulan, tahun);
    });

    $(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();
        listTargetSales(bulan, tahun);
    });

    $(document).on("click", "#btnDelete", function(e){
        var idTarget = $(this).data("idtarget");
        var q = confirm("Yakin ingin menghapus data target sales ?");
        if(q == true){
            $.ajax({
                "url" : "<?php echo base_url('sales/TargetSales/deleteTarget'); ?>/"+idTarget,
                "type" : "GET",
                "dataType" : "JSON",
                success: function(data){
                    alert("Berhasil Menghapus Target Sales");
                    listTargetSales(bulan, tahun);
                }
            })
        }
    });

    function listTargetSales(bulan, tahun){
        var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
        var groupColumn = 0;
        $("#tableTargetSales").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/TargetSales/listTarget'); ?>/"+idDistributor+"/"+bulan+"/"+tahun,
                type: "POST"
            }
        });
    }
</script>