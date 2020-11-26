<style>
    .hitam {		
        color: black;
    }
    .putih {
        color: white;
    }
    .penuh{
        position: relative;
        width: 93%;		
        padding-top:1%; 
        padding-bottom:0%;	
        left: 3%;
        overflow: hidden;	
    }
    .pinch{
        position: absolute;
        width: 100%;
        overflow: hidden;	
        top:0%;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-image: url('<?php echo base_url(); ?>assets/img/background2.png');
    }
    .pinch:before{
        content: "";
        display: block;
        padding-bottom: 54.5%;
    }
    #loading_purple {
        position:fixed;
        top:0;
        left:0;
        z-index:9999;
        text-align:center;
        width:100%;
        height:100%;
        padding-top:70px;
        font:bold 50px Calibri,Arial,Sans-Serif;
        color:#000;
        display:none;
        background-position:50%;
        min-height:100%;
        background-repeat:no-repeat;
        background-image:url('<?php echo base_url(); ?>assets/img/preloader.gif');
        background-color: #fff;
        opacity: 0.6;
    }
    .avgcargo301{
        position: absolute;
        width: 10%;
        left: 24%;
        top: 20%;
        font-weight: bold;
        overflow: hidden;
        background: #1AB394;		
        font-size: 12px;
        font-size: 1vw;	
    }
    .avgcargo301:before{
        content: "";
        display: block;
        padding-bottom: 20%;
    }
    .avgcargo308{
        position: absolute;
        width: 10%;
        left: 24%;
        top: 30%;
        font-weight: bold;
        overflow: hidden;
        background: #1AB394;
        font-size: 12px;
        font-size: 1vw;
    }
    .avgcargo308:before{
        content: "";
        display: block;
        padding-bottom: 20%;
    }
    .avgtmbgn301{
        position: absolute;
        width: 10%;
        left: 54%;
        top: 20%;
        font-weight: bold;
        overflow: hidden;
        background: #1AB394;
        font-size: 12px;
        font-size: 1vw;
    }
    .avgtmbgn301:before{
        content: "";
        display: block;
        padding-bottom: 20%;
    }
    .avgtmbgn308{
        position: absolute;
        width: 10%;
        left: 54%;
        top: 30%;
        font-weight: bold;
        overflow: hidden;
        background: #1AB394;
        font-size: 12px;
        font-size: 1vw;
    }
    .avgtmbgn308:before{
        content: "";
        display: block;
        padding-bottom: 20%;
    }
    .cntcargo301{
        position: absolute;
        width: 6%;
        left: 36%;
        top: 20%;
        overflow: hidden;
        background: #23C6C8;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
    }
    .cntcargo301:before{
        content: "";
        display: block;
        padding-bottom: 34%;
    }
    .cntcargo308{
        position: absolute;
        width: 6%;
        left: 36%;
        top: 30%;
        overflow: hidden;
        background: #23C6C8;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
    }
    .cntcargo308:before{
        content: "";
        display: block;
        padding-bottom: 34%;
    }
    .cnttmbgn301{
        position: absolute;
        width: 6%;
        left: 67%;
        top: 20%;
        overflow: hidden;
        background: #23C6C8;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
    }
    .cnttmbgn301:before{
        content: "";
        display: block;
        padding-bottom: 34%;
    }
    .cnttmbgn308{
        position: absolute;
        width: 6%;
        left: 67%;
        top: 30%;
        overflow: hidden;
        background: #23C6C8;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
    }
    .cnttmbgn308:before{
        content: "";
        display: block;
        padding-bottom: 34%;
    }
    .square-box{
        position: absolute;
        width: 10%;
        left: 25%;
        top: 20%;
        overflow: hidden;
        background: #4679BD;		
    }
    .square-box:before{
        content: "";
        display: block;
        padding-bottom: 20%;
    }
    .square-content{
        position:  absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border-color: black;
    }
    .square-content div {
        display: table;
        width: 100%;
        height: 100%;
    }
    .square-content span {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }
    .avg-bag-tuban1{
        position: absolute;
        width: 11%;
        left: 35.1%;
        top: 46%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bag-tuban1:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bag-tuban2{
        position: absolute;
        width: 11%;
        left: 49%;
        top: 46%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bag-tuban2:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bag-tuban3{
        position: absolute;
        width: 11%;
        left: 62.8%;
        top: 46%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bag-tuban3:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bag-tuban4{
        position: absolute;
        width: 11%;
        left: 76.4%;
        top: 46%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bag-tuban4:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bulk-tuban1{
        position: absolute;
        width: 11%;
        left: 35%;
        top: 74%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bulk-tuban1:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bulk-tuban2{
        position: absolute;
        width: 11%;
        left: 49%;
        top: 74%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bulk-tuban2:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bulk-tuban3{
        position: absolute;
        width: 11%;
        left: 62.9%;
        top: 74%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bulk-tuban3:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .avg-bulk-tuban4{
        position: absolute;
        width: 11%;
        left: 76.5%;
        top: 74%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 1vw;
        color: white;
    }
    .avg-bulk-tuban4:before{
        content: "";
        display: block;
        padding-bottom: 15%;
    }
    .lp-bag-tuban1{
        position: absolute;
        width: 13%;
        left: 34.3%;
        top: 49.5%;
        overflow: hidden;
    }
    .lp-bag-tuban1:before{
        content: "";
        display: block;
        padding-bottom: 81%;
    }
    .lp-bag-tuban2{
        position: absolute;
        width: 13%;
        left: 48.3%;
        top: 49.5%;
        overflow: hidden;
    }
    .lp-bag-tuban2:before{
        content: "";
        display: block;
        padding-bottom: 83%;
    }
    .lp-bag-tuban3{
        position: absolute;
        width: 13%;
        left: 62%;
        top: 49.5%;
        overflow: hidden;
    }
    .lp-bag-tuban3:before{
        content: "";
        display: block;
        padding-bottom: 81%;
    }
    .lp-bag-tuban4{
        position: absolute;
        width: 13%;
        left: 75.7%;
        top: 49.5%;
        overflow: hidden;
    }
    .lp-bag-tuban4:before{
        content: "";
        display: block;
        padding-bottom: 81%;
    }
    .lp-bulk-tuban1{
        position: absolute;
        width: 13%;
        left: 34.3%;
        top: 79%;
        overflow: hidden;
    }
    .lp-bulk-tuban1:before{
        content: "";
        display: block;
        padding-bottom: 70%;
    }
    .lp-bulk-tuban2{
        position: absolute;
        width: 13%;
        left: 48%;
        top: 79%;
        overflow: hidden;
    }
    .lp-bulk-tuban2:before{
        content: "";
        display: block;
        padding-bottom: 70%;
    }
    .lp-bulk-tuban3{
        position: absolute;
        width: 13%;
        left: 62%;
        top: 79%;
        overflow: hidden;
    }
    .lp-bulk-tuban3:before{
        content: "";
        display: block;
        padding-bottom: 70%;
    }
    .lp-bulk-tuban4{
        position: absolute;
        width: 13%;
        left: 75.7%;
        top: 79%;
        overflow: hidden;
    }
    .lp-bulk-tuban4:before{
        content: "";
        display: block;
        padding-bottom: 70%;
    }
    .waktu-siklus-bag{
        position: absolute;
        width: 10%;
        left: 17%;
        top: 57.3%;		
        overflow: hidden;
        background: #1AB394;
        font-weight: bold;
        font-size: 11px;
        font-size: 0.95vw;
        color: white;
    }
    .waktu-siklus-bag:before{
        content: "";
        display: block;
        padding-bottom: 17%;
    }
    .waktu-siklus-bulk{
        position: absolute;
        width: 10%;
        left: 17%;
        top: 77.7%;		
        overflow: hidden;
        background: #1AB394;
        font-weight: bold;
        font-size: 12px;
        font-size: 0.95vw;
        color: white;
    }
    .waktu-siklus-bulk:before{
        content: "";
        display: block;
        padding-bottom: 17%;
    }
    .overall-bag{
        position: absolute;
        width: 10%;
        left: 17%;
        top: 61.3%;
        overflow: hidden;
    }
    .overall-bag:before{
        content: "";
        display: block;
        padding-bottom: 108%;
    }
    .ovr-bag{
        position: relative;
        float: left;
        display: block;		
        width: 100%;
        margin-bottom: 4.5%;
        background: #23C6C8;
        font-weight: bold;
        font-size: 12px;
        font-size: 0.95vw;
        color: white;
    }
    .ovr-bag:before{
        content: "";
        display: block;
        padding-bottom: 1%;
    }
    .overall-bulk{
        position: absolute;	
        width: 10%;
        left: 17%;
        top: 81.8%;
        overflow: hidden;
    }
    .overall-bulk:before{
        content: "";
        display: block;
        padding-bottom: 108%;
    }
    .ovr-bulk{
        position: relative;
        float: left;
        display: block;		
        width: 100%;
        margin-bottom: 5%;
        color: white;
        background: #23C6C8;
        font-weight: bold;
        font-size: 12px;
        font-size: 0.95vw;
    }
    .ovr-bulk:before{
        content: "";
        display: block;
        padding-bottom: 1%;
    }
    .subtotal-bag{
        position: absolute;
        width: 10%;
        left: 17%;
        top: 73.6%;		
        overflow: hidden;
        background: #1AB394;
        font-weight: bold;
        font-size: 12px;
        font-size: 0.95vw;
        color: white;
    }
    .subtotal-bag:before{
        content: "";
        display: block;
        padding-bottom: 16%;
    }
    .subtotal-bulk{
        position: absolute;
        width: 10%;
        left: 17%;
        top: 90.3%;		
        overflow: hidden;
        background: #1AB394;
        font-weight: bold;
        font-size: 12px;
        font-size: 0.95vw;
        color: white;
    }
    .subtotal-bulk:before{
        content: "";
        display: block;
        padding-bottom: 17%;
    }
    .overall-total{
        position: absolute;
        width: 10%;
        left: 17%;
        top: 94.6%;		
        overflow: hidden;
        background: #1C84C6;
        font-weight: bold;
        font-size: 12px;
        font-size: 0.95vw;
        color: white;
    }
    .overall-total:before{
        content: "";
        display: block;
        padding-bottom: 17%;
    }
    .grafik{
        position: absolute;
        width: 9%;
        left: 1%;
        top: 53%;
        background: white;
        overflow: hidden;
    }
    .grafik a{
        font-weight: bold;
        font-size: 12px;
        font-size: 0.9vw;
        color: black;
        width: 100%;
    }
    .grafik:before{
        content: "";
        display: block;
        padding-bottom: 24%;
    }
    .klik a{
        color: black;
    }
    .update{
        position: absolute;
        width: 15%;
        left: 1%;
        top: 11%;
        font-weight: bold;
        overflow: hidden;		
        font-size: 12px;
        font-size: 1vw;	
        color: black;
    }
    .update:before{
        content: "";
        display: block;
        padding-bottom: 30%;
    }
    .sisaso{
        position: absolute;
        width: 15%;
        left: 1%;
        top: 19%;
        font-weight: bold;
        overflow: hidden;		
        font-size: 12px;
        font-size: 0.9vw;	
        color: black;
        text-align: left;
    }
    .sisaso:before{
        content: "";
        display: block;
        padding-bottom: 30%;
    }
</style>
<link href="<?php echo base_url(); ?>assets/css/loadingpoint.css" rel="stylesheet">
<div id="loading_purple"></div>
<div class="row">
    <div class="penuh">
        <div class="pinch">
            <div class="update">
                <div class="square-content">
                    <div>
                        <span>
                            Waktu Update <br/>
                            <div id="waktuupdate">00-00-0000 00:00:00</div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="sisaso">
                <div class="square-content">
                    <div>
                        <span style="text-align: left">
                            <div id="sisaso"></div>    
                        </span>
                    </div>
                </div>
            </div>
            <div class="cargo">
                <div class='avgcargo301'>
                    <div class='square-content'><div class="putih"><span id="avgcargo301">00:00 jam</span></div></div>
                </div>
                <div class="avgcargo308">
                    <div class="square-content"><div class="putih"><span id="avgcargo308">00:00 jam</span></div></div>
                </div>
                <div class="cntcargo301 klik">
                    <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailTruk/0" >
                        <div class="square-content"><div class="putih"><span id="cntcargo301">00 unit</span></div></div>
                    </a>
                </div>
                <div class="cntcargo308 klik">
                    <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailTruk/1">
                        <div class="square-content"><div class="putih"><span id="cntcargo308">00 unit</span></div></div>
                    </a>
                </div>
            </div>
            <div class="timbang">
                <div class="avgtmbgn301">
                    <div class="square-content"><div class="putih"><span id="avgtmbgn301">00:00 jam</span></div></div>
                </div>
                <div class="avgtmbgn308">
                    <div class="square-content"><div class="putih"><span id="avgtmbgn308">00:00 jam</span></div></div>
                </div>
                <div class="cnttmbgn301 klik">
                    <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailTruk/2">
                        <div class="square-content"><div class="putih"><span id="cnttmbgn301">00 unit</span></div></div>
                    </a>
                </div>
                <div class="cnttmbgn308 klik">
                    <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailTruk/3">
                        <div class="square-content"><div class="putih"><span id="cnttmbgn308">00 unit</span></div></div>
                    </a>
                </div>
            </div>
            <div class="loading-point">
                <div class="avg-bag-tuban1">
                    <div class="square-content">
                        <div><span id="avgpbrkbag1">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban1">
                    <div class="c1">
                        <div class="square-content"><div><span id="lpbag1">C1</span></div></div>
                    </div>
                    <div class="c1-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/1">
                            <div class="square-content"><div><span id="bag1">0</span></div></div>
                        </a>
                    </div>
                    <div class="c2">
                        <div class="square-content"><div><span id="lpbag2">C2</span></div></div>
                    </div>
                    <div class="c2-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/2">
                            <div class="square-content"><div><span id="bag2">0</span></div></div>
                        </a>
                    </div>
                    <div class="c3">
                        <div class="square-content"><div><span id="lpbag3">C3</span></div></div>
                    </div>
                    <div class="c3-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/3">
                            <div class="square-content"><div><span id="bag3">0</span></div></div>
                        </a>
                    </div>
                    <div class="c4">
                        <div class="square-content"><div><span id="lpbag4">C4</span></div></div>
                    </div>
                    <div class="c4-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/4">
                            <div class="square-content"><div><span id="bag4">0</span></div></div>
                        </a>
                    </div>
                    <div class="c5">
                        <div class="square-content"><div><span id="lpbag5">C5</span></div></div>
                    </div>
                    <div class="c5-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/5">
                            <div class="square-content"><div><span id="bag5">0</span></div></div>
                        </a>
                    </div>
                    <div class="c6">
                        <div class="square-content"><div><span id="lpbag6">C6</span></div></div>
                    </div>
                    <div class="c6-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/6">
                            <div class="square-content"><div><span id="bag6">0</span></div></div>
                        </a>
                    </div>
                    <div class="c7">
                        <div class="square-content"><div><span id="lpbag7">C7</span></div></div>
                    </div>
                    <div class="c7-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/7">
                            <div class="square-content"><div><span id="bag7">0</span></div></div>
                        </a>
                    </div>
                    <div class="c8">
                        <div class="square-content"><div><span id="lpbag8">C8</span></div></div>
                    </div>	
                    <div class="c8-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/8">
                            <div class="square-content"><div><span id="bag8">0</span></div></div>
                        </a>
                    </div>
                </div>			
                <div class="avg-bag-tuban2">
                    <div class="square-content">
                        <div><span id="avgpbrkbag2">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban2">
                    <div class="c11">
                        <div class="square-content"><div><span id="lpbag11">C11</span></div></div>
                    </div>
                    <div class="c11-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/11">
                            <div class="square-content"><div><span id="bag11">0</span></div></div>
                        </a>
                    </div>	
                    <div class="c12">
                        <div class="square-content"><div><span id="lpbag12">C12</span></div></div>
                    </div>
                    <div class="c12-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/12">
                            <div class="square-content"><div><span id="bag12">0</span></div></div>
                        </a>
                    </div>
                    <div class="c13">
                        <div class="square-content"><div><span id="lpbag13">C13</span></div></div>
                    </div>
                    <div class="c13-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/13">
                            <div class="square-content"><div><span id="bag13">0</span></div></div>
                        </a>
                    </div>
                    <div class="c14">
                        <div class="square-content"><div><span id="lpbag14">C14</span></div></div>
                    </div>
                    <div class="c14-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/14">
                            <div class="square-content"><div><span id="bag14">0</span></div></div>
                        </a>
                    </div>
                    <div class="c15">
                        <div class="square-content"><div><span id="lpbag15">C15</span></div></div>
                    </div>
                    <div class="c15-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/15">
                            <div class="square-content"><div><span id="bag15">0</span></div></div>
                        </a>
                    </div>
                    <div class="c16">
                        <div class="square-content"><div><span id="lpbag16">C16</span></div></div>
                    </div>
                    <div class="c16-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/16">
                            <div class="square-content"><div><span id="bag16">0</span></div></div>
                        </a>
                    </div>
                    <div class="c17">
                        <div class="square-content"><div><span id="lpbag17">C17</span></div></div>
                    </div>
                    <div class="c17-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/17">
                            <div class="square-content"><div><span id="bag17">0</span></div></div>
                        </a>
                    </div>	
                    <div class="c18">
                        <div class="square-content"><div><span id="lpbag18">C18</span></div></div>
                    </div>
                    <div class="c18-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/18">
                            <div class="square-content"><div><span id="bag18">0</span></div></div>
                        </a>
                    </div>
                    <div class="c19">
                        <div class="square-content"><div><span id="lpbag19">C19</span></div></div>
                    </div>
                    <div class="c19-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/19">
                            <div class="square-content"><div><span id="bag19">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bag-tuban3">
                    <div class="square-content">
                        <div><span id="avgpbrkbag3">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban3">
                    <div class="c21">
                        <div class="square-content"><div><span id="lpbag21">C21</span></div></div>
                    </div>
                    <div class="c21-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/21">
                            <div class="square-content"><div><span id="bag21">0</span></div></div>
                        </a>
                    </div>
                    <div class="c22">
                        <div class="square-content"><div><span id="lpbag22">C22</span></div></div>
                    </div>
                    <div class="c22-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/22">
                            <div class="square-content"><div><span id="bag22">0</span></div></div>
                        </a>
                    </div>	
                    <div class="c23">
                        <div class="square-content"><div><span id="lpbag23">C23</span></div></div>
                    </div>
                    <div class="c23-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/23">
                            <div class="square-content"><div><span id="bag23">0</span></div></div>
                        </a>
                    </div>
                    <div class="c24">
                        <div class="square-content"><div><span id="lpbag24">C24</span></div></div>
                    </div>
                    <div class="c24-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/24">
                            <div class="square-content"><div><span id="bag24">0</span></div></div>
                        </a>
                    </div>
                    <div class="c25">
                        <div class="square-content"><div><span id="lpbag25">C25</span></div></div>
                    </div>
                    <div class="c25-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/25">
                            <div class="square-content"><div><span id="bag25">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bag-tuban4">
                    <div class="square-content">
                        <div><span id="avgpbrkbag4">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban4">
                    <div class="c31">
                        <div class="square-content"><div><span id="lpbag31">C31</span></div></div>
                    </div>
                    <div class="c31-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/31">
                            <div class="square-content"><div><span id="bag31">0</span></div></div>
                        </a>
                    </div>	
                    <div class="c32">
                        <div class="square-content"><div><span id="lpbag32">C32</span></div></div>
                    </div>
                    <div class="c32-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/32">
                            <div class="square-content"><div><span id="bag32">0</span></div></div>
                        </a>
                    </div>
                    <div class="c33">
                        <div class="square-content"><div><span id="lpbag33">C33</span></div></div>
                    </div>
                    <div class="c33-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/33">
                            <div class="square-content"><div><span id="bag33">0</span></div></div>
                        </a>
                    </div>
                    <div class="c34">
                        <div class="square-content"><div><span id="lpbag34">C34</span></div></div>
                    </div>
                    <div class="c34-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/34">
                            <div class="square-content"><div><span id="bag34">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bulk-tuban1">
                    <div class="square-content">
                        <div><span id="avgpbrkbulk1">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban1">
                    <div class="c80">
                        <div class="square-content"><div><span id="lpbulk80">C80</span></div></div>
                    </div>
                    <div class="c80-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/80">
                            <div class="square-content"><div><span id="bulk80">0</span></div></div>
                        </a>
                    </div>	
                    <div class="c90">
                        <div class="square-content"><div><span id="lpbulk90">C90</span></div></div>
                    </div>							
                    <div class="c90-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/90">
                            <div class="square-content"><div><span id="bulk90">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bulk-tuban2">
                    <div class="square-content">
                        <div><span id="avgpbrkbulk2">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban2">
                    <div class="c81">
                        <div class="square-content"><div><span id="lpbulk81">C81</span></div></div>
                    </div>
                    <div class="c81-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/81">
                            <div class="square-content"><div><span id="bulk81">0</span></div></div>
                        </a>
                    </div>
                    <div class="c91">
                        <div class="square-content"><div><span id="lpbulk91">C91</span></div></div>
                    </div>				
                    <div class="c91-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/91">
                            <div class="square-content"><div><span id="bulk91">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bulk-tuban3">
                    <div class="square-content">
                        <div><span id="avgpbrkbulk3">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban3">
                    <div class="c82">
                        <div class="square-content"><div><span id="lpbulk82">C82</span></div></div>
                    </div>
                    <div class="c82-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/82">
                            <div class="square-content"><div><span id="bulk82">0</span></div></div>
                        </a>
                    </div>	
                    <div class="c92">
                        <div class="square-content"><div><span id="lpbulk92">C92</span></div></div>
                    </div>			
                    <div class="c92-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/92">
                            <div class="square-content"><div><span id="bulk92">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bulk-tuban4">
                    <div class="square-content">
                        <div><span id="avgpbrkbulk4">00:00 jam</span></div>
                    </div>				
                </div>
                <div class="tuban4">
                    <div class="c84">
                        <div class="square-content"><div><span id="lpbulk84">C84</span></div></div>
                    </div>
                    <div class="c84-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/84">
                            <div class="square-content"><div><span id="bulk84">0</span></div></div>
                        </a>
                    </div>
                    <div class="c94">
                        <div class="square-content"><div><span id="lpbulk94">C94</span></div></div>
                    </div>				
                    <div class="c94-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailConveyor/94">
                            <div class="square-content"><div><span id="bulk94">0</span></div></div>
                        </a>
                    </div>
                </div>	
            </div>
            <div class="overall">
                <div class="waktu-siklus-bag">
                    <div class="square-content">
                        <div>
                            <span id="waktusiklusbag">00:00 jam</span>
                        </div>
                    </div>
                </div>
                <div class="overall-bag">
                    <div class="square-content">
                        <div>
                            <span class="ovr-bag" id="gudangdist">0000</span>
                            <span class="ovr-bag" id="gudangda">0000</span>
                            <span class="ovr-bag" id="gudangsg">0000</span>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailTonase/bag">
                    <div class="subtotal-bag klik">				
                        <div class="square-content">
                            <div>
                                <span id="bagsubtotal">0000</span>
                            </div>
                        </div>				
                    </div>
                </a>
                <div class="waktu-siklus-bulk">
                    <div class="square-content">
                        <div>
                            <span id="waktusiklusbulk">00:00 jam</span>
                        </div>
                    </div>
                </div>
                <div class="overall-bulk">
                    <div class="square-content">
                        <div>
                            <span class="ovr-bulk" id="port">0000</span>
                            <span class="ovr-bulk" id="lokal">0000</span>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>sg/InPlantTuban/detailTonase/bulk">
                    <div class="subtotal-bulk klik">				
                        <div class="square-content">
                            <div>
                                <span id="bulksubtotal">0000</span>
                            </div>
                        </div>				
                    </div>
                </a>
                <div class="overall-total">
                    <div class="square-content">
                        <div>
                            <span id="total">0000</span>
                        </div>
                    </div>
                </div>
            </div>		
            <div class="grafik">
                <a href="<?php echo base_url(); ?>sg/InPlantTuban/grafikLaporan">
                    <div class="square-content">
                        <div>
                            <span><i class="fa fa-line-chart"></i>  Grafik</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>	
</div>
<script>
    function jam(menit) {
        var detik = menit * 60;
        var jam = parseInt(detik / 3600);
        var sisa = detik % 3600;
        var menit = parseInt(sisa / 60);
        var hasil = '';
        if (jam.toString().length === 1) {
            hasil += '0' + jam;
        } else if (isNaN(jam)) {
            hasil += '00';
        } else {
            hasil += jam;
        }
        hasil += ':';
        if (menit.toString().length === 1) {
            hasil += '0' + menit;
        } else if (isNaN(menit)) {
            hasil += '00';
        } else {
            hasil += menit;
        }
        hasil += ' jam';
        return hasil;
    }

    function titleavgcargo(truk, waktu, status) {
        var titleavgcargo = "<center style='font-size:14px;font-weight:bold;'>Waktu tunggu truk " + truk + " dicargo, mulai truk masuk gerbang cargo s/d mendapatkan nomor konveyor<br/><br/>" +
                "Standar Waktu Maksimal :<br/>" +
                waktu + " Menit<br/><br/>" +
                "Kargo " + status + " melebihi standar waktu" +
                "</center>";
        return titleavgcargo;
    }

    function avgCargo(data) {
        if (data['avgCargo'][0].AVERAGE.replace(',', '.') > 240) {
            $('#avgcargo301').css('background', 'red');
            $('#avgcargo301').html(jam(data['avgCargo'][0].AVERAGE.replace(',', '.')));
            $('.avgcargo301').tooltip({title: titleavgcargo('zak', '240', 'telah'), html: true, placement: 'left'});
        } else {
            $('#avgcargo301').html(jam(data['avgCargo'][0].AVERAGE.replace(',', '.')));
            $('.avgcargo301').tooltip({title: titleavgcargo('zak', '240', 'tidak'), html: true, placement: 'left'});
        }

        if (data['avgCargo'][1].AVERAGE.replace(',', '.') > 120) {
            $('#avgcargo308').css('background', 'red');
            $('#avgcargo308').html(jam(data['avgCargo'][1].AVERAGE.replace(',', '.')));
            $('.avgcargo308').tooltip({title: titleavgcargo('bulk', '120', 'telah'), html: true, placement: 'left'});
        } else {
            $('#avgcargo308').html(jam(data['avgCargo'][1].AVERAGE.replace(',', '.')));
            $('.avgcargo308').tooltip({title: titleavgcargo('bulk', '120', 'tidak'), html: true, placement: 'left'});
        }
    }

    function titleavgtmbgn(truk, waktu, status) {
        var titleavgtmbgn = "<center style='font-size:14px;font-weight:bold;'>Waktu tunggu truk " + truk + ", mulai truk mendapatkan nomor konveyor s/d truk timbang masuk<br/><br/>" +
                "Standar Waktu Maksimal :<br/>" +
                waktu + " Menit<br/><br/>" +
                "Antri Timbang Masuk " + status + " melebihi standar waktu" +
                "</center>";
        return titleavgtmbgn;
    }
    function avgTmbgn(data) {
        if (data['avgTmbgn'][0].AVERAGE.replace(',', '.') > 30) {
            $('#avgtmbgn301').css('background', 'red');
            $('#avgtmbgn301').html(jam(data['avgTmbgn'][0].AVERAGE.replace(',', '.')));
            $('.avgtmbgn301').tooltip({title: titleavgtmbgn('zak', '30', 'telah'), html: true, placement: 'left'});
        } else {
            $('#avgtmbgn301').html(jam(data['avgTmbgn'][0].AVERAGE.replace(',', '.')));
            $('.avgtmbgn301').tooltip({title: titleavgtmbgn('zak', '30', 'tidak'), html: true, placement: 'left'});
        }
        if (data['avgTmbgn'][1].AVERAGE.replace(',', '.') > 30) {
            $('#avgtmbgn308').css('background', 'red');
            $('#avgtmbgn308').html(jam(data['avgTmbgn'][1].AVERAGE.replace(',', '.')));
            $('.avgtmbgn308').tooltip({title: titleavgtmbgn('bulk', '30', 'telah'), html: true, placement: 'left'});
        } else {
            $('#avgtmbgn308').html(jam(data['avgTmbgn'][1].AVERAGE.replace(',', '.')));
            $('.avgtmbgn308').tooltip({title: titleavgtmbgn('bulk', '30', 'tidak'), html: true, placement: 'left'});
        }
    }

    function cntCargo(data) {
        $('#cntcargo301').html(data['cntCargo'][0].JUML_TRUCK + ' unit');
        $('#cntcargo308').html(data['cntCargo'][1].JUML_TRUCK + ' unit');
    }

    function cntTmbgn(data) {
        $('#cnttmbgn301').html(data['cntTmbgn'][1].JUML_TRUCK + ' unit');
        $('#cnttmbgn308').html(data['cntTmbgn'][0].JUML_TRUCK + ' unit');
    }

    function titleavgpbrk(semen, pbrk, waktu, status) {
        var titleavgtmbgn = "<center style='font-size:14px;font-weight:bold;'>Waktu pemuatan semen " + semen + " di " + pbrk + " mulai truk timbang masuk s/d timbang keluar<br/><br/>" +
                "Standar Waktu Maksimal :<br/>" +
                waktu + " Menit<br/><br/>" +
                "Pabrik " + pbrk + " " + status + " melebihi standar waktu" +
                "</center>";
        return titleavgtmbgn;
    }

    function avgPbrk(data) {
        var titleBag1;
        var titleBag2;
        var titleBag3;
        var titleBag4;
        var titleBulk1;
        var titleBulk2;
        var titleBulk3;
        var titleBulk4;
        titleBag1 = titleavgpbrk('zak', 'Tuban 1', '240', 'tidak');
        titleBag2 = titleavgpbrk('zak', 'Tuban 2', '240', 'tidak');
        titleBag3 = titleavgpbrk('zak', 'Tuban 3', '240', 'tidak');
        titleBag4 = titleavgpbrk('zak', 'Tuban 4', '240', 'tidak');
        titleBulk1 = titleavgpbrk('curah', 'Tuban 1', '60', 'tidak');
        titleBulk2 = titleavgpbrk('curah', 'Tuban 2', '60', 'tidak');
        titleBulk3 = titleavgpbrk('curah', 'Tuban 3', '60', 'tidak');
        titleBulk4 = titleavgpbrk('curah', 'Tuban 4', '60', 'tidak');

        $.each(data['avgPbrk'], function (key, val) {
            var menit = val.AVERAGE.replace(',', '.');

            if (val.PABRIK == 'T1' && val.MATNR == '301') {
                if (menit > 240) {
                    $('#avgpbrkbag1').css('background', 'red');
                    $('#avgpbrkbag1').css('color', '#fff');
                    $('#avgpbrkbag1').css('font-weight', 'bold');
                    $('#avgpbrkbag1').html(jam(menit));
                    titleBag1 = titleavgpbrk('zak', 'Tuban 1', '240', 'telah');
                } else {
                    $('#avgpbrkbag1').html(jam(menit));
                }
            } else if (val.PABRIK == 'T1' && val.MATNR == '302') {
                if (menit > 60) {
                    $('#avgpbrkbulk1').css('background', 'red');
                    $('#avgpbrkbulk1').css('color', '#fff');
                    $('#avgpbrkbulk1').css('font-weight', 'bold');
                    $('#avgpbrkbulk1').html(jam(menit));
                    titleBulk1 = titleavgpbrk('curah', 'Tuban 1', '60', 'telah');
                } else {
                    $('#avgpbrkbulk1').html(jam(menit));
                }
            } else if (val.PABRIK == 'T2' && val.MATNR == '301') {
                if (menit > 240) {
                    $('#avgpbrkbag2').css('background', 'red');
                    $('#avgpbrkbag2').css('color', '#fff');
                    $('#avgpbrkbag2').css('font-weight', 'bold');
                    $('#avgpbrkbag2').html(jam(menit));
                    titleBag2 = titleavgpbrk('zak', 'Tuban 2', '240', 'telah');
                } else {
                    $('#avgpbrkbag2').html(jam(menit));
                }
            } else if (val.PABRIK == 'T2' && val.MATNR == '302') {
                if (menit > 60) {
                    $('#avgpbrkbulk2').css('background', 'red');
                    $('#avgpbrkbulk2').css('color', '#fff');
                    $('#avgpbrkbulk2').css('font-weight', 'bold');
                    $('#avgpbrkbulk2').html(jam(menit));
                    titleBulk2 = titleavgpbrk('curah', 'Tuban 2', '60', 'telah');
                } else {
                    $('#avgpbrkbulk2').html(jam(menit));
                }
            } else if (val.PABRIK == 'T3' && val.MATNR == '301') {
                if (menit > 240) {
                    $('#avgpbrkbag3').css('background', 'red');
                    $('#avgpbrkbag3').css('color', '#fff');
                    $('#avgpbrkbag3').css('font-weight', 'bold');
                    $('#avgpbrkbag3').html(jam(menit));
                    titleBag3 = titleavgpbrk('zak', 'Tuban 3', '240', 'telah');
                } else {
                    $('#avgpbrkbag3').html(jam(menit));
                }
            } else if (val.PABRIK == 'T3' && val.MATNR == '302') {
                if (menit > 60) {
                    $('#avgpbrkbulk3').css('background', 'red');
                    $('#avgpbrkbulk3').css('color', '#fff');
                    $('#avgpbrkbulk3').css('font-weight', 'bold');
                    $('#avgpbrkbulk3').html(jam(menit));
                    titleBulk3 = titleavgpbrk('curah', 'Tuban 3', '60', 'telah');
                } else {
                    $('#avgpbrkbulk3').html(jam(menit));
                }
            } else if (val.PABRIK == 'T4' && val.MATNR == '301') {
                if (menit > 240) {
                    $('#avgpbrkbag4').css('background', 'red');
                    $('#avgpbrkbag4').css('color', '#fff');
                    $('#avgpbrkbag4').css('font-weight', 'bold');
                    $('#avgpbrkbag4').html(jam(menit));
                    titleBag4 = titleavgpbrk('zak', 'Tuban 4', '240', 'telah');
                } else {
                    $('#avgpbrkbag4').html(jam(menit));
                }
            } else if (val.PABRIK == 'T4' && val.MATNR == '302') {
                if (menit > 60) {
                    $('#avgpbrkbulk4').css('background', 'red');
                    $('#avgpbrkbulk4').css('color', '#fff');
                    $('#avgpbrkbulk4').css('font-weight', 'bold');
                    $('#avgpbrkbulk4').html(jam(menit));
                    titleBulk4 = titleavgpbrk('curah', 'Tuban 4', '60', 'telah');
                } else {
                    $('#avgpbrkbulk4').html(jam(menit));
                }
            }
        });
        $('.avg-bag-tuban1').tooltip({title: titleBag1, html: true, placement: 'top'});
        $('.avg-bag-tuban2').tooltip({title: titleBag2, html: true, placement: 'top'});
        $('.avg-bag-tuban3').tooltip({title: titleBag3, html: true, placement: 'top'});
        $('.avg-bag-tuban4').tooltip({title: titleBag4, html: true, placement: 'top'});
        $('.avg-bulk-tuban1').tooltip({title: titleBulk1, html: true, placement: 'top'});
        $('.avg-bulk-tuban2').tooltip({title: titleBulk2, html: true, placement: 'top'});
        $('.avg-bulk-tuban3').tooltip({title: titleBulk3, html: true, placement: 'top'});
        $('.avg-bulk-tuban4').tooltip({title: titleBulk4, html: true, placement: 'top'});
    }

    function titlelp(no, aktif, deskripsi) {
        var titlelp = "<center style='font-size:14px;font-weight:bold;'>Conveyor " + no + " " + aktif + " Aktif<br/><br/>" +
                deskripsi +
                "</center>";
        return titlelp;
    }

    function cntPbrk(data) {
        $.each(data['cntPbrk'], function (key, val) {
            if (val.MATNR == '301') {
                if (val.COUNTER > 0) {
                    $('#bag' + val.LSTEL).html(val.COUNTER);
                }
                if (val.STATUS == 0) {
                    $('#lpbag' + val.LSTEL).css('background', '#fff');
                    $('#lpbag' + val.LSTEL).css('color', '#000');
                    $('.c' + val.LSTEL).tooltip({title: titlelp(val.LSTEL, 'Tidak', ''), html: true});
                } else {
                    $('.c' + val.LSTEL).tooltip({title: titlelp(val.LSTEL, '', val.DESKRIPSI), html: true});
                }
            } else if (val.MATNR == '302') {
                if (val.COUNTER > 0) {
                    $('#bulk' + val.LSTEL).html(val.COUNTER);
                }
                if (val.STATUS == 0) {
                    $('#lpbulk' + val.LSTEL).css('background', '#fff');
                    $('#lpbulk' + val.LSTEL).css('color', '#000');
                    $('.c' + val.LSTEL).tooltip({title: titlelp(val.LSTEL, 'Tidak', ''), html: true});
                } else {
                    $('.c' + val.LSTEL).tooltip({title: titlelp(val.LSTEL, '', val.DESKRIPSI), html: true});
                }
            }
        });
    }

    function waktuUpdate(data) {
        $('#waktuupdate').html(data['waktuUpdate'][0].WAKTU_UPDATE);
    }

    function formatAngka(n) {
        var num = parseInt(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }

    function tooltip() {
        var klik = "<center style='font-size:14px;font-weight:bold;'>Klik untuk detail truk</center>";
        $('.klik').tooltip({title: klik, html: true});
    }

    function overall(data) {
        var bagsubtotal = 0;
        var bulksubtotal = 0;
        $('#gudangdist').html(formatAngka(data['overall']['BAG']['DIST']));
        $('#gudangda').html(formatAngka(data['overall']['BAG']['DA']));
        $('#gudangsg').html(formatAngka(data['overall']['BAG']['SG']));

        bagsubtotal = data['overall']['BAG']['DIST'] + data['overall']['BAG']['DA'] + data['overall']['BAG']['SG'];

        $('#bagsubtotal').html(formatAngka(bagsubtotal));

        $('#port').html(formatAngka(data['overall']['BULK']['PORT']));
        $('#lokal').html(formatAngka(data['overall']['BULK']['LOKAL']));

        bulksubtotal = data['overall']['BULK']['PORT'] + data['overall']['BULK']['LOKAL'];

        $('#bulksubtotal').html(formatAngka(bulksubtotal));
        $('#total').html(formatAngka(bagsubtotal + bulksubtotal));
    }

    function titleoverall(truk, waktu, status) {
        var titleavgtmbgn = "<center style='font-size:14px;font-weight:bold;'>Rata-rata waktu siklus truk " + truk + "<br/><br/>" +
                "Standar Waktu Maksimal :<br/>" +
                waktu + " Jam<br/><br/>" +
                "Rata-rata Waktu Siklus " + status + " melebihi standar waktu" +
                "</center>";
        return titleavgtmbgn;
    }

    function avgOverall(data) {
        if (data['avgOverall'][0].AVERAGE.replace(',', '.') > 510) {
            $('#waktusiklusbag').css('background', 'red');
            $('#waktusiklusbag').html(jam(data['avgOverall'][0].AVERAGE.replace(',', '.')));
            $('.waktu-siklus-bag').tooltip({title: titleoverall('zak', '8.5', 'telah'), html: true, placement: 'right'});
        } else {
            $('#waktusiklusbag').html(jam(data['avgOverall'][0].AVERAGE.replace(',', '.')));
            $('.waktu-siklus-bag').tooltip({title: titleoverall('zak', '8.5', 'tidak'), html: true, placement: 'right'});
        }
        if (data['avgOverall'][1].AVERAGE.replace(',', '.') > 210) {
            $('#waktusiklusbulk').css('background', 'red');
            $('#waktusiklusbulk').html(jam(data['avgOverall'][1].AVERAGE.replace(',', '.')));
            $('.waktu-siklus-bulk').tooltip({title: titleoverall('bulk', '3.5', 'telah'), html: true, placement: 'right'});
        } else {
            $('#waktusiklusbulk').html(jam(data['avgOverall'][1].AVERAGE.replace(',', '.')));
            $('.waktu-siklus-bulk').tooltip({title: titleoverall('bulk', '3.5', 'telah'), html: true, placement: 'right'});
        }
    }

    function sisaSO(data) {
        var sisaso = 'Sisa SO Bag  : '+formatAngka(data['sisaSO'][0].SISA_BAG) + ' TON<br/>'+
                     'Sisa SO Bulk : '+ formatAngka(data['sisaSO'][0].SISA_BULK) + ' TON';
        $('#sisaso').html(sisaso);
    }

    function loadAll() {
        var url = base_url + 'sg/InPlantTuban/load';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                avgCargo(data);
                avgTmbgn(data);
                cntCargo(data);
                cntTmbgn(data);
                avgPbrk(data);
                cntPbrk(data);
                overall(data);
                avgOverall(data);
                waktuUpdate(data);
                tooltip();
                sisaSO(data);
                $('#loading_purple').hide();
            }
        });
    }

    $(function () {
        loadAll();
        $('.pinch').each(function () {
            new RTP.PinchZoom($(this), {});
        });
    });
</script>