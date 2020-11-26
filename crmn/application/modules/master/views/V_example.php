<!DOCTYPE html>
<html>
<body>

<select id="id_dist">
	<option value="" disabled selected>Masukkan pilihan distributor</option>
		<?php 
			foreach($distributors as $dt_dist){?>
				<option  value="<?= $dt_dist->KODE_DISTRIBUTOR; ?>"><?= $dt_dist->NAMA_DISTRIBUTOR; ?></option>
		]<?php } ?>
</select>

<p>Click the button to select the option element with index "2".</p>
<p><b>Note:</b> The index starts at 0.</p>

<button onclick="myFunction('0000000124')">Try it</button>

<script>


function myFunction(pil) {
  document.getElementById("id_dist").value = pil;
}
</script>

</body>
</html>
