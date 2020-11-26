td{
    position:relative;
    border:1px solid grey;
    overflow:hidden;
}
label{
    background:red;
    text-align:center;
    position:relative;
    padding:50px;
    margin:-5px;
}
input{
    position:absolute;
}
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>REPORT VOLUME</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
                                        <form action="" method="post">
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                            <b>Bulan</b>
                                            <select id="filterTahun" name="filterTahun" class="form-control show-tick">
                                                <option>Pilih Bulan</option>
                                                <option>Januari</option>
												<option>Februari</option>
												<option>Maret</option>
												<option>April</option>
												<option>Mei</option>
												<option>Juni</option>
												<option>Juli</option>
												<option>Agustus</option>
												<option>Sebtember</option>
												<option>Oktober</option>
												<option>November</option>
												<option>Desember</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                            <b>Tahun</b>
                                            <select id="filterTahun" name="filterTahun" class="form-control show-tick">
                                                <option>Pilih Tahun</option>
                                                <option>2019</option>
												<option>2020</option>
												<option>2021</option>
												<option>2022</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="submit" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
											<button type="submit" id="btnexel" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect"><span class="fa fa-file-excel-o"></span> Export </button>
										</div>
                                        </form>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
                                                    <th>SPJ</th>
                                                    <th>KODE CUSTOMER</th>
													<th>NAMA CUSTOMER</th>
													<th>ID DISTRIBUTOR</th>
													<th>NAMA DISTRIBUTOR</th>
                                                    <th>KODE PRODUK</th>
													<th>NAMA PRODUK</th>
													<th>QTY TON</th>
													<th>QTY ZAK</th>
													<th>HARGA PER ZAK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //echo $list;
                                                 ?>
                                            </tbody>
                                        </table>
										</div>
                                    </div>
                            	</div>
                            <div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
    </div>
</section>
<script>
$(document).ready(function() {
	$("#daftar_report").dataTable();
});
</script>