</div>
</div>
</div>
<div class="footer">
    <div>
        <strong>Copyright</strong> &copy; 2018 - CRM - Semen Indonesia Group - All Rights Reserved
    </div>
</div>
</div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

<!--Datepicker -->
<script src="<?php echo base_url(); ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>


<!-- Flot -->
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.resize.js"></script>


<!-- blueimp gallery -->
<script src="<?php echo base_url(); ?>assets/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>

<!-- ChartJS-->
<!-- <script src="<?php //echo base_url();          ?>assets/js/plugins/chartJs/Chart.min.js"></script> -->

<!-- Peity -->
<script src="<?php echo base_url(); ?>assets/js/plugins/peity/jquery.peity.min.js"></script>

<!-- Peity demo -->
<!-- <script src="<?php echo base_url(); ?>assets/js/demo/peity-demo.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/plugins/toastr/toastr.min.js"></script> -->

<!-- table -->
<!-- <script src="<?php //echo base_url();          ?>assets/js/plugins/jeditable/jquery.jeditable.js"></script> -->

<!-- datatables -->
<script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/datatables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-hover-dropdown.js"></script>

<!-- pinchzoom -->	
<script src="<?php echo base_url(); ?>assets/pinchzoom-master/src/pinchzoom.js"></script>

<!-- auto hide navbar -->
<script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap-autohidingnavbar.js"></script>

<script src="<?php echo base_url(); ?>assets/js/ct-navbar.js"></script>



<!-- Toastr script -->
<script src="<?php echo base_url(); ?>assets/js/plugins/toastr/toastr.min.js"></script>

<!-- Sweet alert -->
<script src="<?php echo base_url(); ?>assets/js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    //$(".navbar-fixed-top").autoHidingNavbar();
    var mouseY = 0;

    document.addEventListener('mousemove', function (e) {
        mouseY = e.clientY || e.pageY;
        if (mouseY < 20) {
            $('#topmenu').css({top: '0'});
        } else if (mouseY > 180) {
            setTimeout(function () {
                $('#topmenu').css({top: '-60px'});
            }, 5000);

        }
    }, false);

</script>

<script>
    $(document).ready(function () {
        $('.date').datepicker({
            format: "dd-mm-yyyy"
        });


        $('.tree-toggle').mouseover(function (e) {
            console.log('tes2');
            $(this).parent().children('ul.tree').toggle(200);
            $(this).parent().siblings('li').find('ul.tree').hide('slow');
            e.stopPropagation();
        })
        $('ul.tree').hide('slow');
        
        $('.m-u').mouseover(function (e){
            console.log('trigerred');
            $('ul.tree').hide('slow')
        });

      

    });
</script>

</body>
</html>
