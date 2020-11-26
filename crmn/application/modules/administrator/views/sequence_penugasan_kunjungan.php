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
                        <h2> Sequence Penugasan Harian </h2>
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
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
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
                                                                <b>Pilih Tanggal</b>
                                                                 <input type="text" id="startDate" value="<?php echo date('Y')."-".date('m')."-".date('d') ?>" class="form-control" placeholder="Tanggal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style="display: none;">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <b>Tanggal Akhir</b>
                                                                <input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-t"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <b>&nbsp;</b><br/>
                                                        <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="data_table_kunjungan" >
                                            <form action="" method="post">
                                                <div class="table-responsive">
                                                    <table id="tableKunjungan" class="table table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th >Sequence</th>
                                                                <th>Surveyor</th>
                                                                
                                                                <th>Customer / Toko</th>
                                                                <th>Alamat</th>
                                                                <th>Rencana Kunjungan</td>
                                                                
                                                                <th>Keterangan</th>
                                                                <th>Distributor</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <center>
                                                <button type="button" id="btnUpdateSequence" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-edit"></i> Update Sequence</button>
                                                </center>
                                            </form>
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
        var endDate = $("#startDate").val();//$("#endDate").val();
        listKunjungan(null, null, startDate, endDate);
        $('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $("#startDate, #endDate").blur(); 
        $('#data_table_kunjungan').hide();
        
    });


    $(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
        var posisi = $("#listJenisUser").val();
        var distributor = $("#listDistributor").val();
        var provinsi = $("#listProvinsi").val();
        var salesDistributor = $("#listSalesDistributor").val();
        var startDate = $("#startDate").val();
        var endDate = startDate;//$("#endDate").val();
        //console.log(salesDistributor);
        listKunjungan(distributor, salesDistributor, startDate, endDate);
        $('#data_table_kunjungan').show();
     
    });
    
    $(document).on("click", "#btnUpdateSequence", function(e){
        e.preventDefault();
        
        //update data kunjungan....
        updateSeqKunjungan();
        
        //menampilkan data
        var posisi = $("#listJenisUser").val();
        var distributor = $("#listDistributor").val();
        var provinsi = $("#listProvinsi").val();
        var salesDistributor = $("#listSalesDistributor").val();
        var startDate = $("#startDate").val();
        var endDate = startDate;//$("#endDate").val();
        //console.log(salesDistributor);
        listKunjungan(distributor, salesDistributor, startDate, endDate);
         $('#data_table_kunjungan').show();
    });
    
    
    function updateSeqKunjungan(){
        var konfirmasi = confirm("Yakin data anda sudah benar ?");
        var maxx = $('#sequencings_0').attr('max');
        //console.log(maxx);
        if (konfirmasi == true) {
            var i;
            var idKunjungans = new Array();
            var sequences = new Array();
            for(i = 0; i < maxx; i++ ){
                idKunjungans[i] = $("#idkunjungans_"+i).val();
                sequences[i]    = $("#sequencings_"+i).val();
                console.log(sequences[i]);
                console.log(idKunjungans[i]);
            }
            $.ajax({
                url: "<?php echo base_url('administrator/Penugasan/setSequencing'); ?>",
                type: "POST",
                data: {
                    "total_dt"      : maxx,
                    "id_kunjungans" : idKunjungans,
                    "sequences"     : sequences
                }
            });
        }
    }
    

    function listKunjungan(distributor = null, sales = null, startDate = null, endDate = null){
        $('#tableKunjungan').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Penugasan/listCanvassingSequencing'); ?>",
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


