<style>
	.blink {
    -webkit-animation: blink 1s step-end infinite;
            animation: blink 1s step-end infinite;
}
@-webkit-keyframes blink { 50% { visibility: hidden; }}
        @keyframes blink { 50% { visibility: hidden; }}

    
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
					<div class="header header-title">
                        <h2> Customer Mapping <span id="unmapping" style="float: right; color: yellow;" class="blink"> Un-mapping: </span></h2>
						
                    </div>
                    <div class="body">
                        
                            <div class="container-fluid">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="" method="post">
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListRsm"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListAsm"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListTso"></div>
                                                        </div>
                                                    </div>
													<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                        <div class="form-group">
                                                            <div class="form-line" id="ListSales"></div>
                                                        </div>
                                                    </div>
												
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <b>&nbsp;</b><br/>
                                                        <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                        <button  id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
                                                    </div>
													
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="tableMapping" class="table table-striped table-bordered table-hover" border="1" width="100%" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No</th>
																<th>Kode Customer</th>
                                                                <th>Nama Customer</th>
																<th>Alamat</th>
                                                                <th>Distributor</th>
																<th>SALES</th>
                                                                <th>TSO</th>
                                                                <th>ASM</td>
                                                                <th>RSM</th>
																<th>GSM</th>
																<th>CREATE DATE</th>
                                                            </tr>
                                                        </thead>
														<tbody class="y" id="show_data">
														</tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        <div>
                                    </div>
                                </div>
                          
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script>

	$('document').ready(function(){
		
        $("#tableMapping").dataTable({
		   "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
		});
		
		ListRsm("#ListRsm");
		ListAsm("#ListAsm");
		ListTso("#ListTso");
		ListSales("#ListSales");
		
       listMapping(3248, null, null, null);
	   get_unmapping(3248, null, null, null); 
    });
	
	function ListRsm(key){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_rsm",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];
				//console.log(response);
                var type_list = '<b>Filter RSM</b>';
                type_list += '<select id="listRsmVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="">Pilih RSM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'">'+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listRsmVal", function(){
		var rsm = $(this).val();
        ListAsm("#ListAsm", rsm);
		ListTso("#ListTso", rsm, null);
		console.log(rsm);
    });
	
	function ListAsm(key, rsm = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_asm",
            type: 'POST',
			data: {
					"rsm" : rsm
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data']; 
				//console.log(response);
                var type_list = '<b>Filter ASM</b>';
                type_list += '<select id="listAsmVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">Pilih ASM</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'">'+response[i][1]+'</option>';
					//console.log(response[i][0]);
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listAsmVal", function(){
		var asm = $(this).val();
        ListTso("#ListTso", null , asm);
		ListSales("#ListSales", null , asm, null);
		console.log(asm);
    });
	
	function ListTso(key, rsm = null, asm = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_tso",
            type: 'POST',
			data: {
					"rsm" : rsm,
					"asm" : asm
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data']; 
				//console.log(response);
                var type_list = '<b>Filter TSO</b>';
                type_list += '<select id="listTsoVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">Pilih TSO</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'">'+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("change", "#listTsoVal", function(){
		var tso = $(this).val();
        ListSales("#ListSales", null, null , tso);
		console.log(tso);
    });
	
	function ListSales(key, rsm = null, asm = null, tso = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_sales",
            type: 'POST',
			data: {
					"rsm" : rsm,
					"asm" : asm,
					"tso" : tso
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['data']; 
				//console.log(response);
                var type_list = '<b>Filter Sales</b>';
                type_list += '<select id="listSalesVal"  class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option value="0">Pilih Sales</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'">'+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
		var rsm = $("#listRsmVal").val();
		if(rsm == 0){
			rsm = null;
		}
		var asm = $("#listAsmVal").val();
		if(asm == 0){
			asm = null;
		}
		var tso = $("#listTsoVal").val();
		if(tso == 0){
			tso = null;
		}
        var sales = $("#listSalesVal").val();
		if(sales == 0){
			sales = null;
		}
		
		console.log(rsm+" , "+asm+" , "+tso+" , "+sales);
        listMapping(rsm, asm, tso, sales);
		get_unmapping(rsm, asm, tso, sales);
    });
	
	function listMapping(rsm = null, asm = null, tso = null, sales = null){
        $('#tableMapping').dataTable({
			"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sbi/Mapping_customer/List_mapping'); ?>",
                type: "POST",
                data: {
					"rsm" : rsm,
					"asm" : asm,
					"tso" : tso,
                    "sales" : sales
                }
				// ,
				// proces: function(data){
					// $("#show_data").html('<tr><td colspan="10"><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center></td></tr>'); 
				// }
            },
        });
    }
	
	function get_unmapping(rsm = null, asm = null, tso = null, sales = null){
		$.ajax({
            url: "<?php echo base_url(); ?>sbi/Mapping_customer/List_mapping",
            type: 'POST',
			data: {
					"rsm" : rsm,
					"asm" : asm,
					"tso" : tso,
					"sales" : sales
				  },
            dataType: 'JSON',
            success: function(data){
                var response = data['unmapping']; 
				console.log(response);
				$('#unmapping').text('Un-mapping: '+response);
            }
        });
	}
	
	$(document).on("click", "#btnExport", function(e){
		e.preventDefault();
        var rsm = $("#listRsmVal").val();
		if(rsm == 0){
			rsm = null;
		}
		var asm = $("#listAsmVal").val();
		if(asm == 0){
			asm = null;
		}
		var tso = $("#listTsoVal").val();
		if(tso == 0){
			tso = null;
		}
        var sales = $("#listSalesVal").val();
		if(sales == 0){
			sales = null;
		}
       
        window.open("<?php echo base_url()?>sbi/Export_mapping_customer/toExcel?rsm="+rsm+"&asm="+asm+"&tso="+tso+"&sales="+sales,"_blank");
    });
	
</script>