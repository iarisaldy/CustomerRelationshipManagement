<script src="<?=base_url('assets/chartjs/dist/Chart.js')?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.datepicker').datepicker({
		    format: 'mm/yyyy',
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
            background: url('../assets/img/loading.gif') no-repeat center;
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
                <div class="panel-heading" style="color:#ffffff"><i class="fa fa-line-chart"></i> Stok Bahan & Batubara</div>
                <div class="panel-body">
                    <div class="row">                        
                        <div class="col-md-12">
                            <div class="col-md-4" style="">
                            <div class="col-md-2"><img src="<?=base_url().'assets/img/menu/semen_tonasa.png'?>" style="width:90px;"></div>
                            <div class="col-md-10"><h2 style="text-align:left;line-height: 220%;padding-left: 30px;"><b>SEMEN TONASA</b></h2></div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <form method="post" action="">
                                <div class="form-group">                                
                                    <div class="col-md-2" style="width:150px">
                                        <label>Bulan</label>
                                        <select id="bulan" class="form-control" name="bulan">                                        
                                            <?php 
                                            $list_bulan = array(
                                                "01" => "Januari",
                                                "02" => "Februari",
                                                "03" => "Maret",
                                                "04" => "April",
                                                "05" => "Mei",
                                                "06" => "Juni",
                                                "07" => "Juli",
                                                "08" => "Agustus",
                                                "09" => "September",
                                                "10" => "Oktober",
                                                "11" => "November",
                                                "12" => "Desember"
                                            ); 
                                            foreach($list_bulan as $key => $val){
                                                $selected = $key == $bulan ? 'selected' : '';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                                            }
                                            
                                            ?>
                                            
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="width:110px">
                                        <label>Tahun</label>
                                        <?php 
                                            $tahunSekarang = date('Y');
                                            $awalTahun = $tahunSekarang - 2;                                        
                                        ?>
                                        <select id="tahun" class="form-control" name="tahun">
                                            <?php
                                                for($i = $awalTahun; $i <= $tahunSekarang; $i++){
                                                    $selected = $i == $tahun ? 'selected' : '';
                                                    echo '<option '.$selected.'>'.$i.'</option>';                                                    
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-2" style="width:130px">            
                                        <label>Lokasi</label>
                                        <select id="plant_group" class="form-control" name="plant_group">
                                            <?php
                                                $_plant_group = array('4401'=> 'Tonasa');
                                                foreach($_plant_group as $key => $val){
                                                    $selected = $key == $plant_group ? 'selected' : '';
                                                    echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';                                                        
                                                }
                                            ?>                                        
                                        </select>
                                    </div>
                                    <div class="col-md-1" style="margin-top: 23px;">
                                        <button type="submit" class="btn btn-default" style="margin-top:0px"><i class="fa fa-search"></i></button>
                                    </div>                                
                                </div>
                            </form>
                            </div>
                            <div class="col-md-2" style="margin-top:25px; padding-right: 45px;">
                                <a href="<?php echo site_url('st/ResourceInventory/detail') ?>" class="pull-right btn btn-primary"><i class="fa fa-clock-o"></i>History</a>
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
                                  
                                  echo '<li style="border-radius:5px" class="'.$_class_stok.'"><a href="#" data-nama="'.$h['NAMA_KELOMPOK'].'" data-plant="'.$plant_group.'"  data-periode="'.$periode.'" data-kode="'.$h['KODE_KELOMPOK'].'"><div>'.$h['ALIAS_NAMA'].'<br >'.number_format($_stok, 0, ',', '.').'</div></a></li>'; 
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
<!--                         <div class="legend_item">
                            <div class="kotak kuning">&nbsp;</div>
                            <div>Replenish Point</div>
                        </div> -->
                        <div class="legend_item">
                            <div class="kotak merah">&nbsp;</div>
                            <div>Dibawah min</div>
                        </div>
                    </div>                    
                    <hr  style="margin-top:30px;border-color: red" />
                    <div class="col-md-12 text-center" id="div_title_bahanbaku"  style="margin-top:10px"></div>
                    <div class="row">
                        <div class="col-md-6" id="chartPenerimaan">
                            
                        </div>
                        <div class="col-md-6" id="chartMinMax">
                            
                        </div>
                    </div>
                    <div class="row" style="">
                        <div class="panel panel-primary" style="width:100%">
                            <div class="panel-heading" style="color:#ffffff"><i class="fa fa-info-circle"></i> Info Chart</div>
                            <div class="panel-body">
                              <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6"><strong>Realisasi : </strong></div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-md-6">- Penerimaan s/d</div>
                                <div class="col-md-6" id="info_terima"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">- Pemakaian s/d</div>
                                <div class="col-md-6" id="info_pakai"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">- RKAP Pakai</div>
                                <div class="col-md-4" id="info_rkap"></div>
                            </div>
                            <div class="row" style="font-weight:bolder">
                                <div class="col-md-6">Prognose Pemakaian</div>
                                <div class="col-md-6" id="info_prognose_pakai"></div>
                            </div>
                        </div>
                        <div class="col-md-4"  style="font-weight:bolder">
                            <div class="row">
                                <div class="col-md-6">Total Stock</div>
                                <div class="col-md-4" id="info_total_stock"></div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-6">Usage Average (7 days)</div>
                                <div class="col-md-4" id="info_average7"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Days of Inventory</div>
                                <div class="col-md-4" id="info_day_inventory"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Sisa PO</div>
                                <div class="col-md-4"> : -</div>
                            </div>
                        </div>
                        <div class="col-md-4"  style="font-weight:bolder">
                            <div class="row">
                                <div class="col-md-6">Min Stock</div>
                                <div class="col-md-4" id="info_min_stock"></div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-6">Max Stock</div>
                                <div class="col-md-4" id="info_max_stock"></div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-6">Replenish Point (RP)</div>
                                <div class="col-md-4" id="info_rp"></div>
                            </div> -->
                        </div>  
                            </div>
                    </div>
                </div>
            </div>
            
            
        </div>    
    </div>
		
</div>
<script type="text/javascript">
 $(function(){
   
function number_format(number, decimals, dec_point, thousands_sep) {
	//  discuss at: http://phpjs.org/functions/number_format/
	// original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: davook
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Theriault
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// bugfixed by: Michael White (http://getsprink.com)
	// bugfixed by: Benjamin Lupton
	// bugfixed by: Allan Jensen (http://www.winternet.no)
	// bugfixed by: Howard Yeend
	// bugfixed by: Diogo Resende
	// bugfixed by: Rival
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	//  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	//  revised by: Luke Smith (http://lucassmith.name)
	//    input by: Kheang Hok Chin (http://www.distantia.ca/)
	//    input by: Jay Klehr
	//    input by: Amir Habibi (http://www.residence-mixte.com/)
	//    input by: Amirouche
	//   example 1: number_format(1234.56);
	//   returns 1: '1,235'
	//   example 2: number_format(1234.56, 2, ',', ' ');
	//   returns 2: '1 234,56'
	//   example 3: number_format(1234.5678, 2, '.', '');
	//   returns 3: '1234.57'
	//   example 4: number_format(67, 2, ',', '.');
	//   returns 4: '67,00'
	//   example 5: number_format(1000);
	//   returns 5: '1,000'
	//   example 6: number_format(67.311, 2);
	//   returns 6: '67.31'
	//   example 7: number_format(1000.55, 1);
	//   returns 7: '1,000.6'
	//   example 8: number_format(64000, 5, ',', '.');
	//   returns 8: '67.000,00000'
	//   example 9: number_format(0.9, 0);
	//   returns 9: '1'
	//  example 10: number_format('1.20', 2);
	//  returns 10: '1.20'
	//  example 11: number_format('1.20', 4);
	//  returns 11: '1.2000'
	//  example 12: number_format('1.2000', 3);
	//  returns 12: '1.200'
	//  example 13: number_format('1 000,50', 2, '.', ' ');
	//  returns 13: '100 050.00'
	//  example 14: number_format(1e-8, 8, '.', '');
	//  returns 14: '0.00000001'

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
   
    function drawLineChart(kode_kelompok,period,plant_group) {
        var jsonData = $.ajax({
          url: "<?php echo site_url('st/ResourceInventory/getData')?>",
          beforeSend : function(){
              $('#chartPenerimaan').empty();
              $('#chartMinMax').empty();
              $('#chartPenerimaan').addClass('loading');
              $('#chartMinMax').addClass('loading');
          },
          data : {kode_kelompok : kode_kelompok, period : period, plant_group : plant_group},
          dataType : 'json'
        }).done(function (results) {
          // isi info min max stok rp dll
          var info = results.info;
          $('#info_min_stock').text(': '+angkaIndonesia(info.min));
          $('#info_max_stock').text(': '+angkaIndonesia(info.max));
          $('#info_total_stock').text(': '+angkaIndonesia(info.total_stok));
          var _average7 = info.lastAverageWeek;
          $('#info_average7').text(': '+angkaIndonesia(_average7));
          $('#info_day_inventory').text(': '+angkaIndonesia(info.total_stok/_average7));
          $('#info_rp').text(': '+angkaIndonesia(info.rp));
          $('#info_terima').text(': '+angkaIndonesia(info.total_terima));        
          var _persen_pakai = 0;
          var _persen_pakai_prognose = 0;
          if(kode_kelompok == 1400 || kode_kelompok == 1300){
            $('#info_rkap').prev().text('- RKAP Pakai Total');
            _persen_pakai = info.total_pakai_gypsum;
            _persen_pakai_prognose = info.total_prognose_gypsum;
          }else{
            $('#info_rkap').prev().text('- RKAP Pakai');    
            _persen_pakai = info.total_pakai;
            _persen_pakai_prognose = info.prognose_pakai;
          }
          $('#info_pakai').text(': '+angkaIndonesia(info.total_pakai)+' ('+angkaIndonesia(_persen_pakai/info.rkap * 100)+'%)');
          $('#info_rkap').text(': '+angkaIndonesia(info.rkap)); 
          $('#info_prognose_pakai').text(': '+angkaIndonesia(info.prognose_pakai)+'( '+angkaIndonesia(_persen_pakai_prognose/info.rkap * 100)+' %)');
          // Split timestamp and data into separate arrays

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
                                display: true,
                                    scaleLabel: {
                                    display: true,
                                    labelString: results.satuan
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    callback: function (value, index, values) {
                                        return angkaIndonesia(value);
                                    }
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
                                display: true,
                                    scaleLabel: {
                                    display: true,
                                    labelString: results.satuan
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    callback: function (value, index, values) {
                                        return angkaIndonesia(value);
                                    }
                                }
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
        $('#div_title_bahanbaku').html('<h3>'+$(this).data('nama')+'</h3>');
        var plant_group = $(this).data('plant');;
        drawLineChart(kode_kelompok,period,plant_group);
        e.preventDefault();
        
    })
    /* jika ada batubara maka jadikan sebagai default */
    var  _batubara = $('#nav_bahan .nav>li>a:contains(BATUBARA)');
    if(_batubara.length){
        _batubara.click();
    }else{
       $('#nav_bahan .nav>li>a').first().click(); 
    }
    
 });   
</script>