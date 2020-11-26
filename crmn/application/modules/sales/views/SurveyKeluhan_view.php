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
                        <h2>Input Survey Keluhan</h2>
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
                                                    <option value="0">Choose Schedule</option>
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
                                            <table id="tableKeluhan" class="table table-bordered" width="100%" style="text-align:center;">
                                                <thead style="background-color: #00bcd4; color: white;">
                                                    <tr>
                                                        <td>No</td>
                                                        <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                                        <td>Nama Toko</td>
                                                        <?php } ?>
                                                        <td>Tanggal Kunjungan</td>
                                                        <td>Nama Produk</td>
                                                        <td>Semen Membatu</td>
                                                        <td>Kantong Semen Tidak Kuat</td>
                                                        <td>Semen Terlambat Datang</td>
                                                        <td>Harga Tidak Stabil</td>
                                                        <td>Semen Rusak Saat Diterima</td>
                                                        <td>TOP Kurang Lama</td>
                                                        <td>Pemesanan Sulit</td>
                                                        <td>Komplain Sulit</td>
                                                        <td>Stok Sering Kosong</td>
                                                        <td>Prosedur Pembayaran Rumit</td>
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
                                <h4 class="modal-title" id="defaultModalLabel">Add Survey Keluhan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">

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

                                        <div class="demo-checkbox" style="margin-left:10%;">
                                            <?php foreach ($quest as $questKey => $questValue) { ?>
                                                <input type="checkbox" value="Y" id="<?php echo strtolower(str_replace(" ", "", $questValue->KELUHAN)); ?>" class="filled-in chk-col-cyan"/>
                                                <label for="<?php echo strtolower(str_replace(" ", "", $questValue->KELUHAN)); ?>"><?php echo $questValue->KELUHAN; ?></label>
                                                <br/>
                                            <?php } ?>
                                        </div>
                                        <hr/>
                                        <div class="row clearfix" id="freeTextKeluhan" style="display:none;">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea id="inputKeluhan" rows="3" type="text" class="form-control" placeholder="Keluhan Lain-Lain"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnAddSurveyKeluhan" type="button" class="btn btn-info waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal add survey -->

            <!-- Modal Update survey -->
            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">Update Survey Keluhan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">

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

                                        <div class="demo-checkbox" style="margin-left:10%;">
                                            <?php foreach ($quest as $questKey => $questValue) { ?>
                                                <input type="checkbox" value="Y" id="<?php echo strtolower(str_replace(" ", "", $questValue->KELUHAN)); ?>_edit" class="filled-in chk-col-cyan"/>
                                                <label for="<?php echo strtolower(str_replace(" ", "", $questValue->KELUHAN)); ?>_edit"><?php echo $questValue->KELUHAN; ?></label>
                                                <br/>
                                            <?php } ?>
                                        </div>
                                        <hr/>
                                        <div class="row clearfix" id="freeTextKeluhanEdit" style="display:none;">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea id="inputKeluhan_edit" rows="3" type="text" class="form-control" placeholder="Keluhan Lain-Lain"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnUpdateSurveyKeluhan" type="button" class="btn btn-info waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal update survey -->

        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        tableSurveyKeluhan(0);

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
        tableSurveyKeluhan(0, provinsi, merkProduk, startDate, endDate);
    });


    $(document).on("change", "#listCanvasing", function(){
        var idKunjungan = $(this).val();
        if(idKunjungan != ""){
            $("#btnAddNewSurvey").html("<button id='showFormSurvey' class='btn btn-info' data-toggle='modal' data-target='#defaultModal'><i class='fa fa-plus'></i> Add Survey</button>");
        } else {
            $("#btnAddNewSurvey").html("");
        }
        tableSurveyKeluhan(idKunjungan);
    });

    $(document).on("click", "#btnAddSurveyKeluhan", function(e){
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();
        var idProduk = $("#listProduct").val();
        if(idProduk == ""){
            alert("Pilih Produk Terlebih dahulu");
        } else {
            var semenMembatu = $("#semenmembatu:checked").val();
            var semenTerlambatDatang = $("#sementerlambatdatang:checked").val();
            var kantongTdkKuat = $("#kantongsementidakkuat:checked").val();
            var hargaTdkStabil = $("#hargatidakstabil:checked").val();
            var semenRusak = $("#semenrusaksaatditerima:checked").val();
            var top_lama = $("#topkuranglama:checked").val();
            var pemesananSulit = $("#pemesanansulit:checked").val();
            var komplainSulit = $("#komplainsulit:checked").val();
            var stokKosong = $("#stokseringkosong:checked").val();
            var pembayaranRumit = $("#prosedurpembayaranrumit:checked").val();
            var tidakSesuai = $("#tidaksesuaispesifikasi:checked").val();
            var tidakAdaKeluhan = $("#tidakadakeluhan:checked").val();
            var keluhanLain = $("#inputKeluhan").val();
            $.ajax({
                url: "<?php echo base_url() ?>sales/SurveyKeluhan/addSurveyKeluhan",
                type: "POST",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "id_produk" : idProduk,
                    "semen_membatu" : semenMembatu,
                    "semen_terlambat_datang" : semenTerlambatDatang,
                    "kantong_semen_tidak_kuat" : kantongTdkKuat,
                    "harga_tidak_stabil" : hargaTdkStabil,
                    "semen_rusak" : semenRusak,
                    "top_kurang_lama" : top_lama,
                    "pemesanan_sulit" : pemesananSulit,
                    "komplain_sulit" : komplainSulit,
                    "stok_kosong" : stokKosong,
                    "pembayaran_rumit" : pembayaranRumit,
                    "tidak_sesuai" : tidakSesuai,
                    "tidak_keluhan" : tidakAdaKeluhan,
                    "lain_lain" : keluhanLain
                },
                beforeSend: function(xhr){
                    $("#btnAddSurveyKeluhan").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
                },
                success: function(data){
                    $("#btnAddSurveyKeluhan").html("SAVE");
                    var datas = JSON.parse(data);
                    if(datas.status == "success"){
                        $("#defaultModal").modal("hide");
                        tableSurveyKeluhan(idKunjungan);
                        $("#inputKeluhan").val("");
                        $("#freeTextKeluhan").css("display", "none");
                        $('input:checkbox').removeAttr('checked');
                    }
                }
            });
        }
    });

    $(document).on("click", "#btnDetailSurvey", function(e){
        $('input:checkbox').removeAttr('checked');
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();
        var idSurvey = $(this).data("idsurvey");
        var idProduk = $(this).data("idproduk");
        $.ajax({
            url: "<?php echo base_url() ?>sales/SurveyKeluhan/detailSurveyKeluhan",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_kunjungan": idSurvey,
                "id_produk": idProduk
            },
            success: function(data){
                var datas = data.data[0];
                $("#listProductEdit").val(datas.ID_PRODUK).change();
                if (datas.SEMEN_MENBATU == "Y") $("#semenmembatu_edit").prop("checked", "checked");
                if (datas.SEMEN_TERLAMBAT_DATANG == "Y") $("#sementerlambatdatang_edit").prop("checked", "checked");
                if (datas.KANTONG_TIDAK_KUAT == "Y") $("#kantongsementidakkuat_edit").prop("checked", "checked");
                if (datas.HARGA_TIDAK_STABIL == "Y") $("#hargatidakstabil_edit").prop("checked", "checked");
                if (datas.SEMEN_RUSAK_SAAT_DITERIMA == "Y") $("#semenrusaksaatditerima_edit").prop("checked", "checked");
                if (datas.TOP_KURANG_LAMA == "Y") $("#topkuranglama_edit").prop("checked", "checked");
                if (datas.PEMESANAN_SULIT == "Y") $("#pemesanansulit_edit").prop("checked", "checked");
                if (datas.KOMPLAIN_SULIT == "Y") $("#komplainsulit_edit").prop("checked", "checked");
                if (datas.STOK_SERING_KOSONG == "Y") $("#stokseringkosong_edit").prop("checked", "checked");
                if (datas.PROSEDUR_RUMIT == "Y") $("#prosedurpembayaranrumit_edit").prop("checked", "checked");
                if (datas.TIDAK_SESUAI_SPESIFIKASI == "Y") $("#tidaksesuaispesifikasi_edit").prop("checked", "checked");
                if (datas.TIDAK_ADA_KELUHAN == "Y") $("#tidakadakeluhan_edit").prop("checked", "checked");
                // if (datas.KELUHAN_LAIN_LAIN == "Y") $("#keluhanlainedit").attr("checked", "checked");
                if(datas.KELUHAN_LAIN_LAIN !== null){
                    $("#keluhanlain_edit").prop('checked',true);
                    $("#freeTextKeluhanEdit").css("display", "block");
                    $("#inputKeluhan_edit").val(datas.KELUHAN_LAIN_LAIN);
                } else {
                    $("#freeTextKeluhanEdit").css("display", "none");
                    $("#keluhanlain_edit").prop('checked',false);
                }
                $("#updateModal").modal("show");
            }
        });
    });

    $(document).on("click", "#btnUpdateSurveyKeluhan", function(e){
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();
        var idProduk = $("#listProductEdit").val();
        var semenMembatu = $("#semenmembatu_edit:checked").val();
        var semenTerlambatDatang = $("#sementerlambatdatang_edit:checked").val();
        var kantongTdkKuat = $("#kantongsementidakkuat_edit:checked").val();
        var hargaTdkStabil = $("#hargatidakstabil_edit:checked").val();
        var semenRusak = $("#semenrusaksaatditerima_edit:checked").val();
        var top_lama = $("#topkuranglama_edit:checked").val();
        var pemesananSulit = $("#pemesanansulit_edit:checked").val();
        var komplainSulit = $("#komplainsulit_edit:checked").val();
        var stokKosong = $("#stokseringkosong_edit:checked").val();
        var pembayaranRumit = $("#prosedurpembayaranrumit_edit:checked").val();
        var tidakSesuai = $("#tidaksesuaispesifikasi_edit:checked").val();
        var tidakAdaKeluhan = $("#tidakadakeluhan_edit:checked").val();
        // var keluhanLain = $("#inputKeluhan_edit").val();
        if($('#keluhanlain_edit').prop('checked') == true){
            var keluhanLain = $("#inputKeluhan_edit").val();
        } else {
            var keluhanLain = null;
        }
        // console.log(keluhanLain);
        $.ajax({
            url: "<?php echo base_url() ?>sales/SurveyKeluhan/updateSurveyKeluhan",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_kunjungan" : idKunjungan,
                "id_produk" : idProduk,
                "semen_membatu" : semenMembatu,
                "semen_terlambat_datang" : semenTerlambatDatang,
                "kantong_semen_tidak_kuat" : kantongTdkKuat,
                "harga_tidak_stabil" : hargaTdkStabil,
                "semen_rusak" : semenRusak,
                "top_kurang_lama" : top_lama,
                "pemesanan_sulit" : pemesananSulit,
                "komplain_sulit" : komplainSulit,
                "stok_kosong" : stokKosong,
                "pembayaran_rumit" : pembayaranRumit,
                "tidak_sesuai" : tidakSesuai,
                "tidak_keluhan" : tidakAdaKeluhan,
                "lain_lain" : keluhanLain
            },
            beforeSend: function(xhr){
                $("#btnUpdateSurveyKeluhan").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
            },
            success: function(data){
                $("#btnUpdateSurveyKeluhan").html("SAVE");
                if(data.status == "success"){
                    $("#updateModal").modal("hide");
                    tableSurveyKeluhan(idKunjungan);
                }
            }
        });
    });

    $(document).on("click", "#btnDeleteSurvey", function(e){
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();
        var idSurvey = $(this).data("idsurvey");
        var idProduk = $(this).data("idproduk");

        var r = confirm("Yakin ingin menghapus data survey keluhan ?");
        if(r == true){
            $.ajax({
                url: "<?php echo base_url() ?>sales/SurveyKeluhan/deleteSurveyKeluhan",
                type: "POST",
                data: {
                    "id_kunjungan" : idSurvey,
                    "id_produk" : idProduk
                },
                success: function(data){
                    tableSurveyKeluhan(idKunjungan);
                }
            });
        }
    });

    $(document).on("change", "#keluhanlain", function(){
        if(this.checked) {
            $("#inputKeluhan").val("");
            $("#freeTextKeluhan").css("display", "block");
        } else {
            $("#freeTextKeluhan").css("display", "none");
        }
    });

    $(document).on("change", "#keluhanlain_edit", function(){
        if(this.checked) {
            $("#freeTextKeluhanEdit").css("display", "block");
        } else {
            $("#freeTextKeluhanEdit").css("display", "none");
        }
    });

    function tableSurveyKeluhan(idKunjungan = null, provinsi = null, merkProduk = null, startDate = null, endDate = null){
        $("#tableKeluhan").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/SurveyKeluhan/listSurveyKeluhan'); ?>",
                type: "POST",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "provinsi" : provinsi,
                    "merk" : merkProduk,
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