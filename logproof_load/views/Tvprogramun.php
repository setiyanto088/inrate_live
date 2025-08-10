    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Epg Upload</title>

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

             <h3 class="page-titles" style="font-weight:bold">Logproof Form Upload</h3>
          </div>
          <div class="col-md-7 text-right">
		  
			<br/>
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
					  <h4 class="title-periode1" style="font-weight: bold;">Upload Logproof</h4>
					</div>

				</div>
                <div class="widget-content">
				
				
				
					
						 
				</div>
					<br/>
					<div class="col-lg-12">	
					
					 
					<div class="col-lg-8">	
						 
					</div>
					
					</div>

					
 					<div id="table_program23" >
						<div id="drop_zone">
							<p>Drop file here</p>
							<p>or</p>
							<p><button type="button" id="btn_file_pick" class="btn btn-primary"><span class="glyphicon glyphicon-folder-open"></span>  Select File</button></p>
							<p id="file_info"></p>
							<p><button type="button" id="btn_upload" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-up"></span>  Process Data </button></p>
							<input type="file" id="selectfile" multiple="true">
							<p id="message_info"></p>
						</div>
					</div> 
              </div>
            </div>
			
			<div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">Logproof Load History</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('load')" class="button_white" id="filter_load"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
					</div>
				</div>

                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_load" style="display:none">	
					
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view_file()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						<div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Period</label>
									<input type="text"  class="form-control" name="start_date2" id="start_date2" placeholder="From ..." style="text-align:left" value="">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>End Date Period</label>
									<input type="text" class="form-control" name="end_date2" id="end_date2" placeholder="To ..." style="text-align:left" value="">
								</div>
							</div>
							
					</div>
						
					</div>
					
					
					<div class="col-lg-12" style="margin-top:25px">	
					
					<div id="table_program3" style="margin-top:10px">
						<table aria-describedby="table" id="example42" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">File Name </th>
									<th scope="row">Periode </th>
									<th scope="row">Type </th>
									<th scope="row">Note </th>
									<th scope="row">Status </th>
									<th scope="row">Upload Date </th>
									<th scope="row">Process Date </th>
									<th scope="row">PIC </th>
									<th scope="row">Download </th>
								</tr>

							</thead>
						</table>
					</div>
					
					</div>
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

  function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Hide Filter');
	}

	$('#filter_panel_'+part).slideToggle(500);
	
}

	var table345 = $('#example42').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
	});	
 	
							
							
							
			  
	  
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  defaultDate: new Date()
              });                     
              
              $(this).val("<?php echo date('d/m/Y') ?>");
          });

$(document).ready(function(){
	
	audiencebar_view_file();
	
	$("#drop_zone").on("dragover", function(event) {
		event.preventDefault();  
		event.stopPropagation();
		return false;
	});
	$("#drop_zone").on("drop", function(event) {
		event.preventDefault();  
		event.stopPropagation();
		
		
		$('#btn_upload').attr('disabled','disabled');
		var ext_file = document.getElementById('selectfile').files;

		fileobj = event.originalEvent.dataTransfer.files;
		
		var index_token = '';
		if(fileobj.length>0){
		for(var f = 0; f < fileobj.length; f++) {
			var fname = fileobj[f].name;
			var fsize = fileobj[f].size;
			if (fname.length > 0) {
				//document.getElementById('file_info').innerHTML += "File name : " + fname +' (<b>' + bytesToSize(fsize) + '</b>)<p id ='+f+'></p><br>';
			}
			
			arr_data[int_file] = fileobj[f];
			arr_data_tok += makeid(16)+'|';
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
				// if (fname.length > 0) {
					// document.getElementById('file_info').innerHTML += "File name : " + fname +' (<b>' + bytesToSize(fsize) + '</b>)<br>';
				// }
				
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



	function download_file_exs(token_p){

		var form_data = new FormData();  
	
		form_data.append('token_p', token_p);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'logproof_load/audiencebar_by_program_export'; ?>", 
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'POST',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/sopos.xls',data['filename']);
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	}
	
	function download_file(fileURL, fileName) {
    // for non-IE
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_target';
        var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
        save.download = fileName || filename;
	       if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
				document.location = save.href; 
// window event not working here
			}else{
		        var evt = new MouseEvent('click', {
		            'view': window,
		            'bubbles': true,
		            'cancelable': false
		        });
		        save.dispatchEvent(evt);
		        (window.URL || window.webkitURL).revokeObjectURL(save.href);
			}	
    }

    // for IE < 11
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}

function audiencebar_view_file(){
		  
			var form_data = new FormData();  
			var start_date = $('#start_date2').val();
			var end_date = $('#end_date2').val();
			
			const start_date_1 = start_date.split("/");
			const start_date_2 = end_date.split("/");
			
			const date1 = new Date(start_date_1[2]+'-'+start_date_1[1]+'-'+start_date_1[0]);
			const date2 = new Date(start_date_2[2]+'-'+start_date_2[1]+'-'+start_date_2[0]);

			const diffInMs = ((date2 - date1) / (1000 * 60 * 60 * 24))+1;
			
			form_data.append('start_date', start_date);
			form_data.append('end_date', end_date);
			
			if(diffInMs > 60){
				alert('Maximum date 60 Days !!');
			}else{
		
				$.ajax({
					url: "<?php echo base_url().'logproof_load/audiencebar_by_channel_file'; ?>", 
					dataType: 'text',   
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(data){
				
				
					$('#table_program3').html('<table aria-describedby="table" id="example42" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th scope="row">File Name </th><th scope="row">Periode </th><th scope="row">Type </th><th scope="row">Note </th><th scope="row">Status </th><th scope="row">Upload Date </th><th scope="row">Process Date </th><th scope="row">PIC </th><th scope="row">Download </th></tr></thead></table>');
				
					obj = jQuery.parseJSON(data);
				
					$('#example42').DataTable({
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						
						"searching": true,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj,
						columns: [
							{ data: 'FILENAME' },
							{ data: 'PERIODE' },
							{ data: 'TYPE' },
							{ data: 'ERROR' },
							{ data: 'STATUS' },
							{ data: 'UPLOAD_DATE' },
							{ data: 'PROCESS_DATE' },
							{ data: 'USER' },
							{ data: 'BTN' }
						]
					});	
					
					}
				});	
			
			}
			
	  }

function processData(rdn_ar) {

	var form_data = new FormData();  
	form_data.append('data_rdn', rdn_ar);
	var url = '<?php echo base_url(); ?>logproof_load'; 
	$('#btn_upload').attr('disabled','disabled');

	$.ajax({
		type: 'POST',
		url: "<?php echo base_url().'logproof_load/process_data'; ?>",
		//url: 'upload.php',
		contentType: false,
		processData: false,
		data: form_data,
		beforeSend:function(response) {
			//$('#message_info').html("Uploading your file, please wait...");
			$('#message_info').html("Processing Data, please wait...");
		},
		success:function(response) {
			$('#message_info').html(response['msg']);
			//alert(response);
			$('#selectfile').val('');
			
			
			for(var f = 0; f < response['token'].length; f++) { 
				$('#'+response['token'][f]).css('color', '#a4afba');
			}
			//$('#btn_upload').removeAttr('disabled');
			//window.location = url;
			$('#btn_upload').removeAttr('disabled');
			
			audiencebar_view_file();
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
		url: "<?php echo base_url().'logproof_load/upload_file'; ?>",
		//url: 'upload.php',
		contentType: false,
		processData: false,
		data: form_data,
		beforeSend:function(response) {
			//$('#message_info').html("Uploading your file, please wait...");
			$('#message_info').html("Uploading your file, please wait...");
			
			//document.getElementById('file_info').innerHTML += "File name : " + fname +' (<b>' + bytesToSize(fsize) + '</b>)<br>';
		},
		success:function(response) {
			
			for(var f = 0; f < response['data'].length; f++) { 
				document.getElementById('file_info').innerHTML += "<span id='"+response['data'][f]['TOKEN']+"' style='color:"+response['data'][f]['CHANNEL_COLOR']+"'>File name : " + response['data'][f]['FILE_NAME'] +' (<b>' + response['data'][f]['ROW'] + ' Rows </b>) '+response['data'][f]['ERROR']+'</span><br>';
			}
			
			$('#message_info').html(response['msg']);
			//alert(response);
			$('#selectfile').val('');
			$('#btn_upload').removeAttr('disabled');
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
