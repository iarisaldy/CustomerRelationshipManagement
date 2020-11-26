<?php if($this->session->userdata("id_jenis_user") == "1001" || $this->session->userdata("id_jenis_user") == "1003" || $this->session->userdata("id_jenis_user") == "1007"){ ?>
<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<?php } ?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Input Survey Customer (Stok, Harga & Volume)</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">

                            <?php if($this->session->userdata("id_jenis_user") != "1001"){ ?>
                                <?php if($this->session->userdata("id_jenis_user") != "1002"){ ?>
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
                            <?php } ?>

                                <div class="card">
                                    <div class="header" id="btnAddNewSurvey">
                                        <!-- <button class="btn btn-info" data-toggle="modal" data-target="#defaultModal"><i class="fa fa-plus"></i> Add Survey</button> -->
                                    </div>
                                    <div class="body">
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
                                        <div class="container-fluid">
                                            <table id="tableHarga" class="table table-bordered" width="100%" style="text-align:center;">
                                                <thead style="background-color: #00bcd4; color: white;">
                                                    <tr>
                                                        <td>No</td>
                                                        <?php if($this->session->userdata("id_jenis_user") == "1001" || $this->session->userdata("id_jenis_user") == "1002"){ ?>
                                                        <td>Tanggal Survey</td>
                                                        <td>Nama Toko</td>
                                                        <?php } ?>
                                                        <td>Nama Produk</td>
                                                        <td>Stok<sub>/zak</sub></td>
                                                        <td>Harga Beli</td>
                                                        <td>Harga Jual</td>
                                                        <td>Term of Payment</td>
                                                        <td>Volume Pembelian<sub>/zak</sub></td>
                                                        <td>Volume Penjualan<sub>/zak</sub></td>
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

                <!-- Start Modal -->
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">Add New Survey</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
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
                                        <input id="idKunjungan" type="hidden" class="form-control">
                                        <input id="idToko" type="hidden" class="form-control">
                                        <!-- <input -->
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Stok Toko<sub>/zak</sub> : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="stokToko" type="number" class="form-control" placeholder="Jumlah Stok Toko">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Harga Beli : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="hargaBeli" type="number" class="form-control" placeholder="Harga Beli Satuan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Harga Jual : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="hargaJual" type="number" class="form-control" placeholder="Harga Jual Satuan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Term of Payment : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="topPembelian" type="number" class="form-control" placeholder="TOP Pembayaran">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Tanggal Pembelian : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="tglPembelian" type="text" class="datepicker form-control" placeholder="Tanggal Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Volume Pembelian<sub>/zak</sub> : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="volPembelian" type="number" class="form-control" placeholder="Volume Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Volume Penjualan<sub>/zak</sub> : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="volPenjualan" type="number" class="form-control" placeholder="Volume Penjualan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnAddSurvey" type="button" class="btn btn-info waves-effect">SAVE SURVEY</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

                <!-- Modal Update Survey -->
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">Update Survey</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form class="form-horizontal">

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Product Name : </label>
                                            </div>
                                            
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select data-size="7" id="editListProduct" class="form-control show-tick" data-live-search="true">
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
                                        <input id="editIdSurvey" type="hidden" />
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Stok Toko<sub>/zak</sub> : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editStokToko" type="number" class="form-control" placeholder="Jumlah Stok Toko">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Harga Beli : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editHargaBeli" type="number" class="form-control" placeholder="Harga Beli Satuan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Harga Jual : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editHargaJual" type="number" class="form-control" placeholder="Harga Jual Satuan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Term of Payment : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editTopPembelian" type="number" class="form-control" placeholder="TOP Pembayaran">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Tanggal Pembelian : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editTglPembelian" type="text" class="datepicker form-control" placeholder="Tanggal Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Volume Pembelian<sub>/zak</sub> : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editVolPembelian" type="number" class="form-control" placeholder="Volume Pembelian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Volume Penjualan<sub>/zak</sub> : </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input id="editVolPenjualan" type="number" class="form-control" placeholder="Volume Penjualan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnEditSurvey" type="button" class="btn btn-info waves-effect">SAVE SURVEY</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Update Survey -->
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(e){
        $('#tglPembelian, #editTglPembelian').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        tableSurveyHarga(0);
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
        tableSurveyHarga(0, provinsi, merkProduk, startDate, endDate);
    });

    $(document).on("change", "#listCanvasing", function(){
        var idKunjungan = $(this).val();
        if(idKunjungan != ""){
            $("#btnAddNewSurvey").html("<button id='showFormSurvey' class='btn btn-info' data-toggle='modal' data-target='#defaultModal'><i class='fa fa-plus'></i> Add Survey</button>");
        } else {
            $("#btnAddNewSurvey").html("");
        }
        tableSurveyHarga(idKunjungan);
    });

    $(document).on("click", "#showFormSurvey", function(e){
        $("#idKunjungan").val($("#listCanvasing").val());
        $("#idToko").val($("#listCanvasing :checked").data("idtoko"));
    });

    $(document).on("click", "#btnAddSurvey", function(e){
        e.preventDefault();
        var idKunjungan = $("#idKunjungan").val();
        var idProduk = $("#listProduct").val();
        var idToko = $("#idToko").val();
        var stok = $("#stokToko").val();
        var hargaBeli = $("#hargaBeli").val();
        var hargaJual = $("#hargaJual").val();
        var topPembelian = $("#topPembelian").val();
        var tglPembelian = $("#tglPembelian").val();
        var volPembelian = $("#volPembelian").val();
        var volPenjualan = $("#volPenjualan").val();
        
        $.ajax({
            url: "<?php echo base_url(); ?>sales/InputData/addSurveyToko",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_kunjungan" : idKunjungan,
                "id_produk" : idProduk,
                "id_toko" : idToko,
                "stok" : stok,
                "harga_beli" : hargaBeli,
                "harga_jual" : hargaJual,
                "top" : topPembelian,
                "tgl_beli" : tglPembelian,
                "vol_beli" : volPembelian,
                "vol_jual" : volPenjualan
            },
            beforeSend: function(xhr){
                $("#btnAddSurvey").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
            },
            success: function(data){
                $("#btnAddSurvey").html("SAVE SURVEY");
                if(data.status == "success"){
                    tableSurveyHarga(idKunjungan);
                    $("#defaultModal").modal("hide");
                    $("#listProduct").val("").change();
                    $("#stokToko, #hargaBeli, #hargaJual, #topPembelian, #tglPembelian, #volPembelian, #volPenjualan").val("");
                }
            }
        });
    });

    $(document).on("click", "#btnDetailSurvey", function(e){
        var idSurvey = $(this).data("idsurvey");
        $.ajax({
            url: "<?php echo base_url(); ?>sales/InputData/detailSurvey/"+idSurvey,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $("#updateModal").modal("show");
                $("#editIdSurvey").val(data.data[0].ID_HASIL_SURVEY);
                $("#editListProduct").val(data.data[0].ID_PRODUK).change();
                $("#editStokToko").val(data.data[0].STOK_SAAT_INI);
                $("#editHargaBeli").val(data.data[0].HARGA_PEMBELIAN);
                $("#editHargaJual").val(data.data[0].HARGA_PENJUALAN);
                $("#editTopPembelian").val(data.data[0].TOP_PEMBELIAN);
                $("#editTglPembelian").val(data.data[0].TGL_PEMBELIAN);
                $("#editVolPembelian").val(data.data[0].VOLUME_PEMBELIAN);
                $("#editVolPenjualan").val(data.data[0].VOLUME_PENJUALAN);
            }
        });
    });

    $(document).on("click", "#btnEditSurvey", function(e){
        e.preventDefault();
        var idKunjungan = $("#listCanvasing").val();

        var idSurvey = $("#editIdSurvey").val();
        var idProduk = $("#editListProduct").val();
        var stok = $("#editStokToko").val();
        var hargaBeli = $("#editHargaBeli").val();
        var hargaJual = $("#editHargaJual").val();
        var topPembelian = $("#editTopPembelian").val();
        var tglPembelian = $("#editTglPembelian").val();
        var volPembelian = $("#editVolPembelian").val();
        var volPenjualan = $("#editVolPenjualan").val();
        
        $.ajax({
            url: "<?php echo base_url(); ?>sales/InputData/updateSurvey",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_survey" : idSurvey,
                "id_produk" : idProduk,
                "stok" : stok,
                "harga_beli" : hargaBeli,
                "harga_jual" : hargaJual,
                "top" : topPembelian,
                "tgl_beli" : tglPembelian,
                "vol_beli" : volPembelian,
                "vol_jual" : volPenjualan
            },
            beforeSend: function(xhr){
                $("#btnEditSurvey").html("<span class='fa fa-spinner fa-spin'></span> Please Wait");
            },
            success: function(data){
                $("#btnEditSurvey").html("SAVE SURVEY");
                if(data.status == "success"){
                    tableSurveyHarga(idKunjungan);
                    $("#updateModal").modal("hide");
                }
            }
        });
    });

    $(document).on("click", "#btnDeleteSurvey", function(e){
        var idKunjungan = $("#listCanvasing").val();
        var idSurvey = $(this).data("idsurvey");
        var r = confirm("Yakin ingin menghapus data kunjungan ?");
        if(r == true){
            $.ajax({
                url: "<?php echo base_url(); ?>sales/InputData/deleteSurvey/",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id_survey" : idSurvey
                },
                success: function(data){
                    tableSurveyHarga(idKunjungan);
                }
            })
        }
    });

    function tableSurveyHarga(idKunjungan = null, provinsi = null, merkProduk = null, startDate = null, endDate = null){
        $("#tableHarga").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/InputData/listSurvey'); ?>",
                type: "POST",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "provinsi" : provinsi,
                    "merk" : merkProduk,
                    "start_date" : startDate,
                    "end_date" : endDate
                }
            },
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