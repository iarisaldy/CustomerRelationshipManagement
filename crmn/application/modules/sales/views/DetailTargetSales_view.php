<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Detail Target Sales </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <a href="<?php echo base_url("sales/TargetSales"); ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                                <p>&nbsp;</p>
                                <div class="card">
                                    <div class="body">
                                    <div id="notif-success"></div>
                                        <form class="form-horizontal" method="post">
                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Salesman : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div id="selectSales"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Bulan : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <select id="bulan" class="form-control show-tick" data-size="5">
                                                            <option>Pilih Bulan</option>
                                                            <?php for($j=1;$j<=12;$j++){
                                                                $dateObj   = DateTime::createFromFormat('!m', $j);
                                                                $monthName = $dateObj->format('F');
                                                            ?>
                                                            <option value="<?php echo $j; ?>" ><?php echo $monthName; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Tahun : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <select id="tahun" class="form-control show-tick">
                                                            <option>Pilih Tahun</option>
                                                            <?php for($tahun=date('Y')-1;$tahun<=date('Y')+1;$tahun++){ ?>
                                                                <option value="<?php echo $tahun; ?>" ><?php echo $tahun; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Volume : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" id="volume" class="form-control" placeholder="Target Volume Sales">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Revenue : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" id="revenue" class="form-control" placeholder="Target Revenue Sales">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">Kunjungan : </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" id="kunjungan" class="form-control" placeholder="Target Kunjungan Sales">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button id="addTargetSales" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Target</button>
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
    var idTargetSales = "<?php echo $this->uri->segment("4"); ?>";
    
    $(document).ready(function(e){
        $.ajax({
            "url" : "<?php echo base_url(); ?>sales/TargetSales/detailTargetSales/"+idTargetSales,
            "type" : "GET",
            "dataType" : "JSON",
            success: function(data){
                listSales("#selectSales", data.data[0].ID_SALES);
                $("#bulan").val(data.data[0].BULAN).change();
                $("#tahun").val(data.data[0].TAHUN).change();
                $("#volume").val(data.data[0].VOLUME);
                $("#revenue").val(data.data[0].REVENUE);
                $("#kunjungan").val(data.data[0].KUNJUNGAN);
            }
        })
    });

    $(document).on("click", "#addTargetSales", function(e){
        e.preventDefault();
        var idSales = $("#listSales").val();
        var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        var volume = $("#volume").val();
        var revenue = $("#revenue").val();
        var kunjungan = $("#kunjungan").val();
        $.ajax({
            url: "<?php echo base_url(); ?>sales/TargetSales/actionUpdateTarget",
            type: "POST",
            data: {
                "id_target_sales": idTargetSales,
                "id_sales": idSales,
                "id_distributor": idDistributor,
                "bulan": bulan,
                "tahun" : tahun,
                "volume" : volume,
                "revenue" : revenue,
                "kunjungan" : kunjungan
            },
            beforeSend: function(xhr){
                $("#addTargetSales").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
            },
            success: function(data){
                var json = JSON.parse(data);
                $("#addTargetSales").html("<i class='fa fa-save'></i> Simpan Target");
                if(json.status == "success"){
                    $(".btn-danger").html('<i class="fa fa-arrow-left"></i> Back');
                    $("#notif-success").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success !</strong> Perubahan Target Sales Berhasil.</div>');
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

    function listSales(key, value){
        var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/salesDistributor/"+idDistributor,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listSales" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Sales</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $("#listSales").val(value);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>