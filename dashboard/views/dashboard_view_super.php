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
		var status = 0;
		
		
	
		 $("#example").DataTable({
			"processing": true,
			"serverSide": true,
			destroy: true,
			 "order": [[ 0, "desc" ]],
			"ajax": "<?php echo base_url().'dashboard/list_user2'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token+ "&status=" + status,
			"searchDelay": 700,
			responsive: true,
			"bFilter" : false,
			"bInfo" : false,
			"bLengthChange": false
		});
		
		
			
	});
	
	function userganti(val){
		
		//alert(val);
		$("#example").DataTable({
				"processing": true,
				"serverSide": true,
				destroy: true,
				 "order": [[ 0, "desc" ]],
				"ajax": "<?php echo base_url().'dashboard/list_user2'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token + "&status=" + val,
				"searchDelay": 700,
				responsive: true,
				"bFilter" : false,
				"bInfo" : false,
				"bLengthChange": false
			});
		 // table.ajax.reload();
	}
	
	
	function userganti(id){
		$('#panel-modal').removeData('bs.modal');
        $('#panel-modal  .panel-body').html('<i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Loading...');
        $('#panel-modal  .panel-body').load('<?php echo base_url('dashboard/detailuseraktif');?>'+"/"+id);
        $('#panel-modal  .panel-title').html('<i class="fa fa-user"></i> User Active');
        $('#panel-modal').modal({backdrop:'static',keyboard:false},'show');
	}
	
	function detail(id){
		$('#panel-modal').removeData('bs.modal');
        $('#panel-modal  .panel-body').html('<i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Loading...');
        $('#panel-modal  .panel-body').load('<?php echo base_url('dashboard/detailuser');?>'+"/"+id);
        $('#panel-modal  .panel-title').html('<i class="fa fa-user"></i> Detail User');
        $('#panel-modal').modal({backdrop:'static',keyboard:false},'show');
	}
	
	function modelmenu(id){
		
		var form_data = new FormData();  

		form_data.append('menu',id);
		
		$.ajax({
			url: "<?php echo base_url().'dashboard/list_menu'; ?>", 
			dataType: 'json',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				//obj = jQuery.parseJSON(data);

				console.log(data);
				
				// $('#examplemenus').DataTable({
					// "bFilter": false,
					// "aaSorting": [],
					// "bLengthChange": false,
					// 'iDisplayLength': 10,
					// "sPaginationType": "simple_numbers",
					// "Info" : false,
					// data: obj
				// });	
				
				//$('#id_tbl').html(data);
				$('#id_tbl').html('<table id="examplemenus" class="table table-striped table-bordered"><thead><tr><th>Type</th><th>Feature</th></tr>'+data+'</thead></table>');
				
		
				$('#panel-modal-menus').removeData('bs.modal');
				//$('#panel-modal-menus  .panel-body').html('<i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Loading...');
				//$('#panel-modal  .panel-body').load('<?php echo base_url('dashboard/detailuser');?>'+"/"+id);
				$('#panel-modal-menus  .panel-title').html('<i class="fa fa-menu"></i> List Menu');
				$('#panel-modal-menus').modal({backdrop:'static',keyboard:false},'show');
	
			}
		});	
	}
	
</script>
    
<style>
a:hover, a:visited, a:link, a:active
{
    text-decoration: none;
}
</style>	
	
	
	
    <!-- / Sidebar -->
    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">User Dashboard</li>
            </ol>
            <h3 class="page-title">User Management Dashboard</h3>
          </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row">
	
          <div class="col-md-3">
		   <a href="javascript:void(0)" onclick="userganti(3);">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_spot.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Concurrent User</span>
                <span class="value">
					<?php echo $currentuser[0]['currentuser'];?>
					
				<?php //echo number_format(intval($costspot[0]["spot"]),0,',','.'); ?></span>
              </div>
            </div>
			</a>
          </div>

          <div class="col-md-3">
		  <a href="javascript:void(0)" onclick="userganti(4);">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_cost.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">User Dinas</span>
                <span class="value">
				<?php echo $loginuser[0]['totaluser'];?>
				
				<?php //echo number_format((intval($cost[0]["cost"])/1000000),2,',','.'); ?></span>
              </div>
            </div>
			</a>
          </div>

          <div class="col-md-3">
		  <a href="javascript:void(0)" onclick="userganti(1);">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_grp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">User Premium</span>
                <span class="value">
				<?php echo $premiumuser[0]['premiumuser'];?>
				<?php //echo number_format(intval($spots[0]["grp"]),0,',','.'); ?></span>
              </div>
            </div>
			</a>
          </div>

          <div class="col-md-3">
		  <a href="javascript:void(0)" onclick="userganti(2);">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_crp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">User Trial</span>
                <span class="value">
				<?php echo $trialuser[0]['trialuser'];?>
				
				<?php 
					// if ($spots[0]["grp"]==0) {
						// echo 0;
					// } else {
					// echo number_format((intval($cost[0]["cost"])/intval($spots[0]["grp"]))*1000,0,',','.'); }
				?>
				</span>
              </div>
            </div>
          </div>
		  </a>
        </div>
        <!-- / Dashboard Stats -->

        
      </div>
    </div>
	
	
	
	
	
	
	



    <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-danger panel-filled">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <p></p>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



	
	
	  <div id="panel-modal-menus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-danger panel-filled">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <p></p>
						
						 
								<div id = 'id_tbl'></div>
							  
						
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	
	
	
	
	
	
	
	
	
	
    <!-- / Sidebar -->
<div class="content-wrapper">
  <div class="container-fluid">
	<!-- Content -->  
	<div class="panel urate-panel urate-panel-result">
		  <div class="panel-heading">
		  </div>
		  <div class="panel-body">
			  <table id="example" class="table table-striped table-bordered">
							  <thead>
								<tr>
									<th>Name</th>						  										  
									<th>Status Account</th>	
									<th>Type Account</th>										
									<th>Status Activation</th>						  										  
									<th>Days Activation</th>						  										  
								</tr>
							  </thead>
							</table>
		  </div>
	</div>
	
	
  </div>
</div>