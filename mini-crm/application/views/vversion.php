<div class="content-wrapper">
   <section class="content-header">
      <h1>Application Version<small>List version of application</small></h1>
   </section>

   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">
               <a href="<?php echo base_url('version/add'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New Version</a>
            </h3>
            <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
         </div>
         <div class="box-body">
            <table id="version-list" class="table table-striped">
               <thead>
                  <tr>
                     <th style="width: 5%">No</th>
                     <th>Version Code</th>
                     <th>Description</th>
                     <th style="width: 10%">Type</th>
                     <th style="width: 15%">Action</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   </section>
</div>

<script type="text/javascript">
   $('document').ready(function(){
      list_version();
      $('#version-list').DataTable();
   });

   function delete_version(version_id){
      swal({
         title: "Do you want delete version update ?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         cancelButtonColor: "Cancel",
         confirmButtonText: "Yes, Deleted",
         closeOnCancel: true,
         closeOnConfirm: true,
      }, function (isConfirm) {
         if(isConfirm){
            $.ajax({
               url: base_url+'api/v1/version/hapus',
               type: 'DELETE',
               headers : {
                  'Content-Type' : 'application/x-www-form-urlencoded',
                  'token' : token
               },
               data : {
                  'version_id' : version_id
               },
               dataType : 'JSON',
               success: function(data){
                  if(data.status == "error"){
                     swal("Warning !", data.message, "error");
                  } else {
                     swal({
                        title: 'Success !',
                        text: 'Deleted Version Success',
                        type: 'success'
                     }, function(isConfirm){
                        window.location.href = base_url+'version/';
                     });
                  }
               }
            });
         }
      });
   }

   function edit_version(version_id){
      window.location.href = base_url+'version/edit/'+version_id;
   }

   function list_version(){
      $('#version-list').DataTable({
         destroy: true,
         serverSide: false,
         processing: false,
         paging: true,
         lengthChange: true,
         searching: true,
         ordering: true,
         autoWidth: true,
         language: { "sEmptyTable": "Tidak Terdapat Data" },
         columns : [
            { data : 'no' },
            { data : 'version_code' },
            { data : 'description' },
            { data : 'version_type' },
            { data : 'action' },
         ],
         ajax : {
            url: base_url+'api/v1/version/list',
            type: 'GET',
            headers: {
               'Content-Type' : 'application/x-www-form-urlencoded',
               'token' : localStorage.getItem('token')
            },
            dataType : 'JSON',
            dataSrc : function(data){
               if(data.status == "error"){
                  var return_data = new Array();
                  for(var a = 0; a < 1; a++){
                     return_data.push({
                        'no' : '-',
                        'version_code' : '-',
                        'description' : '-',
                        'version_type' : '-',
                        'action' : '-',
                     });
                  }
                  return return_data;
               } else {
                  var a = 1;
                  var return_data = new Array();
                  for(var b = 0; b < data.data.length; b++){
                     return_data.push({
                        'no' : a,
                        'version_code' : data.data[b].APPS_VERSION,
                        'description' : data.data[b].DESC_UPDATE,
                        'version_type' : data.data[b].TYPE_UPDATE,
                        'action' : '<button onclick="edit_version('+data.data[b].VERSION_ID+');" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</button>&nbsp;<button onclick="delete_version('+data.data[b].VERSION_ID+');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>',
                     });
                     a++;
                  }
                  return return_data;
               }
            }
         }
      });
   }
</script>