<div class="container">
	<div class="row">
		<div class="panel panel-danger">
			<div class="panel-body">
				<div class="col-md-12">
					<img src="<?=base_url('assets/img/logos/header-logo-scm.png')?>" class="img-responsive">
				</div>
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-condensed ">
							<thead>
							<tr>
								<th class="col-md-2"></th>
								<?php 
									foreach ($head as $row) {
										echo "<th class='warning'>$row</th>";
									}
								?>
							</tr>
							</thead>
							<tbody>
								<?php 
									$terakProdukSmig = 0;
									$prodSemenSmig = 0;
									$terakStokSmig = 0;
								?>
								
									<?php 
										foreach ($teraks->result() as $terak) { 
												$terakProdukSmig += $terak->QTY_PRODUKSI;
											
										}
										foreach ($produksiSemen->result() as $prodSemen) { 
											
												$prodSemenSmig += $prodSemen->QTY_PRODUKSI;
											
										}
										print_r($produksiSemen->result());
										foreach ($teraks->result() as $terak) { 
											
												$terakStokSmig += $terak->QTY_STOK;
											
										}
									?>
								<tr>
									<td><button class="btn btn-sm btn-default form-control">SMIG</button></td>
									<td><?=$terakProdukSmig?></td>
									<td><?=$prodSemenSmig?></td>
									<td><?=$terakStokSmig?></td>
								</tr>
								<?php foreach ($org->result() as $row) { ?>
								<tr>
									<td><button class="btn btn-sm btn-default form-control"><?=$row->NAMA_ORG?></button></td>
									<?php 
										foreach ($teraks->result() as $terak) { 
											if($terak->ORG == $row->ORG){
												echo "<td>".number_format($terak->QTY_PRODUKSI, 2, ',', '.')."</td>";
											}
										}
										foreach ($produksiSemen->result() as $prodSemen) { 
											if($prodSemen->ORG == $row->ORG){
												echo "<td>".number_format($prodSemen->QTY_PRODUKSI, 2, ',', '.')."</td>";
											}
										}
										foreach ($teraks->result() as $terak) { 
											if($terak->ORG == $row->ORG){
												echo "<td>".number_format($terak->QTY_STOK, 2, ',', '.')."</td>";
											}
										}
									?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>