
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
                            <form class="form-horizontal" method="post" action="<?php echo base_url('administrator/Manajemen_user/addAction'); ?>">
                            <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="region">Region : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select id="region" name="region" class="form-control show-tick">
                                                        <option value="">Enter your region</option>
                                                        <option value="1">Region 1</option>
                                                        <option value="2">Region 2</option>
                                                        <option value="3">Region 3</option>
                                                        <option value="4">Region 4</option>
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
														echo $JENIS_USER;
													?>
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
                                        <a href="<?php echo base_url('administrator/Manajemen_user'); ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
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
	
	

</script>