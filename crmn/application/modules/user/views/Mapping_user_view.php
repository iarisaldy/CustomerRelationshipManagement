<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
            <div class="card" style="padding: 0.5em">
				<div class="header bg-cyan">
                    <h2 style="padding-top: 0.2em;">MAPPING USER</h2>
                </div>
				
				<div class="body" >
                    <div class="row " >
						
							<div class="col-md-2" style="margin: 0">
							
								<img class="img-responsive img-thumbnail" style="width: 90%;" src="https://png.pngtree.com/png-vector/20190114/ourmid/pngtree-vector-add-user-icon-png-image_313043.jpg">
							
							</div>
							<div class="col-md-10" style="margin: 0">
							<?php foreach($users as $d){ ?>
								<h2><?= $d['NAMA']; ?></h2>
								<p>Kode / ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $d['ID_USER']; ?></p>
								<p>Username &nbsp;&nbsp;&nbsp;: <?= $d['USERNAME']; ?></p>
								<p>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $d['EMAIL']; ?></p>
							<?php } ?>
							</div>
							
					</div>
					<hr>
					<h2 style="text-align: center;"> JENIS USER :  <?= $d['JENIS_USER']; ?></h2>
					<hr>
				</div>
				
				<!--- FITUR DIMATIKAN MAPPING UP
				
				<div class="card" style="margin: 0 1em 1em 1em; <?php if( $d['ID_JENIS_USER'] != 00000){ echo 'display: none;';} ?>;">
					<div class="header" style="background-color: rgba(235, 59, 90,1.0);">
                    <h2 style="padding-top: 0.2em;">HIERARKI</h2>
					</div>
                    <div class="body">
                        <div class="container-fluid">
							<ul class="nav nav-tabs" role="tablist">
								<li style="<?php if( $d['ID_JENIS_USER'] == 1016 or $d['ID_JENIS_USER'] == 1011 or $d['ID_JENIS_USER'] == 1012){ echo 'display: none;';} ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1010){ echo 'active';} ?>"><a href="#gsm" aria-controls="gsm" role="tab" data-toggle="tab">GENERAL SALES MANAJER (GSM)</a></li>
								<li style="<?php if( $d['ID_JENIS_USER'] == 1010 or $d['ID_JENIS_USER'] == 1012){ echo 'display: none;';} ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1011){ echo 'active';} ?>"><a href="#ssm" aria-controls="ssm" role="tab" data-toggle="tab">SENIOR SALES MANAJER (SSM)</a></li>
								<li style="<?php if( $d['ID_JENIS_USER'] == 1011 or $d['ID_JENIS_USER'] == 1010){ echo 'display: none;';} ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1012){ echo 'active';} ?>"><a href="#sm" aria-controls="sm" role="tab" data-toggle="tab">SALES MANAJER (SM)</a></li>
								<li style="<?php if( $d['ID_JENIS_USER'] == 1012 or $d['ID_JENIS_USER'] == 1010 or $d['ID_JENIS_USER'] == 1011){ echo 'display: none;';} ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1011){ echo 'active';} ?>"><a href="#so" aria-controls="so" role="tab" data-toggle="tab">SALES OFFICER (SO)</a></li>
								<li style="<?php if( $d['ID_JENIS_USER'] == 1015 or $d['ID_JENIS_USER'] == 1010 or $d['ID_JENIS_USER'] == 1011){ echo 'display: none;';} ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1009){ echo 'active';} ?>"><a href="#sd" aria-controls="sd" role="tab" data-toggle="tab">SALES DISTRIBUTOR (SD)</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1010){ echo 'active';} ?>" id="gsm">
									<?php if($d['ID_JENIS_USER'] == 1010){ ?>
										<h4>
											<span>Daftar General Sales Mamanajer (GSM) </span>
											<span id="BtnTambah_gsm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListGsmOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_gsm">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID GSM</th>
														<th>NAMA GSM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_gsm"></tbody>
											</table>
										</div>
									<?php } else { ?>
										<h4> General Sales Mamanajer (GSM) </h4>
									<?php } ?>
									
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1011){ echo 'active';} ?>" id="ssm">
									<?php if($d['ID_JENIS_USER'] == 1011){ ?>
										<h4>
											<span>Daftar Senior Sales Mamanajer (SSM) </span>
											<span id="BtnTambah_ssm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSsmOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_ssm">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SSM</th>
														<th>NAMA SSM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_ssm"></tbody>
											</table>
										</div>
									<?php } else { ?>
										<h4> Senior Sales Mamanajer (SSM) </h4>
									<?php } ?>
								</div>
								
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1012){ echo 'active';} ?>" id="sm">
									<?php if($d['ID_JENIS_USER'] == 1012){ ?>
										<h4>
											<span>Daftar Sales Mamanajer (SM) </span>
											<span id="BtnTambah_sm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSmOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_sm">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SM</th>
														<th>NAMA SM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_sm"></tbody>
											</table>
										</div>
									<?php } else { ?>
										<h4> Sales Mamanajer (SM) </h4>
									<?php } ?>
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1011){ echo 'active';} ?>" id="so">
									<?php if($d['ID_JENIS_USER'] == 1009){ ?>
										<h4>
											<span>Daftar Sales Officer (SO) </span>
											<span id="BtnTambah_so" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSoOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_so">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SO</th>
														<th>NAMA SO</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_so"></tbody>
											</table>
										</div>
									<?php } else { ?>
										<h4> Sales Officer (SO) </h4>
									<?php } ?>
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1012){ echo 'active';} ?>" id="sd">
									<?php if($d['ID_JENIS_USER'] == 1012){ ?>
										<h4>
											<span>Daftar Sales Distributor (SD) </span>
											<span id="BtnTambah_sd" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSdOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_sd">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SD</th>
														<th>NAMA SD</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_sd"></tbody>
											</table>
										</div>
									<?php } else { ?>
										<h4> Sales Distributor (SD) </h4>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				 END -->
				 
				 <div class="card" style="margin: 0 1em 1em 1em; <?php if( $d['ID_JENIS_USER'] == 1015 or $d['ID_JENIS_USER'] == 1013 or $d['ID_JENIS_USER'] == 1012 or $d['ID_JENIS_USER'] == 1017){ echo 'display: none;';} ?>;">
					<div class="header" style="background-color: rgba(235, 59, 90,1.0);">
                    <h2 style="padding-top: 0.2em;">HIERARKI DOWN / BAWAHAN LANGSUNG</h2>
					</div>
                    <div class="body">
                        <div class="container-fluid">
							<ul class="nav nav-tabs" role="tablist">
							
								<li style="display: none;" role="presentation" class=""><a href="#gsm" aria-controls="gsm" role="tab" data-toggle="tab">GENERAL SALES MANAGER (GSM)</a></li>
								
								<li style="<?php if($d['ID_JENIS_USER'] == 1016){ } else { echo 'display: none;'; } ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1016){ echo 'active';} ?>"><a href="#ssm" aria-controls="ssm" role="tab" data-toggle="tab">SENIOR SALES MANAGER (SSM)</a></li>
								
								<li style="<?php if($d['ID_JENIS_USER'] == 1010){ } else { echo 'display: none;'; } ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1010){ echo 'active';} ?>"><a href="#sm" aria-controls="sm" role="tab" data-toggle="tab">SALES MANAGER (SM)</a></li>
								
								<li style="<?php if($d['ID_JENIS_USER'] == 1011){ } else { echo 'display: none;'; } ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1011){ echo 'active';} ?>"><a href="#so" aria-controls="so" role="tab" data-toggle="tab">AREA MANAGER (AM)</a></li>
								
								<li style="<?php if($d['ID_JENIS_USER'] == 1012){ } else { echo 'display: none;'; } ?>" role="presentation" class="<?php if( $d['ID_JENIS_USER'] == 1012){ echo 'active';} ?>"><a href="#sd" aria-controls="sd" role="tab" data-toggle="tab">SALES DISTRIBUTOR (SD)</a></li>
								
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in" id="gsm">
									
										<h4>
											<span>Daftar General Sales Manager (GSM) </span>
											<span id="BtnTambah_gsm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListGsmOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_gsm">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID GSM</th>
														<th>NAMA GSM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_gsm"></tbody>
											</table>
										</div>
									
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1016){ echo 'active';} ?>" id="ssm">
									
										<h4>
											<span>Daftar Senior Sales Manager (SSM) </span>
											<span id="BtnTambah_ssm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSsmOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_ssm">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SSM</th>
														<th>NAMA SSM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_ssm"></tbody>
											</table>
										</div>
									
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1010){ echo 'active';} ?>" id="sm">
									
										<h4>
											<span>Daftar Sales Manager (SM) </span>
											<span id="BtnTambah_sm" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSmOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_sm">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SM</th>
														<th>NAMA SM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_sm"></tbody>
											</table>
										</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1011){ echo 'active';} ?>" id="so">
								
										<h4>
											<span>Daftar Area Manager (AM) </span>
											<span id="BtnTambah_so" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSoOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_so">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID AM</th>
														<th>NAMA AM</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_so"></tbody>
											</table>
										</div>
									
								</div>
								<div role="tabpanel" class="tab-pane fade in <?php if( $d['ID_JENIS_USER'] == 1012){ echo 'active';} ?>" id="sd">
									
										<h4>
											<span>Daftar Sales Distributor (SD) </span>
											<span id="BtnTambah_sd" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListSdOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_sd">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID SD</th>
														<th>NAMA SD</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_sd"></tbody>
											</table>
										</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="card" style="margin: 2em 1em 1em 1em; <?php if($d['ID_JENIS_USER'] == 1016 OR $d['ID_JENIS_USER'] == 1010 OR $d['ID_JENIS_USER'] == 1011 OR $d['ID_JENIS_USER'] == 1015 OR $d['ID_JENIS_USER'] == 1013 ){ echo 'display: none;'; } else { } ?>">
					<div class="header" style="background-color: rgba(254, 211, 48,1.0);">
                    	<h2 style="padding-top: 0.2em;">WILAYAH CAKUPAN</h2>
                	</div>
                    <div class="body">
                        <div class="container-fluid">
							<ul class="nav nav-tabs" role="tablist">
								 <?php if($d['ID_JENIS_USER'] != 1012){ ?>
								<li role="presentation" class="active"><a href="#region" aria-controls="region" role="tab" data-toggle="tab">REGION</a></li>
								<li role="presentation" style="display: none;"><a href="#provinsi" aria-controls="provinsi" role="tab" data-toggle="tab">PROVINSI</a></li>
								<li role="presentation" style="display: none;"><a href="#area" aria-controls="area" role="tab" data-toggle="tab">AREA</a></li>
								 <?php } ?>
								<li role="presentation" class="active" style="<?php if($d['ID_JENIS_USER'] == 1017){ echo 'display: none;';} ?>"><a href="#distrik" aria-controls="distrik" role="tab" data-toggle="tab">DISTRIK</a></li>
								 
							</ul> 
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="region" style="<?php if($d['ID_JENIS_USER'] == 1012){ echo 'display: none;';} ?>">
										<h4>
											<span>Daftar Region </span>
											<span id="BtnTambah_region" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListRegionOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_region">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID REGION</th>
														<th>NAMA REGION</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_region"></tbody>
											</table>
										</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="provinsi">
										<h4>
											<span>Daftar Provinsi </span>
											<span id="BtnTambah_provinsi" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListProvinsiOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_provinsi">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID PROVINSI</th>
														<th>NAMA PROVINSI</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_provinsi"></tbody>
											</table>
										</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="area">
										<h4>
											<span>Daftar Area </span>
											<span id="BtnTambah_area" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListAreaOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_area">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>KD AREA</th>
														<th>NAMA AREA</th>
														<th style="text-align:center;">ACTION</th>
													</tr>
												</thead>
												<tbody class="y" id="show_data_area"></tbody>
											</table>
										</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in active" id="distrik" style="<?php if($d['ID_JENIS_USER'] == 1017){ echo 'display: none;';} ?>">
										<h4>
											<span>Daftar Distrik </span>
											<span id="BtnTambah_distrik" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListDistrikOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_distrik">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>ID DISTRIK</th>
														<th>NAMA DISTRIK</th>
														<th style="text-align:center;">ACTION</th>
													</tr> 
												</thead>
												<tbody class="y" id="show_data_distrik"></tbody>
											</table>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="card" style="margin: 2em 1em 1em 1em; <?php if($d['ID_JENIS_USER'] == 1016 OR $d['ID_JENIS_USER'] == 1010 OR $d['ID_JENIS_USER'] == 1011 OR $d['ID_JENIS_USER'] == 1012 or $d['ID_JENIS_USER'] == 1017){ echo 'display: none;';  } else { }?>">
					<div class="header" style="background-color: #12CBC4;">
						<h2 style="padding-top: 0.2em;">DISTRIBUTOR</h2>
					</div>
                    <div class="body">
                        <div class="container-fluid">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#distributor" aria-controls="distributor" role="tab" data-toggle="tab">DISTRIBUTOR</a></li>
								 <?php if($d['ID_JENIS_USER'] != 1015 AND $d['ID_JENIS_USER'] != 1013){ ?>
								<li role="presentation"><a href="#gudang" aria-controls="gudang" role="tab" data-toggle="tab">GUDANG</a></li>
								 <?php } ?>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="distributor">
										<h4>
											<span>Daftar Distributor </span>
											<div id="aksiTambahDistributor">
											<span id="BtnTambah_distributor" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListDistributorOptions" style=" float: right; margin: 0" >
                                            </div>
											</div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_distributor">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>KODE</th>
														<th>NAMA DISTRIBUTOR</th>
														<th style="text-align:center;">ACTION</th>
													</tr> 
												</thead>
												<tbody class="y" id="show_data_distributor"></tbody>
											</table>
										</div>
								</div>
								<div role="tabpanel" class="tab-pane fade in" id="gudang">
										<h4>
											<span>Daftar Gudang</span>
											<span id="BtnTambah_gudang" style="float: right; margin: 0 1em 0 1em;" class="btn btn-info btn-md"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah </span>
											<div class="col-md-3" id="getListGudangOptions" style=" float: right; margin: 0" >
                                            </div>
										</h4>
										<br>
										<hr>
										<div class="table-responsive">
											<table style="font-size: 12px;" class="table table-striped table-bordered dataTable no-footer" id="daftar_gudang">
												<thead class="w">
													<tr>
														<th width="2%">NO</th>
														<th>KODE</th>
														<th>NAMA GUDANG</th>
														<th style="text-align:center;">ACTION</th>
													</tr> 
												</thead>
												<tbody class="y" id="show_data_gudang"></tbody>
											</table>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>

<script>

var id_user_in = <?= $id_user_in; ?>;
var jenis_user = <?= $d['ID_JENIS_USER']; ?>;
//console.log(jenis_user);
 
$(document).ready(function() {
	
	 <?php if($d['ID_JENIS_USER'] == 1015 OR $d['ID_JENIS_USER'] == 1013 or $d['ID_JENIS_USER'] == 1012 or $d['ID_JENIS_USER'] == 1017){   } else { ?>
	
// ------------------------------------------------------------ >>> USER HIERARKI OLD

   //load_data_hierarki('gsm','#daftar_gsm','#show_data_gsm');
   //get_hierarki_list_options('gsm','#getListGsmOptions');
   
   get_hierarki_list_options('ssm','#getListSsmOptions');
   load_data_hierarkiNew('ssm','#daftar_ssm','#show_data_ssm');
   
   get_hierarki_list_options('sm','#getListSmOptions');
   load_data_hierarkiNew('sm','#daftar_sm','#show_data_sm');
   
   get_hierarki_list_options('so','#getListSoOptions');
   load_data_hierarkiNew('so','#daftar_so','#show_data_so');
   
   get_hierarki_list_options('sd','#getListSdOptions');
   load_data_hierarkiNew('sd','#daftar_sd','#show_data_sd');
   
   <?php } ?>
   
   <?php if($d['ID_JENIS_USER'] == 1016 OR $d['ID_JENIS_USER'] == 1010 OR $d['ID_JENIS_USER'] == 1011 OR $d['ID_JENIS_USER'] == 1015 OR $d['ID_JENIS_USER'] == 1013){   } else { ?>
// ---------------------------------------------------------- >>> WILAYAH CAKUPAN
   <?php if($d['ID_JENIS_USER'] != 1012){ ?>
   load_data_wilayah_cakupan('region','#daftar_region','#show_data_region');
    get_wilayah_list_options('region','#getListRegionOptions');
	
   load_data_wilayah_cakupan('provinsi','#daftar_provinsi','#show_data_provinsi');
    get_wilayah_list_options('provinsi','#getListProvinsiOptions');
	
   load_data_wilayah_cakupan('area','#daftar_area','#show_data_area');
	get_wilayah_list_options('area','#getListAreaOptions');
   <?php } ?>
   
   load_data_wilayah_cakupan('distrik','#daftar_distrik','#show_data_distrik');
    get_wilayah_list_options('distrik','#getListDistrikOptions');
	
   <?php 
   } 
   ?>
	
	<?php if($d['ID_JENIS_USER'] == 1016 OR $d['ID_JENIS_USER'] == 1010 OR $d['ID_JENIS_USER'] == 1011 OR $d['ID_JENIS_USER'] == 1012 or $d['ID_JENIS_USER'] == 1017){   } else { ?>
// -------------------------------------------------------- >>> DIST & GUDANG
	
	load_data_distributor_gudang('distributor','#daftar_distributor','#show_data_distributor');
	get_distribitor_gudang_list_options('distributor', '#getListDistributorOptions');
	
	load_data_distributor_gudang('gudang','#daftar_gudang','#show_data_gudang');
	get_distribitor_gudang_list_options('gudang', '#getListGudangOptions');
	
	<?php } ?>
});

// ------------------------------------------------------------------------------------------ >>> HIERAKI

function load_data_hierarkiOld(request, idTabel, idBody){
	$(idBody).html('<tr><td colspan="5"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_mappingan_hierarki',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_user" : id_user_in,
				"request" : request
			},
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					  
					var button = '<td style="text-align: center;">'+
								'<span id="BtnHapusUnmappHieraki" class="btn btn-danger" dt_user_in="'+id_user_in+'" dt_request="'+request+'" dt_id_u_map="'+data[i].ID+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="Hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$(idBody).html(html);
				$(idTabel).dataTable();
			},
			error: function(){
			}
		});
}

function get_hierarki_list_options(request, idDivOption){
	
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/';
	var id_select_option = '';
	var label_option = '';
	
	if(request == 'gsm'){
		get_link_akses = get_link_akses+'List_gsm';
		id_select_option = 'selectInGsm';
		label_option = 'Pilih GSM';
	} else if (request == 'ssm'){
		get_link_akses = get_link_akses+'List_ssm';
		id_select_option = 'selectInSsm';
		label_option = 'Pilih SSM';
	} else if (request == 'sm'){
		get_link_akses = get_link_akses+'List_sm';
		id_select_option = 'selectInSm';
		label_option = 'Pilih SM';
	} else if (request == 'so'){
		get_link_akses = get_link_akses+'List_so';
		id_select_option = 'selectInSo';
		label_option = 'Pilih AM';
	} else if (request == 'sd'){
		get_link_akses = get_link_akses+'List_sd';
		id_select_option = 'selectInSd';
		label_option = 'Pilih SD';
	}
	
	$.ajax({
		    url: get_link_akses,
		    type: 'GET',
			dataType: 'JSON',
		    success: function(data){
                var response = data;

                var type_list = '';
                type_list += '<select id="'+id_select_option+'" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="a404a" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- '+label_option+' -- </option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['+response[i]['ID_USER']+'] '+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(idDivOption).html(type_list);
                //$(id_select_option).val(isi);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
}


function load_data_hierarkiNew(request, idTabel, idBody){
	$(idBody).html('<tr><td colspan="5"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_mappingan_hierarkiNew',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_user" : id_user_in,
				"j_user"  : jenis_user,
				"request" : request
			},
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					  
					var button = '<td style="text-align: center;">'+
								'<span id="BtnHapusUnmappHieraki" class="btn btn-danger" dt_user_in="'+id_user_in+'" dt_request="'+request+'" dt_id_u_map="'+data[i].ID+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="Hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$(idBody).html(html);
				$(idTabel).dataTable();
			},
			error: function(){
			}
		});
}

// ------------------------------ ACTION KLIK UNTUK MAPPING HIERARKI

$(document).on("click", "#BtnTambah_gsm", function(e){
	e.preventDefault();
	
});

$(document).on("click", "#BtnTambah_ssm", function(e){
	e.preventDefault();
	
	var actionControl = 'ssm';
	var actIn_or_Del = 'in';
	var ssmSet = $('#selectInSsm option:selected').val();
	
	if(ssmSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		//setHierarki(ssmSet, actionControl, actIn_or_Del);  /Old
		setHierarkiNew(ssmSet, actionControl, actIn_or_Del);
		$("#daftar_ssm").DataTable().destroy();
		load_data_hierarkiNew('ssm','#daftar_ssm','#show_data_ssm');
	}
});

$(document).on("click", "#BtnTambah_sm", function(e){
	e.preventDefault();
	
	var actionControl = 'sm';
	var actIn_or_Del = 'in';
	var smSet = $('#selectInSm option:selected').val();
	
	if(smSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setHierarkiNew(smSet, actionControl, actIn_or_Del);
		$("#daftar_sm").DataTable().destroy();
		load_data_hierarkiNew('sm','#daftar_sm','#show_data_sm');
	}
});

$(document).on("click", "#BtnTambah_so", function(e){
	e.preventDefault();
	var actionControl = 'so';
	var actIn_or_Del = 'in';
	var soSet = $('#selectInSo option:selected').val();
	
	if(soSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setHierarkiNew(soSet, actionControl, actIn_or_Del);
		$("#daftar_so").DataTable().destroy();
		load_data_hierarkiNew('so','#daftar_so','#show_data_so');
	}
});

$(document).on("click", "#BtnTambah_sd", function(e){
	e.preventDefault();
	
	var actionControl = 'sd';
	var actIn_or_Del = 'in';
	var sdSet = $('#selectInSd option:selected').val();
	
	if(sdSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setHierarkiNew(sdSet, actionControl, actIn_or_Del);
		$("#daftar_sd").DataTable().destroy();
		load_data_hierarkiNew('sd','#daftar_sd','#show_data_sd');
	}
});

// ----> untuk hapus unmap HIERARKI

$(document).on("click", "#BtnHapusUnmappHieraki", function(e){
	e.preventDefault();
	
	var actionControl = $(this).attr("dt_request");
	console.log(actionControl);
	var valueIn = $(this).attr("dt_id_u_map");
	var actIn_or_Del = 'del';
	
    if (confirm("Apakah Anda Yakin Ingin Menghapus Data?")) {
		setHierarkiNew(valueIn, actionControl, actIn_or_Del);
		$("#daftar_"+actionControl).DataTable().destroy();
		load_data_hierarkiNew(actionControl,'#daftar_'+actionControl,'#show_data_'+actionControl);
		return true;
    }
});

function setHierarkiOld(valueIn, actionControl, actIn_or_Del){ 	// Set/Hapus distributor dan gudang user mapping and unmapping 
	var responseIn = '';
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/Set_mapping_hierarki';
	$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"actControl_js" : actionControl,
				"actIn_or_Del" 	: actIn_or_Del,
				"valueIn" 		: valueIn,
				"id_user" 		: id_user_in
			},
			dataType: 'JSON',
		    success: function(datas){
                responseIn = datas['pesan'];
				if (responseIn == 'success'){
					alert("Aksi pada Data "+actionControl+" Berhasil.");
				} else if (responseIn == 'ready') {
					alert("Data "+actionControl+" Sudah Ditambahkan Sebelumnya.");
				} else if (responseIn == 'failed') {
					alert("Aksi pada Data "+actionControl+" Gagal.");
				}
		    }
		});
}

function setHierarkiNew(valueIn, actionControl, actIn_or_Del){ 	// Set/Hapus distributor dan gudang user mapping and unmapping 
	var responseIn = '';
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/Set_mapping_hierarkiNew';
	$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"actControl_js" : actionControl,
				"actIn_or_Del" 	: actIn_or_Del,
				"valueIn" 		: valueIn,
				"id_user" 		: id_user_in
			},
			dataType: 'JSON',
		    success: function(datas){
                responseIn = datas['pesan'];
				if (responseIn == 'success'){
					alert("Aksi pada Data "+actionControl+" Berhasil.");
				} else if (responseIn == 'ready') {
					alert("Data "+actionControl+" Sudah Ditambahkan Sebelumnya.");
				} else if (responseIn == 'failed') {
					alert("Aksi pada Data "+actionControl+" Gagal.");
				}
		    }
		});
}

// ------------------------------------------------------------------------------------------- >> WILAYAH CAKUPAN

function get_wilayah_list_options(request, idDivOption){
	
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/List_wilayah_cakupan';
	var id_select_option = '';
	var label_option = '';
	
	if(request == 'region'){
		id_select_option = 'selectInRegion';
		label_option = 'Pilih Region';
	} else if (request == 'provinsi'){
		id_select_option = 'selectInProvinsi';
		label_option = 'Pilih Provinsi';
	} else if (request == 'area'){
		id_select_option = 'selectInArea';
		label_option = 'Pilih Area';
	} else if (request == 'distrik'){
		id_select_option = 'selectInDistrik';
		label_option = 'Pilih Distrik';
	} 
	
	$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"request" : request
			},
			dataType: 'JSON',
		    success: function(data){
                var response = data;

                var type_list = '';
                type_list += '<select id="'+id_select_option+'" data-size="10" class="form-control selectpicker show-tick"  data-live-search = "true">';
                type_list += '<option value="a404a" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- '+label_option+' -- </option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]["ID"]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['+response[i]["ID"]+'] '+response[i]["NAMA"]+'</option>';
                }
                type_list += '</select>';

                $(idDivOption).html(type_list);
                //$(id_select_option).val(isi);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
}

function load_data_wilayah_cakupan(request, idTabel, idBody){
	$(idBody).html('<tr><td colspan="5"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_mappingan_wilayah',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_user" : id_user_in,
				"request" : request
			},
			success: function(data){
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					  
					var button = '<td style="text-align: center;">'+
								'<span id="BtnHapusUnmappWilayahCakupan" class="btn btn-danger" dt_user_in="'+id_user_in+'" dt_request="'+request+'" dt_id_u_map="'+data[i].ID+'" dt_nama="'+data[i].LABEL+'"><i class="fa fa-trash" title="Hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].ID+'</td>'+
					'<td>'+data[i].LABEL+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$(idBody).html(html);
				$(idTabel).dataTable();
			},
			error: function(){
			}
		});
}

// ------------------------------ ACTION KLIK UNTUK MAPPING WILAYAH CAKUPAN

$(document).on("click", "#BtnTambah_region", function(e){
	e.preventDefault();
	 
	var actionControl = 'region';
	var actIn_or_Del = 'in';
	var regionSet = $('#selectInRegion option:selected').val();
	
	if(regionSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setCakupanWilayah(regionSet, actionControl, actIn_or_Del);
		$("#daftar_region").DataTable().destroy();
		load_data_wilayah_cakupan('region','#daftar_region','#show_data_region');
	}
});

$(document).on("click", "#BtnTambah_provinsi", function(e){
	e.preventDefault();
	 
	var actionControl = 'provinsi';
	var actIn_or_Del = 'in';
	var provinsiSet = $('#selectInProvinsi option:selected').val();
	
	if(provinsiSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setCakupanWilayah(provinsiSet, actionControl, actIn_or_Del);
		$("#daftar_provinsi").DataTable().destroy();
		load_data_wilayah_cakupan('provinsi','#daftar_provinsi','#show_data_provinsi');
	}
});

$(document).on("click", "#BtnTambah_area", function(e){
	e.preventDefault();
	 
	var actionControl = 'area';
	var actIn_or_Del = 'in';
	var areaSet = $('#selectInArea option:selected').val();
	
	if(areaSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setCakupanWilayah(areaSet, actionControl, actIn_or_Del);
		$("#daftar_area").DataTable().destroy();
		load_data_wilayah_cakupan('area','#daftar_area','#show_data_area');
	}
});

$(document).on("click", "#BtnTambah_distrik", function(e){
	e.preventDefault();
	 
	var actionControl = 'distrik';
	var actIn_or_Del = 'in';
	var distrikSet = $('#selectInDistrik option:selected').val();
	
	if(distrikSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setCakupanWilayah(distrikSet, actionControl, actIn_or_Del);
		$("#daftar_distrik").DataTable().destroy();
		load_data_wilayah_cakupan('distrik','#daftar_distrik','#show_data_distrik');
	}
});

// ----> untuk hapus unmap wilayah cakupan

$(document).on("click", "#BtnHapusUnmappWilayahCakupan", function(e){
	e.preventDefault();

	var actionControl = $(this).attr("dt_request");
	var valueIn = $(this).attr("dt_id_u_map");
	var actIn_or_Del = 'del';
	
    if (confirm("Apakah Anda Yakin Ingin Menghapus Data?")) {
		setCakupanWilayah(valueIn, actionControl, actIn_or_Del);
		$("#daftar_"+actionControl).DataTable().destroy();
		load_data_wilayah_cakupan(actionControl,'#daftar_'+actionControl,'#show_data_'+actionControl);
		 return true;
    }
});

function setCakupanWilayah(valueIn, actionControl, actIn_or_Del){ // // Set/Hapus wilayah  user mapping and unmapping 
	var responseIn = '';
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/Set_mapping_wilayah_cakupan';
	$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"actControl_js" : actionControl,
				"actIn_or_Del" 	: actIn_or_Del,
				"valueIn" 		: valueIn,
				"id_user" 		: id_user_in
			},
			dataType: 'JSON',
		    success: function(datas){
                responseIn = datas['pesan'];
				if (responseIn == 'success'){
					alert("Aksi pada Data "+actionControl+" Berhasil.");
				} else if (responseIn == 'ready') {
					alert("Data "+actionControl+" Sudah Ditambahkan Sebelumnya.");
				} else if (responseIn == 'failed') {
					alert("Aksi pada Data "+actionControl+" Gagal.");
				}
		    }
		});
}

// ------------------------------------------------------------------------------------------- >> DISTRIBUTOR & GUDANG

function get_distribitor_gudang_list_options(request, idDivOption){
	
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/List_distributor_gudang';
	var id_select_option = '';
	var label_option = '';
	
	if(request == 'distributor'){
		id_select_option = 'selectInDistributor';
		label_option = 'Pilih Distributor';
	} else if (request == 'gudang'){
		id_select_option = 'selectInGudang';
		label_option = 'Pilih Gudang';
	}
	
	$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"request" : request
			},
			dataType: 'JSON',
		    success: function(data){
                var response = data;

                var type_list = '';
                type_list += '<select id="'+id_select_option+'" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="a404a" disabled selected> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- '+label_option+' -- </option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KD']+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ['+response[i]['KD']+'] '+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(idDivOption).html(type_list);
                //$(id_select_option).val(isi);
                $(".selectpicker").selectpicker("refresh");
		    }
		});
}

function load_data_distributor_gudang(request, idTabel, idBody){
	$(idBody).html('<tr><td colspan="5"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
		
		$.ajax({
			url: '<?php echo site_url(); ?>user/Manajemen_user/List_mappingan_dist_gudang',
			type: 'POST',
			dataType : 'json',
			data: {
				"id_user" : id_user_in,
				"request" : request
			},
			success: function(data){
				
				if(request == 'distributor'){
					if(data.length > 0){
						$("#aksiTambahDistributor").hide();
					} else{
						$("#aksiTambahDistributor").show();
					}
				}
				  var html = '';
				  var i;
				  var c = "x";
				  var no = 1 ;
				  for(i=0; i<data.length; i++){
					  
					var button = '<td style="text-align: center;">'+
								'<span id="BtnHapusUnmappDistGudang" class="btn btn-danger" dt_user_in="'+id_user_in+'" dt_request="'+request+'" dt_id_u_map="'+data[i].KODE+'" dt_nama="'+data[i].NAMA+'"><i class="fa fa-trash" title="Hapus"></i></span>'+
							 '</td>'; 
					
					html += '<tr class='+c+'>'+
					'<td style="text-align: center;">'+no+'</td>'+
					'<td>'+data[i].KODE+'</td>'+
					'<td>'+data[i].NAMA+'</td>'+
					//label+
					button+
					'</tr>';
					no++;
					if(c == "x"){
						c = "y"  ;
					}else{
						c = "x" ; 
					}
				  }
				$(idBody).html(html);
				$(idTabel).dataTable();
			},
			error: function(){
			}
		});
}

// ------------------------------ ACTION KLIK UNTUK MAPPING Distributor dan Gudang

$(document).on("click", "#BtnTambah_distributor", function(e){
	e.preventDefault();
	 
	var actionControl = 'distributor';
	var actIn_or_Del = 'in';
	var distributorSet = $('#selectInDistributor option:selected').val();
	
	if(distributorSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setDistributorGudang(distributorSet, actionControl, actIn_or_Del);
		$("#daftar_distributor").DataTable().destroy();
		load_data_distributor_gudang('distributor','#daftar_distributor','#show_data_distributor');
	}
});

$(document).on("click", "#BtnTambah_gudang", function(e){
	e.preventDefault();
	 
	var actionControl = 'gudang';
	var actIn_or_Del = 'in';
	var gudangSet = $('#selectInGudang option:selected').val();
	
	if(gudangSet == 'a404a'){
		alert("Masukkan Pilihan Terlebih Dahulu.");
	} else {
		setDistributorGudang(gudangSet, actionControl, actIn_or_Del);
		$("#daftar_gudang").DataTable().destroy();
		load_data_distributor_gudang('gudang','#daftar_gudang','#show_data_gudang');
	}
});

// ----> untuk hapus unmap distributor dan gudang

$(document).on("click", "#BtnHapusUnmappDistGudang", function(e){
	e.preventDefault();

	var actionControl = $(this).attr("dt_request");
	console.log(actionControl);
	var valueIn = $(this).attr("dt_id_u_map");
	var actIn_or_Del = 'del';
	
    if (confirm("Apakah Anda Yakin Ingin Menghapus Data?")) {
		setDistributorGudang(valueIn, actionControl, actIn_or_Del);
		$("#daftar_"+actionControl).DataTable().destroy();
		load_data_distributor_gudang(actionControl,'#daftar_'+actionControl,'#show_data_'+actionControl);
		return true;
    }
});

function setDistributorGudang(valueIn, actionControl, actIn_or_Del){ 	// Set/Hapus distributor dan gudang user mapping and unmapping 
	var responseIn = '';
	var get_link_akses = '<?php echo site_url(); ?>user/Manajemen_user/Set_mapping_distributor_gudang';
	$.ajax({
		    url: get_link_akses,
		    type: 'POST',
			data: {
				"actControl_js" : actionControl,
				"actIn_or_Del" 	: actIn_or_Del,
				"valueIn" 		: valueIn,
				"id_user" 		: id_user_in
			},
			dataType: 'JSON',
		    success: function(datas){
                responseIn = datas['pesan'];
				if (responseIn == 'success'){
					alert("Aksi pada Data "+actionControl+" Berhasil.");
				} else if (responseIn == 'ready') {
					alert("Data "+actionControl+" Sudah Ditambahkan Sebelumnya.");
				} else if (responseIn == 'failed') {
					alert("Aksi pada Data "+actionControl+" Gagal.");
				}
		    }
		});
}

</script>