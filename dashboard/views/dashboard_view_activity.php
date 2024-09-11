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

	<style>
td.details-control {
		background: url('<?php echo base_url();?>img/png/chevron-arrow-down.png') no-repeat center left;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('<?php echo base_url();?>img/png/chevron-arrow-up.png') no-repeat center left;
	}
</style>
	
	
<script>



	$( document ).ready(function() {
		//alert('ok');
		
		//alert('aaaa');
		var user_id = '<?php echo $id;?>';
		var status = 0;
		
		
	
		var table = $("#example").DataTable({
			"processing": true,
			"serverSide": true,
			destroy: true,
			 "order": [[ 0, "desc" ]],
			"ajax": "<?php echo base_url().'dashboard/list_activity/'?>" + user_id,
			 "columns": [
				{
					"className":      'details-control',
					"orderable":      false,
					"data":           "0",
					"defaultContent": ''
				},
				{ "data": "1" },
				{ "data": "2" },
				{ "data": "3" },
				{ "data": "4" },
				{ "data": "5" }
			],
			"searchDelay": 700,
			"responsive": true,
			"bFilter" : false,
			"bInfo" : false,
			"bLengthChange": false
		});
		
		function format ( d ) {
			return  '<div class="row"><div class="col-md-12"><div class="result-table" ><table id="myTable1" class="table table-striped table-bordered example urate-table md-12" style="margin-top:10px;width:100%"><thead><tr><th>IP Address</th><th>Status Login</th><th>Login Time</th><th>Logout Time</th><th>Duration Login</th><th>Activity Page</th><th>Time Access</th></tr></thead></table></div></div></div>';
		}
  
		$('#example tbody').on('click', 'tr td.details-control', function () {
		 
		 //alert('aaaaa');
			 var tr = $(this).closest('tr');
			var row = table.row( tr );
			
			 var data_pr = row.data();
			//console.log(row.data());
	 
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			} else {
				 row.child( format(row.data()) ).show();
				tr.addClass('shown');
				
				
				var tablex = $("#myTable1").DataTable({
					"processing": true,
					"serverSide": true,
					destroy: true,
					 "order": [[ 0, "desc" ]],
					"ajax": "<?php echo base_url().'dashboard/list_activity_detail/'?>"+data_pr[6]+"/"+user_id,
					 "columns": [
						{ "data": "0" },
						{ "data": "1" },
						{ "data": "2" },
						{ "data": "3" },
						{ "data": "4" },
						{ "data": "5" },
						{ "data": "7" }
					],
					"searchDelay": 700,
					"responsive": true,
					"bFilter" : false,
					"bInfo" : false,
					"bLengthChange": false
				});
			
			}
			
		} );
			
	});
</script>
<style>
* {
    box-sizing: border-box;
}

body {
    background-color: #474e5d;
    font-family: Helvetica, sans-serif;
}

/* The actual timeline (the vertical ruler) */
.timeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: red;
    top: 0;
    bottom: 0;
    left: 0%;
    margin-left: -3px;
}

/* Container around content */
.container {
    padding: 10px 40px;
    position: relative;
    background-color: inherit;
    width: 50%;
}

/* The circles on the timeline */
.container::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: 0px;
    background-color: #eee;
    border: 4px solid #FF9F55;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
}

/* Place the container to the left */
.left {
    left: 0;
}

/* Place the container to the right */
.right {
    left: -24.5%;
}


/* Add arrows to the right container (pointing left) */
.right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
    left: -16px;
}

/* The actual content */
.content {
    padding: 20px 30px;
    background-color: #eee;
    position: relative;
    border-radius: 6px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
    left: 31px;
  }
  
  /* Full-width containers */
  .container {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .container::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
    left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
    left: 0%;
  }
}
</style>
    <!-- / Sidebar -->
<div class="content-wrapper">
  <div class="container-fluid">
  
	<div class="row">
	  <div class="col-md-6">
		  <ol class="breadcrumb">
			  <li class="breadcrumb-item">Supervisor</li>
			  <li class="breadcrumb-item">User Management</li>
			  <li class="breadcrumb-item active">Activity User</li>
		  </ol>
		  <h3 class="page-title-inner">Activity User</h3>
	  </div>       
	</div>
	<!-- Content -->  
	<div class="panel urate-panel urate-panel-result">
		  <div class="panel-heading">
		  </div>
		  <div class="panel-body">
		  
		  	<div class="row" >
			
			<div class="col-md-6">
				<div class="form-group">
					<div class="col-sm-4">Name </div>
					  <div class="col-sm-8">
						<span>: <?php echo $detailuser[0]['nama']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">Email</div>
					  <div class="col-sm-8">
						<span> : <?php echo $detailuser[0]['email']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">Packet</div>
					  <div class="col-sm-8">
						<span> : <?php echo $detailuser[0]['role']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">Type User</div>
					  <div class="col-sm-8">
						<span> : <?php if($detailuser[0]['activation_id'] == "1"){ echo "Paid"; }else{ echo "Trial"; }?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">Paid Date</div>
					  <div class="col-sm-8">
						<span> : <?php echo $detailuser[0]['paid_date']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">Expired Date</div>
					  <div class="col-sm-8">
						<span> : <?php echo $detailuser[0]['expired_date']?></span>
					  </div>
				</div>
			
				
				
			</div>	

			<div class="col-md-6">
				<div class="timeline">
				  <?php 
				  if(isset($history)){
				  foreach($history as $hs){?>
				  <div class="container right">
					<div class="content">
					  <h2><?php echo $hs['date_log'];?></h2>
					  <p><?php echo $hs['status'];?></p>
					</div>
				  </div>
				  <?php }}?>
				</div>
			</div>			
		</div>
		
			

				
		  
		  
			  <table id="example" class="table table-striped table-bordered">
							  <thead>
								<tr>
									<th>IP Address</th>						  										  
									<th>Status Login</th>						  										  
									<th>Login Time</th>						  										  
									<th>Logout Time</th>						  										  
									<th>Duration Login</th>						  										  
									<th>Last Activity Page</th>						  										  
								</tr>
							  </thead>
							</table>
		  </div>
	</div>
	
	
  </div>
</div>

