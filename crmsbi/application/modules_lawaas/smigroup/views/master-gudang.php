<style>
    .panel-heading, .modal-header {
        background: linear-gradient(to left, #1ab394, #036C13);
        color: white;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Master Gudang</h4>
                </div>
            </div>
            <div class="panel-body">
                <button class="btn btn-success" onclick="add_gudang()"><i class="glyphicon glyphicon-plus"></i> Tambah Gudang</button>
                <br />
                <br />
                <div class="ibox-content">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:25px;text-align: center">No</th>
                                <th style="text-align: center">Nama Distrik</th>
                                <th style="text-align: center">Kode Gudang</th>
                                <th style="text-align: center">Nama Gudang</th>
                                <th style="text-align: center">Alamat</th>
                                <th style="text-align: center">Kapasitas Gudang (Zak)</th>
                                <th style="text-align: center">Kapasitas Bongkar/Hari (Ton)</th>
                                <th style="text-align: center">Company</th>
                                <th style="width:150px;text-align: center">Action</th>
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

<script type="text/javascript">

    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function () {

        //datatables
        table = $('#table').DataTable({
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url + 'smigroup/StockLevelGudang/ListGudang',
                "type": "POST"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "destroy": true,
            "ordering": false
        });
    });


    function add_gudang()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Gudang'); // Set Title to Bootstrap modal title
    }

    function edit_gudang(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'smigroup/StockLevelGudang/DetailGudang/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                // menapilkan data pada tiap input sesuai dg name input
                $('[name="ID"]').val(data.ID);
                $('[name="KD_DISTR"]').val(data.KD_DISTR);
                $('[name="NM_DISTR"]').val(data.NM_DISTR);
                $('[name="KD_GDG"]').val(data.KD_GDG);
                $('[name="NM_GDG"]').val(data.NM_GDG);
                $('[name="ALAMAT"]').val(data.ALAMAT);
                $('[name="KAPASITAS"]').val(data.KAPASITAS);
                $('[name="KAPASITAS_B"]').val(data.UNLOADING_RATE_TON);
                $('[name="KD_DISTRIK"]').val(data.KD_DISTRIK);
                $('[name="AREA"]').val(data.AREA);
                $('[name="LATITUDE"]').val(data.LATITUDE);
                $('[name="LONGITUDE"]').val(data.LONGITUDE);
                $('[name="ORG"]').val(data.ORG);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Perusahaan'); // Set title to Bootstrap modal title

            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }
    // proses simpan add new perusahaan atau edit perusahaan
    function save()
    {
        $('#btnSave').text('Simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'smigroup/StockLevelGudang/AddGudang';
        } else {
            url = base_url + 'smigroup/StockLevelGudang/UpdateGudang';
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
    // proses delete perusahaan
    function delete_gudang(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'smigroup/StockLevelGudang/DeleteGudang/' + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }

</script>

<!-- Bootstrap modal -->
<div class="modal" id="modal_form" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form">
                    <div class="form-body">
                        <!--<input type="hidden" value="" name="KODE_PERUSAHAAN"/>--> 
                            <input  name="ID" class="form-control" required="" type="hidden">
                        <div class="form-group">
                            <label class="control-label">Kode Distrik</label>
                            <input name="KD_DISTR" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Distrik</label>
                            <input name="NM_DISTR" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kode Gudang</label>
                            <input name="KD_GDG" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Gudang</label>
                            <input name="NM_GDG" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Alamat</label>
                            <input name="ALAMAT" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kapasitas Gudang (Zak)</label>
                            <input name="KAPASITAS" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kapasitas Bongkar/Hari (Ton)</label>
                            <input name="KAPASITAS_B" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kode Distrik</label>
                            <input name="KD_DISTRIK" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Area</label>
                            <input name="AREA" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Latitude</label>
                            <input name="LATITUDE" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Longitude</label>
                            <input name="LONGITUDE" class="form-control" required="" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <input name="ORG" class="form-control" required="" type="text">
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label">Status</label>
                            <select name="STATUS" class="form-control">
                                <option value="0">ASI</option>
                                <option value="1">non-ASI</option>
                            </select>
                        </div> -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->



