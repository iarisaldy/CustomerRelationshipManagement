   <div class="content-wrapper">
   	<section class="content-header">
   		<h1>User List
   			<small>List of Application User</small>
   		</h1>
   		<ol class="breadcrumb">
   			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   			<li><a href="#">Examples</a></li>
   			<li class="active">Blank page</li>
   		</ol>
   	</section>

   	<section class="content">
   		<div class="box">
   			<div class="box-header with-border">
   				<h3 class="box-title">Title</h3>
   				<div class="box-tools pull-right">
   					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                 </div>
              </div>
              <div class="box-body">
               <table id="user-list" class="table">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Role</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>1</td>
                        <td>Admin</td>
                        <td>Admin</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="box-footer">
             Footer
          </div>
       </div>
    </section>
 </div>
 <script type="text/javascript">
    $(document).ready(function(){
      $('#user-list').DataTable({
         paging: true,
         lengthChange: true
      });
   });
</script>
