<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
					<div class="header bg-cyan">
                        <h2></h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="container-fluid">
                                <center>
                                    <h2>SELAMAT DATANG DI DASHBOARD CRM</h2>
                                    <h3><?php echo strtoupper($this->session->userdata("name")).", ".strtoupper($this->session->userdata("jenis_user")); ?></h3>
                                </center>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
            </div>
        </div>
    </div>
</section>