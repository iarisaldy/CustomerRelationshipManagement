<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Role Management</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <!-- start card table role -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header bg-pink">
                                        <h2>List Role</h2>
                                    </div>
                                    <div class="body">
                                        <table id="tableRole" class="table table-striped table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <td width="5%" align="center">No</td>
                                                    <td>Role</td>
                                                    <td width="30%" align="center">Action</td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card table role -->

                            <!-- start card table menu -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header bg-pink">
                                        <h2>Menu Role</h2>
                                    </div>
                                    <div class="body">
                                        <table id="tableMenu" class="table table-striped table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <td>Menu</td>
                                                    <td width="15%" align="center">Action</td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card table menu -->
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
        listRole();
        listMenu();
    });

    function listRole(){
        $('#tableRole').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Role/dataRole'); ?>",
                type: "GET"
            },
        });
    }

    function listMenu(){
        $('#tableMenu').dataTable();
    }
</script>