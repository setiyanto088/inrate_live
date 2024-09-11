

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
	
	
	
	function approved(val, stat){
		swal({
            title: 'Are you sure?',
              text: "You will approved this user?",
              type: 'info',
              showCancelButton: true,
              confirmButtonText: 'Ok'
        }).then(function () {
            var datapost={
                "id"  :   val,
				"status" : stat,
				"reason" : ''
              };
              $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>dashboard/updateRole",
                data : JSON.stringify(datapost),
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(response) {
                  if (response.success == true) {

                      swal({
                            title: 'Success!',
                            text: response.message,
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Ok'
                        }).then(function () {
                             window.location.href = "<?php echo base_url('dashboard');?>";
                        })



                  } else{
                    swal("Failed!", response.message, "error");
                  }
                }
              });
        })
	}
	
	
	
	function reject(val, stat){
		
		swal({
		  title: 'Are you sure to reject this user?',
          text: "You will rejected this user?",
		  showCancelButton: true,
		  html:
			'<input id="swal-input1" class="swal2-input" placeholder="Your Reject Reason?">',
		  preConfirm: function () {
			return new Promise(function (resolve) {
			  resolve([
				$('#swal-input1').val()
			  ])
			})
		  },
		  onOpen: function () {
			$('#swal-input1').focus()
		  }
		}).then(function (result) {
			
			var reason = '';
			
			if(result){
				reason = result[0];
			}
			
			 var datapost={
                "id"  :   val,
				"status" : stat,
				"reason" : reason
              };
              $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>dashboard/updateRole",
                data : JSON.stringify(datapost),
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function(response) {
                  if (response.success == true) {

                      swal({
                            title: 'Success!',
                            text: response.message,
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Ok'
                        }).then(function () {
                             window.location.href = "<?php echo base_url('dashboard');?>";
                        })



                  } else{
                    swal("Failed!", response.message, "error");
                  }
                }
              });
			
			
		  // console.log(result);
		}).catch(swal.noop)
		
		
		// swal({
            // title: 'Are you sure?',
              // text: "You will rejected this user?",
              // type: 'error',
              // showCancelButton: true,
              // confirmButtonText: 'Ok'
        // }).then(function () {
            // var datapost={
                // "id"  :   val,
				// "status" : stat
              // };
              // $.ajax({
                // type: "POST",
                // url: "<?php echo base_url();?>dashboard/updateRole",
                // data : JSON.stringify(datapost),
                // dataType: 'json',
                // contentType: 'application/json; charset=utf-8',
                // success: function(response) {
                  // if (response.success == true) {

                      // swal({
                            // title: 'Success!',
                            // text: response.message,
                            // type: 'success',
                            // showCancelButton: false,
                            // confirmButtonText: 'Ok'
                        // }).then(function () {
                             // window.location.href = "<?php echo base_url('dashboard');?>";
                        // })



                  // } else{
                    // swal("Failed!", response.message, "error");
                  // }
                // }
              // });
        // })
	}
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
										<!--th>ID</th-->
										<th>Name</th>						  										  
										<th>Status Account</th>						  										  
										<th>Status Activation</th>						  										  
										<th>Days Activation</th>	
										<th>Doc</th>	

										<?php
										$role_id = $this->session->userdata('role_id');
										if($role_id == 6){
											echo "<th>Action</th>";
										}
												
										?>										
									</tr>
								  </thead>
								</table>
              </div>
          </div>
		
		
	</div>
</div>