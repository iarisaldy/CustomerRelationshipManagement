<style>
    table {
        /*display: block;*/
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
                        <h2>Resume Canvassing</h2>
                    </div>
                    
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            		<div class="card">
                                        <div class="body">
                                            <form>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="filterProvinsi"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="filterKota"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="filterMerk"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                                                        <b>&nbsp</b><br/>
                                                        <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                                <li role="presentation" class="active"><a href="#harga" data-toggle="tab">SURVEY HARGA, STOK & VOLUME</a></li>
                                                <li role="presentation"><a href="#promosi" data-toggle="tab">SURVEY PROMOSI</a></li>
                                                <li role="presentation"><a href="#keluhan" data-toggle="tab">SURVEY KELUHAN</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade in active" id="harga">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table id="tabelSurveyStok" class="table table-striped table-bordered" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Customer</th>
                                                                        <th>Merk</th>
                                                                        <th>Tanggal Survey</th>
                                                                        <th>Stok</th>
                                                                        <th>Harga Jual</th>
                                                                        <th>Harga Beli</th>
                                                                        <th>Volume Penjualan</th>
                                                                        <th>Volume Pembelian</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade in" id="promosi">
                                                    
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade in" id="keluhan">
                                                    <table id="resumeCanvassing" class="table table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
                                                                <th>Merk</th>
                                                                <th>Potongan Harga</th>
                                                                <th>Bonus Semen<sub>/Zak</sub></th>
                                                                <th>Poin</th>
                                                                <th>Voucher</th>
                                                                <th>Tour</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
<script type="text/javascript">
    var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user') ?>";

	$("document").ready(function(){
        if(idJenisUser == "1002" || idJenisUser == "1003" || idJenisUser == "1005" || idJenisUser == "1007"){
            var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
            promotion(idDistributor);
            survey(idDistributor, null, null, null);
        } else {
            promotion(null);
        }
        filterProvinsi("#filterProvinsi");
        filterKota("#filterKota", null, 0);
        filterMerk("#filterMerk");
	});

    $(document).on("change", "#listProvinsi", function(e){
        var idProvinsi = $(this).val();
        filterKota("#filterKota", null, idProvinsi);
    });


    $(document).on("click", "#btnFilter", function(e){
        var idProvinsi = $("#listProvinsi").val();
        var idKota = $("#listKota").val();
        var merkProduk = $("#listMerk").val();
        if(idJenisUser == "1002" || idJenisUser == "1003" || idJenisUser == "1005" || idJenisUser == "1007"){
            var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
            promotion(idDistributor, idProvinsi, idKota, merkProduk);
            survey(idDistributor, idProvinsi, idKota, merkProduk);
        } else {
            promotion(null, idProvinsi, idKota, merkProduk);
        }
    });


	function promotion(idDistributor = null, idProvinsi = null, idKota = null, merkProduk = null){
		$("#resumeCanvassing").dataTable({
			"destroy" : true,
			"ajax" : {
				"url" : "<?php echo base_url('distributor/ResumeCanvassing/promotion') ?>",
				"type" : "POST",
                "data" : {
                    "kode_distributor" : idDistributor,
                    "id_provinsi" : idProvinsi,
                    "id_kota" : idKota,
                    "merk_produk" : merkProduk
                }
			}
		});
	}

    function survey(idDistributor = null, idProvinsi = null, idKota = null, merkProduk = null){
        $("#tabelSurveyStok").dataTable({
            "destroy" : true,
            "ajax" : {
                "url" : "<?php echo base_url('distributor/ResumeCanvassing/survey') ?>",
                "type" : "POST",
                "data" : {
                    "kode_distributor" : idDistributor,
                    "id_provinsi" : idProvinsi,
                    "id_kota" : idKota,
                    "merk_produk" : merkProduk
                }
            }
        });
    }

    function filterProvinsi(key, value){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/FilterSurvey/provinsi",
		    type: "GET",
			dataType: "JSON",
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Provinsi</b>';
                type_list += '<select id="listProvinsi" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Provinsi</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function filterKota(key, value = null, idProvinsi = null){
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/kota/"+idProvinsi,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Kab / Kota</b>';
                type_list += '<select id="listKota" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Kota</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_DISTRIK']+'">'+response[i]['NAMA_DISTRIK']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function filterMerk(key, value = null){
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/merkProduk",
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Merk</b>';
                type_list += '<select id="listMerk" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Merk</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['GROUP_ID']+'">'+response[i]['JENIS_PRODUK']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>