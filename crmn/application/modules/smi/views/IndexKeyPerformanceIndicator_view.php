<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Index Key Performance Indicators</h2>
                    </div>
                    <div class="body">
                        <a href="<?php echo base_url('smi/KeyPerformanceIndicator'); ?>" class="btn btn-sm btn-danger">Back</a>&nbsp;
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#largeModal">Tambah / Ubah Index KPI</button>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <b>Bulan</b>
                                        <select data-size="5" id="filterBulan" class="form-control show-tick">
                                            <option>Pilih Bulan</option>
                                            <?php 
                                            for($j=1;$j<=12;$j++){
                                                $dateObj   = DateTime::createFromFormat('!m', $j);
                                                $monthName = $dateObj->format('F');
                                                ?>
                                                <option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <b>Tahun</b>
                                        <select id="filterTahun" class="form-control show-tick">
                                            <option>Pilih Tahun</option>
                                            <?php $year = date('Y')-1;
                                                for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i==date('Y')){echo "selected";} ?>><?php echo $i; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <br/>
                                        <button id="btnFilterAction" class="btn btn-info"><span class="fa fa-filter"></span> View</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table id="indexKpi" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <?php 
                                                	$idJenisUser = $this->session->userdata("id_jenis_user");
                                                	echo ($idJenisUser == "1001" ? "<th>Region</th>" : "<th>Distributor</th>");
                                                ?>
                                                <th>Volume</th>
                                                <th>Harga</th>
                                                <th>Revenue</th>
                                                <th>Kunjungan</th>
                                                <!-- 
												<th>Keep</th>
                                                <th>Get</th>
                                                <th>Growth</th>
                                                <th>SO/DO</th> 
												-->
                                                <th>Total Target Kunjungan Semua Sales</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
                <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="largeModalLabel">Tambah / Ubah Index KPI</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                	<?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                		<div class="col-md-12" id="filterRegion"></div>
                                	<?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b>Bulan</b>
                                            <select data-size="5" id="bulan" class="form-control show-tick">
                                                <option>Pilih Bulan</option>
                                                <?php 
                                                for($j=1;$j<=12;$j++){
                                                    $dateObj   = DateTime::createFromFormat('!m', $j);
                                                    $monthName = $dateObj->format('F');
                                                    ?>
                                                    <option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Volume</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexVolume">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexHarga">
                                            </div>
                                        </div>
                                        <!--  <div class="form-group">
                                            <label>Keep</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexKeep">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Growth</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexGrowth">
                                            </div>
                                        </div>  -->
                                        <div class="form-group">
                                            <label>Total Target Kunjungan Semua Sales</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="targetKunjungan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b>Tahun</b>
                                            <select id="tahun" class="form-control show-tick">
                                                <option>Pilih Tahun</option>
                                                <?php $year = date('Y')-1;
                                                    for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if($i==date('Y')){echo "selected";} ?>><?php echo $i; ?></option>
                                                <?php } ?>    
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Revenue</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexRevenue">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Kunjungan</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexKunjungan">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Get</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexGet">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>SO / DO</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexSo_Do">
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSaveIndex" class="btn btn-info waves-effect">SAVE INDEX</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("document").ready(function(){
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();
        indexKpi(bulan, tahun);
        listRegion("#filterRegion");
    });

    $(document).on("click", "#btnFilterAction", function(e){
        e.preventDefault();
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();
        indexKpi(bulan, tahun);
    });

    $(document).on("click", "#btnSaveIndex", function(e){
        e.preventDefault();
        var idJenisUser = <?php echo $this->session->userdata("id_jenis_user") ?>;
        if(idJenisUser == "1001"){
        	var region = $("#listRegion").val();
        	var kodeDist = null;
        } else if(idJenisUser == "1002") {
        	var region = '<?php echo $this->session->userdata("id_region") ?>';
        	var kodeDist = '<?php echo $this->session->userdata("kode_dist") ?>';
        }
        
        var volume = $("#indexVolume").val();
        var harga = $("#indexHarga").val();
        var revenue = $("#indexRevenue").val();
        var kunjungan = $("#indexKunjungan").val();
		//**
        var keep = $("#indexKeep").val();
        var get = $("#indexGet").val();
        var growth = $("#indexGrowth").val();
        var so_do = $("#indexSo_Do").val();
		//**
        var targetKunjungan = $("#targetKunjungan").val();
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        var totalIndex = parseInt(volume) + parseInt(harga) + parseInt(revenue) + parseInt(kunjungan) + parseInt(keep) + parseInt(get) + parseInt(growth) + parseInt(so_do);
        if(region != "0"){
            if(volume != "" || harga != "" || revenue != "" || kunjungan != ""){
                if(totalIndex > 100){
                    alert("Index Tidak Boleh Lebih dari 100");
                } else if(totalIndex < 100){
                    alert("Index Tidak Boleh Kurang dari 100");
                } else {
                    $.ajax({
                        url: "<?php echo base_url(); ?>smi/KeyPerformanceIndicator/tambahIndexKpi",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            "id_region" : region,
                            "kode_dist" : kodeDist,
                            "volume" : volume,
                            "harga" : harga,
                            "revenue" : revenue,
                            "kunjungan" : kunjungan,
                            "target_kunjungan" : targetKunjungan,
                            "bulan" : bulan,
                            "tahun" : tahun,
                            "keep" : keep,
                            "get" : get,
                            "growth" : growth,
                            "so_do" : so_do
                        },
                        success: function(data){
                            indexKpi(bulan, tahun);
                            $("#indexVolume, #indexHarga, #indexRevenue, #indexKunjungan, #indexKeep, #indexGet, #indexGrowth, #indexSo_Do").val("");
                            listRegion("#filterRegion");
                            $("#largeModal").modal("hide");
                        }
                    });
                }
            } else {
                alert("Semua Kategori Harus Memiliki Index");
            }
        } else {
            alert("Pilih Provinsi Terlebih dahulu");
        }
    });

    function listRegion(key){
        $.ajax({
            url: "<?php echo base_url(); ?>smi/Region/listRegion",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listRegion" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">Pilih Region</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_REGION']+'">'+response[i]['NAMA_REGION']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function indexKpi(bulan = null, tahun = null){
        $("#indexKpi").dataTable({
            "destroy": "true",
            "ajax": {
                url: "<?php echo base_url('smi/KeyPerformanceIndicator/listIndexKpi'); ?>/"+bulan+"/"+tahun,
                type: "GET"
            }
        });
    }
</script>