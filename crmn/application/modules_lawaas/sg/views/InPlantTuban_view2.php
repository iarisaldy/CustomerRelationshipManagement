<style>
    td{
        background-repeat: no-repeat;
    }
    .bag{
        position: relative;
        top: 3px;
        left: 0px;
        padding-bottom: 8px;
        display: block;
    }
    .bulk{
        position: relative;
        bottom: 0px;
        left: 0px;
        padding-bottom: 7px;
    }
    .total{
        position: relative;
        bottom: 0px;
        left: 0px;
    }
    .avg{
        display: block;
        font-size: 13px;
		font-weight: bold;
    }
    .cnt{
        display: block;
        font-size: 13px;
    }
    .block{
        font-size: 12px;
    }
	.wktupdate{
		position: relative;
        bottom: 5px;
        left: 10px;
		padding-bottom: 2px;
	}
	.jamloading_point{
		position: relative;
		bottom: 30px;
	}
	.loading_point{
		position: relative;
		top: 0px;
	}
	.jam-lp-tuban1{
		position: relative;
		bottom: 23px;
	}
	.lp-tuban1{
		position: relative;
		bottom: 20px;
	}
	.lp-tuban4{
		position: relative;
		bottom: 41px;
	}
	.c-point{
		float: left;
		width: 25px;
		height: 20px;
		margin-top: 2px;
		margin-left: 5px;
		margin-right: 4px;
		color: #fff;
		font-size: 11px;
		text-weight: bold;
		background: #1AB394;
		border-radius: 3px;
	}
	.c-point-val{
		float: left;
		width: 25px;
		height: 20px;
		margin-left: 5px;
		margin-right: 4px;
		margon-bottom: 2px;
		color: #fff;
		font-size: 11px;
		text-weight: bold;
		background: #23C6C8;
		border-radius: 3px;
	}
	.jam-lp-tuban2{
		position: relative;
		bottom: 2px;
	}
	.jam-lp-tuban4{
		position: relative;
		bottom: 44px;
	}
	#loading_purple {
		position:fixed;
		top:0;
		left:0;
		background:url('<?php echo base_url();?>assets/img/loading.gif')no-repeat center center;
		z-index:9999;
		text-align:center;
		width:100%;
		height:100%;
		padding-top:70px;
		font:bold 50px Calibri,Arial,Sans-Serif;
		color:#000;
		display:none;
	}
	.inplant{
		width:100%;
		overflow: auto;
	}
</style>
<div id="loading_purple"></div>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4><span class="text-navy"><i class="fa fa-truck"></i> IN PLANT TUBAN</span></h4>
            </div>
            <div class="panel-body">
                <div class="inplant">
				<table id="Table_01" width="" height="" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="17" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_01.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="77" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_02.png')">
							<div class="col-md-12">
								<div class="wktupdate">
									<h4><b>Waktu Update : </b></h4>										
								</div>	
								<div class="wktupdate">
									<b><span id="waktuupdate"></span></b>										
								</div>								
							</div>
                        </td>
                        <td colspan="14" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_03.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="53" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_04.png')">
                        </td>
                        <td rowspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_05.png')">
                        </td>
                        <td colspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_06.png')">
                            <div class="col-md-7">
                                <span class="label label-primary avg" id="avgcargo301">00:00 jam</span>
                            </div>
                            <div class="col-md-5">
                                <a href="<?php echo base_url();?>sg/InPlantTuban/detailTruk/0" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                    <span class="label label-info cnt"><b id="cntcargo301">0</b> <b>unit</b></span>
                                </a>
                            </div>
                        </td>
                        <td colspan="3" rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_07.png')">
                        </td>
                        <td colspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_08.png')">
                            <div class="col-md-7">
                                <span class="label label-primary avg" id="avgtmbgn301">00:00 jam</span>
                            </div>
                            <div class="col-md-5">
                                <a href="<?php echo base_url();?>sg/InPlantTuban/detailTruk/2" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                    <span class="label label-info cnt"><b id="cnttmbgn301">0</b> <b>unit</b></span>
                                </a>
                            </div>
                        </td>
                        <td colspan="2" rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_09.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="41" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_10.png')">
                        </td>
                        <td colspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_11.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="30" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_12.png')">
                            <div class="col-md-7">
                                <span class="label label-primary avg" id="avgcargo308">00:00 jam</span>
                            </div>
                            <div class="col-md-5">
                                <a href="<?php echo base_url();?>sg/InPlantTuban/detailTruk/1" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                    <span class="label label-info cnt"><b id="cntcargo308">0</b> <b>unit</b></span>
                                </a>
                            </div>
                        </td>
                        <td colspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_13.png')">
                            <div class="col-md-7">
                                <span class="label label-primary avg" id="avgtmbgn308">00:00 jam</span>
                            </div>
                            <div class="col-md-5">
                                <a href="<?php echo base_url();?>sg/InPlantTuban/detailTruk/3" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                    <span class="label label-info cnt"><b id="cnttmbgn308">0</b> <b>unit</b></span>
                                </a>
                            </div>
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="41" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_14.png')">
                        </td>
                        <td colspan="11" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_15.png')">
                        </td>
                        <td>
                           <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="74" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_16.png')">
                            <center>
                                <div class="row jam-lp-tuban1">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbag1">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban1">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbag1" data-toggle="tooltip" data-placement="top" title="">C1</span>
											<span class="c-point" id="lpbag2" data-toggle="tooltip" data-placement="top" title="">C2</span>
											<span class="c-point" id="lpbag3" data-toggle="tooltip" data-placement="top" title="">C3</span>
											<span class="c-point" id="lpbag4" data-toggle="tooltip" data-placement="top" title="">C4</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/1" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag1">0</span>
                                            </a>							
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/2" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag2">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/3" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag3">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/4" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag4">0</span>
                                            </a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbag5" data-toggle="tooltip" data-placement="top" title="">C5</span>
											<span class="c-point" id="lpbag6" data-toggle="tooltip" data-placement="top" title="">C6</span>
											<span class="c-point" id="lpbag7" data-toggle="tooltip" data-placement="top" title="">C7</span>
											<span class="c-point" id="lpbag8" data-toggle="tooltip" data-placement="top" title="">C8</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/5" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag5">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/6" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag6">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/7" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag7">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/8" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag8">0</span>
                                            </a>
										</div>
									</div>
								</div>
                            </center>
                        </td>
                        <td rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_17.png')">
                        </td>
                        <td colspan="2" rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_18.png')">
                            <center>
                                <div class="row jam-lp-tuban2">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbag2">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="c-point" id="lpbag11" data-toggle="tooltip" data-placement="top" title="">C11</span>
										<span class="c-point" id="lpbag12" data-toggle="tooltip" data-placement="top" title="">C12</span>
										<span class="c-point" id="lpbag13" data-toggle="tooltip" data-placement="top" title="">C13</span>
										<span class="c-point" id="lpbag14" data-toggle="tooltip" data-placement="top" title="">C14</span>
                                    </div>									
                                </div>
								<div class="row">
									<div class="col-md-12">
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/11" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag11">0</span>
                                        </a>
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/12" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag12">0</span>
                                        </a>
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/13" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag13">0</span>
                                        </a>
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/14" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag14">0</span>
                                        </a>
                                    </div>
								</div>
								<div class="row">
                                    <div class="col-md-12">
                                        <span class="c-point" id="lpbag15" data-toggle="tooltip" data-placement="top" title="">C15</span>
										<span class="c-point" id="lpbag16" data-toggle="tooltip" data-placement="top" title="">C16</span>
										<span class="c-point" id="lpbag17" data-toggle="tooltip" data-placement="top" title="">C17</span>
										<span class="c-point" id="lpbag18" data-toggle="tooltip" data-placement="top" title="">C18</span>
                                    </div>									
                                </div>
								<div class="row">
									<div class="col-md-12">
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/15" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
											<span class="c-point-val" id="bag15">0</span>
                                        </a>
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/16" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag16">0</span>
                                        </a>
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/17" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag17">0</span>
                                        </a>
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/18" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag18">0</span>
                                        </a>
                                    </div>
								</div>
								<div class="row">
                                    <div class="col-md-12">
                                        <span class="c-point" id="lpbag19" data-toggle="tooltip" data-placement="top" title="">C19</span>
                                    </div>									
                                </div>
								<div class="row">
									<div class="col-md-12">
										<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/19" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                            <span class="c-point-val" id="bag19">0</span>
                                        </a>
                                    </div>
								</div>
                            </center>
                        </td>
                        <td rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_19.png')">
                        </td>
                        <td rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_20.png')">
                            <center>
                                <div class="row jam-lp-tuban1">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbag3">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban1">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbag21" data-toggle="tooltip" data-placement="top" title="">C21</span>
											<span class="c-point" id="lpbag22" data-toggle="tooltip" data-placement="top" title="">C22</span>
											<span class="c-point" id="lpbag23" data-toggle="tooltip" data-placement="top" title="">C23</span>
											<span class="c-point" id="lpbag24" data-toggle="tooltip" data-placement="top" title="">C24</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/21" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag21">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/22" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag22">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/23" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag23">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/24" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag24">0</span>
                                            </a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbag25" data-toggle="tooltip" data-placement="top" title="">C25</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/25" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag25">0</span>
                                            </a>
										</div>
									</div>
								</div>
                            </center>
                        </td>
                        <td rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_21.png')">
                        </td>
                        <td colspan="2" rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_22.png')">
                            <center>
                                <div class="row jam-lp-tuban4">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbag4">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban4">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbag31" data-toggle="tooltip" data-placement="top" title="">C31</span>
											<span class="c-point" id="lpbag32" data-toggle="tooltip" data-placement="top" title="">C32</span>
											<span class="c-point" id="lpbag33" data-toggle="tooltip" data-placement="top" title="">C33</span>
											<span class="c-point" id="lpbag34" data-toggle="tooltip" data-placement="top" title="">C34</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/31" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag31">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/32" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag32">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/33" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag33">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/34" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bag34">0</span>
                                            </a>
										</div>
									</div>
								</div>
                            </center>
                        </td>
                        <td rowspan="3" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_23.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="75" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_24.png')">
                        </td>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_25.png')">
							<a class="block btn btn-default btn-xs" href="<?php echo base_url();?>sg/InPlantTuban/grafikLaporan" style="font-size:13px;"><b><i class="fa fa-line-chart"></i> Grafik</b></a>
                        </td>
                        <td colspan="4" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_26.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="26" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_27.png')">
                        </td>
                        <td colspan="2" rowspan="4" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_28.png')">
                            <div class="bag">
                                <span class="label label-info block" id="waktusiklusbag">00:00 jam</span>
                            </div>
                            <div class="bag">
                                <span class="label label-info block" id="gudangdist">0.000</span>
                            </div>
                            <div class="bag">
                                <span class="label label-info block" id="gudangda">0.000</span>
                            </div>
                            <div class="bag">
                                <span class="label label-info block" id="gudangsg">0.000</span>
                            </div>
                            <a href="<?php echo base_url();?>sg/InPlantTuban/detailTonase/bag" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                <div class="bag">                                
                                    <span class="label label-primary block" id="bagsubtotal">0.000</span>                                
                                </div>
                            </a>
                            <div class="bulk">
                                <span class="label label-info block" id="waktusiklusbulk">00:00 jam</span>
                            </div>
                            <div class="bulk">
                                <span class="label label-info block" id="port">0.000</span>
                            </div>
                            <div class="bulk">
                                <span class="label label-info block" id="lokal">0.000</span>
                            </div>
                            <a href="<?php echo base_url();?>sg/InPlantTuban/detailTonase/bulk" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                <div class="bulk">
                                    <span class="label label-primary block" id="bulksubtotal">0.000</span>
                                </div>
                            </a>
                            <div class="total">
                                <span class="label label-success block" id="total">0.000</span>
                            </div>
                        </td>
                        <td rowspan="5" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_29.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="48" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_30.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="33" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_31.png')">
                            <center>
                                <div class="row jamloading_point">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbulk1">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban1">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbulk80" data-toggle="tooltip" data-placement="top" title="">C80</span>
											<span class="c-point" id="lpbulk81" data-toggle="tooltip" data-placement="top" title="">C81</span>
											<span class="c-point" id="lpbulk90" data-toggle="tooltip" data-placement="top" title="">C90</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/80" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk80">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/81" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk81">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/90" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk90">0</span>
                                            </a>
										</div>
									</div>
								</div>
                            </center>
                        </td>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_32.png')">
                        </td>
                        <td colspan="2" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_33.png')">
                            <center>
                                <div class="row jamloading_point">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbulk2">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban1">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbulk91" data-toggle="tooltip" data-placement="top" title="">C91</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/91" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk91">0</span>
                                            </a>
										</div>
									</div>
								</div>                              
                            </center>
                        </td>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_34.png')">
                        </td>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_35.png')">
                            <center>
                                <div class="row jamloading_point">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbulk3">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban1">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbulk82" data-toggle="tooltip" data-placement="top" title="">C82</span>
											<span class="c-point" id="lpbulk92" data-toggle="tooltip" data-placement="top" title="">C92</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/82" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk82">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/92" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk92">0</span>
                                            </a>
										</div>
									</div>
								</div>
                            </center>
                        </td>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_36.png')">
                        </td>
                        <td colspan="2" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_37.png')">
                            <center>
                                <div class="row jamloading_point">
                                    <div class="col-md-12">
                                        <span class="label block" id="avgpbrkbulk4">00:00 jam</span>
                                    </div>                                
                                </div>
                                <div class="lp-tuban1">
									<div class="row">
										<div class="col-md-12">
											<span class="c-point" id="lpbulk84" data-toggle="tooltip" data-placement="top" title="">C84</span>
											<span class="c-point" id="lpbulk94" data-toggle="tooltip" data-placement="top" title="">C94</span>
										</div>									
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/84" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk84">0</span>
                                            </a>
											<a href="<?php echo base_url();?>sg/InPlantTuban/detailConveyor/94" data-toggle="tooltip" data-placement="top" title="Klik untuk detail truk">
                                                <span class="c-point-val" id="bulk94">0</span>
                                            </a>
										</div>
									</div>
								</div>
                            </center>
                        </td>
                        <td style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_38.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="150" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" rowspan="2" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_39.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="31" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-image: url('<?php echo base_url();?>assets/img/inplanttuban/background_inplant_40.png')">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="1" height="10" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="14" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="109" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="82" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="62" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="42" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="83" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="94" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="43" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="9" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="45" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="94" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="5" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="140" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="9" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="6" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="132" height="1" alt="">
                        </td>
                        <td>
                            <img src="<?php echo base_url();?>assets/img/inplanttuban/spacer.gif" width="133" height="1" alt="">
                        </td>
                        <td></td>
                    </tr>
                </table>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
	function jam(menit){
		var detik = menit*60;
        var jam = parseInt(detik/3600);
        var sisa = detik%3600;
        var menit = parseInt(sisa/60);
        var hasil = '';
        if(jam.toString().length === 1){
            hasil += '0'+jam;
        } else if(isNaN(jam)){
			hasil += '00';
		} else {
            hasil += jam;
        }
        hasil += ':';
		if(menit.toString().length === 1){
            hasil += '0'+menit;
        } else if(isNaN(menit)){
			hasil += '00';
		} else {
            hasil += menit;
        }
		hasil += ' jam';
		return hasil;
	}
    function cntCargo(){
        var url=base_url+'sg/InPlantTuban/cntcargo';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){
                $('#cntcargo301').html(data[1].JUML_TRUCK);
                $('#cntcargo308').html(data[0].JUML_TRUCK);
            }
        });
    }
    
    function cntTmbgn(){
        var url=base_url+'sg/InPlantTuban/cnttmbgn';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){
                $('#cnttmbgn301').html(data[1].JUML_TRUCK);
                $('#cnttmbgn308').html(data[0].JUML_TRUCK);
            }
        });
    }
    
    function avgCargo(){
        var url=base_url+'sg/InPlantTuban/avgcargo';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){ 
				if(data[0].AVERAGE.replace(',','.') > 240){
					$('#avgcargo301').css('background','#ED5565');
					$('#avgcargo301').html(jam(data[0].AVERAGE.replace(',','.')));
				} else {
					$('#avgcargo301').html(jam(data[0].AVERAGE.replace(',','.')));
				}
                
				if(data[1].AVERAGE.replace(',','.') > 120){
					$('#avgcargo308').css('background','#ED5565');
					$('#avgcargo308').html(jam(data[1].AVERAGE.replace(',','.')));
				} else {
					$('#avgcargo308').html(jam(data[1].AVERAGE.replace(',','.')));
				}
            }
        });
    }
    
    function avgTmbgn(){
        var url=base_url+'sg/InPlantTuban/avgtmbgn';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){
				if(data[0].AVERAGE.replace(',','.') > 30){
					$('#avgtmbgn301').css('background','#ED5565');
					$('#avgtmbgn301').html(jam(data[0].AVERAGE.replace(',','.')));
				} else {
					$('#avgtmbgn301').html(jam(data[0].AVERAGE.replace(',','.')));
				}
                
				if(data[1].AVERAGE.replace(',','.') > 30){
					$('#avgtmbgn308').css('background','#ED5565');
					$('#avgtmbgn308').html(jam(data[1].AVERAGE.replace(',','.')));
				} else {
					$('#avgtmbgn308').html(jam(data[1].AVERAGE.replace(',','.')));
				}
            }
        });
    }
    
    function overall(){
        var url = base_url+'sg/InPlantTuban/overall';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
			beforeSend:function(){
				$('#loading_purple').show();
			},
            success:function(data){
				if(data[0].BAG_AVG.replace(',','.') > 60){
					$('#waktusiklusbag').css('background','#ED5565');
					$('#waktusiklusbag').html(jam(data[0].BAG_AVG.replace(',','.')));
				} else {
					$('#waktusiklusbag').html(jam(data[0].BAG_AVG.replace(',','.')));
				}
                $('#gudangdist').html(data[0].DIST_DA);
                //$('#gudangda').html(data[0].DIST_DA);
                $('#gudangsg').html(data[0].BAG_SG);
                $('#bagsubtotal').html(data[0].BAG_SUB_TOTAL);                
                
				if(data[0].BULK_AVG.replace(',','.') > 60){
					$('#waktusiklusbulk').css('background','#ED5565');
					$('#waktusiklusbulk').html(jam(data[0].BULK_AVG.replace(',','.')));
				} else {
					$('#waktusiklusbulk').html(jam(data[0].BULK_AVG.replace(',','.')));
				}
                $('#port').html(data[0].BULK_PORT);
                $('#lokal').html(data[0].BULK_LOKAL);
                $('#bulksubtotal').html(data[0].BULK_SUB_TOTAL);
                $('#total').html(data[0].TOTAL);
				$('#loading_purple').hide();
            }
        });
    }
    
    function avgpbrk(){
        var url = base_url+'sg/InPlantTuban/avgpbrk';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){
				$.each(data, function(key,val){
					var menit = val.AVERAGE.replace(',','.');
					if(val.PABRIK=='T1' && val.MATNR=='301'){
						if(menit > 240){
							$('#avgpbrkbag1').css('background','#ED5565');
							$('#avgpbrkbag1').css('color','#fff');
							$('#avgpbrkbag1').css('font-weight','bold');
							$('#avgpbrkbag1').html(jam(menit));
						} else {
							$('#avgpbrkbag1').html(jam(menit));
						}                        
                    } else if(val.PABRIK=='T1' && val.MATNR=='302'){
						if(menit > 60){
							$('#avgpbrkbulk1').css('background','#ED5565');
							$('#avgpbrkbulk1').css('color','#fff');
							$('#avgpbrkbulk1').css('font-weight','bold');
							$('#avgpbrkbulk1').html(jam(menit));
						} else {
							$('#avgpbrkbulk1').html(jam(menit));
						}
                    } else if(val.PABRIK=='T2' && val.MATNR=='301'){
						if(menit > 240){
							$('#avgpbrkbag2').css('background','#ED5565');
							$('#avgpbrkbag2').css('color','#fff');
							$('#avgpbrkbag2').css('font-weight','bold');
							$('#avgpbrkbag2').html(jam(menit));
						} else {
							$('#avgpbrkbag2').html(jam(menit));
						}
                    } else if(val.PABRIK=='T2' && val.MATNR=='302'){
						if(menit > 60){
							$('#avgpbrkbulk2').css('background','#ED5565');
							$('#avgpbrkbulk2').css('color','#fff');
							$('#avgpbrkbulk2').css('font-weight','bold');
							$('#avgpbrkbulk2').html(jam(menit));
						} else {
							$('#avgpbrkbulk2').html(jam(menit));
						}
                    } else if(val.PABRIK=='T3' && val.MATNR=='301'){
						if(menit > 240){
							$('#avgpbrkbag3').css('background','#ED5565');
							$('#avgpbrkbag3').css('color','#fff');
							$('#avgpbrkbag3').css('font-weight','bold');
							$('#avgpbrkbag3').html(jam(menit));
						} else {
							$('#avgpbrkbag3').html(jam(menit));
						}
                    } else if(val.PABRIK=='T3' && val.MATNR=='302'){
						if(menit > 60){
							$('#avgpbrkbulk3').css('background','#ED5565');
							$('#avgpbrkbulk3').css('color','#fff');
							$('#avgpbrkbulk3').css('font-weight','bold');
							$('#avgpbrkbulk3').html(jam(menit));
						} else {
							$('#avgpbrkbulk3').html(jam(menit));
						}
                    } else if(val.PABRIK=='T4' && val.MATNR=='301'){
						if(menit > 240){
							$('#avgpbrkbag4').css('background','#ED5565');
							$('#avgpbrkbag4').css('color','#fff');
							$('#avgpbrkbag4').css('font-weight','bold');
							$('#avgpbrkbag4').html(jam(menit));
						} else {
							$('#avgpbrkbag4').html(jam(menit));
						}
                    } else if(val.PABRIK=='T4' && val.MATNR=='302'){
						if(menit > 60){
							$('#avgpbrkbulk4').css('background','#ED5565');
							$('#avgpbrkbulk4').css('color','#fff');
							$('#avgpbrkbulk4').css('font-weight','bold');
							$('#avgpbrkbulk4').html(jam(menit));
						} else {
							$('#avgpbrkbulk4').html(jam(menit));
						}
                    } 
				});
            }
        })
    }
    
    function cntpbrk(){
        var url = base_url+'sg/InPlantTuban/cntpbrk';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){
                for (var i = 0; i <= 35; i++) {
                    if(data[i].MATNR=='301'){
                        if(data[i].COUNTER>0){
                            $('#bag'+data[i].LSTEL).html(data[i].COUNTER);                            
                            $('#lpbag'+data[i].LSTEL).attr('data-original-title',data[i].DESKRIPSI);
                        } else if(data[i].STATUS==0) {
							$('#lpbag'+data[i].LSTEL).attr('data-original-title','Conveyor '+data[i].LSTEL+' tidak aktif');
							$('#lpbag'+data[i].LSTEL).css('background','#fff');
							$('#lpbag'+data[i].LSTEL).css('color','#000');
						}
                    } else if(data[i].MATNR=='302'){
                        if(data[i].COUNTER>0){
                            $('#bulk'+data[i].LSTEL).html(data[i].COUNTER);
                            $('#lpbulk'+data[i].LSTEL).attr('data-original-title',data[i].DESKRIPSI);
                        } else if(data[i].STATUS==0) {
							$('#lpbulk'+data[i].LSTEL).attr('data-original-title','Conveyor '+data[i].LSTEL+' tidak aktif');
							$('#lpbulk'+data[i].LSTEL).css('background','#fff');
							$('#lpbulk'+data[i].LSTEL).css('color','#000');
						}
                    }
                }
            }
        })
    }
	
	function waktuUpdate(){
		var url = base_url+'sg/InPlantTuban/waktuUpdate';
		$.ajax({
            url:url,
            type:'post',
            dataType:'json',
            success:function(data){
                $('#waktuupdate').html(data[0].WAKTU_UPDATE);
            }
        })
	}
	
	function load_all(){
            cntCargo();
            cntTmbgn();
            avgCargo();
            avgTmbgn();
            overall();
            avgpbrk();
            cntpbrk();
			waktuUpdate();
	}
    
    $(function(){
        $('[data-toggle="tooltip"]').tooltip();
        load_all();
        setInterval(function(){
            load_all();
        }, 60000);
    });
</script>