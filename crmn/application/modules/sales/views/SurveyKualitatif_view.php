<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>Survey Kualitatif</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="header">
                                    <?php if($this->session->userdata("id_jenis_user") == "1003" || $this->session->userdata("id_jenis_user") == "1005" || $this->session->userdata("id_jenis_user") == "1006"){ ?>
                                        <button id='showFormSurvey' class='btn btn-info' data-toggle='modal' data-target='#defaultModal'><i class='fa fa-plus'></i> Add Survey</button>
                                    <?php } ?>
                                    </div>
                                    <div class="body">
                                    <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                <div class="form-group">
                                                    <div class="form-line" id="filterJenisUser"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                <div class="form-group">
                                                    <div class="form-line" id="filterDistributor"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                <div class="form-group">
                                                    <div class="form-line" id="filterProvinsi"></div>
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
                                            <table id="tableKualitatif" class="table table-bordered" width="100%">
                                                <thead style="background-color: #00bcd4; color: white;">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <?php if($this->session->userdata("id_jenis_user") == "1001"){ ?>
                                                        <th>Tanggal Survey</th>
                                                        <th>Surveyor</th>
                                                        <th>Distributor</th>
                                                        <th>Provinsi</th>
                                                        <!-- <th>Kota</th> -->
                                                        <?php } ?>
                                                        <th>Isian Survey</th>
                                                        <th width="15%">Action</th>
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
                                <h4 class="modal-title" id="defaultModalLabel">Add Survey Kualitatif</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">
                                    <form class="form-horizontal">
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Isian Survey : </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea id="jawabanKualitaitf" class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnAddSurveyKualitatif" type="button" class="btn btn-info waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal add survey -->

            <!-- Modal edit survey -->
            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="defaultModalLabel">Update Survey Kualitatif</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">
                                    <form class="form-horizontal">
                                    <input type="hidden" id="idSurveyEdit"/>
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">
                                                <label for="name">Isian Survey : </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea id="jawabanKualitatifEdit" class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnUpdateSurveyKualitatif" type="button" class="btn btn-info waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal edit survey -->

            </div>
        </div>
    </div>
</section>
<script>
    var idUser = "<?php echo $this->session->userdata("user_id"); ?>";
    $('document').ready(function(){
        tableSurveyKualitatif(idUser);
        filterJenisUser("#filterJenisUser");
        filterDistributor("#filterDistributor");
        filterProvinsi("#filterProvinsi");
        $('#startDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#endDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    });

    $(document).on("click", "#btnFilter", function(e){
        var posisi = $("#listJenisUser").val();
        var distributor = $("#listDistributor").val();
        var provinsi = $("#listProvinsi").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        tableSurveyKualitatif(idUser, posisi, distributor, provinsi, startDate, endDate);
    });

    $(document).on("click", "#btnAddSurveyKualitatif", function(e){
        e.preventDefault();
        var isianSurvey = $("#jawabanKualitaitf").val();

        $.ajax({
            url: "<?php echo base_url() ?>sales/SurveyKualitatif/addSurvey",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_user" : idUser,
                "isian_survey" : isianSurvey
            },
            success: function(data){
                $("#defaultModal").modal("hide");
                $("#jawabanKualitatif").val("");
                tableSurveyKualitatif(idUser);
            }
        });
    });

    $(document).on("click", "#btnDetailSurvey", function(e){
        e.preventDefault();
        var idSurvey = $(this).data("idsurveykualitatif");

        $.ajax({
            url: "<?php echo base_url() ?>sales/SurveyKualitatif/detailSurvey/"+idSurvey,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $("#updateModal").modal("show");
                $("#idSurveyEdit").val(data.data[0].ID_SURVEY_KUALITATIF);
                $("#jawabanKualitatifEdit").val(data.data[0].JAWABAN);
            }
        });
    });

    $(document).on("click", "#btnUpdateSurveyKualitatif", function(e){
        e.preventDefault();
        var idSurvey = $("#idSurveyEdit").val();
        var isianSurvey = $("#jawabanKualitatifEdit").val();
       
        $.ajax({
            url: "<?php echo base_url("") ?>sales/SurveyKualitatif/updateSurvey",
            type: "POST",
            dataType: "JSON",
            data: {
                "id_survey" : idSurvey,
                "isian_survey" : isianSurvey
            },
            success: function(data){
                $("#updateModal").modal("hide");
                tableSurveyKualitatif(idUser);
            }
        });
    });

    $(document).on("click", "#btnDeleteSurvey", function(e){
        var idSurvey = $(this).data("idsurveykualitatif");

        var r = confirm("Yakin ingin menghapus data survey kualitatif ?");
        if(r == true){
            $.ajax({
                url: "<?php echo base_url("") ?>sales/SurveyKualitatif/deleteSurvey",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id_survey" : idSurvey
                },
                success: function(data){
                    tableSurveyKualitatif(idUser);
                }
            });
        }
    });

    function tableSurveyKualitatif(idKunjungan = null, posisi = null, distributor = null, provinsi = null, startDate = null, endDate = null){
        $("#tableKualitatif").dataTable({
            "destroy": true,
            "ajax": {
                url : "<?php echo base_url() ?>sales/SurveyKualitatif/listSurvey",
                type: "POST",
                data: {
                    "id_kunjungan" : idKunjungan,
                    "posisi" : posisi,
                    "distributor" : distributor,
                    "provinsi" : provinsi,
                    "start_date" : startDate,
                    "end_date" : endDate
                }
            },
            "columnDefs": [
                { "width": "15%", "targets": 2 }
            ]
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
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['NAMA_DISTRIBUTOR']+'</option>';
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