<link rel="stylesheet" stype="text/css" href="<?php echo base_url();?>assets/master_opc/css/opc-style.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/master_opc/css/hy_model.css">

<script type="text/javascript" src="<?php echo base_url();?>assets/master_opc/js/lib/json2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/master_opc/js/opc-lib-min.js"></script>


<script>
    OPC_config = {
                    token:'7e61b230-481d-4551-b24b-ba9046e3d8f2',
                    serverURL: 'http://10.15.3.146:58725'
            };

var auto_refresh = setInterval(function() {
		$("#zabar").load(location.href+" #zabar>*","").fadeIn("slow");
		$("#zabar").trigger('updatelayout');
	},200000);
</script>	
<div data-role="page">
	<div id="zabar">

<?php include 'load_tuban.php';  ?>
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <th width="20%" height="45" align="center" valign="middle" nowrap="nowrap">TUBAN I</th>
    <th width="20%" align="center" valign="middle" nowrap="nowrap">TUBAN II </th>
    <th width="20%" align="center" valign="middle" nowrap="nowrap">TUBAN III </th>
    <th width="20%" align="center" valign="middle" nowrap="nowrap">TUBAN IV </th>
    <th colspan="2" align="center" valign="middle" nowrap="nowrap">GRESIK</th>
  </tr>
  <tr>
    <td valign="top" class="<?php echo $go[1][4][0];?>"><span class="machine-text">Raw Mill 1</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][4][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[1][1][0]; ?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Blend :</span>
	<span class="timer-text"><?php echo $go[1][5][0]; ?> Ton</span>
	<span class="feed-text">Ep <span class="feed-value"><?php echo $go[1][11][0]; ?></span> mg/Nm<sup>3</sup></span>	</div>    </td>
    <td valign="top" class="<?php echo $go[2][28][0];?>"><span class="machine-text">Raw Mill 2</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[2][28][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[2][32][0]; ?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Blend :</span>
	<span class="timer-text"><?php echo $go[2][35][0]; ?> Ton</span>
	<span class="feed-text">Ep <span class="feed-value"><?php echo $go[2][24][0]; ?></span> mg/Nm<sup>3</sup></span>	</div>	</td>
    <td valign="top" id="rm3_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"RM3_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	><span class="machine-text">Raw Mill 3</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
		<span id="RawFeed" style="font-weight:bold;" 
			opc-tag-txt='{"tag":"RM3_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'
			></span>
	
	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Blend 1:</span>
	<span class="timer-text">
		<span id="blend1" style="font-weight:bold;" 
opc-tag-txt='{"tag":"RM3_Tuban_Blend1.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span> % </span>
	<span class="feed-text">Ep <span class="feed-value">
			<span id="epraw3" style="font-weight:bold;" 
			opc-tag-txt='{"tag":"RM3_Tuban_EP.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
		></span> 
	</span> mg/Nm<sup>3</sup></span>	</div>
	<span class="timer-text" style="font-weight:bold;" >Blend 2 : 
					<span id="blend2" style="font-weight:bold;" 
	opc-tag-txt='{"tag":"RM3_Tuban_Blend2.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span> %	</span>	</td>
    <td valign="top" 
	id="rm4_bg"
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"RM4_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	><span class="machine-text">Raw Mill 4</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
		<span id="RawFeed4" style="font-weight:bold;" 
			opc-tag-txt='{"tag":"RM4_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.00","int":"0","string":"{0}"},"offset":0}}'
			></span>
	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Blend :</span>
	<span class="timer-text">
	<span id="blend4" style="font-weight:bold;" 
	opc-tag-txt='{"tag":"RM4_Tuban_Blend1.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span> %	</span>
	<span class="feed-text">Ep <span class="feed-value">
			<span id="epraw4" style="font-weight:bold;" 
			opc-tag-txt='{"tag":"RM4_Tuban_EP.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
		></span> 
	</span> mg/Nm<sup>3</sup></span>	</div>	</td>
    <td colspan="2" align="left" valign="middle" class="run">
			<span class="machine-text">Finish Mill A</span>
			<div class="title">
			<span class="duration-text">Duration :</span>
			<span class="timer-text"><?php //echo $po[2][1];?></span>
			<span class="feed-text">Feed <span class="feed-value"><?php //echo number_format($po[0][0],2,".",",");?></span> T/h</span>	</div>	</td>
  </tr>
  <tr>
    <td valign="middle" class="<?php echo $go[1][17][0];?>"><span class="machine-text">Kiln 1</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][17][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[1][9][0]; ?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Ep Kiln<span class="feed-value"><?php echo $go[1][7][0]; ?></span> mg/Nm<sup>3</sup></span>
	<span class="feed-text">Speed <span class="feed-value">
		<span id="Kilnrpm1" style="font-weight:bold;"><?php echo $go[1][111][0]; ?></span>
	</span> rpm</span>	</div>	</td>
    <td valign="middle" class="<?php echo $go[2][37][0];?>"><span class="machine-text">Kiln 2</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[2][37][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[2][29][0] + $go[2][33][0] ; ?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Ep Kiln<span class="feed-value"><?php echo $go[2][25][0]; ?></span> mg/Nm<sup>3</sup></span>
		<span class="feed-text">Speed <span class="feed-value">
		<span id="Kilnrpm2" style="font-weight:bold;"><?php echo $go[2][112][0]; ?></span>
	</span> rpm</span>	</div>	</td>
    <td valign="middle" 
	id="kl3_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"KL3_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	
	
	><span class="machine-text">Kiln 3</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
			<span id="KilnFede" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"KL3_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span>
	
	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Ep Kiln <span class="feed-value">
			<span id="epkiln3" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"KL3_Tuban_EP.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span> 
	</span>   mg/Nm<sup>3</sup></span>

	<span class="feed-text">Speed <span class="feed-value">
		<span id="Kilnrpm3" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"KL3_Tuban_Rpm.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.00","int":"0","string":"{0}"},"offset":0}}'			
			></span>
	</span> rpm</span>	</div>	</td>
    <td valign="middle" 
		id="kl4_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"KL4_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	
	><span class="machine-text">Kiln 4</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
		<span id="KilnFede4" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"KL4_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span>
	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">Ep Kiln<span class="feed-value">
			<span id="epkiln4" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"KL4_Tuban_EP.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span> 
	
	</span> mg/Nm<sup>3</sup></span>
		<span class="feed-text">Speed <span class="feed-value">
		<span id="Kilnrpm4" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"KL4_Tuban_Rpm.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.00","int":"0","string":"{0}"},"offset":0}}'			
			></span>
	</span> rpm</span>	</div>	</td>
    <td colspan="2" align="left" valign="middle" class="run">
			<span class="machine-text">Finish Mill B</span>
				<div class="title">
				<span class="duration-text">Duration :</span>
				<span class="timer-text">00:00:00</span>
				<span class="feed-text">Feed <span class="feed-value">--</span> T/h</span>			</div>	</td>
  </tr>
  <tr>
    <td valign="middle" class="<?php echo $go[1][8][0];?>"><span class="machine-text">Coal Mill 1</span>
	</br>
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][8][1]; ?></span>	</td>
    <td valign="middle" class="<?php echo $go[2][30][0];?>"><span class="machine-text">Coal Mill 2</span>
	</br>
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[2][30][1]; ?></span>	</td>
    <td valign="middle"
	id="cm3_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"CM3_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	
	><span class="machine-text">Coal Mill 3</span>
	</br>
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>	</td>
    <td valign="middle" 
		id="cm4_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"CM4_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	
	><span class="machine-text">Coal Mill 4</span>
	</br>
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>	</td>
    <td colspan="2" align="left" valign="middle" class="run">
			<span class="machine-text">Finish Mill C</span>
			<div class="title">
			<span class="duration-text">Duration :</span>
			<span class="timer-text"><?php //echo $po[3][1];?></span>
			<span class="feed-text">Feed <span class="feed-value"><?php //echo number_format($po[1][0],2,".",",");?></span> T/h</span>	</div>	</td>
  </tr>
  <tr>
    <td valign="middle" class="<?php echo $go[1][12][0];?>"><span class="machine-text">Finish Mill 1</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][12][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[1][20][0];?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">HRC:</span>
	<span class="timer-text"><?php echo $go[1][16][0];?></span>	</div>	</td>
    <td valign="middle" class="<?php echo $go[2][36][0];?>"><span class="machine-text">Finish Mill 3</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[2][36][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[2][34][0];?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">HRC:</span>
	<span class="timer-text"><?php echo $go[2][21][0]; ?></span>	</div>	</td>
    <td valign="middle" 
	id="fm5_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"FM5_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	><span class="machine-text">Finish Mill 5</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">	<span id="feed5" style="font-weight:bold;" 
		opc-tag-txt='{"tag":"FM5_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
				></span>	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">HRC:</span>
	<span class="timer-text"><?php echo $go[3][49][0]; ?></span>	</div>	</td>
    <td valign="middle" 
	id="fm7_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"FM7_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'

	><span class="machine-text">Finish Mill 7</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
	<span id="feed7" style="font-weight:bold;" 
		opc-tag-txt='{"tag":"FM7_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
				></span>
	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">&nbsp;</span>
	<span class="timer-text">&nbsp;</span>	</div>	</td>
    <td colspan="2" valign="middle" class="<?php //echo $po[2][0];?>">
	Finish Mill 8 (Project Semen Putih)	</td>
  </tr>
  <tr>
    <td valign="middle" class="<?php echo $go[1][18][0];?>" ><span class="machine-text">Finish Mill 2</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][18][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[1][14][0];?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">HRC:</span>
	<span class="timer-text"><?php echo $go[1][0][0];?></span>	</div>	</td>
    <td valign="middle" class="<?php echo $go[2][31][0];?>"><span class="machine-text">Finish Mill 4</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[2][32][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[2][26][0]; ?></span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">HRC:</span>
	<span class="timer-text"><?php echo $go[2][22][0];?></span>	</div>	</td>
    <td valign="middle" id="fm6_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"FM6_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
	><span class="machine-text">Finish Mill 6</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
	<span id="feed6" style="font-weight:bold;" 
	opc-tag-txt='{"tag":"FM6_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span>
	</span> T/h</span>	</div>
	<div class="title">
	<span class="duration-text">HRC:</span>
	<span class="timer-text">Run</span>	</div>	</td>
    <td valign="middle"  id="fm8_bg" 
		opc-tag-bkg='{"type":"group","all_f":{"color":"#FF0000","offset":0},"bad_q":{"color":"#FFFF00","offset":0},"group":[{"tag":"FM8_Tuban_Motor.Value","config":{"color":"#00FF00","offset":0}}]}'
><span class="machine-text">Finish Mill 8</span>
	<div class="title"> 
	<span class="duration-text">Duration :</span>
	<span class="timer-text"> -- </span>
	<span class="feed-text">Feed <span class="feed-value">
		<span id="feed8" style="font-weight:bold;" 
	opc-tag-txt='{"tag":"FM8_Tuban_Feed.Value","config":{"formats":{"bad_q":"...","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0}"},"offset":0}}'			
			></span>
	</span> T/h</span>	</div>
		<div class="title">
	<span class="duration-text">&nbsp;</span>
	<span class="timer-text">&nbsp;</span>	</div>	</td>
	<!-- Proses Silo Gresik-->
    <td width="10%" rowspan="4" valign="top" class="siloc" style="font-size:11px;">	
			
	<div class="silo-text">Silo 01</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][1][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 02</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][2][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 03</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][3][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 04</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][4][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 05</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][5][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 06</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][6][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 07</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][7][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 08</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][8][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 09</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][9][0]; ?> TON</div>
	<div class="silo-main"></div>	</td>
	
	<!-- Proses Silo Gresik-->
    <td width="10%" rowspan="4" valign="top" class="siloc" style="font-size:11px;">
	<div class="silo-text">Silo 10</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][10][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 11</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][11][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 12</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][12][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 13</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][13][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 14</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][14][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 15</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][15][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 16</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][16][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 17</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][17][0]; ?> TON</div>
	<div class="silo-main"></div>
	<div class="silo-text">Silo 18</div>
		<div class="silo-stat">&nbsp;</div>
		<div class="silo-value" align="right"><?php echo $go['GRESIK'][18][0]; ?> TON</div>
	<div class="silo-main"></div>	
	</td>
  </tr>
  <tr>
    <td valign="middle" class="<?php echo $go[1][13][0];?>">
	<span class="machine-text">ATOX MILL</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][13][1]; ?></span>	</div>	</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td valign="middle" class="<?php echo $go[1][19][0];?>"><span class="machine-text">NEW VERTICAL MILL</span>
	<div class="title">
	<span class="duration-text">Duration :</span>
	<span class="timer-text"><?php echo $go[1][19][1]; ?></span>
	<span class="feed-text">Feed <span class="feed-value"><?php echo $go[1][76][0]; ?></span> T/h</span>	</div></td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    </tr>
  <tr class="siloc">
    <td align="left" valign="top">
			<div class="silo-text">Silo 01 </div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[1][10][0]; ?> TON			</div>
		<div class="silo-main"></div>
			<div class="silo-text">Silo 02 </div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[1][2][0]; ?> TON			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 03			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[1][15][0]; ?> TON			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 04			</div>			<div class="silo-stat">
			&nbsp;
			</div>
			<div class="silo-value" align="right">
			<?php echo $go[1][6][0]; ?> TON			</div>	</td>
    <td height="50" align="left" valign="top">
	<div class="silo-text">
			Silo 05	  </div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[2][27][0]; ?> TON			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 06			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[2][23][0]; ?> TON			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 07			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[2][38][0]; ?> TON			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 08			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<?php echo $go[2][39][0]; ?> TON			</div>	</td>
    <td align="left" valign="top">
		<div class="silo-text">
			Silo 09	  </div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
			<div id="silo_09" style="font-weight:bold;" 
				opc-tag-txt='{"tag":"Silo_Tuban_09.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
						>			</div>		
			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 10			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_10" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_10.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>
			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 11			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_11" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_11.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>
			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 12			</div>
			<div class="silo-stat">
			&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_12" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_12.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>
			</div>	</td>
    <td align="left" valign="top">
		<div class="silo-text">
			Silo 13	  </div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_13" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_13.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>		</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 14			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_14" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_14.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>
			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 15			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_15" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_15.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>
			</div>
		<div class="silo-main"></div>
			<div class="silo-text">
			Silo 16			</div>
			<div class="silo-stat">
&nbsp;			</div>
			<div class="silo-value" align="right">
				<div id="silo_16" style="font-weight:bold;" 
					opc-tag-txt='{"tag":"Silo_Tuban_16.Value","config":{"formats":{"bad_q":"connecting..","bool_f":"False","bool_t":"True","float":"0.0","int":"0","string":"{0} Ton"},"offset":0}}'
							>				</div>
			</div>	</td>
    </tr>
</table>
</div></div>