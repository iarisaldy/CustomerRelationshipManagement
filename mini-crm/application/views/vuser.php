   <div class="content-wrapper">
   	<section class="content-header">
   		<h1>User List
   			<small>List of Application User</small>
   		</h1>
   	</section>

   	<section class="content">
   		<div class="box">
   			<div class="box-header with-border">
   				<h3 class="box-title">
                  <button onclick="addUser()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New User</button>
               </h3>
   				<div class="box-tools pull-right">
   					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
   						<i class="fa fa-minus"></i></button>
   					</div>
   				</div>
   				<div class="box-body">
   					<table id="user-list" class="table table-striped">
   						<thead>
   							<tr>
   								<th style="width: 5%">No</th>
   								<th>Name</th>
   								<th style="width: 15%">Role</th>
   								<th style="width: 15%">Action</th>
   							</tr>
   						</thead>
   					</table>
   				</div>
   			</div>
   		</section>
   	</div>

   	<script type="text/javascript">
   		$(document).ready(function(){
            list_user();
            $('#user-list').DataTable();
         });

         function list_user(){
            $('#user-list').DataTable({
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
               { data : 'name' },
               { data : 'role' },
               { data : 'action' },
               ],
               ajax : {
                  url: base_url+'api/v1/user',
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
                              'name' : '-',
                              'role' : '-',
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
                              'name' : data.data[b].NAME,
                              'role' : data.data[b].ROLE_NAME,
                              'action' : '<button onclick="edit_user('+data.data[b].USER_ID+');" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</button>&nbsp;<button onclick="delete_user('+data.data[b].USER_ID+');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>',
                           });
                           a++;
                        }
                        return return_data;
                     }
                  }
               }
            });
         }

         function edit_user(user_id){
            window.location.href = base_url+'user/edit/'+user_id;
         }

         function delete_user(user_id){
            swal({
               title: "Do you want to delete user ?",
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
                     url: base_url+'api/v1/user/hapus',
                     type: 'DELETE',
                     headers : {
                        'Content-Type' : 'application/x-www-form-urlencoded',
                        'token' : token
                     },
                     data : {
                        'user_id' : user_id
                     },
                     dataType : 'JSON',
                     success: function(data){
                        if(data.status == "error"){
                           swal("Warning !", data.message, "error");
                        } else {
                           swal({
                              title: 'Success !',
                              text: 'Deleted User Success',
                              type: 'success'
                           }, function(isConfirm){
                              window.location.href = base_url+'user/';
                           });
                        }
                     }
                  });
               }
            });
         }

         function addUser(){
            window.location.href = base_url+'user/add';
         }
      </script>
