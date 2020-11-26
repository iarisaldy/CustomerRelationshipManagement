<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	th { font-size: 12px; }
	td { font-size: 11px; }
	th, td { white-space: nowrap; }
	.W{
		background-color:#3F51B5 !important;
		font-weight:bolder;
		color:#FFFFFF;
	}
	.y{
		background-color:#FFFFFF !important;
		font-weight:bold;
		color:#222222;
	}
	.x{
		background-color:#E3F2FD !important;
		font-weight:bold;
		color:#222222;
	}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>REPORT HASIL SURVEY</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-md-12">
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Tahun</b>
													<select id="filterTahun" name="filterTahun" class="form-control show-tick">
														<option>Pilih Tahun</option>
														<?php for($j=date('Y');$j<=date('Y')+4;$j++){ ?>
														<option value="<?php echo $j; ?>" <?php if(date('Y') == $j){ echo "selected";} ?>><?php echo $j; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="form-line">
													<b>Bulan</b>
													<select id="filterBulan" name="filterBulan" class="form-control show-tick">
														<option>Pilih Bulan</option>
														<?php 
														for($j=1;$j<=12;$j++){
															$dateObj   = DateTime::createFromFormat('!m', $j);
															$monthName = $dateObj->format('F');
															?>
															<option value="<?php echo $j; ?>" <?php if($j == date('m')){ echo "selected";} ?>><?php echo $monthName; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                            <b>&nbsp;</b><br/>
                                            <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12" >
                                            <b>&nbsp;</b><br/>
											<button id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-download"></span> Export </button>
										</div>
                                    </div>
                            	</div>
                            	<div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTable no-footer" id="daftar_report" width="100%">
                                            <thead class="w">
                                                <tr>
													<th>NO</th>
													<th width="10%">ID SO</th>
                                                    <th width="10%">NAMA SO</th>
													<th width="5%">TGL KUNJUNGAN</th>
													<th width="10%">KD TOKO</th>
                                                    <th width="10%">NAMA TOKO</th>
													<th width="10%">DISTRIK</th>
													<th width="5%">AREA</th>
													<th width="10%">PROVINSI</th>
													<th width="15%">REGION</th>
													<th width="15%">KD PRODUK</th>
													<th width="15%">NAMA PRODUK</th>
													<th>STOK SAAT INI</th>
													<th>VOLUME PEMBELIAN</th>
													<th>HARGA PEMBELIAN</th>
													<th>TGL PEMBELIAN</th>
													<th>TOP PEMBELIAN</th>
													<th>VOLUME PENJUALAN</th>
													<th>HARGA PENJUALAN</th>
													<th>KAPASITAS TOKO</th>
													<th>KELUHAN</th>
													<th>JAWABAN KELUHAN</th>
													<th>PROMO</th>
													<th>JAWABAN PROMO</th>
													<th>NAMA SM</th>
													<th>NAMA SSM</th>
													<th>NAMA GSM</th>
                                                </tr>
                                            </thead>
                                            <tbody class="y" id="show_data">
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

<script src="https://www.jqueryscript.net/demo/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel/src/jquery.table2excel.js"></script>

<script>

var tahun  = $('#filterTahun').val();
var bulan 	= $('#filterBulan').val();

function load_data(){

	$('#export_distributor').show();

    var oTable = $('#daftar_report').DataTable({
        processing: false,
        select: true,
        destroy: true,
        searching: true,
        lengthChange: false,
        ajax:{
            url: '<?php echo site_url(); ?>laporan/MarketVisit_AM/getDataMarketVisit_AM/' + tahun + '/' + bulan,
            type:'GET',
            dataSrc : function(json){
                var return_data = new Array()
                $.each(json['response'], function(i, item){

                    return_data.push({
                        'No' : (i+1),
                        'ID_SO' : item['ID_SO'],
                        'NAMA_SO' : item['NAMA_SO'],
                        'TGL_RENCANA_KUNJUNGAN' : item['TGL_RENCANA_KUNJUNGAN'],
                        'ID_TOKO' : item['ID_TOKO'],
                        'NAMA_TOKO' : item['NAMA_TOKO'],
                        'NAMA_DISTRIK' : item['NAMA_DISTRIK'],
                        'NAMA_AREA' : item['NAMA_AREA'],
                        'NAMA_PROVINSI' : item['NAMA_PROVINSI'],
                        'ID_REGION' : item['ID_REGION'],
                        'ID_PRODUK' : item['ID_PRODUK'],
                        'NAMA_PRODUK' : item['NAMA_PRODUK'],
                        'STOK_SAAT_INI' : item['STOK_SAAT_INI'],
                        'VOLUME_PEMBELIAN' : item['VOLUME_PEMBELIAN'],
                        'HARGA_PEMBELIAN' : item['HARGA_PEMBELIAN'],
                        'TGL_PEMBELIAN' : item['TGL_PEMBELIAN'],
                        'TOP_PEMBELIAN' : item['TOP_PEMBELIAN'],
                        'VOLUME_PENJUALAN' : item['VOLUME_PENJUALAN'],
                        'HARGA_PENJUALAN' : item['HARGA_PENJUALAN'],
                        'KAPASITAS_TOKO' : item['KAPASITAS_TOKO'],
                        'KELUHAN' : item['KELUHAN'],
                        'JAWABAN_KELUHAN' : item['JAWABAN_KELUHAN'],
                        'PROMOSI' : item['PROMOSI'],
                        'JAWABAN_PROMOSI' : item['JAWABAN_PROMOSI'],
                        'NAMA_SM' : item['NAMA_SM'],
                        'NAMA_SSM' : item['NAMA_SSM'],
                        'NAMA_GSM' : item['NAMA_GSM'],
                    })
                })
                return return_data;
            }
        },
        columns : [
            {data : 'No'},
            {data : 'ID_SO'},
            {data : 'NAMA_SO'},
            {data : 'TGL_RENCANA_KUNJUNGAN'},
            {data : 'ID_TOKO'},
            {data : 'NAMA_TOKO'},
            {data : 'NAMA_DISTRIK'},
            {data : 'NAMA_AREA'},
            {data : 'NAMA_PROVINSI'},
            {data : 'ID_REGION'},
            {data : 'ID_PRODUK'},
            {data : 'NAMA_PRODUK'},
            {data : 'STOK_SAAT_INI'},
            {data : 'VOLUME_PEMBELIAN'},
            {data : 'HARGA_PEMBELIAN'},
            {data : 'TGL_PEMBELIAN'},
            {data : 'TOP_PEMBELIAN'},
            {data : 'VOLUME_PENJUALAN'},
            {data : 'HARGA_PENJUALAN'},
            {data : 'KAPASITAS_TOKO'},
            {data : 'KELUHAN'},
            {data : 'JAWABAN_KELUHAN'},
            {data : 'PROMOSI'},
            {data : 'JAWABAN_PROMOSI'},
            {data : 'NAMA_SM'},
            {data : 'NAMA_SSM'},
            {data : 'NAMA_GSM'},
        ]
    })
}

$(function () {
    load_data();

    $('#btnFilter').click(function () {
        tahun   = $('#filterTahun').val();
        bulan   = $('#filterBulan').val();

        load_data();
    });

    $('#btnExport').click(function () {
        tahun   = $('#filterTahun').val();
        bulan   = $('#filterBulan').val();

        var win = window.open('<?php echo site_url(); ?>laporan/MarketVisit_AM//Export_excel/' + tahun + '/' + bulan, '_blank');
        if (win) {
		    //Browser has allowed it to be opened
		    win.focus();
		} else {
		    //Browser has blocked it
		    alert('Please allow popups for this website');
		}

    });


});

function tampil_data(){
$("#show_data").html('<tr><td colspan="12"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center></td></tr>');
	var region = $('#pilihregion option:selected').val();
	var id_prov = $('#listProvinsi option:selected').val();
		
		$.ajax({
		url: '<?php echo site_url(); ?>laporan/MarketVisit_AM/getDataMarketVisit_AM',
		type: 'POST',
		dataType : 'json',
		data: {
			"tahun" : $('#filterTahun').val(),
			"bulan" : $('#filterBulan').val(),
		},
		success: function(data){
			  var html = '';
			  var i;
			  var c = "x";
			  var no = 1 ;
			  for(i=0; i<data.length; i++){
				html += '<tr class='+c+'>'+
				'<td>'+no+'</td>'+
				'<td>'+data[i].ID_SO+'</td>'+
				'<td>'+data[i].NAMA_SO+'</td>'+
				'<td>'+data[i].TGL_RENCANA_KUNJUNGAN+'</td>'+
				'<td>'+data[i].ID_TOKO+'</td>'+
				'<td>'+data[i].NAMA_TOKO+'</td>'+
				'<td>'+data[i].NAMA_DISTRIK+'</td>'+	
				'<td>'+data[i].NAMA_AREA+'</td>'+			
				'<td>'+data[i].NAMA_PROVINSI+'</td>'+
				'<td>'+data[i].ID_REGION+'</td>'+
				'<td>'+data[i].ID_PRODUK+'</td>'+
				'<td>'+data[i].NAMA_PRODUK+'</td>'+
				'<td>'+data[i].STOK_SAAT_INI+'</td>'+
				'<td>'+data[i].VOLUME_PEMBELIAN+'</td>'+
				'<td>'+data[i].HARGA_PEMBELIAN+'</td>'+
				'<td>'+data[i].TGL_PEMBELIAN+'</td>'+
				'<td>'+data[i].TOP_PEMBELIAN+'</td>'+
				'<td>'+data[i].VOLUME_PENJUALAN+'</td>'+
				'<td>'+data[i].HARGA_PENJUALAN+'</td>'+
				'<td>'+data[i].KAPASITAS_TOKO+'</td>'+
				'<td>'+data[i].KELUHAN+'</td>'+
				'<td>'+data[i].JAWABAN_KELUHAN+'</td>'+
				'<td>'+data[i].PROMOSI+'</td>'+
				'<td>'+data[i].JAWABAN_PROMOSI+'</td>'+
				'<td>'+data[i].NAMA_SM+'</td>'+
				'<td>'+data[i].NAMA_SSM+'</td>'+
				'<td>'+data[i].NAMA_GSM+'</td>'+
				'</tr>';
				no++;
				if(c == "x"){
					c = "y"  ;
				}else{
					c = "x" ;
				}
			  }
			$('#show_data').html(html);
			$("#daftar_report").dataTable();
		},
		error: function(){
		}
    });
}

// $(document).ready(function() {
// 	tampil_data();

// });


// $(document).on("click", "#btnFilter", function(){
// 	$("#daftar_report").DataTable().destroy();
// 	tampil_data();
// });

// $(document).on("click", "#btnExport", function(e){
// 	e.preventDefault();
// 	var tahun = $('#filterTahun').val();
// 	var bulan = $('#filterBulan').val();

// 	window.open("<?php echo base_url()?>laporan/MarketVisit_AM/toExcel_SO?tahun="+tahun+"&bulan="+bulan,"_blank");
// });

</script>