<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2> Menu Management</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="<?php echo base_url('administrator/User')?>" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                                <br/>&nbsp;
                                    <div class="card">
                                        <div class="body">
                                            <table id="tableMenu" class="table table-striped table-bordered" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td width="5%" align="center">No</td>
                                                        <td>Menu</td>
                                                        <td>Link</td>
                                                        <td>Icon</td>
                                                        <td width="15%" align="center">Action</td>
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
        listMenu();
    });

    function listMenu(){
        $('#tableMenu').dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('administrator/Menu/dataMenu'); ?>",
                type: "GET"
            },
        });
    }
</script>