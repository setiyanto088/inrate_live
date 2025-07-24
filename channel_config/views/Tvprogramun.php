    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Channel Config</title>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/widget.css?v=1.0.1">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/table.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack-extra.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/grid.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/chart.css">
   <!-- JQuery DataTable Css -->
    <link href="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
	 <script src="<?php echo $path;?>assets/ext/dataTables.fixedColumns.min.js"></script>
	   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">  
    
	 <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Timepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.js"></script> 
  <!-- Multiple Select -->
	<script src="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.standalone.js"></script>
	
  <style>
  .highcharts-credits{
		display: none;
	}
	
	#example3_filter{
		margin-top: 10px;
	}
	.dataTable > tbody > tr > .right {
		text-align: right;
	  }
	  .dataTable > thead > tr > th {
		text-align: center;
	  }
	.highcharts-button{
		display: none;
	}
	#container{
			width: 100%;
	}

	table.dataTable thead .sorting_desc::after {
	  content: "";
	}
	table.dataTable thead .sorting_asc::after {
	  content: "";
	}
	table.dataTable thead .sorting::after {
	  content: "";
	}

	.cArrowDown {
	  width: 12px;
	  float: right;
	  margin-right: -25px;
	}
	.highcharts-title{
		color: #4a4d54 !important; 
	}
	
	table.dataTable {
		clear: both;
		margin-top: -1px !important;
		margin-bottom: 0px !important;
		max-width: none !important;
	}
	 
	.even {
		background:#E0E0E0;
	}
	
	    .loader{
      display: block;
      text-align: center;
      padding-top: 10px;
      font-size: 16px;
      font-weight: bold;
    }
    
	  .dt-button{
  		position:relative;
  		left: 1%;
  		background-color: transparent;
  		color: #cb3827;
  		border-radius: 30px;
  		border: 1px solid #cb3827;
  		padding: 6px;
  		padding-left: 30px;
  		padding-right: 30px;
      bottom: 6px;
  	}    
	
	.urate-form-input{
		
		color: #cb3827;
		
	}
	
	body{ 
	padding: 0px;
}
#drop_zone {
	background-color: #FFE3E3;
	border: #B980F0 5px dashed;
	width: 100%;
	padding : 60px 0;
}
#drop_zone p {
	font-size: 20px;
	text-align: center;
}
#btn_upload, #selectfile {
	display: none;
}
	
  </style>

</head>

<body>


  <!-- Main Container -->
  <div class="main-container">
   
    <!-- / Sidebar -->
    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">                                   

             <h3 class="page-titles" style="font-weight:bold">Channel Parameters</h3>
          </div>
          <div class="col-md-7 text-right">
		  
			<h6 id="hs"></h6>
          </div>
        </div>


        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row ">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="3"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">Channel Data</h4>
					</div>

				</div>
                <div class="widget-content">

				</div>
			
					
 					<div id="table_program2" >
						<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th  scope="col" style="vertical-align:top;text-align:center" >No</th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel Name </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel Front End </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel Genre </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel Number </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel Regional </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel Category </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Channel URI </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Color </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Status </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Update</th>
									</tr>
								</thead>
								<tbody>
								<?php $nu = 1; foreach($array_data_channel as $array_data_channels){ ?>
									<tr>
										<th  scope="col" style="vertical-align:top;text-align:center" ><?php echo $nu; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['CHANNEL_NAME']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['CHANNEL_NAME_PROG']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['GENRE']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['CHANNEL_NUMBER']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['CHANNEL_REG']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['CATEGORY']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $array_data_channels['CHANEL_URI']; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><div class="button_black" style='background-color:#<?php echo $array_data_channels['COLOR']; ?>'> &nbsp </div></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><?php echo $status_tpe[$array_data_channels['FLAG_TV']]; ?></th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><button onclick="update('<?php echo $array_data_channels['CHANNEL_NAME'] ?>','<?php echo $array_data_channels['CHANNEL_NAME_PROG'] ?>','<?php echo $array_data_channels['GENRE'] ?>','<?php echo $array_data_channels['CHANNEL_NUMBER'] ?>','<?php echo $array_data_channels['CHANNEL_REG'] ?>','<?php echo $array_data_channels['CATEGORY'] ?>','<?php echo $array_data_channels['CHANEL_URI'] ?>','<?php echo $array_data_channels['COLOR'] ?>','<?php echo $array_data_channels['FLAG_TV'] ?>')" id="exportWidget" class="button_black" data-complete-text="" style="float: right;"><strong>Update</strong></button></th>
									</tr>
								<?php $nu++; } ?>
								</tbody>
						</table>
					</div> 
              </div>
            </div>
         
          <br>

        </div>
             <!-- Modal Load Channel -->
	
        </div>
        <!-- / Dashboard Widget -->
        <!-- / Content -->
      </div>
    </div>

	<div class="modal fade modalDaypart" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Update Channel</strong></h4>
				</div>
				<form class="row" id="edit_user" method="post" enctype="multipart/form-data" action="<?php echo base_url()."channel_config/edit_channel" ;?>">
				<div class="modal-body">
						<div class="form-group col-md-12">
							<label for="">Channel Name</label>
							<input type="text" class="form-control urate-form-input" name="channel_name" id="channel_name" placeholder="" readOnly="readOnly" />
							<input type="hidden" class="form-control urate-form-input" name="cdr_edit_data" id="cdr_edit_data" placeholder="" required />
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel Front End</label>
							<input type="text" class="form-control urate-form-input" name="channel_fe" id="channel_fe" placeholder="" />
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel Genre</label>
							<select type="text" class="form-control urate-form-input" name="genre" id="genre" >
							<?php foreach($array_data_cat as $array_data_cats){ 
								
								echo "<option value='".$array_data_cats['KATEGORI']."'>".$array_data_cats['KATEGORI']."</option>";

							} ?>
							<select/>
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel Number</label>
							<input type="text" class="form-control urate-form-input" name="number" id="number" placeholder="" />
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel Regional</label>
							<select type="text" class="form-control urate-form-input" name="regional" id="regional" >
							<option value='INTERNATIONAL'>INTERNATIONAL</option>
							<option value='LOCAL'>LOCAL</option>
							<select/>
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel Category</label>
							<select type="text" class="form-control urate-form-input" name="category" id="category" >
							<option value='BLOCKING'>BLOCKING</option>
							<option value='FOREIGN PREMIUM'>FOREIGN PREMIUM</option>
							<option value='FTA INTERNATIONAL'>FTA INTERNATIONAL</option>
							<option value='FTA LOKAL'>FTA LOKAL</option>
							<option value='FTA NATIONAL'>FTA NATIONAL</option>
							<option value='HOTLINK'>HOTLINK</option>
							<option value='IN HOUSE BASIC'>IN HOUSE BASIC</option>
							<option value='IN HOUSE PREMIUM'>IN HOUSE PREMIUM</option>
							<option value='LOCAL'>LOCAL</option>
							<option value='LOCAL PREMIUM'>LOCAL PREMIUM</option>
							<option value='OTHER'>OTHER</option>
							<select/>
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel URI</label>
							<input type="text" class="form-control urate-form-input" name="uri" id="uri" placeholder="" />
						</div>
						<div class="form-group col-md-6">
							<label for="">Color</label>
							<input type="color" class="form-control" name="color" id="color" placeholder="" />
						</div>
						<div class="form-group col-md-6">
							<label for="">Status</label>
							<select type="text" class="form-control urate-form-input" name="status" id="status" >
								<option value='1'>Active</option>
								<option value='0'>Not Active</option>
							<select/>
						</div>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em>&nbsp Cancel</button>
					<button type="submit" id="btn_daftar_edit" class="button_black" ><em class="fa fa-check"></em>&nbsp Save</button>
				</div>
				</form>
			</div>
		</div>
	</div>

   <script src="<?php echo $path;?>assets/js/table.js"></script>
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
 <script src="<?php echo $path;?>assets/js/widget.js?v=2"></script>
<!-- highcharts -->
	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>
	 
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo $paths;?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>

    
<script>
var fileobj;
var arr_data = {};
var arr_data_tok = '';
var arr_data_tok_int = '';
var int_file = 0;

function news(){
	$("#modalNewTime").modal('show');
}

function update(CHANNEL_NAME,CHANNEL_NAME_PROG,GENRE,CHANNEL_NUMBER,CHANNEL_REG,CATEGORY,CHANEL_URI,COLOR,FLAG_TV){
	
	$("#channel_name").val(CHANNEL_NAME);
	$("#channel_fe").val(CHANNEL_NAME_PROG);
	$("#genre").val(GENRE);
	$("#number").val(CHANNEL_NUMBER);
	$("#regional").val(CHANNEL_REG);
	$("#category").val(CATEGORY);
	$("#uri").val(CHANEL_URI);
	$("#color").val('#'+COLOR);
	$("#status").val(FLAG_TV);
	$("#modalUpdate").modal('show');
	
	$("#cdr_edit_data").val(CHANNEL_NAME+'|'+CHANNEL_NAME_PROG+'|'+GENRE+'|'+CHANNEL_NUMBER+'|'+CHANNEL_REG+'|'+CATEGORY+'|'+CHANEL_URI+'|'+COLOR+'|'+FLAG_TV);
}



function makeid(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}

$('#edit_user').on('submit',(function(e) {
				$('#btn_daftar_edit').attr('disabled','disabled');
				$('#dayPartMsgedit').html('');
				e.preventDefault();
				
				var formData = new FormData(this);

				$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					success: function(response) {
						
						console.log(response);
						if (response.success == true) {
								
								$('#table_program2').html('');
								$('#table_program2').html(response.html);
								
								var table345 = $('#example4').DataTable({
									"bFilter": true,
									"aaSorting": [],
									"bLengthChange": false,
									'iDisplayLength': 10,
									"sPaginationType": "simple_numbers",
									"Info" : false,
								});	

								
								$('#btn_daftar_edit').removeAttr('disabled');
								
								$('#dayPartMsg').html('');
								$('#dayPartMsg').html('<font size="4px" color="red"><sub >'+response.message+'</sub></font>');
								
								$("#modalUpdate").modal('hide');
								
								
						} else{
							$('#btn_daftar_edit').removeAttr('disabled');
							$('#dayPartMsgedit').html('');
								$('#dayPartMsgedit').html('<font size="4px" color="red"><sub >'+response.message+'</sub></font>');

							//swal("Failed!", response.message, "error");
						}
					}
				}).fail(function(xhr, status, message) {
					$('#btn_daftar_edit').removeAttr('disabled');
					//$('#btn_daftar').text("Daftar Supervisor");
					//swal("Failed!", "Invalid respon, silahkan cek koneksi.", "error");
				});
			}));

$(document).ready(function(){
	
	
	var table345 = $('#example4').DataTable({
		"bFilter": true,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
	});	


	$("#drop_zone").on("dragover", function(event) {
		event.preventDefault();  
		event.stopPropagation();
		return false;
	});
	$("#drop_zone").on("drop", function(event) {
		event.preventDefault();  
		event.stopPropagation();
		
		var ext_file = document.getElementById('selectfile').files;

		fileobj = event.originalEvent.dataTransfer.files;
		
		var index_token = '';
		if(fileobj.length>0){
		for(var f = 0; f < fileobj.length; f++) {
			var fname = fileobj[f].name;
			var fsize = fileobj[f].size;
			if (fname.length > 0) {
				document.getElementById('file_info').innerHTML += "File name : " + fname +' (<b>' + bytesToSize(fsize) + '</b>)<br>';
			}
			
			arr_data[int_file] = fileobj[f];
			arr_data_tok += makeid(10)+'|';
			index_token += int_file+'|';
			int_file++;
		}
		}
		
		
		document.getElementById('selectfile').files = fileobj;
		document.getElementById('btn_upload').style.display="inline";
		ajax_file_upload(fileobj,arr_data_tok,index_token);
		
		
		
		
	});
	
	
	
	$('#btn_file_pick').click(function(){
		/*normal file pick*/
		document.getElementById('selectfile').click();
		document.getElementById('selectfile').onchange = function() {
			fileobj = document.getElementById('selectfile').files;
			
			var index_token = '';
			if(fileobj.length>0){
			for(var f = 0; f < fileobj.length; f++) { 
				var fname = fileobj[f].name;
				var fsize = fileobj[f].size;
				if (fname.length > 0) {
				document.getElementById('file_info').innerHTML += "File name : " + fname +' (<b>' + bytesToSize(fsize) + '</b>)<br>';
				}
				
				arr_data[int_file] = fileobj[f];
				arr_data_tok += makeid(10)+'|';
				index_token += int_file+'|';
				int_file++;
			
			}
			}
			document.getElementById('btn_upload').style.display="inline";
			ajax_file_upload(fileobj,arr_data_tok,index_token);
		};
	});
	$('#btn_upload').click(function(){
		if(fileobj=="" || fileobj==null){
			alert("Please select a file");
			return false;
		}else{
			processData(arr_data_tok);
		}   
	});
});

function processData(rdn_ar) {

	var form_data = new FormData();  
	form_data.append('data_rdn', rdn_ar);
	var url = '<?php echo base_url(); ?>epg_config'; 

	$.ajax({
		type: 'POST',
		url: "<?php echo base_url().'channel_config/process_data'; ?>",
		//url: 'upload.php',
		contentType: false,
		processData: false,
		data: form_data,
		beforeSend:function(response) {
			//$('#message_info').html("Uploading your file, please wait...");
			$('#message_info').html("Processing Data, please wait...");
		},
		success:function(response) {
			$('#message_info').html(response);
			//alert(response);
			$('#selectfile').val('');
			window.location = url;
			
		}
	});

}

function ajax_file_upload(file_obj,rdn_ar,arr_data_tok_int) {
	//console.log(file_obj);
if(file_obj != undefined) {
	var form_data = new FormData();  
	if(fileobj.length>0){
		for(var f = 0; f < fileobj.length; f++) { 
		form_data.append('upload_file[]', file_obj[f]);
		form_data.append('data_rdn', rdn_ar);
		form_data.append('arr_data_tok_int', arr_data_tok_int);
		}
	}   
	$.ajax({
		type: 'POST',
		url: "<?php echo base_url().'channel_config/upload_file'; ?>",
		//url: 'upload.php',
		contentType: false,
		processData: false,
		data: form_data,
		beforeSend:function(response) {
			//$('#message_info').html("Uploading your file, please wait...");
			$('#message_info').html("Uploading your file, please wait...");
		},
		success:function(response) {
			$('#message_info').html(response);
			//alert(response);
			$('#selectfile').val('');
		}
	});
}
}
function bytesToSize(bytes) {
	var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	if (bytes == 0) return '0 Byte';
	var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
</script>	
    
</body>

</html>
