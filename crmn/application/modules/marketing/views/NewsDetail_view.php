<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-8 col-md-offset-2">
                <!-- card view -->
                <div class="card">
					<div class="header header-title bg-red bg-cyan-">
                        <h2> Headline News</h2> 
                    </div>

                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                            <a href="<?php echo base_url('marketing/News'); ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                            <p>&nbsp;</p>
                                <div id="loader" style="margin: auto;padding: 10px;width: 100%">
                                    <div class="progress col-md-4">
                                        <div class="progress-bar bg-cyan progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 100%">
                                            PLEASE WAIT...
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <article align="justify">
                                    <h2 id="title"></h2>
                                    <p id="date"></p>
                                    <p id="image"></p>
                                    <br><br>
                                    <p id="content"></p>
                                    <!-- <h2 id="title">Semen Indonesia ajak warganet Makassar “Bicara Baik” di Media Sosial</h2> -->
                                    <!-- <p id="date">Oktober 19, 2018</p> -->
                                    <!-- <p>PT Semen Indonesia (Persero) Tbk kembali menggelar workshop media sosial bertajuk “Bicara Baik”.  Kali ini workshop digelar di Goedang Poepsa, Makassar bersama 50 penggiat media sosial, Kamis (18/10).</p>
                                    <p>Makassar merupakan kota keempat dalam rangkaian acara #BicaraBaik yang digelar oleh Semen Indonesia. Acara serupa juga telah digelar di Rembang, Surabaya dan Tuban. Di episode Makassar ini para peserta diajak untuk berbagi pengalaman bersama Marischka Prudence (travel blogger) dan Tumming Abu (content creator). Tak hanya sekedartraveling dan blogging, mereka mengubah hobinya menjadi sebuah peluang usaha.</p>
                                    <p>Pgs. Kepala Departemen Komunikasi Perusahaan Semen Indonesia Sigit Wahono mengatakan, kegiatan #BicaraBaik bersama para influencer ini digelar sebagai wadah sharing pengalaman dan berbagi ide bagi para pegiat media sosial. Dari kegiatan ini, Semen Indonesia berharap agar generasi muda dan netizen dapat memanfaatkan media sosial dengan bijak.</p>
                                    <p>"Dengan diskusi ini, diharapkan kedepan para pengguna media sosial muda lebih bijak dalam menggunakan media sosial dengan membuat konten-konten yang kreatif dan bermanfaat. Jika bisa memanfaatkan, para pegiat media sosial dapat menjadi creativepreneur atau content creator yang dapat membuka peluag usaha," tutupnya.</p>
                                    <p>Selain kegiatan sharing session media sosial, melalui acara ini perseroan juga menunjukkan kepeduliannya terhadap korban gempa dan tsunami di Palu dan Donggala dengan memberikan bantuan berupa uang tunai yang disalurkan melalui Semen Tonasa.</p> -->
                                    
                                </article>
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
        var idNews = <?php echo $this->input->get("news") ?>;
        detailNews(idNews);
    });

    function detailNews(idNews){
        $.ajax({
            url: "<?php echo base_url() ?>marketing/News/getNews/"+idNews,
            type: "GET",
            dataType: "JSON",
            beforeSend: function(xhr){
                $("#loader").css("display", "block");
            },
            success: function(data){
                console.log(data);
                $("#loader").css("display", "none");
                $("#title").html(data.data[0].title);
                $("#date").html(data.data[0].public_date);
                $("#image").html('<img class="img-responsive" src="'+data.data[0].thumbnail+'" />')
                $("#content").html(data.data[0].content);
            }
        });
    }
</script>