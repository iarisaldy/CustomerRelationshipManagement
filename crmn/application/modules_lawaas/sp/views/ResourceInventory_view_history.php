<script src="<?=base_url('assets/chartjs/dist/Chart.js')?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[name$=Date]').datepicker({
		    format: 'dd M yyyy',
		});
	});
</script>
<style type="text/css"> 
        .nav li a div{
            color : #FFF;
            height: 55px;
        }
        .nav li>a:focus>div,.nav li>a:hover>div{
            color : #000;
            height: 55px;
        }
        .container {
        margin-left: -20px;
        }
        .panel {
        width: 113%;
        }
        /*========*/
        .ibox-title.title-desc,.panel-heading {
        background: linear-gradient(to left, #1ab394, #036C13);
        }
        body{
            color : #000
        }
	#nav_bahan .top-navigation .nav > li > a{
		padding: 5px 20px;
	}
	#nav_bahan .navbar{
		min-height: 30px;
	}
        #nav_bahan .navbar li{
            margin-right : 3px;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
	}
        #nav_bahan .nav-justified > li > a{
            width: 100%;            
        }
        #nav_bahan .nav-justified {
            border-collapse:separate;
            border-spacing:3px;
         } 
        .hitam{
           background-color: #000;
        }
        .hijau{
           background-color: #006621;
        }
        .kuning{
           background-color: #FFC000;           
        }
        .merah{
           background-color: red;
        }
        .legend_div{
            clear : both;
            margin : 10px auto;
            margin-left: 30%;            
        }
        .legend_item {
            float :left;
            margin-left : 10px;
        }
        .legend_item>div {
            float :left;
            margin-left: 5px;
        }
        .kotak{
            width : 15px;
            height : 15px;
        }
        .loading{
            background: url('../../assets/img/loading.gif') no-repeat center;
        }
        #chartPenerimaan,#chartMinMax{
            min-width: 100px;
            min-height : 100px;
        }
</style>
<div class="container">
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading" style="color:#ffffff"><i class="fa fa-line-chart"></i> Resource Inventory</div>
                <div class="panel-body">
                    <div class="row">                        
                        <div class="col-md-12">
                            <div class="col-md-4" style="">
                            <div class="col-md-2"><img src="<?=base_url().'assets/img/menu/semen_padang.png'?>" style="width:90px;"></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 220%;padding-left: 30px;"><b>SEMEN PADANG</b></h2></div>
                            </div>
                            <div class="col-md-8" style="margin-top: 12px;">
                            <form method="post" action="">
                                <div class="form-group">
                                        <div class='col-md-3'>
                                            <div class="form-group">
                                                <div class="input-group date">
                                                    <input type="text" class="form-control parameter" name="startDate" readonly value="<?php echo $startDate ?>" />
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class='col-md-3' style="margin-left:-15px">
                                            <div class="form-group">
                                                <div class="input-group date" >
                                                    <input type="text" class="form-control parameter" name="endDate" readonly  value="<?php echo $endDate ?>" />
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 
                                    <div class="col-md-2" style="margin-left:-15px">                                    
                                        <select id="plant_group" class="form-control" name="plant_group">
                                            <?php
                                                $_plant_group = array('3301'=> 'Padang','3302' => 'Dumai');
                                                foreach($_plant_group as $key => $val){
                                                    $selected = $key == $plant_group ? 'selected' : '';
                                                    echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';                                                        
                                                }
                                            ?>                                        
                                        </select>
                                    </div>
                                    <div class="col-md-1" style="margin-left:-15px">
                                        <button type="submit" class="btn btn-default" style="margin-top:0px"><i class="fa fa-search"></i></button>
                                    </div>
                                    <div class="col-md-3" style="margin-left: 45px;">
                                        <div class="col-md-7">
                                            <a href="#" id="btnExcel" class="btn btn-primary"><i class="fa fa-file-o"></i> Save xls</a>
                                        </div>
                                        <div class="col-md-5">
                                            <a href="<?php echo site_url('sp/ResourceInventory') ?>" class="btn btn-default"><i class="fa fa-undo"></i> Back</a>
                                        </div>
                                    </div>                                
                                </div>
                            </form>           
                            </div>
                        </div>                    
                    </div>
                    <div class="row" style="margin-top:10px" id="nav_bahan">
                        <ul class="nav nav-justified nav-pills">
                            <?php 
                               foreach($head as $h){ 
                                  $_stok = isset($stok[$h['KODE_KELOMPOK']]) ? $stok[$h['KODE_KELOMPOK']]['QTY_STOK'] : 0; 
                                  $_stok_min = isset($stok[$h['KODE_KELOMPOK']]) ? $stok[$h['KODE_KELOMPOK']]['STOK_MIN'] : 0; 
                                  $_stok_max = isset($stok[$h['KODE_KELOMPOK']]) ? $stok[$h['KODE_KELOMPOK']]['STOK_MAX'] : 0; 
                                  $_stok_rp = isset($stok[$h['KODE_KELOMPOK']]) ? $stok[$h['KODE_KELOMPOK']]['RP'] : 0; 
                                  
                                  if($_stok <= $_stok_min){
                                        $_class_stok = 'merah'; 
                                  }else if($_stok <= $_stok_rp){
                                      $_class_stok = 'kuning'; 
                                  }else if($_stok <= $_stok_max){
                                      $_class_stok = 'hijau'; 
                                  }else{
                                    $_class_stok = 'hitam'; 
                                  }
                                  
                                  echo '<li style="border-radius:5px" class="'.$_class_stok.'"><a href="#" data-nama="'.$h['NAMA_KELOMPOK'].'" data-plant="'.$plant_group.'" data-endDate="'.$endDateDb.'" data-startDate="'.$startDateDb.'" data-periode="'.$periode.'" data-kode="'.$h['KODE_KELOMPOK'].'"><div>'.$h['ALIAS_NAMA'].'<br >'.number_format($_stok, 0, ',', '.').'</div></a></li>'; 
                               } 
                            ?>                           
                        </ul>
                    </div>
                    <div class="legend_div">
                        <div class="legend_item">
                            <div class="kotak hitam">&nbsp;</div>
                            <div>Melebihi max</div>
                        </div>
                        <div class="legend_item">
                            <div class="kotak hijau">&nbsp;</div>
                            <div>Stok aman</div>
                        </div>
                        <div class="legend_item">
                            <div class="kotak kuning">&nbsp;</div>
                            <div>Replenish Point</div>
                        </div>
                        <div class="legend_item">
                            <div class="kotak merah">&nbsp;</div>
                            <div>Dibawah min</div>
                        </div>
                    </div>
                    <hr  style="margin-top:40px;border-color: red" />
                    <div class="col-md-12 text-center" id="div_title_bahanbaku"  style="margin-top:10px"></div>
                    <div class="row">
                        <div class="col-md-6" id="chartPenerimaan">
                            
                        </div>
                        <div class="col-md-6" id="chartMinMax">
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
        </div>    
    </div>
		
</div>
<script type="text/javascript">
 $(function(){
 $('#btnExcel').click(function(){
        var _kodeKelompok = $('#div_title_bahanbaku').data('kode_kelompok');
        var _bahanTerpilih = $('#nav_bahan li a[data-kode='+_kodeKelompok+']');
        var _startDate = _bahanTerpilih.data('startdate');
        var _endDate = _bahanTerpilih.data('enddate');
        var _plant = _bahanTerpilih.data('plant');   
        var _namaKelompok = $('#div_title_bahanbaku').text();
        window.open('<?php echo site_url('sp/ResourceInventory/toExcel') ?>?startDate='+_startDate+'&endDate='+_endDate+'&plant='+_plant+'&kodekelompok='+_kodeKelompok+'&nama='+_namaKelompok);
        return false; 
 });  
function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0
			: Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ','
			: thousands_sep, dec = (typeof dec_point === 'undefined') ? '.'
			: dec_point, s = '', toFixedFix = function(n, prec) {
		var k = Math.pow(10, prec);
		return '' + (Math.round(n * k) / k).toFixed(prec);
	};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}
  function angkaIndonesia(x){
      return number_format(x,0,',','.');
  }
    
    
    
    function drawLineChart(kode_kelompok,startDate,endDate,plant_group) {
        var jsonData = $.ajax({
          url: "<?php echo site_url('sp/ResourceInventory/getData_history')?>",
          beforeSend : function(){
              $('#chartPenerimaan').empty();
              $('#chartMinMax').empty();
              $('#chartPenerimaan').addClass('loading');
              $('#chartMinMax').addClass('loading');
          },
          data : {kode_kelompok : kode_kelompok, startDate : startDate, endDate : endDate, plant_group : plant_group},
          dataType : 'json'
        }).done(function (results) {
          // isi info min max stok rp dll

          var tempData = {
            label : results.labels ,
            datasets : results.datasets
          };
          $('#chartPenerimaan').html('<canvas id="chartPenerimaan_canvas"></canvas>');
          $('#chartMinMax').html('<canvas id="chartPenerimaan_canvas" ></canvas>');
          // Get the context of the canvas element we want to select
          $('#chartPenerimaan').find('canvas').each(function(i,item){
               var ctx = item.getContext('2d');
               var myLineChart = new Chart(ctx,{
                type: 'line',                
                data: results.pakai,                
                options: {                                     
                      tooltips: {
                        mode: 'label',  
                        callbacks: {
                            label: function(tooltipItem, data) {
				var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
				return datasetLabel + ': ' + angkaIndonesia(tooltipItem.yLabel);
                            },
                            
                        }                        
                    },
                    title : { text :'Penerimaan & Pemakaian',display : true },
                    legend : {
                        position : 'bottom',
                        labels : {
                            boxWidth : 10,
                            fontSize : 10,
                        },
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }],
                        xAxes: [{
                            gridLines:{
                                color:"rgba(255,255,255,0.5)",
                                zeroLineColor:"rgba(255,255,255,0.5)"
                              }    
                          }],
                    }
                }
                });

          })
          $('#chartMinMax').find('canvas').each(function(i,item){
               var cty = item.getContext('2d');
               var myLineCharty = new Chart(cty,{
                type: 'line',
                
                data: results.minmax,
                options: {
                    tooltips: {         
                        mode: 'label',  
                        callbacks: {
                            label: function(tooltipItem, data) {
				var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
				return datasetLabel + ': ' + angkaIndonesia(tooltipItem.yLabel);
                            },                            
                        }
                    },
                    title : { text : 'Min Max Stock', display : true},
                    legend : {
                        position : 'bottom',
                        labels : {
                            boxWidth : 10,
                            fontSize : 10,
                        },
                    },
                    scales: {            
                        yAxes: [{
                            ticks: {
                                beginAtZero : true
                            },
                        }],
                        xAxes : [{                    
                            gridLines:{
                                color:"rgba(255,255,255,0.5)",
                                zeroLineColor:"rgba(255,255,255,0.5)"
                              }    
                        }]
                    }
                }
                });
          })
              $('#chartPenerimaan').removeClass('loading');
              $('#chartMinMax').removeClass('loading');                      
      });
    }
    $('#nav_bahan .nav>li>a').click(function(e){
        var kode_kelompok = $(this).data('kode');
        var period = $(this).data('periode');
        $('#div_title_bahanbaku').html('<h3>'+$(this).data('nama')+'</h3>').data('kode_kelompok',kode_kelompok);
        var plant_group = $(this).data('plant');
        var startDate = $(this).data('startdate');
        var endDate = $(this).data('enddate');
        drawLineChart(kode_kelompok,startDate,endDate,plant_group);
        e.preventDefault();
        
    })
    
    var  _batubara = $('#nav_bahan .nav>li>a:contains(BATUBARA)');
    if(_batubara.length){
        _batubara.click();
    }else{
       $('#nav_bahan .nav>li>a').first().click(); 
    }
 });   
</script>