<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header header-title bg-red bg-cyan-">
                        <h2>News</h2>
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
                        <div class="row" style="overflow-y: scroll; height: 70%;">
                        
                        <div class="col-md-12" id="pageNews">
                            <div id="loader">
                                <div class="progress col-md-4 col-md-offset-4">
                                    <div class="progress-bar bg-cyan progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 100%">
                                        PLEASE WAIT...
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="news-item">
                                    <h3>
                                        HUT Semen Indonesia Gelar Kejuaraan Silat
                                    </h3>
                                    <p>Kegiatan "Semen Indonesia Expo 2017" dimanfaatkan perusahaan untuk memamerkan Iayanan terbarunya yakni Semen Indonesia Total Solution (SITOS). SITOS merupakan Iayanan terintegrasi...</p>
                                    <div class="read_more">
                                        <a href="<?php echo base_url('marketing/News/detail/1'); ?>">READ MORE</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="news-item">
                                    <h3>
                                        SITOS, Layanan Terbaru Semen Indonesia
                                    </h3>
                                    <p>Kegiatan "Semen Indonesia Expo 2017" dimanfaatkan perusahaan untuk memamerkan Iayanan terbarunya yakni Semen Indonesia Total Solution (SITOS). SITOS merupakan Iayanan terintegrasi...</p>
                                    <div class="read_more">
                                        <a href="<?php echo base_url('marketing/News/detail/1'); ?>">READ MORE</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="news-item">
                                    <h3>
                                        Semen Indonesia Ajak Masyarakat Cinta Produk Dalam Negeri
                                    </h3>
                                    <p>Kegiatan "Semen Indonesia Expo 2017" dimanfaatkan perusahaan untuk memamerkan Iayanan terbarunya yakni Semen Indonesia Total Solution (SITOS). SITOS merupakan Iayanan terintegrasi...</p>
                                    <div class="read_more">
                                        <a href="<?php echo base_url('marketing/News/detail/1'); ?>">READ MORE</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="news-item">
                                    <h3>
                                        Volume penjualan Semen Indonesia 26,43 juta ton
                                    </h3>
                                    <p>Kegiatan "Semen Indonesia Expo 2017" dimanfaatkan perusahaan untuk memamerkan Iayanan terbarunya yakni Semen Indonesia Total Solution (SITOS). SITOS merupakan Iayanan terintegrasi...</p>
                                    <div class="read_more">
                                        <a href="<?php echo base_url('marketing/News/detail/1'); ?>">READ MORE</a>
                                    </div>
                                </div>
                            </div> -->

                        </div>
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
        getNews();
    });

    function getNews() {
        $.ajax({
            url: "<?php echo base_url(); ?>marketing/News/getNews",
            type: "GET",
            dataType: "JSON",
            beforeSend: function(xhr){
                $("#loader").css("display", "block");
            },
            success: function(data){
				console.log(data.data.length);
                $("#loader").css("display", "none");
                for(var i=0; i< data.data.length; i++){
                    content = data.data[i].content;
                    str = content.substring(0,100);
                    var news = "";
                    news += '<div class="col-md-4"><div class="news-item"><h3>'+data.data[i].title+'</h3>';
                    news += '<p><sub>'+data.data[i].public_date+'</sub></p>';
                    news += '<p>'+str+'...</p>';
                    news += '<div class="read_more"><a href="<?php echo base_url("marketing/News/detail?news='+data.data[i].id_artikel+'"); ?>">READ MORE</a></div></div></div>';

                    $("#pageNews").append(news);
                }
            }
        })
    }
</script>