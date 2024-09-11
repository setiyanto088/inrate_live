

<script>
	$( document ).ready(function() {
		//alert('ok');
		
		var user_id = $.cookie(window.cookie_prefix + "user_id");
		var token = $.cookie(window.cookie_prefix + "token");
		var statusnew = <?php echo $id;?>;
		
		if(statusnew == 1|| statusnew == 2){
				 $("#example2").DataTable({
					"processing": true,
					"serverSide": true,
					destroy: true,
					 "order": [[ 0, "desc" ]],
					"ajax": "<?php echo base_url().'dashboard/list_user3'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token+ "&status=" + statusnew,
					"searchDelay": 700,
					responsive: true,
					"bFilter" : false,
					"bInfo" : false,
					"bLengthChange": false
				});
		}else if(statusnew == 3){
			 $("#example2").DataTable({
					"processing": true,
					"serverSide": true,
					destroy: true,
					 "order": [[ 0, "desc" ]],
					"ajax": "<?php echo base_url().'dashboard/list_user_count'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
					"searchDelay": 700,
					responsive: true,
					"bFilter" : false,
					"bInfo" : false,
					"bLengthChange": false
				});
		}else{
			 $("#example2").DataTable({
					"processing": true,
					"serverSide": true,
					destroy: true,
					 "order": [[ 0, "desc" ]],
					"ajax": "<?php echo base_url().'dashboard/list_user_admin'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
					"searchDelay": 700,
					responsive: true,
					"bFilter" : false,
					"bInfo" : false,
					"bLengthChange": false
				});
		}
	
	
		
		
			
	});
</script>
	<div class="panel urate-panel urate-panel-result">
		  <div class="panel-heading">
		  </div>
		  <div class="panel-body">
		  
		  <?php if($id == 4){?>
			   
		   <table id="example2" class="table table-striped table-bordered">
							  <thead>
								<tr>
									<th>Name</th>						  										  
									<th>Status Account</th>						  										  
								</tr>
							  </thead>
							</table>
		  <?php }elseif($id == 3){?>
			   
		   <table id="example2" class="table table-striped table-bordered">
							  <thead>
								<tr>
									<th>Name</th>						  										  
									<th>Active User</th>						  										  
								</tr>
							  </thead>
							</table>
		  <?php }else{ ?>
		  <table id="example2" class="table table-striped table-bordered">
							  <thead>
								<tr>
									<th>Name</th>						  										  
									<th>Status Account</th>						  										  
									<th>Status Activation</th>						  										  
									<th>Days Activation</th>						  										  
								</tr>
							  </thead>
							</table>
		  <?php } ?>
			 
		  </div>
	</div>