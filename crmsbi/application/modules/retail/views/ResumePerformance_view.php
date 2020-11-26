<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2>RESUME PERFORMANCE RETAIL</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                    <table id="tblResumePerformance" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" width="10%">ID Customer</th>
                                                <th rowspan="2" width="30%">Nama Toko</th>
                                                <th rowspan="2">Kecamatan</th>
                                                <th colspan="6">Bulan</th>
                                            </tr>
                                            <tr>
                                                <?php 
                                                $begin = new DateTime(date('Y-m-d', strtotime('-5 month')));
                                                $end = new DateTime(date('Y-m-d', strtotime('+1 month')));

                                                $interval = DateInterval::createFromDateString('1 month');
                                                $period = new DatePeriod($begin, $interval, $end);
                                                foreach ($period as $dt) {
                                                    echo "<th>".$dt->format("F Y")."</th>";
                                                }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("document").ready(function(){
        tblResumePerformance();
    });

    function tblResumePerformance(){
        $("#tblResumePerformance").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('retail/ResumePerformance/dataPerformanceRetail'); ?>",
                type: "GET"
            }
        });
    }
</script>