<style>
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
</style>
<div id="loading_purple"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4><span class="text-navy"><i class="fa fa-truck"></i> IN PLANT TUBAN</span></h4>             
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        <a href="javascript:history.go(-1)" type="button" class="btn btn-primary pull-left">
                        <i class="fa fa-arrow-circle-left"></i> Kembali
                    </a>
                    <center><h2><b>DETAIL TONASE</b></h2></center>
                    </div>
                </div>                              
                <div class="table-responsive">
                    <table id="table_detail_tonase" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center success">NO ITEM</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center success">NAMA ITEM</th>
                            <th colspan="2" class="text-center success">ZAK</th>
                            <th colspan="2" class="text-center success">TONASE</th>
                        </tr>
                        <tr>
                            <th class="text-center success">JUMLAH</th>
                            <th class="text-center success">SATUAN</th>
                            <th class="text-center success">JUMLAH</th>
                            <th class="text-center success">SATUAN</th>
                        </tr>
                        </thead>
                        <tbody>
                            <!-- data di load disini -->
                        </tbody>
                    </table>
                </div>
                <div class="pull-right">
                            
                </div>
                <div id="page-info">
                    <ul class="list-group clear-list">
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function get_detail_truk(){
        var loc = window.location;
        var id = loc.pathname.substring(loc.pathname.lastIndexOf('/') + 1, loc.pathname.length);
        var url = base_url+'sg/InPlantTuban/dataDetailTonase/'+id;
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
			beforeSend:function(){
				$('#loading_purple').show();
			},
            success:function(data){
				$('#loading_purple').hide();
                $('#table_detail_tonase tbody').html(data.rows);
            }
        });
    }
    $(function(){
        get_detail_truk();
    });
</script>
