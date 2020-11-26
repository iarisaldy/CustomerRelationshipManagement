<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Target Keep, Get & Growth Key Performance Indicators</h2>
                    </div>
                    <div class="body">
                        <a href="<?php echo base_url('smi/KeyPerformanceIndicator'); ?>" class="btn btn-sm btn-danger">Back</a>&nbsp;
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#hargaModal">Tambah Target</button>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="form-line" id="filterDistributor"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <b>Bulan</b>
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
                                        <b>Tahun</b>
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
                                <div class="col-md-12">
                                    <table id="indexTarget" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Distributor</th>
                                                <th>Keep</th>
                                                <th>Get</th>
                                                <th>Growth</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Semen Indonesia Distributor Jatim</td>
                                                <td>Jawa Timur</td>
                                                <td>51</td>
                                                <td>10</td>
                                                <td>10</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
                <!-- START MODAL HARGA -->
                <div class="modal fade" id="hargaModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #00b0e4;color: white;">
                                <h4 class="modal-title" id="largeModalLabel">Tambah Target</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="import-target-customer" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <br/>
                                            <a href="<?php echo base_url('assets/excel/Template_Upload_Target_Customer.xlsx'); ?>" target="_blank" class="btn btn-sm btn-info">Download Template</a>
                                            <p>&nbsp;</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Target</label>
                                                <div class="form-line">
                                                    <input type="file" name="customer" id="customer" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-info">SIMPAN TARGET</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END MODAL UPLOAD HARGA -->
            </div>
        </div>
    </div>
</section>
<script>
    $("document").ready(function(){
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();
        indexTarget(bulan, tahun);

        filterDistributor("#filterDistributor");
    });

    $(document).on("click", "#btnFilterAction", function(e){
        e.preventDefault();
        var distributor = $("#listDistributor").val();
        var bulan = $("#filterBulan").val();
        var tahun = $("#filterTahun").val();

        indexTarget(bulan, tahun, distributor);
    });

    function indexTarget(bulan = null, tahun = null, distributor = null){
        $("#indexTarget").dataTable({
            "destroy": "true",
            "ajax": {
                url: "<?php echo base_url('smi/ImportTarget/listTargetCustomer'); ?>",
                type: "POST",
                data: {
                    "distributor" : distributor,
                    "bulan" : bulan,
                    "tahun" : tahun
                }
            }
        });
    }

    $('#import-target-volume').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData();
        formData.append('tahun', $("#tahun").val());
        formData.append('file', $('#file')[0].files[0]);

        $.ajax({
            url : "<?php echo base_url(); ?>smi/ImportTarget/customer",
            type : 'POST',
            data : formData,
            contentType : false,
            processData : false,
            dataType: "JSON",
            success : function(data){
                if(data.status == "success"){
                    alert("Tambah Target Berhasil");
                    $("#largeModal").modal("hide");

                    var bulan = $("#filterBulan").val();
                    var tahun = $("#filterTahun").val();
                    // indexTarget(bulan, tahun);
                }
            }
        });
    });

    $('#import-target-customer').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData();
        formData.append('customer', $('#customer')[0].files[0]);

        $.ajax({
            url : "<?php echo base_url(); ?>smi/ImportTarget/customer",
            type : 'POST',
            data : formData,
            contentType : false,
            processData : false,
            dataType: "JSON",
            success : function(data){
                if(data.status == "success"){
                    alert("Tambah Target Berhasil");
                    $("#hargaModal").modal("hide");
                    var bulan = $("#filterBulan").val();
                    var tahun = $("#filterTahun").val();
                    indexTarget(bulan, tahun);
                }
            }
        });
    });

    function filterDistributor(key, value){
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/distributor",
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Distributor</b>';
                type_list += '<select id="listDistributor" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Distributor</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['KODE_DISTRIBUTOR']+'">'+response[i]['KODE_DISTRIBUTOR']+' - '+response[i]['NAMA_DISTRIBUTOR']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>