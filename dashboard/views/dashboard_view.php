	<!-- JQuery DataTable Css -->
    <link href="<?php echo $path;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo $path;?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<script>
	$( document ).ready(function() {
		//alert('ok');
		
		var user_id = $.cookie(window.cookie_prefix + "user_id");
		var token = $.cookie(window.cookie_prefix + "token");
		
		
	
	$(document).ready(function() {
		 $("#example").DataTable({
			"processing": true,
			"serverSide": true,
			destroy: true,
			"ajax": "<?php echo base_url().'dashboard/list_user2'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			"searchDelay": 700,
			responsive: true,
			"bFilter" : false,
			"bInfo" : false,
			"bLengthChange": false
		});
		
	}); 
		
			
	});
	
	
</script>
    
    <!-- / Sidebar -->
    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">
            <h3 class="page-title">List User Dashboard</h3>
          </div>
        </div>    
		<div class="panel urate-panel urate-panel-result">
              <div class="panel-heading">
              </div>
              <div class="panel-body">
                  <table id="example" class="table table-striped table-bordered">
								  <thead>
									<tr>
										<th>ID</th>
										<th>Name</th>						  										  
										<th>Status Account</th>						  										  
										<th>Status Activation</th>						  										  
										<th>Days Activation</th>						  										  
									</tr>
								  </thead>
								</table>
              </div>
          </div>
		
		
	</div>
</div>