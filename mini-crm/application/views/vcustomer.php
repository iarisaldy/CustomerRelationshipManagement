<style type="text/css">
#customer-location {
	height: 250px;
	position: relative;
	overflow: hidden;
	width: 100%;
}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Customer
			<small>list of registered customer</small>
		</h1>
	</section>

	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">
					<button data-toggle="modal" id="btn-import" data-target="#modal-import" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload Customer</button>
					&nbsp;
					<button data-toggle="modal" id="btn-export" data-target="#modal-export" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Export Customer</button>
				</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
					title="Collapse">
					<i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body table-responsive">
				<div class="row">
					<div class="col-md-3">
						<i>Filter Region</i>
						<select class="form-control" id="filter_region"></select>
					</div>
					<div class="col-md-3">
						<i>Filter City</i>
						<select class="form-control" id="filter_city">
							<option value="">Choose City</option>
						</select>
					</div>
					<div class="col-md-6">
						<br/>
						<button id="btn-filter" class="btn btn-info"><i class="fa fa-filter"></i> Filter</button>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="list-customer" class="table" style="width: 100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode Customer</th>
										<th>Nama Toko</th>
										<th>Nama Pemilik</th>
										<th>Provinsi</th>
										<th>Kota</th>
										<th>Kecamatan</th>
										<th>Area</th>
										<th>Aksi</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</section>

	<div class="modal fade" id="modal-default">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div style="background-color: #dd4b39; color: white;" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Detail Customer</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-bordered table-striped">
								<tr>
									<th>Kode Customer</th>
									<td id="kode_customer">-</td>
								</tr>
								<tr>
									<th>Nama Customer</th>
									<td id="nm_customer"></td>
								</tr>
								<tr>
									<th>Nomor Telepon Toko</th>
									<td id="no_telp_toko">-</td>
								</tr>
								<tr>
									<th>Distributor</th>
									<td id="distributor">-</td>
								</tr>
								<tr>
									<th>Nama Pemiliki</th>
									<td id="nm_owner">-</td>
								</tr>
								<tr>
									<th>Provinsi</th>
									<td id="provinsi">-</td>
								</tr>
								<tr>
									<th>Kota</th>
									<td id="kota">-</td>
								</tr>
								<tr>
									<th>Kecamatan</th>
									<td id="kecamatan">-</td>
								</tr>
								<tr>
									<th>Area</th>
									<td id="area">-</td>
								</tr>
								<tr>
									<th>Alamat</th>
									<td id="alamat">-</td>
								</tr>
								<tr>
									<th>Status</th>
									<td id="status">-</td>
								</tr>
								<tr>
									<th>Keterangan</th>
									<td id="keterangan">-</td>
								</tr>
								<tr>
									<th>Akurasi GPS</th>
									<td id="gps">-</td>
								</tr>
								<tr>
									<th>Verifikasi Data Toko</th>
									<td id="verifikasi">-</td>
								</tr>
								<tr>
									<th>Verifikasi QR Code</th>
									<td id="verifikasiqr">-</td>
								</tr>								
								<tr>
									<th>Nonaktifkan</th>
									<td id="btn-delete">-</td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<div class="box box-danger box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Customer Location</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<div id="customer-location"></div>
								</div>
							</div>
							<div class="box collapsed-box box-danger box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">QR Code</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
								<div class="box-body">
									<input type="hidden" id="id-customer-val" name="">
									<input type="hidden" id="name-customer-val" name="">
									<div align="center"><button onclick="printQrCode()" class="btn btn-sm btn-warning">Print QR Code</button></div><br/>
									<div id="hasil-qrcode">
										<div align="center" id="ket-qrcode"></div>
									</div>
									<div id="hasil-print"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-import">
		<div class="modal-dialog">
			<div class="modal-content">
				<div style="background-color: #dd4b39; color: white;" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-upload"></i> Import Customer</h4>
					</div>
					<div class="modal-body">
						<div>
							<a href="<?php echo base_url('assets/Template-Upload.xlsx'); ?>" target="_blank" class="btn btn-sm btn-info">Download Template</a>&nbsp;<label class="btn btn-xs btn-danger">&nbsp; <sup>*</sup> Kolom dengan label merah harus diisi</label>
						</div>

						<hr/>
						<form id="import-customer" enctype="multipart/form-data">
							<div class="box-body">
								<div class="form-group">
									<label for="exampleInputEmail1">File Excel</label>
									<input type="file" name="file" id="file" class="form-control">
									<sub>* Format file xlsx, csv, xls</sub>
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-sm btn-info">Save</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-export">
		<div class="modal-dialog">
			<div class="modal-content">
				<div style="background-color: #dd4b39; color: white;" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-download"></i> Export Customer</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="box-body">
								<div class="form-group">
									<label for="exampleInputEmail1">Choose City</label>
									<select class="form-control" id="list_city"></select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
						<button id="export" type="button" class="btn btn-sm btn-info">Export</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDLcPZk5_QNfhUDokPNILm_jnB7-B7yvoY"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/qrcode.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/html2canvas.min.js'); ?>"></script>
	<script type="text/javascript">
		var token = localStorage.getItem('token');
		var data_token   = JSON.parse(atob(token.split('.')[1]));
		$('document').ready(function(){
			list_region();
			list_city('list_city', 1000053);
			if(data_token.role != "ADMIN"){
				$('#btn-import').css('display','none');
			} 
			list_customer(0,0);
		});

		$('#import-customer').on('submit', function(e){
			e.preventDefault();
			var formData = new FormData();
			formData.append('file', $('#file')[0].files[0]);

			$.ajax({
				url : base_url+'api/v1/import',
				type : 'POST',
				data : formData,
				contentType : false,
				processData : false,
				success : function(data){
					console.log(data.status);
					if(data.status == "success"){
						swal({
							title: 'Success !',
							text: 'Import customer success',
							type: 'success'
						}, function(isConfirm){
							window.location.reload();
						});
					}
				}
			});
		});

		function list_customer(region = null, city = null){
			$('#list-customer').DataTable({
				"destroy" : true,
				"processing": true,
				"serverSide": true,
				"order": [],
				"ajax": {
					"url": "<?php echo site_url('api/v1/customer/list_customer/')?>"+region+"/"+city,
					"headers": { 'token' : localStorage.getItem('token') },
					"type": "POST"
				},
				"columnDefs": [
				{
					"targets": [0],
					"orderable": false,
				},
				],
			});
		}

		$('#btn-filter').on('click', function(){
			var region = $('#filter_region').val();
			var city = $('#filter_city').val();
			list_customer(region, city);
		});

		function list_region(){
			$.ajax({
				url: base_url+'api/v1/region/',
				type: 'GET',
				headers : {
					'token' : localStorage.getItem('token'),
				},
				dataType: 'JSON',
				success: function(data){
					var city = '';
					city += '<option value="">Choose Region</option>';
					if(data.status == "error"){
						swal("Perhatian !", data.message, "error");
					} else {
						for(var a=0;a<data.data.length;a++){
							city += '<option value="'+data.data[a].KD_REGION+'">'+data.data[a].NM_REGION+'</option>';
						}
					}
					$('#filter_region').html(city);
				}
			});
		}

		$('#filter_region').on('change', function(){
			var region = $('#filter_region').val();
			list_city('filter_city', region);
		});

		function list_city(type_id, region){
			if(region == ""){
				$('#'+type_id).html('<option value="">PILIH KOTA</option>');
			} else {
				$.ajax({
					url: base_url+'api/v1/city/'+region,
					type: 'GET',
					headers : {
						'token' : localStorage.getItem('token'),
					},
					dataType: 'JSON',
					success: function(data){
						var city = '';
						city += '<option value="">PILIH KOTA</option>';
						if(data.status == "error"){
							swal("Perhatian !", data.message, "error");
						} else {
							for(var a=0;a<data.data.length;a++){
								city += '<option value="'+data.data[a].KD_CITY+'">'+data.data[a].NM_CITY+'</option>';
							}
						}
						$('#'+type_id).html(city);
					}
				});
			}
			
		}

		function detail_customer(customer_id){
			$('#modal-default').modal('show');
			$.ajax({
				url: base_url+'api/v1/customer/detail/'+customer_id,
				type: 'GET',
				headers : {
					'token' : localStorage.getItem('token'),
				},
				dataType: 'JSON',
				success: function(data){
					if(data.status == "error"){
						swal("Perhatian !", data.message, "error");
					} else {
						if(data.data[0].IS_VERIFIED == 'Y'){
							verifikasi = '<large class="label label-success">Terverifikasi</large>';
						} else {
							verifikasi = '<large class="label label-danger">Belum Terverifikasi</large>';
						}
						if(data.data[0].IS_VERIFIED_BARCODE == 'Y'){
							verifikasiqr = '<large class="label label-success">Terverifikasi</large>';
						} else {
							verifikasiqr = '<large class="label label-danger">Belum Terverifikasi</large>';
						}						

						if(data.data[0].IS_DELETED == 'Y'){
							hapus = "NONAKTIF";
						} else {
							hapus = "<button onclick='delete_customer("+data.data[0].CUSTOMER_ID+")' class='btn btn-sm btn-danger'>Nonaktifkan / Hapus</button>";
						}
						$('#kode_customer').html(data.data[0].KD_CUSTOMER);
						$('#nm_customer').html(data.data[0].NM_TOKO);
						$('#no_telp_toko').html(data.data[0].NO_TELP_TOKO);
						$('#distributor').html(data.data[0].NM_DISTRIBUTOR);
						$('#nm_owner').html(data.data[0].NM_OWNER);
						$('#provinsi').html(data.data[0].NM_REGION);
						$('#kota').html(data.data[0].NM_CITY);
						$('#kecamatan').html(data.data[0].NM_DISTRICT);
						$('#area').html(data.data[0].NM_AREA);
						$('#alamat').html(data.data[0].ALAMAT_TOKO);
						$('#status').html(data.data[0].STATUS_ACTIVE_TOKO);
						$('#keterangan').html(data.data[0].KETERANGAN);
						$('#gps').html(data.data[0].GPS_ACCURACY);
						$('#verifikasi').html(verifikasi);
						$('#verifikasiqr').html(verifikasiqr);
						$('#btn-delete').html(hapus);
						customer_location(Number(data.data[0].LATITUDE), Number(data.data[0].LONGITUDE));
						create_qrcode(data.data[0].CUSTOMER_ID, data.data[0].NM_TOKO);
					}
				}
			});
		}

		function delete_customer(customer_id){
			swal({
				title: "Do you want delete customer ?",
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
						url: base_url+'api/v1/customer/nonaktif',
						type: 'PUT',
						headers : {
							'Content-Type' : 'application/x-www-form-urlencoded',
							'token' : token
						},
						data : {
							'customer_id' : customer_id
						},
						dataType : 'JSON',
						success: function(data){
							if(data.status == "error"){
								swal("Warning !", data.message, "error");
							} else {
								swal({
									title: 'Success !',
									text: 'Deleted Customer Success',
									type: 'success'
								}, function(isConfirm){
									window.location.href = base_url+'customer/';
								});
							}
						}
					});
				}
			});
		}

		function create_qrcode(customer_id, nm_customer,){
			var text = customer_id+';'+nm_customer+';';
			$('#ket-qrcode').html('<img src="http://chart.apis.google.com/chart?cht=qr&chs=250x250&chma=50&chld=H|0&chl='+text+'&choe=UTF-8.png" />');

			$('#id-customer-val').val(customer_id);
			$('#name-customer-val').val(nm_customer);
		}

		function printQrCode(){
			var customer_id = $('#id-customer-val').val();
			var name_customer = $('#name-customer-val').val();
			var res = name_customer.replace(/[#_)(,'/&*^)]/g,'');
			// var res = name_customer.replace("(", "");
			// var res = res.replace(")", "");
			// var res = res.replace(",", "");
			// var res = res.replace("'", " ");
			// var res = res.replace("/", " ");

			// $.ajax({
			// 	url: base_url+'card/create',
			// 	type: "POST",
			// 	data: {
			// 		"id" : customer_id,
			// 		"name" : res
			// 	},
			// 	success: function(data){
			// 		window.open(base_url+'card/create/', '_blank');
			// 	}
			// });

			window.open(base_url+'card/create/'+customer_id+'/'+res, '_blank');
		}

		$('#export').on('click', function(){
			var city_id = $('#list_city').val();
			if(city_id != ""){
				window.open(base_url+'api/v1/export/excel/'+city_id);
			} else {
				swal("Warning !", "PLEASE SELECT CITY FRIST", "error");
			}
		});

		function customer_location(latitude, longitude){
			if(latitude == 0 && longitude == 0){
				$('#customer-location').html('<img width="100%" src="'+base_url+'assets/images/business.gif"/>');
			} else {
				var myLatLng = {lat: latitude, lng: longitude};

				var options = {
					zoom: 15,
					center: myLatLng,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					disableDefaultUI: true
				};

				map = new google.maps.Map(document.getElementById('customer-location'), options);
				var marker = {
					position: myLatLng,
					map: map,
				}

				mapmarker = new google.maps.Marker(marker);
				mapmarker.setAnimation(google.maps.Animation.BOUNCE);
			}

		}
	</script>

