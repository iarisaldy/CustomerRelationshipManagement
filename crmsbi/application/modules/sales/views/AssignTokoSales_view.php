<style type="text/css">
tr.group,
tr.group:hover {
    background-color: #ddd !important;
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- card view -->
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>Assign Toko Sales</h2>
                    </div>
                    <div class="body">
                        <a href="<?php echo base_url('smi/KeyPerformanceIndicator'); ?>" class="btn btn-sm btn-info">Back</a>&nbsp;
                        <button class="btn btn-sm btn-warning" data-toggle="modal" id="btn-modal" data-target="#largeModal">Tambah Assign Toko</button>
                        <p>&nbsp;</p>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                    <table id="tableAssignToko" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Sales</th>
                                                <th>Customer</th>
                                                <th>Kota</th>
                                                <th>Kecamatan</th>
                                                <th>Alamat</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
                <!-- end card view -->
                <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #FF9600;color: white;">
                                <h4 class="modal-title" id="largeModalLabel">Tambah Assign Toko</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                	<div class="col-md-12" id="sales"></div>
                                    <div class="col-md-12" id="customer">
                                        <div id="label"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSaveAssign" class="btn btn-info waves-effect">SIMPAN</button>
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">TUTUP</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("document").ready(function(){
        listAssignToko();
    });

    $(document).on("click", "#btn-modal", function(e){
        e.preventDefault();
        listSales("#sales");
        listCustomer("#customer");
    });

    $(document).on("click", "#btn-delete-assign", function(e){
        var idAssign = $(this).data("idassign");
        var btn_delete = window.confirm("Apakah yakin menghapus data assign toko ?");
        if(btn_delete){
            $.ajax({
                "url": "<?php echo base_url(); ?>sales/AssignToko/deleteAssign/"+idAssign,
                "type": "GET",
                "dataType": "JSON",
                success: function(data){
                    alert("Penghapusan data assign berhasil");
                    listAssignToko();
                }
            })
        }
    });

    $(document).on("click", "#btnSaveAssign", function(e){
        e.preventDefault();
        var idSales = $("#listSales").val();
        var idCustomer = $("#listCustomer").val();
        $.ajax({
            url: "<?php echo base_url(); ?>sales/AssignToko/addAssign",
            type: "POST",
            data: {
                "id_sales" : idSales,
                "id_customer" : idCustomer
            },
            success: function(data){
                listAssignToko();
                alert("Penambahan Assign Toko Berhasil");
                $("#largeModal").modal("hide");
            }
        });
    });

    function listAssignToko(){
        var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
        var groupColumn = 0;
        $("#tableAssignToko").dataTable({
            "destroy" : true,
            "ajax" : {
                url: "<?php echo base_url('sales/AssignToko/listAssign'); ?>/"+idDistributor,
                type: "POST"
            },
            "columnDefs": [{ "visible": false, "targets": groupColumn }],
            "order": [[ groupColumn, 'asc' ]],
            "displayLength": 10,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );
                        last = group;
                    }
                });
            }
        });
    }

    function listCustomer(key, value){
        var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
        $.ajax({
            url: "<?php echo base_url(); ?>sales/AssignToko/listCustomer/"+idDistributor,
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function(xhr){
                $("#label").html("Mohon Tunggu dalam Proses Pengambilan Data Customer");
            },
            success: function(data){
                $("#label").html("");
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Customer / Toko</b>';
                type_list += '<select id="listCustomer" data-size="5" class="form-control selectpicker show-tick"  data-live-search="true" multiple>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_CUSTOMER']+'">'+response[i]['ID_CUSTOMER']+' - '+response[i]['NAMA_TOKO']+' - '+response[i]['ALAMAT']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }

    function listSales(key, value){
        var idDistributor = "<?php echo $this->session->userdata('kode_dist') ?>";
        $.ajax({
            url: "<?php echo base_url(); ?>sales/FilterSurvey/salesDistributor/"+idDistributor,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var response = data['data'];

                var type_list = '';
                type_list += '<b>Sales Distributor</b>';
                type_list += '<select id="listSales" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">';
                type_list += '<option value="">Pilih Sales</option>';
                for (var i = 0; i < response.length; i++) {
                    type_list += '<option value="'+response[i]['ID_USER']+'">'+response[i]['NAMA']+'</option>';
                }
                type_list += '</select>';

                $(key).html(type_list);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
</script>