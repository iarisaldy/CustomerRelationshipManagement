<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header header-title">
                        <h2>Cement Sales Volume</h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                            // echo $menusValue->ID_MENU;
                         if($menusValue->ID_MENU == '1011'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>

                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            	<div class="col-md-12">
                            		<div class="col-md-2" id="filterRegion">
                                    </div>
                                    <!-- <div class="col-md-2" id="filterProvinsi">
                                        <select class="form-control show-tick">
                                            <option>Pilih Provinsi</option>
                                        </select>
                                    </div> -->
                                    <div class="col-md-2">
                                        <select data-size="5" id="filterBulan" class="form-control show-tick">
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
                                    <div class="col-md-2">
                                        <select id="filterTahun" class="form-control show-tick">
                                            <option>Pilih Tahun</option>
                                            <?php $year = date('Y')-1;
                                                for ($i=$year; $i <= $year+2 ; $i++) { ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i==date('Y')){echo "selected";} ?>><?php echo $i; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="btnFilterAction" class="btn btn-info"><span class="fa fa-filter"></span> View</button>
                                    </div>
                            	</div>
                            	<div id="salesVolume"></div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script>
	$("document").ready(function(){
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();

		chartCementSalesVolume(0, null, bulan, tahun);
        listRegion("#filterRegion");
    });

    $(document).on("change", "#listRegion", function(e){
        idRegion = $(this).find(':selected').data('region');
        listProvinsi("#filterProvinsi", idRegion);
    });

    $(document).on("click", "#btnFilterAction", function(e){
        var idRegion = $("#listRegion").find(':selected').data("region");
        var idProvinsi = $("#listProvinsi").val();
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();

        chartCementSalesVolume(idRegion, null, bulan, tahun);
    });

	function chartCementSalesVolume(idRegion = null, idProvinsi = null, bulan = null, tahun = null){
        if(idRegion == "0"){
            var showValues = "0";
        } else {
            var showValues = "1";
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "<?php echo base_url(); ?>smi/CementSalesVolume/chartVolume",
            "method": "POST",
            "dataType": "JSON",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "cb95a2f1-3838-c12d-ab6c-6e82ae8264dd"
            },
            "data": {
                "id_region": idRegion,
                "id_provinsi": idProvinsi,
                "bulan": bulan,
                "tahun": tahun
            },
            beforeSend: function(xhr){
                $("#btnFilterAction").html("<span class='fa fa-spinner fa-spin'></span> View");
            }
        }

		$.ajax(settings).done(function (response) {
            $("#btnFilterAction").html("<span class='fa fa-filter'></span> View");
            const dataFormat = {
                "chart": {
                    "caption": "",
                    "xAxisname": "Provinsi",
                    "yAxisName": "Volume (TON)",
                    "numberPrefix": "",
                    "plotFillAlpha": "90",
                    "theme": "fusion",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "showCanvasBorder": "0",
                    "usePlotGradientColor": "0",
                    "valueFontColor": "#000000",
                    "labelDisplay": "rotate",
                    "slantLabels": "1",
                    "showToolTip": "1",
                    "palettecolors": "#989CD0,#54CFCB",
                    "showPlotBorder": "0",
                    "showValues": "1",
                    "decimalSeparator": ",",
                    "thousandSeparator": ".",
                    "formatNumberScale": "0",
                    "showValues" : showValues
                },
                "categories": [{
                    "category": response.category
                }],
                "dataset": [{
                    "seriesname": "Rencana Volume",
                    "data": response.data_rencana[0].data
                },{
                    "seriesname": "Realisasi Volume",
                    "data": response.data_realisasi[0].data
                }]
           };

            FusionCharts.ready(function(){
                var fusioncharts = new FusionCharts({
                    type: "mscolumn2d",
                    renderAt: 'salesVolume',
                    width: '100%',
                    height: '400',
                    dataFormat: 'json',
                    dataSource : dataFormat
                }).render();
            });
        });
    }

    function listRegion(key){
        $.ajax({
            url: "<?php echo base_url(); ?>smi/Region/listRegion",
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listRegion" class="form-control selectpicker show-tick">';
                type_list += '<option>Pilih Region</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option data-region="'+response[i]['REGION']+'" value="'+response[i]['ID_REGION']+'">'+response[i]['NAMA_REGION']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function listProvinsi(key, idRegion){
        $.ajax({
            url: "<?php echo base_url(); ?>smi/Region/listProvinsi/"+idRegion,
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<select id="listProvinsi" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true">';
                type_list += '<option>Pilih Provinsi</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_PROVINSI']+'">'+response[i]['NAMA_PROVINSI']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>