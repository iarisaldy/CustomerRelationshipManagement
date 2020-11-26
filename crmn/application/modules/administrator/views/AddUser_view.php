
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2> Add New User</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- form add new user -->
                            <form class="form-horizontal" method="post" action="<?php echo base_url('administrator/User/addAction'); ?>">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="region">Region : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <?php 
                                                        $idJenisUser = $this->session->userdata("id_jenis_user");
                                                        if($idJenisUser == "1007"){
                                                            $idRegion = $this->session->userdata("id_region");
                                                    ?>
                                                    <select id="region" name="region" class="form-control show-tick" disabled>
                                                    <option value="">Enter your region</option>
                                                    <?php
                                                        foreach ($region as $regionKey => $regionValue) { ?>
                                                            <option value="<?php echo $regionValue->ID; ?>" <?php if($idRegion == $regionValue->ID){ echo "selected";} ?>><?php echo $regionValue->REGION_NAME; ?></option>
                                                        <?php } ?>
                                                    <?php } else {?>
                                                    <select id="region" name="region" class="form-control show-tick">
                                                    <option value="">Enter your region</option>
                                                    <?php
                                                        foreach ($region as $regionKey => $regionValue) { ?>
                                                            <option value="<?php echo $regionValue->ID; ?>"><?php echo $regionValue->REGION_NAME; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Name : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="name" class="form-control" name="name" placeholder="Enter your name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="email">Email : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="email" id="email" class="form-control" name="email" placeholder="Enter your email">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="username">Username : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="username" class="form-control" name="username" placeholder="Enter your username">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="password">Password : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" id="insertPassword" class="form-control" name="password" placeholder="Enter your password">
                                                </div>
                                            </div>
                                            <br/>
                                            <input type="checkbox" id="showPassword" class="filled-in">
                                            <label for="showPassword">Show Password</label>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="selectRole">User Role : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <select id="selectRole" name="role" class="form-control show-tick">
                                                    <option value="">Enter your role</option>
                                                    <?php
                                                        foreach ($jenisUser as $jenisUserKey => $jenisUserValue) { ?>
                                                            <option value="<?php echo $jenisUserValue->ID_JENIS_USER; ?>"><?php echo $jenisUserValue->JENIS_USER; ?></option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div class="row clearfix" id="cardDistributor" style="display:none;">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="email_address_2">Distributor Name : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <select data-size="5" id="listDistributor" name="distributor" class="form-control show-tick" data-live-search="true">
                                                    <option value="">Select your distributor</option>
                                                    <?php
                                                        foreach ($distributor as $distributorKey => $distributorValue) { ?>
                                                            <option value="<?php echo $distributorValue->KODE_DISTRIBUTOR; ?>"><?php echo $distributorValue->KODE_DISTRIBUTOR." - ".$distributorValue->NAMA_DISTRIBUTOR; ?></option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix" id="cardRegion" style="display:none;">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="email_address_2">Region (Provinsi) : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <div id="selectProvinsi"><b style="color:red;">Choose Region SMIG first</b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix" id="cardArea" style="display:none;">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="email_address_2">Area : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <div id="selectArea"><b style="color:red;">Choose Provinsi first<b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix" id="cardRetail" style="display:none;">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="email_address_22" style="color: #5A555A;">Toko : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <div id="selectRetail"><b style="color:red;">Choose Distributor first<b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end form, end body card -->
                                </div>
                            </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save User</button>
                                        &nbsp;
                                        <a href="<?php echo base_url('administrator/User'); ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
                                    </div>
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
    var base_url = "<?php echo base_url() ?>";

    $("document").ready(function(){
        var idJenisUser = "<?php echo $this->session->userdata('id_jenis_user'); ?>";
        if(idJenisUser == "1007"){
            var idRegion = "<?php echo $this->session->userdata('id_region'); ?>";
            idRegion = idRegion.substr(idRegion.length - 1)
            listProvinsi("#selectProvinsi", parseInt(idRegion)+1);
        }
    });

    $(document).on('change', '#showPassword', function() {
        var x = document.getElementById("insertPassword");
        if(this.checked) {
        // checkbox is checked
        x.type = "text";
        } else {
            x.type = "password";
        }
    });

    $(document).on("change", "#selectRole", function(){
        var idRole = $(this).val();

        if(idRole == "1002" || idRole == "1003" || idRole == "1004" || idRole == "1005" || idRole == "1007"){
            $("#cardDistributor").css("display", "block");
        } else {
            $("#cardDistributor").css("display", "none");
        }

        if(idRole == "1003" || idRole == "1005" || idRole == "1006" || idRole == "1007"){
            $("#cardArea").css("display", "block");
            $("#cardRegion").css("display", "block");
        } else {
            $("#cardArea").css("display", "none");
            $("#cardRegion").css("display", "none");
        }

        if(idRole == "1004"){
            $("#cardRetail").css("display", "block");
        } else {
            $("#cardRetail").css("display", "none");
        }
    });

    $(document).on("change", "#region", function(){
        var idRegion = $('#region option:selected').text();
        var lastChar = idRegion.substr(idRegion.length - 1);

        listProvinsi("#selectProvinsi", lastChar);
    });

    $(document).on("change", "#listProvinsi", function(){
        var idProvinsi = $(this).val();
        listArea("#selectArea", idProvinsi);
        console.log(idProvinsi);
    });

    $(document).on("change", "#listDistributor", function(){
        var idDistributor = $(this).val();
        listRetail("#selectRetail", idDistributor);
    })

    function listArea(key, idProvinsi){
        $.ajax({
		    url: base_url+"administrator/user/area/",
		    type: 'POST',
            data: {
                "idprovinsi" : idProvinsi
            },
			dataType: 'JSON',
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listArea" data-size="5" class="form-control selectpicker show-tick" name="area[]" multiple>';
                type_list += '<option value="00">All Area</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_AREA']+'">'+response[i]['NAMA_AREA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function listProvinsi(key, idRegion){
        $.ajax({
		    url: base_url+"administrator/user/provinsi/"+idRegion,
		    type: 'GET',
			dataType: 'JSON',
		    success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listProvinsi" data-size="5" class="form-control selectpicker show-tick" name="provinsi[]" multiple data-live-search="true">';
                type_list += '<option value="00">All Provinsi</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
    }

    function listRetail(key, idDistributor){
        $.ajax({
            url: base_url+"administrator/user/retail/"+idDistributor,
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
</script>