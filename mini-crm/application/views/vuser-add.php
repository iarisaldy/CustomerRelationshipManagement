
<div class="content-wrapper">
	<section class="content-header">
		<h1>Add User
			<small>Added New User</small>
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
									<form id="add-new-user" role="form">
										<div class="form-group">
											<label for="name_user">Name</label>
											<input type="text" class="form-control" id="name_user" placeholder="Name User" required>
										</div>
										<div class="form-group">
											<label for="username">Username</label>
											<input type="text" class="form-control" id="username" placeholder="New Username" required>
										</div>

										<div class="form-group">
											<label for="password">Password</label>
											<div class="input-group">
												<input type="password" id="password" class="form-control" placeholder="New Password" required>
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

		$(document).ready(function(){
			$('#loading-indicator').show();
			$('#user-list').DataTable();
			list_role();
		});

		function view_password(){
			if($('#password').get(0).type == 'text'){
				$('.btn-flat').html('<i class="fa fa-eye"></i>');
				$('#password').get(0).type = 'password';
			} else {
				$('.btn-flat').html('<i class="fa fa-eye-slash"></i>');
				$('#password').get(0).type = 'text';
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

		$('#add-new-user').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: base_url+'api/v1/user/add',
				type: 'POST',
				headers : {
					'token' : token
				},
				data : {
					'name' : $('#name_user').val(),
					'username' : $('#username').val(),
					'password' : $('#password').val(),
					'role' : $('#role').val(),
					'createdby' : data_token.user_id
				},
				success: function(data){
					if(data.status == "error"){
						swal("Warning !", data.message, "error");
					} else {
						swal({
							title: 'Success !',
							text: 'Create User New Success',
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
