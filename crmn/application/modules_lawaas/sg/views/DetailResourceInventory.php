<?php $head = $data['head']; ?>
<h3><?=$head->NAMA_MATERIAL?></h3>
<table class="table table-condensed">
	<tbody>
		<tr>
			<td>Total Stock : </td>
		</tr>
		<tr>
			<td>Usage Average (7 Days) : </td>
		</tr>
		<tr>
			<td>Days of Inventory: </td>
		</tr>
		<tr>
			<td>Sisa PO: </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Min Stock: <?=$head->STOK_MIN?></td>
		</tr>
		<tr>
			<td>Max Stock: <?=$head->STOK_MAX?></td>
		</tr>
		<tr>
			<td>Reorder Point: <?=$head->ROP?></td>
		</tr>
	</tbody>
</table>