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
					<div class="header bg-cyan">
                        <h2>Input Survey Program Promosi</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            <?php if($this->session->userdata("id_jenis_user") != "1001"){ ?>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Schedule Customer : </label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select id="listCanvasing" class="form-control show-tick" data-live-search="true" data-size="5">
                                                    <option value="">Choose Schedule</option>
                                                    <?php foreach($canvasing as $canvasingKey => $canvasingValue){ ?>
                                                    <option data-idtoko="<?php echo $canvasingValue->ID_TOKO; ?>" value="<?php echo $canvasingValue->ID_KUNJUNGAN_CUSTOMER ?>"><?php echo $canvasingValue->NAMA_TOKO." / ".$canvasingValue->CHECKIN_TIME; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                                <div class="card">
                                    <div class="header" id="btnAddNewSurvey" style="display: none;"></div>
                                    <div class="body">

                                        <div class="container-fluid">
                                        <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                            <div class="row">
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                    <div class="form-group">
                                                        <div class="form-line" id="filterProvinsi"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                    <div class="form-group">
                                                        <div class="form-line" id="filterMerk"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <b>Tanggal Awal</b>
                                                            <input type="text" id="startDate" value="<?php echo date('Y')."-".date('m')."-"."01" ?>" class="form-control" placeholder="Tanggal Awal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <b>Tanggal Akhir</b>
                                                            <input type="text" id="endDate" value="<?php $lastDayThisMonth = date("Y-m-t"); echo $lastDayThisMonth; ?>" class="form-control" placeholder="Tanggal Akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <b>&nbsp</b><br/>
                                                    <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                            <table id="tablePromosi" class="table table-bordered" width="100%" style="text-align:center;">
                                                <thead style="background-color: #00bcd4; color: white;">
                                                    <tr>
                                                        <td>No</td>
                                                        <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                                        <td>Nama Toko</td>
                                                        <?php } ?>
                                                        <td>Tanggal Kunjungan</td>
                                                        <td>Nama Produk</td>
                                                        <td>Bonus Semen</td>
                                                        <td>Setiap Pembelian</td>
                                                        <td>Wisata</td>
                                                        <td>Point Reward</td>
                                                        <td>Voucher</td>
                                                        <td>Potongan Harga</td>
                                                        <td>Lain-lain</td>
                                                        <td>Action</td>
                                                     </tr>
                                                </thead>
                                            </table>                                        
                                        </div>

                                    </div>
                                </div>

                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->

                <!-- Modal add survey -->
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">Add Survey Program Promosi</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">

                                    <form class="form-horizontal">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Product Name : </label>
                                            </div>  
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select data-size="7" id="listProduct" class="form-control show-tick" data-live-search="true">
                                                            <option value="">Choose Product</option>
                                                            <?php foreach ($product as $productKey => $productValue) { ?>
                                                            <option value="<?php echo $productValue->ID_PRODUK; ?>"><?php echo $productValue->NAMA_PRODUK; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Bonus Semen : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="bonusSemen" type="number" class="form-control" placeholder="Bonus Semen">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Setiap Pembelian : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="setiapPembelian" type="number" class="form-control" placeholder="Setiap Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Voucher : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="voucher" type="number" class="form-control" placeholder="Voucher">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Potongan Pembelian : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="potonganPembelian" type="number" class="form-control" placeholder="Potongan Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Wisata : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="wisata" type="text" class="form-control" placeholder="Bonus Wisata">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Poin Reward : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="poinReward" type="text" class="form-control" placeholder="Bonus Poin Reward">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Promosi Lain-lain : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="promosiLain" type="text" class="form-control" placeholder="Promosi Lain-lain">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnAddSurveyPromosi" type="button" class="btn btn-info waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal add survey -->

            <!-- Modal add survey -->
            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">Update Survey Program Promosi</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">

                                    <form class="form-horizontal">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Product Name : </label>
                                            </div>  
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select data-size="7" id="listProductEdit" class="form-control show-tick" data-live-search="true">
                                                            <option value="">Choose Product</option>
                                                            <?php foreach ($product as $productKey => $productValue) { ?>
                                                            <option value="<?php echo $productValue->ID_PRODUK; ?>"><?php echo $productValue->NAMA_PRODUK; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Bonus Semen : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="bonusSemenEdit" type="number" class="form-control" placeholder="Bonus Semen">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Setiap Pembelian : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="setiapPembelianEdit" type="number" class="form-control" placeholder="Setiap Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Voucher : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="voucherEdit" type="number" class="form-control" placeholder="Voucher">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Potongan Pembelian : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="potonganPembelianEdit" type="number" class="form-control" placeholder="Potongan Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Wisata : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="wisataEdit" type="text" class="form-control" placeholder="Bonus Wisata">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Poin Reward : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="poinRewardEdit" type="text" class="form-control" placeholder="Bonus Poin Reward">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Promosi Lain-lain : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="promosiLainEdit" type="text" class="form-control" placeholder="Promosi Lain-lain">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnUpdateSurveyPromosi" type="button" class="btn btn-info waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal add survey -->
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        tableSurveyPromosi(0);

        $('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        filterProvinsi("#filterProvinsi");
        filterMerk("#filterMerk");
    });

    $(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
        var provinsi = $("#listProvinsi").val();
        var merkProduk = $("#listMerk").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        tableSurveyPromosi(0, provinsi, merkProduk, startDate, endDate);
    });


    $(document).on("change", "#listCanvasing", function(){
        var idKunjungan = $(this).val();
        if(idKunjungan != ""){
            $("#btnAddNewSurvey").html("<button id='showFormSurvey' class='btn btn-info' data-toggle='modal' data-target='#defaultModal'><i class='fa fa-plus'></i> Add Survey</button>");
        } else {
            $("#btnAddNewSurvey").html("");
        }
        tableSurveyPromosi(idKunjungan);
    });

    $(document).on("click", "#btnAddSurveyPromosi", function(e){
        var idKunjungan = $("#listCanvasing").val();
        var idProduk = $("#listProduct").val();
        if(idProduk == ""){
            alert("Pilih Produk Terlebih dahulu");
        } else {
            var bonusSemen = $("#bonusSemen").val();
            var setiapPembelian = $("#setiapPembelian").val();
            var voucher = $("#voucher").val();
            var potonganPembelian = $("#potonganPembelian").val();
            var wisata = $("#wisata").val();
            var poinReward = $("#poinReward").val();
            var promosiLain = $("#promosiLain").val();

            $.ajax({
                url: "<?php echo base_url(); ?>sales/SurveyPromosi/addSurveyPromosi",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "id_produk" : idProduk,
                    "bonus_semen" : bonusSemen,
                    "setiap_pembelian" : setiapPembelian,
                    "voucher" : voucher,
                    "potongan_pembelian" : potonganPembelian,
                    "wisata" : wisata,
                    "poin_reward" : poinReward,
                    "promosi_lain" : promosiLain
                },
                beforeSend: function(xhr){
                    $("#btnAddSurveyPromosi").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
                },
                success: function(data){
                    $("#btnAddSurveyPromosi").html("SAVE");
                    if(data.status == "success"){
                        $("#defaultModal").modal("hide");
                        tableSurveyPromosi(idKunjungan);
                        $("#bonusSemen, #setiapPembelian, #voucher, #potonganPembelian, #promosiLain, #wisata, #poinReward").val("");
                        $("#listProduct").val("").change();
                        // $('input:checkbox').removeAttr('checked');
                    }
                }
            });
        }
    });

    $(document).on("click", "#btnDetailSurvey", function(e){
        var idKunjungan = $("#listCanvasing").val();
        var idProduk = $(this).data("idproduk");

        $.ajax({
            url: "<?php echo base_url(); ?>sales/SurveyPromosi/detailSurveyPromosi",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_kunjungan" : idKunjungan,
                "id_produk" : idProduk
            },
            success: function(data){
                var datas = data.data[0];
                $("#listProductEdit").val(datas.ID_PRODUK).change();
                $("#bonusSemenEdit").val(datas.BONUS_SEMEN);
                $("#setiapPembelianEdit").val(datas.SETIAP_PEMBELIAN);
                $("#voucherEdit").val(datas.VOUCER);
                $("#potonganPembelianEdit").val(datas.POTONGAN_HARGA);
                $("#wisataEdit").val(datas.BONUS_WISATA);
                $("#poinRewardEdit").val(datas.POINT_REWARD);
                $("#promosiLainEdit").val(datas.PROMOSI_LAIN);
                $("#updateModal").modal("show");
            }
        });
    });

    $(document).on("click", "#btnUpdateSurveyPromosi", function(e){
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();
        var idProduk = $("#listProductEdit").val();
        var bonusSemen = $("#bonusSemenEdit").val();
        var setiapPembelian = $("#setiapPembelianEdit").val();
        var voucher = $("#voucherEdit").val();
        var potonganPembelian = $("#potonganPembelianEdit").val();
        var wisata = $("#wisataEdit").val();
        var poinReward = $("#poinRewardEdit").val();
        var promosiLain = $("#promosiLainEdit").val();
        
        $.ajax({
           url: "<?php echo base_url(); ?>sales/SurveyPromosi/updateSurveyPromosi",
           type: "POST",
           dataType: "JSON",
           data: {
               "id_kunjungan" : idKunjungan,
               "id_produk" : idProduk,
               "bonus_semen" : bonusSemen,
               "setiap_pembelian" : setiapPembelian,
               "voucher" : voucher,
               "potongan_pembelian" : potonganPembelian,
               "wisata" : wisata,
               "poin_reward" : poinReward,
               "promosi_lain" : promosiLain
           },
           beforeSend: function(xhr){
                $("#btnUpdateSurveyPromosi").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
           },
           success: function(data){
                $("#btnUpdateSurveyPromosi").html("SAVE");
               if(data.status == "success"){
                   $("#updateModal").modal("hide");
                   tableSurveyPromosi(idKunjungan);
               }
           }
        });

    });

    $(document).on("click", "#btnDeleteSurvey", function(e){
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();
        var idProduk = $(this).data("idproduk");

        var r = confirm("Yakin ingin menghapus data survey keluhan ?");
        if(r == true){
            $.ajax({
                url: "<?php echo base_url(); ?>sales/SurveyPromosi/deleteSurveyPromosi",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "id_produk" : idProduk
                },
                success: function(data){
                    tableSurveyPromosi(idKunjungan);
                }
            });
        }
    });

    function tableSurveyPromosi(idKunjungan = null, provinsi = null, merk = null, startDate = null, endDate = null){
        $("#tablePromosi").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/SurveyPromosi/listSurveyPromosi'); ?>",
                type: "POST",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "provinsi" : provinsi,
                    "merk" : merk,
                    "start_date" : startDate,
                    "end_date" : endDate
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

    function filterMerk(key, value){
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/merkProduk",
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Merk Produk</b>';
                type_list += '<select id="listMerk" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Merk Produk</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['JENIS_PRODUK']+'">'+response[i]['JENIS_PRODUK']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>