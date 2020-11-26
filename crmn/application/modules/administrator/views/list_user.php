<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2> List User</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                             <!--<div class="col-md-3">
                                <select id="filterRole" class="form-control">
                                    <option value="">Choose Role</option>
                                    <?php echo $JENIS_USER; ?>
                                </select>
                            
                            <div class="col-md-3">
                                <button id="btnFilterRole" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                            </div>
							</div> -->
                            <div class="col-md-6" style="float:right;">
                                <a style="float:right;" href="<?php echo base_url('administrator/Manajemen_user/add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New User</a>
                            </div>

                            <div class="col-md-12">
                                <?php if($this->session->flashdata('message')){ ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> <?php echo $this->session->flashdata('message'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <div class="col-md-12">
                            <div class="card">
                                <div class="body">
                                <table id="tableUser" class="table table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <td width="5%" align="center">No</td>
                                            <td>Name</td>
                                            <td>Role</td>
                                            <td width="25%" align="center">Action</td>
                                        </tr>
                                    </thead>
									</tbody>
										<?php echo $LIST_USER;  ?>
									</tbody>
                                </table>
                                </div>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->

                <!-- Modal delete user -->
                <div class="modal fade" id="deleteUser" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete User</h4>
                            </div>
                            <form method="POST" action="<?php echo base_url('administrator/User/deleteAction'); ?>">
                            <div class="modal-body">
                                <input type="hidden" name="idUserDelete" id="idUserDelete" value=""/>
                                <p>Are you sure to delete this user ?</p>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                &nbsp;
                                <button type="submit" class="btn btn-sm btn-danger">Yes</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal delete user -->
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
$("#tableUser").dataTable();
});

    // $(document).on('click', '#btnFilterRole', function(e){
        // var role = $('#filterRole').val();
        // dataUser(role);
    // });

    // function dataUser(role = ''){
        // $('#tableUser').dataTable({
            // "destroy" : true,
            // "ajax" : {
                // url: "<?php echo base_url('administrator/Manajemen_user/dataUser'); ?>/"+role,
                // type: "GET"
            // },
        // });
    // }

    function deleteUser(idUser){
        $('#idUserDelete').val(idUser);
        $('#deleteUser').modal('show');
    }
</script>
