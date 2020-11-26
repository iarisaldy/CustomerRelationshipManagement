 <!-- Custom Css -->
 <style>
 /* Profile Page ================================ */
.profile-card .profile-header {
  background-color: #ad1455;
  padding: 42px 0; }

.profile-card .profile-body .image-area {
  text-align: center;
  margin-top: -64px; }
  .profile-card .profile-body .image-area img {
    border: 2px solid #ad1455;
    padding: 2px;
    margin: 2px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    border-radius: 50%; }

.profile-card .profile-body .content-area {
  text-align: center;
  border-bottom: 1px solid #ddd;
  padding-bottom: 15px; }
  .profile-card .profile-body .content-area p {
    margin-bottom: 0; }
    .profile-card .profile-body .content-area p:last-child {
      font-weight: 600;
      color: #ad1455;
      margin-top: 5px; }

.profile-card .profile-footer {
  padding: 15px; }
  .profile-card .profile-footer ul {
    margin: 0;
    padding: 0;
    list-style: none; }
    .profile-card .profile-footer ul li {
      border-bottom: 1px solid #eee;
      padding: 10px 0; }
      .profile-card .profile-footer ul li:last-child {
        border-bottom: none;
        margin-bottom: 15px; }
      .profile-card .profile-footer ul li span:first-child {
        font-weight: bold; }
      .profile-card .profile-footer ul li span:last-child {
        float: right; }

.card-about-me .body ul {
  margin: 0;
  padding: 0;
  list-style: none; }
  .card-about-me .body ul li {
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
    padding-bottom: 15px; }
    .card-about-me .body ul li:last-child {
      border: none;
      margin-bottom: 0;
      padding-bottom: 0; }
    .card-about-me .body ul li .title {
      font-weight: bold;
      color: #666; }
      .card-about-me .body ul li .title i {
        margin-right: 2px;
        position: relative;
        top: 7px; }
    .card-about-me .body ul li .content {
      margin-top: 10px;
      color: #999;
      font-size: 13px; }

.panel-post {
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  -ms-border-radius: 0;
  border-radius: 0; }
  .panel-post .panel-heading {
    background-color: #fff;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    -ms-border-radius: 0;
    border-radius: 0; }
    .panel-post .panel-heading .media {
      margin-bottom: 0; }
      .panel-post .panel-heading .media a img {
        width: 42px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%; }
      .panel-post .panel-heading .media .media-body {
        padding-top: 5px; }
        .panel-post .panel-heading .media .media-body h4 {
          font-size: 14px; }
          .panel-post .panel-heading .media .media-body h4 a {
            color: #666; }
  .panel-post .panel-body {
    padding: 0; }
    .panel-post .panel-body .post .post-heading {
      padding: 12px 15px; }
      .panel-post .panel-body .post .post-heading p {
        margin-bottom: 0; }
  .panel-post .panel-footer {
    background-color: #fff;
    border: none; }
    .panel-post .panel-footer ul {
      margin: 0;
      padding: 0;
      list-style: none; }
      .panel-post .panel-footer ul li {
        display: inline-block;
        margin-right: 12px; }
        .panel-post .panel-footer ul li:last-child {
          float: right;
          margin-right: 0; }
        .panel-post .panel-footer ul li a {
          color: #777;
          text-decoration: none; }
          .panel-post .panel-footer ul li a i {
            font-size: 16px;
            position: relative;
            top: 4px;
            margin-right: 2px; }
          .panel-post .panel-footer ul li a span {
            font-size: 13px; }
    .panel-post .panel-footer .form-group {
      margin-bottom: 5px;
      margin-top: 20px; }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
				<div class="card" style="padding-bottom: 0;">
				
					<div class="header bg-purple">
						<h2 style="padding-top: 0.2em;">DETAIL SURVEI PENILAIAN SALES</h2>
					</div>
						
					<div class="body">
						<div class="row">
							
				<div class="col-xs-12 col-sm-3 col-md-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img  style="width: 45%;" src="https://png.pngtree.com/png-vector/20190114/ourmid/pngtree-vector-add-user-icon-png-image_313043.jpg" alt="AdminBSB - Profile Image" />
                            </div>
                            <div class="content-area">
                                <h3><?= $survei->NAMA_SALES; ?></h3>
                                <p><?= $survei->NAMA_DISTRIBUTOR; ?></p>
                                <h4>Supervisor / AM: </h4>
								<p style="font-weight: normal;"><?= $survei->NAMA_SO; ?></p>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li>
                                    <span style="font-weight: normal;">Poin Perolehan</span>
                                    <span><?= $survei->POINT_PEROLEHAN; ?></span>
                                </li>
                                <li>
                                    <span style="font-weight: normal;">Poin Maksimal</span>
                                    <span><?= $survei->POINT_MAX; ?></span>
                                </li>
                                <li>
                                    <span>Hasil Penilaian</span>
                                    <span><?= number_format((($survei->POINT_PEROLEHAN/$survei->POINT_MAX) * 100), 2); ?></span>
                                </li>
                            </ul>
                           
                        </div>
                    </div>
					
					<div class="card card-about-me">
                        
                        <div class="body">
                            <ul>
								<li>
                                    <div class="title">
                                        <i class="material-icons">perm_media</i>
                                        Foto Survei
                                    </div>
                                    <div class="content">
                                         <div class="body">
                                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
												
												<?php foreach($foto as $img){ ?>
                                                    <div class="item active">
                                                        <img class="img-responsive" width="100%" src="<?php echo site_url(); ?><?= $img['PATH_FOTO']; ?>" alt="Foto">
                                                    </div>
                                                <?php } ?>
													
                                                </div>

                                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>Hasil Penilaian Survei Sales </b></a></li>
                                    
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        
										<div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos" style="font-size: 10px;">
                                    <thead>
                                        
                                        <tr style="font-size: 12px;">
                                            <th width="2%">No</th>
                                            <th>Pertanyaan</th>
                                            <th>Jawaban</th>
                                            <th>Poin</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($jp as $dt_jp){ ?>
                                    <tr style="background-color: #F5F5F5;"> 
                                        <td colspan="4" style="color: #03A9F4; font-size: 11px;"><strong> <?= $dt_jp['NM_JENIS_PENILAIAN']; ?></strong></td>
                                    </tr>
                                    
									<?php
                                    $isi_p =  $this->MRSS->List_penilaian($dt_jp['NO_VISIT'], $dt_jp['ID_JENIS_PENILAIAN']);
									$nomber= 1;
									foreach($isi_p as $nilai){
										$persen = ($nilai['POINT']/$nilai['POINT_MAX']) * 100;
									?>
                                        <tr>
                                            <td><?= $nomber; ?></td>
                                            <td><?= $nilai['NM_PERTANYAAN']; ?></td>
                                            <td>[<?= $nilai['POINT']; ?>] - <?= $nilai['OPSIONAL']; ?></td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-light-blue" title="<?= $nilai['POINT']; ?>/<?= $nilai['POINT_MAX']; ?>" role="progressbar" aria-valuenow="<?= $nilai['POINT']; ?>" aria-valuemin="0" aria-valuemax="<?= $nilai['POINT_MAX']; ?>" style="width: <?= $persen; ?>%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    
                                    <?php
									$nomber++;
									} }
									?>
                                    </tbody>
                                </table>
                            </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-xs-12 col-sm-3 col-md-3">
					<div class="card card-about-me">
                        
                        <div class="body">
                            <ul>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">group</i>
                                        Objektif Pelaksanaan Survei
                                    </div>
                                    <div class="content">
                                        Strike Rate, Customer Active, NOO, Sell-out Toko, Menanggapi Komplain, Perilaku Salesman (Kedisiplinan Pelaksanaan Salesmanship).
                                    </div>
                                </li>
								<li>
                                    <div class="title">
                                        <i class="material-icons">event_available</i>
                                        Tanggal Survei
                                    </div>
                                    <div class="content">
                                        <?= $survei->TGL_KUNJUNGAN_TSO; ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">store_mall_directory</i>
                                        Toko Customer
                                    </div>
                                    <div class="content">
                                        <?= strtoupper($survei->NAMA_TOKO); ?> (Telp. <?= $survei->TELP_TOKO; ?>)
                                    </div>
                                </li>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">location_on</i>
                                        Lokasi
                                    </div>
                                    <div class="content">
                                       <?= $survei->ALAMAT; ?> - <?= $survei->NAMA_KECAMATAN; ?> - <?= $survei->NAMA_DISTRIK; ?>
									   - <?= $survei->NAMA_PROVINSI; ?>
									   <br>
									   [<?= $survei->NAMA_AREA; ?> - REGION <?= $survei->REGION; ?>]
                                    </div>
                                </li>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">assignment_ind</i>
                                        Atasan Sales Distributor
                                    </div>
                                    <div class="content">
                                        <p><span class="label bg-red">AM: >> <?= $survei->NAMA_SO; ?></span></p>
                                        <p><span class="label bg-teal">SM: >> <?= $survei->NAMA_SM; ?></span></p>
                                        <p><span class="label bg-blue">SSM: >> <?= $survei->NAMA_SSM; ?></span></p>
                                        <p><span class="label bg-amber">GSM: >> <?= $survei->NAMA_GSM; ?></span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">notes</i>
                                        Evaluasi & Tindakan Perbaikan
                                    </div>
                                    <div class="content">
                                        <?= $survei->KESIMPULAN; ?>.
                                    </div>
                                </li>
                               
                            </ul>
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

 <script src="../../js/pages/examples/profile.js"></script>