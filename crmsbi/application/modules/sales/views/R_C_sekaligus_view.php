td{
    position:relative;
    border:1px solid grey;
    overflow:hidden;
}
label{
    background:red;
    text-align:center;
    position:relative;
   
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
                        <h2> Tambah Schedule Canvassing Bulanan</h2>
						
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
							<form method="post" action="<?php echo base_url(); ?>sales/R_C_sekaligus/action_canvasing">
								
								<div class="col-md-2">
                                    Bulan : 
                                    <select name="setBulan" id="filterBulan" class="form-control show-tick" data-size="5">
                                        <option>Pilih Bulan</option>
                                        <?php for($i=1;$i<=12;$i++){ ?>
                                        <option value="<?php echo $i; ?>" <?php if($this->session->userdata('prosesCanvasing_bulan') == ($i)){ echo "selected";} ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    Tahun : 
                                    <select name="setTahun" id="filterTahun" class="form-control show-tick" data-size="5">
                                        <option>Pilih Tahun</option>
                                        <?php for($j=date('Y')-0;$j<=date('Y')+2;$j++){ ?>
                                        <option value="<?php echo $j; ?>" <?php if($this->session->userdata('prosesCanvasing_tahun') == $j){ echo "selected";} ?>><?php echo $j; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
								
								<div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                    <b>&nbsp</b><br/>
                                    <button type="submit" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> Proses Canvasing</button>
                                </div>
                            </form>
							</div>
						</div>
						<hr>
						
						
						<?php
							if($this->session->userdata('prosesCanvasing') != null){
						?>
						<div class="row">
							<div class="container-fluid">
								<div class="col-md-2">
									Sales Distributor :
									<select name="setSales" id="filterSales" class="form-control show-tick">
                                        <option disabled>Pilih Sales</option>
                                        <?php foreach ($dt_saless as $dts) { ?>
                                        <option value="<?= $dts->ID_USER;?>"><?= $dts->NAMA; ?></option>
                                        <?php } ?>
                                    </select>
								</div>
								<div class="col-md-3">
									Keterangan (Penugasan) :
									<div class="form-group">
                                        <select id="penugasan" class="form-control selectpicker show-tick" multiple>
                                            <option value="canvassing">Canvassing</option>
                                            <option value="penagihan">Penagihan</option>
                                            <option value="lain-lain">Lain-Lain</option>
                                        </select>
                                    </div>
                                    
								</div>
								<div class="col-md-3" id="form-penugasan" style="display: none;">
									Penugasan Lain :
									<div class="form-group" >
                                        <div class="form-line">
                                            <input id="lain-lain" type="text" class="form-control" placeholder="Masukkan penugasan">
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="container-fluid table-responsive">
								<table id="tableCanvasingProses" class="table" width="100%" style="font-size: 12px; overflow-x:auto; border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">KODE </th>
                                            <th rowspan="2">Customer</th>
											<th rowspan="2">Aksi</th>
											<?php
												$dateString = $range_tanggal;
												//Last date of current month.
												$lastDateOfMonth = date("t", strtotime($dateString));
											?>
                                            <th colspan="<?= $lastDateOfMonth; ?>">Range Tanggal
											</th>
                                            
                                        </tr>
										<tr>
										<?php for($i = 1; $i <= $lastDateOfMonth; $i++){ ?>
											<th><?= $i;?></th>
										<?php } ?>
										</tr>
                                    </thead>
									<tbody>
										<?php 
										$count = 1;
										foreach ($dt_costumers as $dt) { 
										 ?>
										<tr>
											<td><?= $dt->ID_CUSTOMER;?></td>
											<td><?= $dt->NAMA_TOKO ?></td>
											<td><input type="checkbox" id=""><label for=""></label></td>
											<?php for($i = 1; $i <= $lastDateOfMonth; $i++){ 
											$dateset = $this->session->userdata('prosesCanvasing_tahun').'-'.$this->session->userdata('prosesCanvasing_bulan').'-'.$i;
												if(date("l", strtotime($dateset)) == "Saturday") {
													echo '<td style="background-color: orange;"><input type="checkbox" id=""><label for=""></label></td>';
												} elseif(date("l", strtotime($dateset)) == "Sunday"){
													echo '<td style="background-color: red;"><input type="checkbox" id=""><label for=""></label></td>';
												} else {
													echo '<td><input type="checkbox" id=""><label for=""></label></td>';
												}
											?>
												
											<?php } ?>
											
										</tr>
										<?php } 
										?>
									</tbody>
                                </table>
							</div>
						</div>
						<?php
							}
							$this->session->set_userdata('prosesCanvasing', null);
						?>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<script>
//tableCanvasingProses

	$('document').ready(function(){
		$('#tableCanvasingProses').DataTable();
        filterSalesDistributor("#filterSalesDistributor");
		
    });
	
	$(document).on("change", "#penugasan", function(){
        var penugasan = $("#penugasan").val();
        var texts = penugasan.toString();
        if(texts.search(/lain-lain/) >= 0){
            $("#form-penugasan").css("display", "block");
        } else {
            $("#form-penugasan").css("display", "none");
        }
    });

</script>

<script>
$('td').click(function(){
    $(this).children('input').click();
});
</script>