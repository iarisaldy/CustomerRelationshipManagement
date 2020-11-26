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
        background-image: url('<?php echo base_url(); ?>assets/img/background_rembang.png');
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
        left: 56%;
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
        left: 56%;
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
    .con01{
        position: absolute;
        width: 5%;
        color: black;
        top: 50%;
        left: 41%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con01:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con01-val{
        position: absolute;
        width: 5%;
        top: 57.4%;
        left: 41%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con01-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con02{
        position: absolute;
        width: 5%;
        color: black;
        top: 50%;
        left: 53%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con02:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con02-val{
        position: absolute;
        width: 5%;
        top: 57.4%;
        left: 53%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con02-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con03{
        position: absolute;
        width: 5%;
        color: black;
        top: 50%;
        left: 65%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con03:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con03-val{
        position: absolute;
        width: 5%;
        top: 57.4%;
        left: 65%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con03-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con04{
        position: absolute;
        width: 5%;
        color: black;
        top: 50%;
        left: 77%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con04:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con04-val{
        position: absolute;
        width: 5%;
        top: 57.4%;
        left: 77%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con04-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con11{
        position: absolute;
        width: 2%;
        color: black;
        top: 50%;
        left: 65%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con11:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con11-val{
        position: absolute;
        width: 2%;
        top: 52.8%;
        left: 65%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con11-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con12{
        position: absolute;
        width: 2%;
        color: black;
        top: 50%;
        left: 68%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con12:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con12-val{
        position: absolute;
        width: 2%;
        top: 52.8%;
        left: 68%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con12-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con80{
        position: absolute;
        width: 2%;
        color: black;
        top: 80%;
        left: 60.5%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con80:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con80-val{
        position: absolute;
        width: 2%;
        top: 82.8%;
        left: 60.5%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con80-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con90{
        position: absolute;
        width: 5%;
        color: black;
        top: 80%;
        left: 41%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con90:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con90-val{
        position: absolute;
        width: 5%;
        top: 87.4%;
        left: 41%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con90-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con91{
        position: absolute;
        width: 5%;
        color: black;
        top: 80%;
        left: 53%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con91:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con91-val{
        position: absolute;
        width: 5%;
        top: 87.4%;
        left: 53%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con91-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con92{
        position: absolute;
        width: 5%;
        color: black;
        top: 80%;
        left: 65%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con92:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con92-val{
        position: absolute;
        width: 5%;
        top: 87.4%;
        left: 65%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con92-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con97{
        position: absolute;
        width: 5%;
        color: black;
        top: 80%;
        left: 77%;
        background: #2bef25;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con97:before{
        content: "";
        display: block;
        padding-bottom: 80%;
    }
    .con97-val{
        position: absolute;
        width: 5%;
        top: 87.4%;
        left: 77%;
        color: black;
        background: #80DFFF;
        font-size: 11px;
        font-size: 0.8vw;
        font-weight: bold;
    }
    .con97-val:before{
        content: "";
        display: block;
        padding-bottom: 80%;
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
                    <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailTruk/0">
                        <div class="square-content"><div class="putih"><span id="cntcargo301">00 unit</span></div></div>
                    </a>
                </div>
                <div class="cntcargo308 klik">
                    <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailTruk/1">
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
                    <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailTruk/2">
                        <div class="square-content"><div class="putih"><span id="cnttmbgn301">00 unit</span></div></div>
                    </a>
                </div>
                <div class="cnttmbgn308 klik">
                    <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailTruk/3">
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
                    <div class="con01">
                        <div class="square-content"><div><span id="lpbag01" style="font-size: 15px;">C1</span></div></div>
                    </div>
                    <div class="con01-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/01">
                            <div class="square-content"><div><span id="bag1" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                    <div class="con02">
                        <div class="square-content"><div><span id="lpbag02" style="font-size: 15px;">C2</span></div></div>
                    </div>
                    <div class="con02-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/02">
                            <div class="square-content"><div><span id="bag02" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                    <div class="con03">
                        <div class="square-content"><div><span id="lpbag03" style="font-size: 15px;">C3</span></div></div>
                    </div>
                    <div class="con03-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/03">
                            <div class="square-content"><div><span id="bag03" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                    <div class="con04">
                        <div class="square-content"><div><span id="lpbag04" style="font-size: 15px;">C4</span></div></div>
                    </div>
                    <div class="con04-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/04">
                            <div class="square-content"><div><span id="bag04" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                </div>
                <div class="avg-bulk-tuban1">
                    <div class="square-content">
                        <div><span id="avgpbrkbulk1">00:00 jam</span></div>
                    </div>              
                </div>
                <div class="tuban1">
                    <div class="con90">
                        <div class="square-content"><div><span id="lpbulk90" style="font-size: 15px;">C90</span></div></div>
                    </div>
                    <div class="con90-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/90">
                            <div class="square-content"><div><span id="bulk90" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                    <div class="con91">
                        <div class="square-content"><div><span id="lpbulk91" style="font-size: 15px;">C91</span></div></div>
                    </div>
                    <div class="con91-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/91">
                            <div class="square-content"><div><span id="bulk91" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                    <div class="con92">
                        <div class="square-content"><div><span id="lpbulk92" style="font-size: 15px;">C92</span></div></div>
                    </div>
                    <div class="con92-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/92">
                            <div class="square-content"><div><span id="bulk92" style="font-size: 15px;">0</span></div></div>
                        </a>
                    </div>
                    <div class="con97">
                        <div class="square-content"><div><span id="lpbulk97" style="font-size: 15px;">C91</span></div></div>
                    </div>
                    <div class="con97-val klik">
                        <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailConveyor/97">
                            <div class="square-content"><div><span id="bulk97" style="font-size: 15px;">0</span></div></div>
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
                <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailTonase/bag">
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
                <a href="<?php echo base_url(); ?>sg/InPlantRembang/detailTonase/bulk">
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
                <a href="#">
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
    function titleavgcargo(truk, waktu, status) {
        var titleavgcargo = "<center style='font-size:14px;font-weight:bold;'>Waktu tunggu truk " + truk + " dicargo, mulai truk masuk gerbang cargo s/d mendapatkan nomor konveyor<br/><br/>" +
                "Standar Waktu Maksimal :<br/>" +
                waktu + " Menit<br/><br/>" +
                "Kargo " + status + " melebihi standar waktu" +
                "</center>";
        return titleavgcargo;
    }

    function avgCargo(data) {
        if (data['avgCargo'][0].AVERAGE != null) {
            if (data['avgCargo'][0].AVERAGE.replace(',', '.') > 240) {
                $('#avgcargo301').css('background', 'red');
                $('#avgcargo301').html(jam(data['avgCargo'][0].AVERAGE.replace(',', '.')));
                $('.avgcargo301').tooltip({title: titleavgcargo('zak', '240', 'telah'), html: true, placement: 'left'});
            } else {
                $('#avgcargo301').html(jam(data['avgCargo'][0].AVERAGE.replace(',', '.')));
                $('.avgcargo301').tooltip({title: titleavgcargo('zak', '240', 'tidak'), html: true, placement: 'left'});
            }
        }else{
            $('.avgcargo301').tooltip({title: titleavgcargo('zak', '240', 'tidak'), html: true, placement: 'left'});
        }

        if (data['avgCargo'][1].AVERAGE != null) {
            if (data['avgCargo'][1].AVERAGE.replace(',', '.') > 120) {
                $('#avgcargo308').css('background', 'red');
                $('#avgcargo308').html(jam(data['avgCargo'][1].AVERAGE.replace(',', '.')));
                $('.avgcargo308').tooltip({title: titleavgcargo('bulk', '120', 'telah'), html: true, placement: 'left'});
            } else {
                $('#avgcargo308').html(jam(data['avgCargo'][1].AVERAGE.replace(',', '.')));
                $('.avgcargo308').tooltip({title: titleavgcargo('bulk', '120', 'tidak'), html: true, placement: 'left'});
            }
        }else{
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
        if (data['avgTmbgn'][0].AVERAGE != null) {
            if (data['avgTmbgn'][0].AVERAGE.replace(',', '.') > 30) {
                $('#avgtmbgn301').css('background', 'red');
                $('#avgtmbgn301').html(jam(data['avgTmbgn'][0].AVERAGE.replace(',', '.')));
                $('.avgtmbgn301').tooltip({title: titleavgtmbgn('zak', '30', 'telah'), html: true, placement: 'left'});
            } else {
                $('#avgtmbgn301').html(jam(data['avgTmbgn'][0].AVERAGE.replace(',', '.')));
                $('.avgtmbgn301').tooltip({title: titleavgtmbgn('zak', '30', 'tidak'), html: true, placement: 'left'});
            }
        }else{
            $('.avgtmbgn301').tooltip({title: titleavgtmbgn('zak', '30', 'tidak'), html: true, placement: 'left'});
        }

        if (data['avgTmbgn'][1].AVERAGE != null) {
            if (data['avgTmbgn'][1].AVERAGE.replace(',', '.') > 30) {
                $('#avgtmbgn308').css('background', 'red');
                $('#avgtmbgn308').html(jam(data['avgTmbgn'][1].AVERAGE.replace(',', '.')));
                $('.avgtmbgn308').tooltip({title: titleavgtmbgn('bulk', '30', 'telah'), html: true, placement: 'left'});
            } else {
                $('#avgtmbgn308').html(jam(data['avgTmbgn'][1].AVERAGE.replace(',', '.')));
                $('.avgtmbgn308').tooltip({title: titleavgtmbgn('bulk', '30', 'tidak'), html: true, placement: 'left'});
            }
        }else{
            $('.avgtmbgn308').tooltip({title: titleavgtmbgn('bulk', '30', 'tidak'), html: true, placement: 'left'});
        }
    }

    function cntCargo(data) {
        $('#cntcargo' + data['cntCargo'][0].TIPE_TRUCK).html(data['cntCargo'][0].JUML_TRUCK + ' unit');
        $('#cntcargo' + data['cntCargo'][1].TIPE_TRUCK).html(data['cntCargo'][1].JUML_TRUCK + ' unit');
    }

    function cntTmbgn(data) {
        $('#cnttmbgn' + data['cntTmbgn'][0].TIPE_TRUCK).html(data['cntTmbgn'][0].JUML_TRUCK + ' unit');
        $('#cnttmbgn' + data['cntTmbgn'][1].TIPE_TRUCK).html(data['cntTmbgn'][1].JUML_TRUCK + ' unit');
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
        var titleBulk1;
        var menit;
        var menit_bag = 0;
        var banyak_bag = 0;
        var menit_bulk = 0;
        var banyak_bulk = 0;
        var 
        titleBag1 = titleavgpbrk('zak', 'Tuban 1', '240', 'tidak');
        titleBulk1 = titleavgpbrk('curah', 'Tuban 1', '60', 'tidak');

        $.each(data['avgPbrk'], function (key, val) {
            menit = val.AVERAGE.replace(',', '.');
            if (val.MATNR == '301') {
                menit_bag = parseFloat(menit_bag) + parseFloat(menit);
                banyak_bag = banyak_bag + 1;
            }

            if (val.MATNR == '302') {
                menit_bulk = parseFloat(menit_bulk) + parseFloat(menit);
                banyak_bulk = banyak_bulk + 1;
            }
        });

        // console.log(menit_bag,menit_bulk,menit);

        if (menit_bag > 0) {
            menit_bag = menit_bag / banyak_bag;
            if (menit_bag > 240) {
                $('#avgpbrkbag1').css('background', 'red');
                $('#avgpbrkbag1').css('color', '#fff');
                $('#avgpbrkbag1').css('font-weight', 'bold');
                $('#avgpbrkbag1').html(jam(menit_bag));
            }else{
                $('#avgpbrkbag1').html(jam(menit_bag));
            }
        }

        if (menit_bulk > 0) {
            menit_bulk = menit_bulk / banyak_bulk;
            if (menit_bulk > 60) {
                $('#avgpbrkbulk1').css('background', 'red');
                $('#avgpbrkbulk1').css('color', '#fff');
                $('#avgpbrkbulk1').css('font-weight', 'bold');
                $('#avgpbrkbulk1').html(jam(menit_bulk));
                titleBulk1 = titleavgpbrk('curah', 'Tuban 1', '60', 'telah');
            }else{
                $('#avgpbrkbulk1').html(jam(menit_bulk));
            }
        }

        $('.avg-bag-tuban1').tooltip({title: titleBag1, html: true, placement: 'top'});
        $('.avg-bulk-tuban1').tooltip({title: titleBulk1, html: true, placement: 'top'});
    }

    function cntPbrk(data) {
        $.each(data['cntPbrk'], function (key, val) {
            if (val.MATNR == '301') {
                if (val.COUNTER > 0) {
                    $('#bag' + jQuery.trim(val.LSTEL)).html(val.COUNTER);
                }
                if (val.STATUS == 0) {
                    $('#lpbag' + jQuery.trim(val.LSTEL)).css('background', '#fff');
                    $('#lpbag' + jQuery.trim(val.LSTEL)).css('color', '#000');
                    $('.con' + jQuery.trim(val.LSTEL)).tooltip({title: titlelp(val.LSTEL, 'Tidak', ''), html: true});
                } else {
                    $('.con' + jQuery.trim(val.LSTEL)).tooltip({title: titlelp(val.LSTEL, '', val.DESKRIPSI), html: true});
                }
            } else if (val.MATNR == '302') {
                if (val.COUNTER > 0) {
                    $('#bulk' + jQuery.trim(val.LSTEL)).html(val.COUNTER);
                }
                if (val.STATUS == 0) {
                    $('#lpbulk' + jQuery.trim(val.LSTEL)).css('background', '#fff');
                    $('#lpbulk' + jQuery.trim(val.LSTEL)).css('color', '#000');
                    $('.con' + jQuery.trim(val.LSTEL)).tooltip({title: titlelp(val.LSTEL, 'Tidak', ''), html: true});
                } else {
                    $('.con' + jQuery.trim(val.LSTEL)).tooltip({title: titlelp(val.LSTEL, '', val.DESKRIPSI), html: true});
                }
            }
        });
    }

    function titlelp(no, aktif, deskripsi) {
        var titlelp = "<center style='font-size:14px;font-weight:bold;'>Conveyor " + no + " " + aktif + " Aktif<br/><br/>" +
                deskripsi +
                "</center>";
        return titlelp;
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
        if (data['avgOverall'][0].AVERAGE != null) {
            if (data['avgOverall'][0].AVERAGE.replace(',', '.') > 510) {
                $('#waktusiklusbag').css('background', 'red');
                $('#waktusiklusbag').html(jam(data['avgOverall'][0].AVERAGE.replace(',', '.')));
                $('.waktu-siklus-bag').tooltip({title: titleoverall('zak', '8.5', 'telah'), html: true, placement: 'right'});
            } else {
                $('#waktusiklusbag').html(jam(data['avgOverall'][0].AVERAGE.replace(',', '.')));
                $('.waktu-siklus-bag').tooltip({title: titleoverall('zak', '8.5', 'tidak'), html: true, placement: 'right'});
            }
        }else{
            $('.waktu-siklus-bag').tooltip({title: titleoverall('zak', '8.5', 'tidak'), html: true, placement: 'right'});
        }
        
        if (data['avgOverall'][1].AVERAGE != null) {
            if (data['avgOverall'][1].AVERAGE.replace(',', '.') > 210) {
                $('#waktusiklusbulk').css('background', 'red');
                $('#waktusiklusbulk').html(jam(data['avgOverall'][1].AVERAGE.replace(',', '.')));
                $('.waktu-siklus-bulk').tooltip({title: titleoverall('bulk', '3.5', 'telah'), html: true, placement: 'right'});
            } else {
                $('#waktusiklusbulk').html(jam(data['avgOverall'][1].AVERAGE.replace(',', '.')));
                $('.waktu-siklus-bulk').tooltip({title: titleoverall('bulk', '3.5', 'telah'), html: true, placement: 'right'});
            }
        }else{
            $('.waktu-siklus-bulk').tooltip({title: titleoverall('bulk', '3.5', 'telah'), html: true, placement: 'right'});
        }
    }

    function sisaSO(data) {
        var sisa_bag = 0;
        var sisa_bulk = 0;
        if (data['sisaSO'].length === 0) {
            sisa_bag = 0;
            sisa_bulk = 0;
        }else{
            if (data['sisaSO'][0].SISA_BAG != null) {
                sisa_bag = data['sisaSO'][0].SISA_BAG;
            }

            if (data['sisaSO'][0].SISA_BULK != null) {
                sisa_bulk = data['sisaSO'][0].SISA_BULK;
            }
        }
        var sisaso = 'Sisa SO Bag  : '+formatAngka(sisa_bag) + ' TON<br/>'+
                     'Sisa SO Bulk : '+ formatAngka(sisa_bulk) + ' TON';
        $('#sisaso').html(sisaso);
    }

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

    function load_all(){
        var url = base_url + 'sg/InPlantRembang/load';
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                console.log(data);
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
        load_all();
        $('.pinch').each(function () {
            new RTP.PinchZoom($(this), {});
        });
    });
</script>