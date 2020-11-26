<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Add New Program</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <form class="form-horizontal">

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="program_name">Program Name : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="program_name" class="form-control" name="name" placeholder="Enter program name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="detail_program">Description : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea id="detail_program" class="form-control" placeholder="Enter program description" rows="5"></textarea>
                                                </div>
                                                <p style="color:red;" id="viewCountText"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="detail_program">Start Date Program : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="startDate" class="datepicker form-control" placeholder="Please choose start date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="detail_program">End Date Program : </label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="endDate" class="datepicker form-control" placeholder="Please choose end date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button id="btnAddProgram" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save New Program</button>
                                        &nbsp;
                                        <a href="<?php echo base_url('marketing/Program'); ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                </div>

                                </form>
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
        $("#startDate").bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $("#endDate").bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    });

    $(document).on("keyup", "#detail_program", function(e){
        var detailText = $("#detail_program").val();
        var jumlah_text = detailText.length;

        if(jumlah_text >= 200){
            $("#viewCountText").html((255 - jumlah_text) + " Karakter tersisa");
        } else {
            $("#viewCountText").html("");
        }
    });
    
    $(document).on("click", "#btnAddProgram", function(e){
        e.preventDefault();
        var judul = $("#program_name").val();
        var detail = $("#detail_program").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        
        if(judul != "" && detail != ""){
            if(detail.length <= 255){
                $.ajax({
                    url: "<?php echo base_url() ?>marketing/Program/addProgramProses",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        "judul_program" : judul,
                        "detail_program" : detail,
                        "startdate" : startDate,
                        "enddate" : endDate
                    },
                    success: function(data){
                        if(data.status == "success");
                        var r = confirm("Berhasil Menambahkan Program Baru");
                        if(r == true){
                            window.location.href = "<?php echo base_url() ?>marketing/Program";
                        }
                    }
                });
            } else {
                alert("Detail Program tidak boleh melebihi 255 karakter");
            }
        } else {
            alert("Lengkapi isian terlebih dahulu");
        }
        
    });
</script>