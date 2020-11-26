
<div class="content-wrapper">
	<section class="content-header">
		<h1>Edit User
			<small>Edit User Account</small>
		</h1>
	</section>

	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> </h3><button onclick="back()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="box box-danger box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">User Identity</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<form id="edit-user" role="form">
										<div class="form-group">
											<label for="edit_user">Name</label>
											<input type="text" class="form-control" id="edit_user" placeholder="Name User" required>
										</div>
										<div class="form-group">
											<label for="edit_username">Username</label>
											<input type="text" class="form-control" id="edit_username" placeholder="New Username" required>
										</div>

										<div class="form-group">
											<label for="edit_password">Password</label>
											<div class="input-group">
												<input type="password" id="edit_password" class="form-control" placeholder="New Password" required>
												<span class="input-group-btn">
													<button type="button" onclick="view_password()" class="btn btn-info btn-flat"><i class="fa fa-eye"></i></button>
												</span>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="box box-danger box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">Role</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<div class="form-group">
											<label for="role">User Role</label>
											<select id="role" class="form-control" required>
												<option>Choose Role</option>
											</select>
											<p>&nbsp;</p>
											<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-save"></i> Save User</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script type="text/javascript">
		var token = localStorage.getItem('token');
		var data_token   = JSON.parse(atob(token.split('.')[1]));
		var user_id = '<?php echo $this->uri->segment('3'); ?>';

		$(document).ready(function(){
			list_role();
			detail_user(user_id);
		});

		function detail_user(user_id){
			$.ajax({
				url: base_url+'api/v1/user/detail/'+user_id,
				type: 'GET',
				headers : {
					'token' : token
				},
				success: function(data){
					var data = JSON.parse(data);

					if(data.status == "error"){
						swal("Perhatian !", data.message, "error");
					} else {
						$('#role').val(data.data[0].ROLE_ID).change();
						$('#edit_user').val(data.data[0].NAME);
						$('#edit_username').val(data.data[0].USERNAME);
						$('#edit_password').val(data.data[0].PASSWORD);
						
					}
				}
			});
		}

		function view_password(){
			if($('#edit_password').get(0).type == 'text'){
				$('.btn-flat').html('<i class="fa fa-eye"></i>');
				$('#edit_password').get(0).type = 'password';
			} else {
				$('.btn-flat').html('<i class="fa fa-eye-slash"></i>');
				$('#edit_password').get(0).type = 'text';
			}

		}

		function list_role(){
			$.ajax({
				url: base_url+'api/v1/role',
				type: 'GET',
				headers : {
					'token' : token
				},
				success: function(data){
					if(data.status == "error"){
						swal("Perhatian !", data.message, "error");
					} else {
						var role = "";
						for(var i=0;i<data.data.length;i++){
							role += "<option value='"+data.data[i].ROLE_ID+"'>"+data.data[i].NAME+"</option>";
						}
						$('#role').append(role);
					}
				}
			});
		}

		$('#edit-user').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: base_url+'api/v1/user/edit',
				type: 'PUT',
				headers : {
					'token' : token
				},
				data : {
					'user_id' : user_id,
					'name' : $('#edit_user').val(),
					'username' : $('#edit_username').val(),
					'password' : $('#edit_password').val(),
					'role' : $('#role').val(),
					'updatedby' : data_token.user_id
				},
				dataType : 'JSON',
				success: function(data){
					if(data.status == "error"){
						swal("Warning !", data.message, "error");
					} else {
						swal({
							title: 'Success !',
							text: 'Update User Success',
							type: 'success'
						}, function(isConfirm){
							window.location.href = base_url+'user/';
						});
					}
				}
			});
		})

		function back(){
			window.location.href = base_url+'user';
		}
	</script>
