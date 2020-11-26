<div class="content-wrapper">
   <section class="content-header">
      <h1>Add New Version<small>Added the latest app version</small></h1>
   </section>

   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">
               <a href="<?php echo base_url('version') ?>" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</a>
            </h3>
            <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6">
                  <div class="box box-danger box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">Application Version</h3>
                     </div>
                     <div class="box-body">
                        <form id="add-new-version">
                           <div class="form-group">
                              <label for="version-code">Version Code</label>
                              <input type="text" class="form-control" id="version-code" placeholder="New Version Code" required>
                              <small id="last_version" class="label label-danger"></small>
                           </div>
                           <div class="form-group">
                              <label for="update-type">Update Type</label>
                              <select id="update-type" class="form-control" required>
                                 <option value="">Choose Type</option>
                                 <option value="MINOR">MINOR</option>
                                 <option value="MAJOR">MAJOR</option>
                              </select>
                           </div>
                     </div>
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="box box-danger box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">Description</h3>
                     </div>
                     <div class="box-body">
                           <div class="form-group">
                              <label for="desc-version">Description Update</label>
                              <textarea class="form-control" id="desc-version" placeholder="Description Application Update" rows="5"></textarea>
                              <br/>
                              <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-save"></i> Save New Version</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<script type="text/javascript">
   var token = localStorage.getItem('token');
   var data_token   = JSON.parse(atob(token.split('.')[1]));
   $('document').ready(function(){
      last_version();
   });

   $('#add-new-version').on('submit', function(e){
      var version_code = $('#version-code').val();
      var update_type = $('#update-type').val();
      e.preventDefault();
      if(version_code == "" && update_type == ""){
         swal("Warning !", "Fill in all forms", "error");
      } else {
         $.ajax({
            url : base_url+'api/v1/version/add',
            type : 'POST',
            headers : {
               'token' : token
            },
            data : {
               'version_code' : version_code,
               'update_type' : update_type,
               'desc_version' : $('#desc-version').val() 
            },
            success: function(data){
               data = JSON.parse(data);
               if(data.status == "error"){
                  swal("Warning !", data.message, "error");
               } else {
                  swal({
                     title: 'Success !',
                     text: 'Add New Version Success',
                     type: 'success'
                  }, function(isConfirm){
                     window.location.href = base_url+'version/';
                  });
               }
            }
      });
      }
   });

   function last_version(){
      $.ajax({
         url: base_url+'api/v1/version/0',
         type: 'GET',
         headers : {
            'token' : token
         },
         success: function(data){
            var parseData = JSON.parse(data);
            if(data.status == "error"){
               swal("Warning !", data.message, "error");
               $('#last_version').html('<i class="fa fa-clock-o"></i> Latest Version : Tidak Ada Versi');
            } else {
               $('#last_version').html('<i class="fa fa-clock-o"></i> Latest Version : '+parseData.data.LAST_VERSION);
            }
         }
      });
   }
</script>