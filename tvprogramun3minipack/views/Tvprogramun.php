    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home Post Buy Dashboard</title>

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
	.form-control{
		font-weight: bold;
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
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Pay TV</li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Minipack Dashboard</li>
            </ol>
            <h4 class="page-title"><strong>Minipack Dashboard</strong></h4>
          </div>
        </div>
		<br>
        <!-- Dashboard Stats -->
        <div class="row">
		
		<div class="col-lg-12">	
			<div class="col-lg-2">	
				<h4 id="shs">Showing data from</h4>
			</div>
			<div class="col-lg-2">	
					<select class="form-control" name="tahun" id="tahun" required onChange="viewall()">
					<option value='2018' <?php  if ($tahunselected=='2018') { echo 'selected'; } ?> >2018</option>
					<option value='2019' <?php  if ($tahunselected=='2019') { echo 'selected'; } ?> >2019</option>
					<option value='2020' <?php  if ($tahunselected=='2020') { echo 'selected'; } ?> >2020</option>
					<option value='2021' <?php  if ($tahunselected=='2021') { echo 'selected'; } ?> >2021</option>
					<option value='2022' <?php  if ($tahunselected=='2022') { echo 'selected'; } ?> >2022</option>
					<option value='2023' <?php  if ($tahunselected=='2023') { echo 'selected'; } ?> >2023</option>	
					<?php 
						//print_r($thn);
							foreach($thn as $periode){
								
								if ($periode['TANGGAL']==$tahunselected) {
									echo "<option value=".$periode['TANGGAL']." selected>".$periode['TANGGAL']."</option>";
								}else {
									echo "<option value=".$periode['TANGGAL']." >".$periode['TANGGAL']."</option>";
								}
								
							
								
							}
						
						 
						?>
					</select>   
			</div>
			
			<div class="col-lg-8">	
				<hr />
			</div>
			 
		</div>
		<br/>
		<br/>
		<br/>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">Audience by Minipack</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('channel')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>

                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_channel" style="display:none">	
					
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						<div class="col-lg-12">	

							<div class="col-lg-3">	
								<div class="form-group">
									<label>Day</label>
									<select class="form-control"  id="tgl1" name="tgl1" >
									  
									  <?php 
										echo '<option value="0"  >'.'All Days</option>';
										foreach($tanggal as $ddd){
											
											echo '<option value='.$ddd.'  >'.'Day '.$ddd.'</option>';
										}
									  ?>
									</select> 
								</div>
							</div>
							<div class="col-lg-3">
							<div class="form-group">
									<label>Week</label>
							<select class="form-control"  id="week1" name="week1"  >
							  
							  <?php 
								echo '<option value="ALL"  >'.'All Weeks</option>';
								for ($i=0;$i<=count($mingguan1)-1;$i++){
									$w=$i+1;
									echo '<option value='.$mingguan1[$i]['WEEK'].'  >'.'Week '.$w.'</option>';
								}
							  ?>
							</select> 
							</div>
							</div>
							<div class="col-lg-3">
							<div class="form-group">
									<label>Data</label>
							<select class="form-control" name="audiencebar" id="audiencebar" required >
								<option value="AUDIENCE" selected >Audience</option>
								<option value="TOTAL_VIEWERS" >Total Views</option>
								<option value="DURATION" >Duration</option>
							</select> 
							</div>
							</div>
							<div class="col-lg-3">
							<div class="form-group">
									<label>Type</label>
									<select class="form-control" name="tipe_filter" id="tipe_filter" required >
										<option value="live" selected >Live</option>
										<option value="ALL" >All</option>
										<option value="TVOD" >TVOD</option>
									</select> 
							</div>
							</div>
							<div class="col-lg-3">
							<div class="form-group">
									<label>Area</label>
									<select class="form-control" name="tipe_area" id="tipe_area" required >
										<option value="ALL" selected >All Area</option>
										<option value="01" >Area 01</option>
										<option value="02" >Area 02</option>
										<option value="03" >Area 03</option>
										<option value="04" >Area 04</option>
									</select> 
							</div>
							</div>
							
						</div>
						
					</div>
					
					
					<div class="col-lg-12" style="margin-top:25px">	
					

					
					<div class="panel-body" id="tab-contents-result" style="">
						<div class="col-md-2">
 								<div class="row" style="background-color:#F2F2F2;padding:5px;color:#000;border: none;border-radius:5px">
									 <div class="col-md-6" id="tabs_table" style="border: none;background-color:#fff;border-radius:5px;">
										<button id="tab_table" style="border: none;background-color:#fff;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('table')" href="#table" aria-controls="table" role="tab" data-toggle="tab"><strong>Table</strong></button>
									</div>
									<div class="col-md-6" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Chart</strong></button>
									</div>
								</div>
                        </div>      
					</div>
					
					<div class="tab-content" >
						<!-- Tab Table -->
						<div role="tabpanel" class="tab-pane active" id="table" style="margin-top:10px;">
				  
							<div id="table_program2" style="margin-top:-30px">
								<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
									<thead style="color:red">
										<tr>
											<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
											<th scope="row">Minipack <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
											<th scope="row">Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
										</tr>

									</thead>
								</table>
							</div>
					
						</div>
						<div role="tabpanel" class="tab-pane" id="chart" >
							  <div id="area_chart" class="col-md-12" style="padding:10px">	
								  <div class="result-chart" style="border: 1px solid #efefef;border-radius: 25px">
										
									  <p id="dtmsg" style="text-align: center;font-size: 24px;display:none;">No data available<p>
									  <div class="result-chart-graph" style=" margin : auto">
										  <div id="container1" style=" margin: 0 auto"></div>
									  </div>
								  </div>
							  </div>
						</div>
					</div>
					
					</div>
                 </div>
            </div>
          </div>
  
        </div>
        <!-- / Dashboard Widget -->
        <!-- / Content -->
      </div>
    </div>
  </div>
  <!-- / Main Contaner -->

  <!-- Modal New Widget -->


  <!-- Modal Delete Widget -->

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

<script async >

		function tab_filter(tabs){
	
			if(tabs == 'chart'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#fff');
				$('#tabs_chart').css('background-color','#fff');
			
			}else{
				
				$('#tab_table').css('background-color','#fff');
				$('#tabs_table').css('background-color','#fff');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				
			
			}
			
		 }  
		 

function timesec(id){
	
 	document.getElementById("modal_filter").focus();
	
	$("#id_time").val(id);
	$("#modal_time").modal("show");
	
	
}

function settime(){
	
 	$("#modal_time").modal("hide");
	
	var hours = $("#hours").val();
	var minutes = $("#minutes").val();
	var seconds = $("#seconds").val();
	var id_time = $("#id_time").val();
	
	var time = hours+":"+minutes+":"+seconds;
	
	 $("#"+id_time).val(time);
	 
	$("#minutes").val("00").change();
	$("#seconds").val("00").change();
	$("#hours").val("00").change();
	
}

$(function () {
	

var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };	
	
window.chartColors = {
	red: '#ff5f5f',
	orange: 'rgb(220, 99, 70)',
	yellow: 'rgb(255, 205, 86)',
	green: '#a7d14b',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	white: 'rgb(255, 255, 255)'
};
 
});

$( document ).ready(function() {


	$('#week1').change(function(){
		$('#tgl1').val(0);	
	});
	
	$('#tgl1').change(function(){
		$('#week1').val("ALL");	
	});
	
	$('#tgl2').change(function(){
		$('#week2').val("ALL");	
	});
	
	$('#week2').change(function(){
		$('#tgl2').val(0);	
	});
	
});



var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';
var data = '' ;
var audiencebychannel = <?php echo $audiencebychannel; ?>;
var json_channel = <?php echo $json_channel; ?>;
var json_spot = <?php echo $json_spot; ?>;
var tot_s = <?php echo $tot_s; ?>;


$(function () {	
var fieldas = $('#product_program').val();
var tgl2 = $('#tgl2').val();
var week2 = $('#week2').val();


var tgl1mr = $('#tgl1mr').val();
var tgl2mr = $('#tgl2mr').val();


var search_val = $( "input[aria-controls='example3']" ).val();
var search_val8 = $( "input[aria-controls='example48']" ).val();

 
  var user_id = $.cookie(window.cookie_prefix + "user_id");
              var token = $.cookie(window.cookie_prefix + "token");    

	var table4 = $('#example4').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		data: audiencebychannel,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		columns: [
			{ data: 'Rangking' },
			{ data: 'channel' },
			{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
					 
				}
			}
		]
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});
	
	var dataSum = 0;
	// for (var i=0;i < data_array.length;i++) {
		// dataSum += data_array[i]
	// }
	
	
	Highcharts.chart('container1', {
		chart: {
			type: 'column'
		},
		title: {
			text: '<h1>Minipack Viewership & Contributor</h1>',
			style: {
						fontSize: '2.9em'
			}
		},
		subtitle: {
			text: this.id,
			style: {
						fontSize: '1.9em'
			}
		},
		xAxis: {
			categories: json_channel,
			crosshair: true,
			accessibility: {
				description: 'Countries'
			},
			labels: {
					style: {
						fontSize:'1.0em'
					}
			   }
		},
		yAxis: {
			min: 0,
			title: {
				text: ''
			},
			labels: {
				overflow: 'justify',
				style: {
					fontSize:'1.3em'
				}
			}
		},
		tooltip: {
			valueSuffix: '',
			formatter:function() {
				var pcnt = (this.y / tot_s) * 100;
				var percentage = Highcharts.numberFormat(pcnt, 1,',','.') + '%';
				var html_tip = this.x+'<br> : '+this.y+'<br>'+percentage;
				return html_tip;
			},
			style: {
				fontSize:'1.3em'
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			},
			series: {
				shadow:false,
				borderWidth:0,
				pointWidth: 15,
				dataLabels:{
					enabled:true,
					formatter:function() {
						var pcnt = (this.y / tot_s) * 100;
						var percentage = Highcharts.numberFormat(pcnt, 1,',','.') + '%';
						return this.y +'<br>'+ percentage;
					},
					style: {
						fontSize: '0.8em'
					}
				}
			}
		},
		legend: {
			enabled: false
		},
		series: [
			{	
				dataSorting: {
					enabled: true
				},
				name: '',
				data: json_spot,
				color: 'red'
			}
		]
	});
	
		
	$('#channel_export').on('click', function() {
 	  
		if($('#fta_channel').is(':checked')){
		
			var check = "True";
		}else{
			var check = "False";
		
		}
	  
		var form_data = new FormData();  
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var week = $('#week1').val();
		var tgl = $('#tgl1').val();
		var tipe_filter = $('#tipe_filter').val();
		var profile_chan = $('#profile_chan').val();
		var check = check;
		
		var filter = table4.search()
			
		form_data.append('cond',filter);
		form_data.append('check', check);
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
		form_data.append('tgl', tgl);
		form_data.append('tipe_filter', tipe_filter);
		form_data.append('profile', profile_chan);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3minipack/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel.xls','Audience_by_channel.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
});


function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Hide Filter');
	}

	$('#filter_panel_'+part).slideToggle(500);
	
}

function getNest(){
	 
	
	$('#filter_text').val(JSON.stringify(nest));
	
	$('#filter_form').submit();
	
	
} 


function viewall(){
	
		var url = '<?php echo base_url(); ?>tvprogramun3'; 
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
 		  
		 $("#laod").append(' <img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	
}



function print_excel(){
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var profile_chan = $('#profile_chan').val();
	 
	var filter = table4.search()
	
 	
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
	form_data.append('profile', profile_chan);
	
	 
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

function audiencebar_view(){

	var check = "True";
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var tipe_filter = $('#tipe_filter').val();
	var check = check;
	var profile_chan = $('#profile_chan').val();
	var tipe_area = $('#tipe_area').val();
	//var hariakhir = $('#hariakhir').val();
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('check', check);
	form_data.append('tgl', tgl);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('tipe_area', tipe_area);
	form_data.append('profile', profile_chan);
   
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3minipack/audiencebar_by_channel'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			 
			$('#table_program2').html("");
			 
			if(type == 'Viewers'){
				
				var tpe = 'Total Views';
				
			}else if(type == 'Duration'){
				var tpe = 'Duration ';
			}else{
				
				var tpe = type;
			}
					$('#table_program2').html('<table aria-describedby="table" id="example4" class="table table-striped example" style="color:black"><thead style="color:red"><tr><th>Rank<img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);
			
			console.log(obj);

				$('#example4').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 10,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					
		"searching": true,
					data: obj.data_ch,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					columns: [
						{ data: 'Rangking' },
						{ data: 'channel' },
						{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
				return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								 
							}
						}
					]
				});	
				
				
			Highcharts.chart('container1', {
				chart: {
					type: 'column'
				},
				title: {
					text: '<h1>Minipack Viewership & Contributor</h1>',
					style: {
								fontSize: '2.9em'
					}
				},
				subtitle: {
					text: this.id,
					style: {
								fontSize: '1.9em'
					}
				},
				xAxis: {
					categories: obj.chart_label,
					crosshair: true,
					accessibility: {
						description: 'Countries'
					},
					labels: {
							style: {
								fontSize:'1.0em'
							}
					   }
				},
				yAxis: {
					min: 0,
					title: {
						text: ''
					},
					labels: {
						overflow: 'justify',
						style: {
							fontSize:'1.3em'
						}
					}
				},
				tooltip: {
					valueSuffix: '',
					formatter:function() {
						var pcnt = (this.y / tot_s) * 100;
						var percentage = Highcharts.numberFormat(pcnt, 1,',','.') + '%';
						var html_tip = this.x+'<br> : '+this.y+'<br>'+percentage;
						return html_tip;
					},
					style: {
						fontSize:'1.3em'
					}
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					},
					series: {
						shadow:false,
						borderWidth:0,
						pointWidth: 15,
						dataLabels:{
							enabled:true,
							formatter:function() {
								var pcnt = (this.y / tot_s) * 100;
								var percentage = Highcharts.numberFormat(pcnt, 1,',','.') + '%';
								return this.y +'<br>'+ percentage;
							},
							style: {
								fontSize: '0.8em'
							}
						}
					}
				},
				legend: {
					enabled: false
				},
				series: [
					{	
						dataSorting: {
							enabled: true
						},
						name: '',
						data: obj.chart_data,
						color: 'red'
					}
				]
			});
			
			
			
			 
		}
	});	
}

    
    function diff(from, to) {
		
		 var monthNames = [ "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December" ];
			
			
        var arr = [];
        var datFrom = new Date('1 ' + from);
        var datTo = new Date('1 ' + to);
        var fromYear =  datFrom.getFullYear();
        var toYear =  datTo.getFullYear();
        var diffYear = (12 * (toYear - fromYear)) + datTo.getMonth();
    
        for (var i = datFrom.getMonth(); i <= diffYear; i++) {
            arr.push(Math.floor(fromYear+(i/12))+"-"+monthNames[i%12] );
        }        
        
        return arr;
    }

 


window.onload = function () {
	Chart.pluginService.register({
		beforeDraw: function (chart) {
			if (chart.config.options.elements.center) {
		        //Get ctx from string
		        var ctx = chart.chart.ctx;
		        
				//Get options from the center object in options
		        var centerConfig = chart.config.options.elements.center;
		      	var fontStyle = centerConfig.fontStyle || 'Arial';
				var txt = centerConfig.text;
		        var color = centerConfig.color || '#000';
		        var sidePadding = centerConfig.sidePadding || 20;
		        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
		        
		        //Start with a base font of 30px
		        ctx.font = "50px " + fontStyle;
		        
				//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
		        var stringWidth = ctx.measureText(txt).width;
		        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

		        // Find out how much the font can grow in width.
		        var widthRatio = elementWidth / stringWidth;
		        var newFontSize = Math.floor(30 * widthRatio);
		        var elementHeight = (chart.innerRadius * 2);

		        // Pick a new font size so it will not be larger than the height of label.
		        var fontSizeToUse = Math.min(newFontSize, elementHeight);

				//Set font settings to draw it correctly.
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'middle';
		        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
		        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
		        ctx.font = fontSizeToUse + "px " + fontStyle;
		        ctx.fillStyle = color;
		        
		        //Draw text in center
		        ctx.fillText(txt, centerX, centerY);
			}
		}
	});
  
 };                                  

$( document ).ready(function() {
   
	
	var selPeriode = $('#tahun').val();
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
   
});

function show(){
	$('#hs').html('*check widget first before export');
}               

$(document).ready(function(){
    $(".table th").on("click",function(){                    
        if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
            $(this).children().css("transform","rotate(180deg)");
        } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
            $(this).children().css("transform","rotate(0deg)");
        }
    });
});
</script>	
    
</body>

</html>
