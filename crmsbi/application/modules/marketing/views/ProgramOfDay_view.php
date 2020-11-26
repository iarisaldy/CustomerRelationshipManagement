<style>
    #multiple-items{
        cursor: -webkit-grab !important;
        height: 40%; 
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title bg-red bg-cyan-">
                        <h2>Program of The Day</h2>
                    </div>
                    <?php
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];

                        foreach ($dataMenu as $menusKey => $menusValue) { 
                         if($menusValue->ID_MENU == '1000'){ 
                    ?>
                        <ul class="submenus">
                        <?php 
                            foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                        ?>
                            <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                        </ul>
                    <?php }
                    } ?>

                    <div class="body">
                        <div class="row">
                            <div class="col-md-12" style="float: right;">
                                <?php $idJenisUser = $this->session->userdata("id_jenis_user"); ?>
                                <?php if($idJenisUser == "1001" || $idJenisUser == "1002"){ ?>
                                <a href="<?php echo base_url('marketing/program/add'); ?>" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add New Program</a>
                                <?php } ?>
                            </div>
                            <ul class="notes">
                            <?php foreach ($program as $programKey => $programValue) { ?>
                                
                                <li>
                                  <div class="item">
                                    <h2><?php echo $programValue->JUDUL_PROGRAM; ?></h2>
                                    <span class="label label-info">Berlaku: <?php echo $programValue->START_DATE." s/d ".$programValue->END_DATE ?></span>
                                    <?php if($idJenisUser == $programValue->PIC_PROGRAM){ ?>
                                    <div class="modif-wrap">
                                        <a href="javascript:void(0);" title="Edit" class="success" onClick="detailProgram(<?php echo (int)$programValue->ID_PROGRAM; ?>)"><i class="material-icons">edit</i></a> 
                                        <a href="javascript:void(0);" title="Delete" class="danger" onClick="detailProgram(<?php echo (int)$programValue->ID_PROGRAM; ?>)"><i class="material-icons">delete</i></a> 
                                    </div>
                                    <?php } ?>
                                    <br/>&nbsp;
                                    <p><?php echo $programValue->DETAIL_PROGRAM; ?></p>
                                    <span class="label label-info"><?php echo $programValue->JENIS_USER." : ".$programValue->NAMA_DISTRIBUTOR; ?></span>
                                  </div>
                                </li>

                            <?php } ?>
                        </ul>

                        
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>

<script>
    $('document').ready(function(e){
        $('#multiple-items').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });
    });

    function detailProgram(idProgram){
        window.location.href = "<?php echo base_url(); ?>marketing/Program/detail/"+idProgram;
    }

    function deleteProgram(idProgram){
        var r = confirm("Apakah yakin ingin menghapus ?");
        if(r == true){
            $.ajax({
                url: "<?php echo base_url(); ?>marketing/Program/deleteProgram",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id_program": idProgram
                },
                success: function(data){
                    if(data.status == "success"){
                        location.reload();
                    }
                }
            });
        }
    }
</script>