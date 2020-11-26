<div class="wrapper wrapper-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tabel Mahasiswa</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="table_data" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>NAMA</th>
                                        <th>JURUSAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<script>
    function get_data(){
        url = base_url+'dashboard/get_data';
        $.ajax({
            
            url:url,
            type:'post',
            dataType:'json',
            success:function(rows){
                
                $("#table_data tbody").html(rows);
            }
        
        });
    }
    $(function(){
        get_data();
    });
</script>