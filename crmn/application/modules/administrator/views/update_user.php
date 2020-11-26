<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Update User</h2>
                    </div>
                    <div class="body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- form add new user -->
                            <form class="form-horizontal" method="post" action="<?php echo base_url('administrator/Manajemen_user/updateAction/'.$dt_user[0]['ID_USER']); ?>">
                                <div class="card">
                                    <div class="body">

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="">Region : </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                    <select id="selectRegion" name="region" class="form-control show-tick" disabled>
                                                        <option value="<?php echo $region['0']['ID_REGION']; ?>"><?php echo $region['0']['REGION_NAME'];  ?></option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="">Name : </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input value="<?php echo $dt_user[0]['NAMA']; ?>" type="text" class="form-control" name="name" placeholder="Enter your name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="">Email : </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input value="<?php echo $dt_user[0]['EMAIL']; ?>" type="email" class="form-control" name="email" placeholder="Enter your email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="">Username : </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input value="<?php echo $dt_user[0]['USERNAME']; ?>" type="text"  class="form-control" name="username" placeholder="Enter your username">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="">Password : </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input value="<?php echo $dt_user[0]['PASSWORD']; ?>" type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
                                                    </div>
                                                </div>
                                                <br/>
                                                <input type="checkbox" id="showPassword" class="filled-in">
                                                <label for="showPassword">Show Password</label>
                                            </div>
                                        </div>
										<!--
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="">User Role : </label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                    <select name="role" class="form-control show-tick">
                                                        <option value="">Enter your role</option>
                                                        <?php
                                                            //echo $JENIS_USER;    
                                                        ?>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										-->
                                        <!-- end form in card -->
										
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="body">
                                        <div class="container-fluid">

                                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                                <li role="presentation" class="active"><a href="#home" data-toggle="tab">Distributor</a></li>
                                                <li role="presentation"><a href="#profile" data-toggle="tab">Provinsi</a></li>
                                                <li role="presentation"><a href="#messages" data-toggle="tab">Area</a></li>
												<li role="presentation"><a href="#TSO" data-toggle="tab">TSO</a></li>
												<li role="presentation"><a href="#ASM" data-toggle="tab">ASM</a></li>
												<li role="presentation"><a href="#RSM" data-toggle="tab">RSM</a></li>
                                                <li role="presentation"><a href="#GUDANG" data-toggle="tab">GUDANG</a></li>
                                            </ul>

                                            <div class="tab-content">

                                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateDistributor">
                                                        </div>

                                                        <div class="col-md-3" id="btnDistributor">
                                                            <button id="addUserDistributor" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>
                                                
                                                    <table id="userDistTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>Kode Distributor</th>
                                                                <th>Distributor</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div role="tabpanel" class="tab-pane fade in" id="profile">

                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateProvinsi"></div>

                                                        <div class="col-md-3" id="btnProvinsi">
                                                            <button id="addUserProvinsi" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>

                                                    <table id="userProvTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>Kode Provinsi</th>
                                                                <th>Provinsi</th>
                                                                <th style="width: 10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                                <div role="tabpanel" class="tab-pane fade in" id="messages">
                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateArea"></div>

                                                        <div class="col-md-3" id="btnArea">
                                                            <button id="addUserArea" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>

                                                    <table id="userAreaTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>Kode Area</th>
                                                                <th>Nama Area</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                                <div role="tabpanel" class="tab-pane fade in" id="TSO">
                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateTSO"></div>

                                                        <div class="col-md-3" id="btnTso">
                                                            <button id="addUserTSO" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>

                                                    <table id="userTSOTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>ID TSO</th>
                                                                <th>Nama TSO</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
												
                                                <div role="tabpanel" class="tab-pane fade in" id="ASM">
                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateASM"></div>

                                                        <div class="col-md-3" id="btnTso">
                                                            <button id="addUserASM" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>

                                                    <table id="userASMTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>ID ASM</th>
                                                                <th>Nama ASM</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade in" id="RSM">
                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateRSM"></div>

                                                        <div class="col-md-3" id="btnTso">
                                                            <button id="addUserRSM" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>

                                                    <table id="userRSMTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>ID RSM</th>
                                                                <th>Nama RSM</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade in" id="GUDANG">
                                                    <div class="container-fluid row">
                                                        <div class="col-md-3" id="updateGUDANG"></div>

                                                        <div class="col-md-3" id="btnGUDANG">
                                                            <button id="addUserGUDANG" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                                        </div>
                                                    </div>

                                                    <table id="userGUDANGTable" class="table table-bordered" style="width: 100%">
                                                        <thead style="background-color: #00bcd4; color: white;">
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th>ID GUDANG</th>
                                                                <th>Nama GUDANG</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
									<!--
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save User</button>
                                        &nbsp;
                                        <a href="<?php echo base_url('administrator/User'); ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
                                    </div>
									-->
                                </div>
                                </form>
                                <!-- end form add new user -->
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
    $(document).on('change', '#showPassword', function() {
        var x = document.getElementById("password");
        if(this.checked) {
            x.type = "text";
        } else {
            x.type = "password";
        }
    });
    $('document').ready(function(){
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        userDistList(idUser);
        userProvList(idUser);
        userAreaList(idUser);
        userTSOList(idUser);
        userASMList(idUser);
        userRSMList(idUser);
        userGUDANGList(idUser);
        // getDistRetail(idUser);

        listDistributor("#updateDistributor");
        listProvinsi("#updateProvinsi");
        listArea("#updateArea");
        listTSO("#updateTSO");
        listASM("#updateASM");
        listRSM("#updateRSM");
        listGUDANG("#updateGUDANG");
    });

    

    $(document).on("click", "#addUserDistributor", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserDistributor/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "kode_dist" : $("#listDistributor").val()
            },
		    success: function(data){
                userDistList(idUser);
                listDistributor("#updateDistributor");
		    }
        });
    });

    $(document).on("click", "#updateUserDistributor", function(e){
        e.preventDefault();
        var idDist = $(this).data('iddist');
        var idUserDist = $(this).data('iduserdist');

        $("#btnDistributor").html(
            '<button id="actionUpdateUserDistributor" data-iduserdist="'+idUserDist+'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Update</button>&nbsp;'+
            '<button id="cancelUserDistributor" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Cancel</button>'
            );

        listDistributor("#updateDistributor", idDist);
    });

    $(document).on("click", "#actionUpdateUserDistributor", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        var idUserDist = $(this).data('iduserdist');

        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/updateUserDistributor/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user_distributor" : idUserDist,
                "kode_dist" : $("#listDistributor").val()
            },
		    success: function(data){
                userDistList(idUser);
                listDistributor("#updateDistributor");
                $("#btnDistributor").html('<button id="addUserDistributor" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>');
		    }
        });
    });

    $(document).on("click", "#cancelUserDistributor", function(e){
        listDistributor("#updateDistributor");
        $("#btnDistributor").html('<button id="addUserDistributor" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>');
    });

    $(document).on("click", "#deleteUserDistributor", function(e){
        e.preventDefault();
        var idUserDistributor = $(this).data('iduserdist');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserDistributor/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user_distributor" : idUserDistributor,
                "delete_mark" : 1
            },
		    success: function(data){
                userDistList(idUser);
                listDistributor("#updateDistributor");
		    }
        });
    });


    $(document).on("click", "#addUserProvinsi", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserProvinsi/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "id_provinsi" : $("#listProvinsi").val()
            },
		    success: function(data){
                userProvList(idUser);
                listProvinsi("#updateProvinsi");
		    }
        });
    });

    $(document).on("click", "#updateUserProvinsi", function(e){
        e.preventDefault();
        var idProv = $(this).data('idprov');
        var idUserProv = $(this).data('iduserprov');

        $("#btnProvinsi").html(
            '<button id="actionUpdateUserProvinsi" data-iduserprov="'+idUserProv+'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Update</button>&nbsp;'+
            '<button id="cancelUserProvinsi" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Cancel</button>'
            );

        listProvinsi("#updateProvinsi", idProv);
    });

    $(document).on("click", "#actionUpdateUserProvinsi", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        var idUserDist = $(this).data('iduserprov');

        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/updateUserProvinsi/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user_provinsi" : idUserDist,
                "id_provinsi" : $("#listProvinsi").val()
            },
		    success: function(data){
                userProvList(idUser);
                listProvinsi("#updateProvinsi");
                $("#btnProvinsi").html('<button id="addUserProvinsi" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>');
		    }
        });
    });

    $(document).on("click", "#cancelUserProvinsi", function(e){
        listProvinsi("#updateProvinsi");
        $("#btnProvinsi").html('<button id="addUserProvinsi" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>');
    });

    $(document).on("click", "#deleteUserProvinsi", function(e){
        e.preventDefault();
        var idUserProvinsi = $(this).data('iduserprov');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserProvinsi/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user_provinsi" : idUserProvinsi,
                "delete_mark" : 1
            },
		    success: function(data){
                userProvList(idUser);
                listProvinsi("#updateProvinsi");
		    }
        });
    });

    // CRUD USER AREA
    $(document).on("click", "#addUserArea", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserArea/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "id_area" : $("#listArea").val()
            },
		    success: function(data){
                userAreaList(idUser);
                listArea("#updateArea");
		    }
        });
    });

    $(document).on("click", "#updateUserArea", function(e){
        e.preventDefault();
        var idArea = $(this).data('idarea');
        var idUserArea = $(this).data('iduserarea');

        $("#btnArea").html(
            '<button id="actionUpdateUserArea" data-iduserarea="'+idUserArea+'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Update</button>&nbsp;'+
            '<button id="cancelUserArea" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Cancel</button>'
            );

        listArea("#updateArea", idArea);
    });


    $(document).on("click", "#cancelUserArea", function(e){
        listArea("#updateArea");
        $("#btnArea").html('<button id="addUserArea" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>');
    });

    $(document).on("click", "#actionUpdateUserArea", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        var idUserArea = $(this).data('iduserarea');

        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/updateUserArea/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user_area" : idUserArea,
                "id_area" : $("#listArea").val()
            },
		    success: function(data){
                userAreaList(idUser);
                listArea("#updateArea");
                $("#btnArea").html('<button id="addUserArea" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>');
		    }
        });
    });

    $(document).on("click", "#deleteUserArea", function(e){
        e.preventDefault();
        var idUserArea = $(this).data('iduserarea');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserArea/"); ?>",
		    type: 'POST',
			dataType: 'JSON',
            data: {
                "id_user_area" : idUserArea,
                "delete_mark" : 1
            },
		    success: function(data){
                userAreaList(idUser);
                listArea("#updateArea");
		    }
        });
    });
    // END CRUD USER AREA

    //CRUD User TSO
    // CRUD USER AREA
    $(document).on("click", "#addUserTSO", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserTSO/"); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "id_TSO" : $("#listTSO").val()
            },
            success: function(data){
                userTSOList(idUser);
                listTSO("#updateTSO");
            }
        });
    });
    $(document).on("click", "#updateUserTSO", function(e){
        e.preventDefault();
        var TSO = $(this).data('TSO');
        var iduserTSO = $(this).data('iduserTSO');

        $("#updateTSO").html(
            '<button id="actionUpdateUserArea" data-iduserarea="'+iduserTSO+'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Update</button>&nbsp;'+
            '<button id="cancelUserArea" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Cancel</button>'
            );

        listTSO("#updateTSO");
    });
    $(document).on("click", "#deleteUserTSO", function(e){
        e.preventDefault();
        var iduserTSO = $(this).data('idusertso');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserTSO"); ?>/"+iduserTSO,
            type: 'POST',
            dataType: 'JSON',
            data: {

                "no_user_tso"     : iduserTSO,
            },
            success: function(data){
                userTSOList(idUser);
                listTSO("#updateTSO");
            }
        });
    });

    $(document).on("click", "#addUserASM", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserASM/"); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "id_TSO" : $("#listASM").val()
            },
            success: function(data){
                userASMList(idUser);
                listASM("#updateASM");
            }
        });
    });
    $(document).on("click", "#deleteUserASM", function(e){
        e.preventDefault();
        var iduserTSO = $(this).data('idusertso');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserASM"); ?>/"+iduserTSO,
            type: 'POST',
            dataType: 'JSON',
            data: {

                "no_user_tso"     : iduserTSO,
            },
            success: function(data){
                userASMList(idUser);
                listASM("#updateASM");
            }
        });
    });
    $(document).on("click", "#addUserRSM", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserRSM/"); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "id_TSO" : $("#listRSM").val()
            },
            success: function(data){
                userRSMList(idUser);
                listRSM("#updateRSM");
            }
        });
    });
    $(document).on("click", "#deleteUserRSM", function(e){
        e.preventDefault();
        var iduserTSO = $(this).data('idusertso');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserRSM"); ?>/"+iduserTSO,
            type: 'POST',
            dataType: 'JSON',
            data: {

                "no_user_tso"     : iduserTSO,
            },
            success: function(data){
                userRSMList(idUser);
                listRSM("#updateRSM");
            }
        });
    });
    $(document).on("click", "#addUserGUDANG", function(e){
        e.preventDefault();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/addUserGUDANG/"); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                "id_user" : idUser,
                "id_TSO" : $("#listGUDANG").val()
            },
            success: function(data){
                userGUDANGList(idUser);
                listGUDANG("#updateGUDANG");
            }
        });
    });
    $(document).on("click", "#deleteUserGUDANG", function(e){
        e.preventDefault();
        var iduserTSO = $(this).data('idusertso');
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/Manajemen_user/deleteUserGUDANG"); ?>/"+iduserTSO,
            type: 'POST',
            dataType: 'JSON',
            data: {

                "no_user_tso"     : iduserTSO,
            },
            success: function(data){
                userGUDANGList(idUser);
                listGUDANG("#updateGUDANG");
            }
        });
    });
    // Update user Retail
    $(document).on("click", "#updateUserRetail", function(e){
        e.preventDefault();
        var idCustomer = $("#listRetail").val();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url("administrator/user/updateUserRetail/"); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                "id_customer" : idCustomer,
                "id_user" : idUser
            },
            success: function(data){
                userRetailList(idUser);
            }
        });
    });
    // End update user retail

    function listDistributor(key, isi = null){
       var idUser = <?php echo $dt_user[0]['ID_USER'] ?>; 
        $.ajax({
		    url: "<?php echo base_url("administrator/Manajemen_user/listDistributor/"); ?>/"+idUser,
		    type: 'GET',
			dataType: 'JSON',
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listDistributor" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option>Choose Distributor</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['NAMA_DISTRIBUTOR']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $("#listDistributor").val(isi);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function getDistRetail(idUser){
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/User/userDistributor/"+idUser,
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                listRetail("#updateRetail",data.data[0][1])
            }
        });
    }



    function listProvinsi(key, isi = null){
        var idRegion = $('#selectRegion option:selected').text();
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        var lastChar = idRegion.substr(idRegion.length - 1);
        $.ajax({
		    url: "<?php echo base_url(); ?>administrator/Manajemen_user/provinsi/"+lastChar+"/"+idUser,
		    type: 'GET',
			dataType: 'JSON',
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listProvinsi" data-size="5" class="form-control selectpicker show-tick" data-live-search="true">';
                type_list += '<option>Choose Provinsi</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $("#listProvinsi").val(isi);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function listArea(key, isi, idProvinsi){
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
		    url: "<?php echo base_url(); ?>administrator/Manajemen_user/area/",
		    type: 'POST',
            data: {
                "idprovinsi" : idProvinsi,
                "id_user"    : idUser,
            },
			dataType: 'JSON',
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listArea" data-size="5" class="form-control selectpicker show-tick" data-live-search="true">';
                type_list += '<option value="00">Choose Area</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_AREA']+'">'+response[i]['NAMA_AREA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $("#listArea").val(isi);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function listRetail(key, idDistributor){
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/user/retail/"+idDistributor,
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listRetail" data-size="5" class="form-control selectpicker show-tick" name="retail" data-live-search="true">';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_CUSTOMER']+'">'+response[i]['NAMA_TOKO']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
    function listTSO(key, idDistributor){
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/Manajemen_user/TSO/",
            type: 'POST',
            data: {
                "id_user"    : idUser,
            },
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listTSO" data-size="5" class="form-control selectpicker show-tick" data-live-search="true">';
                type_list += '<option value="00">Choose TSO</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
    function listASM(key, idDistributor){
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/Manajemen_user/ASM/",
            type: 'POST',
            data: {
                "id_user"    : idUser,
            },
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listASM" data-size="5" class="form-control selectpicker show-tick" data-live-search="true">';
                type_list += '<option value="00">Choose ASM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
    function listRSM(key, idDistributor){
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/Manajemen_user/RSM/",
            type: 'POST',
            data: {
                "id_user"    : idUser,
            },
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listRSM" data-size="5" class="form-control selectpicker show-tick" data-live-search="true">';
                type_list += '<option value="00">Choose RSM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
    function listGUDANG(key, idDistributor){
        var idUser = <?php echo $dt_user[0]['ID_USER'] ?>;
        $.ajax({
            url: "<?php echo base_url(); ?>administrator/Manajemen_user/GUDANG/",
            type: 'POST',
            data: {
                "id_user"    : idUser,
            },
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listGUDANG" data-size="5" class="form-control selectpicker show-tick" data-live-search="true">';
                type_list += '<option value="00">Choose GUDANG</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['NO_GD']+'">'+response[i]['KD_GUDANG']+' - '+response[i]['NM_GUDANG']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function userDistList(idUser){
        $('#userDistTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userDistributor'); ?>/"+idUser,
                type: "GET"
            },
        });
    }

    function userProvList(idUser){
        $('#userProvTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userProvinsi'); ?>/"+idUser,
                type: "GET"
            },
        });
    }

    function userAreaList(idUser){
        $('#userAreaTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userArea'); ?>/"+idUser,
                type: "GET"
            },
        });
    }

    function userTSOList(idUser){
        $('#userTSOTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userTSO'); ?>/"+idUser,
                type: "GET"
            },
        });
    }
    function userASMList(idUser){
        $('#userASMTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userASM'); ?>/"+idUser,
                type: "GET"
            },
        });
    }
    function userRSMList(idUser){
        $('#userRSMTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userRSM'); ?>/"+idUser,
                type: "GET"
            },
        });
    }
    function userGUDANGList(idUser){
        $('#userGUDANGTable').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Manajemen_user/userGUDANG'); ?>/"+idUser,
                type: "GET"
            },
        });
    }
</script>