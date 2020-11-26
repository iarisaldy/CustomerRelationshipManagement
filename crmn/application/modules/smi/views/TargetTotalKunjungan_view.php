<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Total Target Kunjungan</h2>
                    </div>
                    <div class="body">
                        <a href="<?php echo base_url('smi/KeyPerformanceIndicator'); ?>" class="btn btn-sm btn-info">Back</a>&nbsp;
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#largeModal">Tambah / Ubah Target Provinsi</button>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <table id="indexKpi" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Provinsi</th>
                                                <th>Total Target</th>
                                                <th>Aksi</th>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Target Kunjungan</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id="indexVolume">
                                            </div>
                                        </div>
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
        // indexKpi();
        listRegion("#filterRegion");
    });

    $(document).on("click", "#btnSaveIndex", function(e){
        e.preventDefault();
        var idJenisUser = <?php echo $this->session->userdata("id_jenis_user") ?>;
        if(idJenisUser == "1001"){
        	var region = $("#listRegion").val();
        	var kodeDist = null;
        } else if(idJenisUser == "1002") {
        	var region = null;
        	var kodeDist = '<?php echo $this->session->userdata("kode_dist") ?>';
        }
        
        var volume = $("#indexVolume").val();
        var harga = $("#indexHarga").val();
        var revenue = $("#indexRevenue").val();
        var kunjungan = $("#indexKunjungan").val();
        var totalIndex = parseInt(volume) + parseInt(harga) + parseInt(revenue) + parseInt(kunjungan);
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
                            "kunjungan" : kunjungan
                        },
                        success: function(data){
                            indexKpi();
                            $("#indexVolume, #indexHarga, #indexRevenue, #indexKunjungan").val("");
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
            url: "<?php echo base_url(); ?>smi/Region/listProvinsi",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listRegion" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">Pilih Region</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function indexKpi(){
        $("#indexKpi").dataTable({
            "destroy": "true",
            "ajax": {
                url: "<?php echo base_url('smi/KeyPerformanceIndicator/listIndexKpi'); ?>",
                type: "GET"
            }
        });
    }
</script>