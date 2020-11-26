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
                    <h4>Link</h4>
                </div>
            </div>
            <div class="panel-body">
                <button class="btn btn-success" onclick="add_link()"><i class="glyphicon glyphicon-plus"></i> Tambah Link</button>
                <br />
                <br />
                <div class="ibox-content">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:25px;text-align: center">No</th>
                                <th style="text-align: center">Link</th>
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
            "processing": true,
            "serverSide": false,
            "order": [],
            "ajax": {
                "url": base_url + 'intelligence/Link/ListLink',
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [-1],
                    "orderable": false,
                },
            ],
        });
    });


    function add_link()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Link'); // Set Title to Bootstrap modal title
    }

    function edit_link(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'intelligence/Link/DetailLink/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="ID"]').val(data.ID);
                $('[name="LINK"]').val(data.LINK);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Link'); // Set title to Bootstrap modal title

            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save()
    {
        $('#btnSave').text('Simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = base_url + 'intelligence/Link/AddLink';
        } else {
            url = base_url + 'intelligence/Link/UpdateLink';
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

    function delete_link(id)
    {
        if (confirm('Apakah anda yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/Link/DeleteLink/' + id,
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
                            <label class="control-label">Link</label>
                            <input name="LINK" class="form-control" required="" type="text">
                        </div>
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



