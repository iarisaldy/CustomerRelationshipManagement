<style>
	.blink {
    -webkit-animation: blink 1s step-end infinite;
            animation: blink 1s step-end infinite;
}
@-webkit-keyframes blink { 50% { visibility: hidden; }}
        @keyframes blink { 50% { visibility: hidden; }}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2> Customer Mapping <!--<span id="unmapping" style="float: right; color: yellow;" class="blink"> Un-mapping: </span>--> </h2> 
						
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
                                                            <div class="form-line" id="ListSales"></div>
                                                        </div>
                                                    </div>
												
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <b>&nbsp;</b><br/>
                                                        <button type="button" id="btnFilter" class="btn btn-info btn-sm btn-lg m-l-15 waves-effect"><i class="fa fa-filter"></i> View</button>
                                                        <button style="float: right;" id="btnExport" class="btn btn-success btn-sm btn-lg m-l-15 waves-effect" ><span class="fa fa-file-excel-o"></span> Export </button>
                                                    </div>
													
                                                    </form>
                                                </div>
                                            </div>
											<div id="waiting"> </div>
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
                                                                <th>AM/SO</th>
                                                                <th>SM</td>
                                                                <th>SSM</th>
                                                            </tr>
                                                        </thead>
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
		var tso = <?= $this->session->userdata('user_id'); ?>;
		
		ListSales("#ListSales", null, null, tso);
		
       //listMapping(null, null, tso, null);
	   //get_unmapping(null, null, tso, null);
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
                type_list += '<option value="0"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pilih Sales</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i][0]+'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+response[i][1]+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
	}
	
	$(document).on("click", "#btnFilter", function(e){
        e.preventDefault();
		//var rsm = $("#listRsmVal").val();
		var rsm = 0;
		if(rsm == 0){
			rsm = null;
		}
		//var asm = $("#listAsmVal").val();
		var asm = 0;
		if(asm == 0){
			asm = null;
		}
		//var tso = $("#listTsoVal").val();
		var tso = <?= $this->session->userdata('user_id'); ?>;
		if(tso == 0){
			tso = null;
		}
        var sales = $("#listSalesVal").val();
		if(sales == 0){
			sales = null;
		}
		
		console.log(rsm+" , "+asm+" , "+tso+" , "+sales);
        listMapping(rsm, asm, tso, sales);
		//get_unmapping(rsm, asm, tso, sales);
    });
	
	function listMapping(rsm = null, asm = null, tso = null, sales = null){
		$("#waiting").html('<br><center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span><br><p style="margin-top: 1em;"> Loading data. Please wait ...</p></center><br>'); 
		
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
                },
				complete: function(datas){
					$("#waiting").html('');
				}
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
        //var rsm = $("#listRsmVal").val();
		var rsm = 0;
		if(rsm == 0){
			rsm = null;
		}
		//var asm = $("#listAsmVal").val();
		var asm = 0;
		if(asm == 0){
			asm = null;
		}
		//var tso = $("#listTsoVal").val();
		var tso = <?= $this->session->userdata('user_id'); ?>;
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