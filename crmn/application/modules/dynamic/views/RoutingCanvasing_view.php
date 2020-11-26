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
                        <h2> Routing Canvasing </h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                            // echo $menusValue->ID_MENU;
                         if($menusValue->ID_MENU == '1011'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>
                    
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <?php if($this->session->userdata('id_jenis_user') == '1002' || $this->session->userdata('id_jenis_user') == '1007' 
								|| $this->session->userdata('id_jenis_user') == '1003' || $this->session->userdata('id_jenis_user') == '1005'){ ?>
                                <a href="<?php echo base_url("sales/RoutingCanvasing/addCanvasing") ?>" class="btn btn-sm btn-info waves-effect waves-light pull-left"><i class="fa fa-plus"></i> Add Schedule Canvasing</a>
                                <br/>&nbsp;
                                <?php } else if($this->session->userdata('id_jenis_user') == '1001' ){ ?>
                                    <a href="<?php echo base_url("sales/RoutingCanvasing/addCanvasing") ?>" class="btn btn-sm btn-info waves-effect waves-light pull-left"><i class="fa fa-plus"></i> Add Schedule Canvasing KAM / AM</a>
                                    <br/>&nbsp;
                                <?php } ?>

                                    <div class="card">
                                        <div class="body">

                                        <form>
                                            <div class="row clearfix">
                                            <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                            	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line" id="filterJenisUser"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line" id="filterDistributor"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line" id="filterProvinsi"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <b>Tanggal Awal</b>
                                                            <input type="text" id="startDate" value="<?php echo date('Y')."-".date('m')."-".date('d') ?>" class="form-control" placeholder="Tanggal Awal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <b>Tanggal Akhir</b>
                                                            <input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-t"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1005" || $this->session->userdata("id_jenis_user") == "1007"){ ?>
                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="form-line" id="filterSalesDistributor"></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                                    <b>&nbsp</b><br/>
                                                    <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                    <?php if($this->session->userdata("id_jenis_user") == "1001" || $this->session->userdata("id_jenis_user") == "1002" || $this->session->userdata("id_jenis_user") == "1005" || $this->session->userdata("id_jenis_user") == "1006" || $this->session->userdata("id_jenis_user") == "1007"){ ?>
                                                    <button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

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
                                                        <th>Assign</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        listKunjungan(null, null, null, startDate, endDate);
        filterJenisUser("#filterJenisUser");
        filterDistributor("#filterDistributor");
        filterProvinsi("#filterProvinsi");
        filterSalesDistributor("#filterSalesDistributor");
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
        listKunjungan(posisi, distributor, provinsi, startDate, endDate, salesDistributor);
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

    function listKunjungan(posisi = null, distributor = null, provinsi = null, startDate = null, endDate = null, sales = null){
        $('#tableKunjungan').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/RoutingCanvasing/listCanvassing'); ?>",
                type: "POST",
                data: {
                	"posisi" : posisi,
                	"distributor" : distributor,
                	"provinsi" : provinsi,
                    "sales_distributor" : sales,
                    "start_date" : startDate,
                    "end_date" : endDate
                }
            },
        });
    }

    function filterJenisUser(key, value){
        $.ajax({
		    url: "<?php echo base_url(); ?>sales/FilterSurvey/jenisUser",
		    type: "GET",
			dataType: "JSON",
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Posisi Surveyor</b>';
                type_list += '<select id="listJenisUser" class="form-control selectpicker show-tick">';
                type_list += '<option value="">Pilih Posisi Surveyor</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_JENIS_USER']+'">'+response[i]['JENIS_USER']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function filterSalesDistributor(key, value){
        var idDistributor = "<?php echo $this->session->userdata('kode_dist'); ?>";
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/salesDistributor/"+idDistributor,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Sales Distributor</b>';
                type_list += '<select id="listSalesDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih SalesMan</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

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
                type_list += '<option value="">Pilih Distributor</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['KODE_DISTRIBUTOR']+' - '+response[i]['NAMA_DISTRIBUTOR']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
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
</script>