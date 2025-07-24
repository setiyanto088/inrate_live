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
      <div class="container-fluid" style="margin-left:20px;">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">                                   
            <h4 class="page-title"><strong>Monitoring</strong></h4>
          </div>
        </div>
		<br>

        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row">
			<div id="" class="row">
				<div class="col-md-2" >	
					<h4 style="color:red;margin-left:10px;"><strong>Current Usage</strong></h4>
				</div>
				<div class="col-md-2" >	
				<select class="form-control" name="tahun" id="tahun" onChange="cpu_usage()">
						<option value='1' >Main Server</option>
						<option value='2' >Web Service Server</option>
					</select>   
				</div>
		  </div>
          <div class="grid-stack-item row" data-gs-min-width="3" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="3" data-gs-height="2" data-gs-auto-position="1" style="padding:10px">
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">CPU Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_cpu" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-time" style="margin-top: -15px;"></canvas>
                </div>

            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Memory Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_mem" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-mem" style="margin-top: -15px;"></canvas>
                </div>

            </div>
			</div>

			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Storage Available</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_store" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-store" style="margin-top: -15px;"></canvas>
                </div>

            </div>
			</div>
			
			</div>
			
			<div class="grid-stack-item row" data-gs-min-width="3" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="3" data-gs-height="2" data-gs-auto-position="1" style="padding:10px">
			
			<h4 style="color:red;margin-left:10px;"><strong>Daily Usage <?php echo date('d F Y'); ?></strong></h4>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Max CPU Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_maxcpu" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-maxcpu" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Max Memory Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_maxmem" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-maxmem" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Average CPU Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_avgcpu" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-avgcpu" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Average Memory Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_avgmem" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-avgmem" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			
          </div>
		  
		  <div class="grid-stack-item row" data-gs-min-width="3" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="3" data-gs-height="2" data-gs-auto-position="1" style="padding:10px">
			
			<div id="" class="row">
				<div class="col-md-2" >	
					<h4 style="color:red;margin-left:10px;"><strong>Monthly Usage</strong></h4>
				</div>
				<div class="col-md-2" >	
				<select class="form-control" name="periode" id="periode" required onChange="cpu_usage()">
					<?php
						foreach($array_per as $array_pers){
							if($array_pers == date('Y-F')){
								echo "<option value='".$array_pers."' selected >".$array_pers."</option>";
							}else{
								echo "<option value='".$array_pers."' >".$array_pers."</option>";
							}
							
						}
					?>
						
					</select>   
				</div>
		  </div>
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Max CPU Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_maxcpum" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-maxcpum" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Max Memory Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_maxmemm" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-maxmemm" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Average CPU Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_avgcpum" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-avgcpum" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Average Memory Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_avgmemm" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-avgmemm" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Average Max CPU Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_avgcpumx" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-avgcpumx" style="margin-top: -15px;"></canvas>
                </div>
            </div>
			</div>
			
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left" >
                  <h4 style="font-weight:bold">Average Max Memory Usage</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div id="chart_avgmemmx" class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-avgmemmx" style="margin-top: -15px;"></canvas>
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
  <div class="modal fade" id="deleteWidget" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Widget</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to delete ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-delete" data-dismiss="modal">Delete</button>
        </div>
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

<script async >

setInterval(function(){
	cpu_usage();
},10000);

function cpu_usage(){
	
		var form_data = new FormData();
		var types = $('#tahun').val();
		var periode = $('#periode').val();
		form_data.append('types',types);
		form_data.append('periode',periode);
		
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3mon/get_data_last'; ?>", 
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,    
			type: 'POST',
			success: function(data){

				document.getElementById("chart_cpu").innerHTML = '&nbsp;';
				document.getElementById("chart_cpu").innerHTML = '<canvas id="widget-spot-time" style="margin-top: -15px;"></canvas>';
				
				
				
				
				var percentageDoughnutChart = data.dataw.CPU_USAGE;
    
				var DoughnutChartData = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChart,
							100-percentageDoughnutChart
						]
					}]
				};
				
				var canvasSpotByTime = document.getElementById("widget-spot-time").getContext("2d");
				var myDoughnutChart = new Chart(canvasSpotByTime, {
					type: 'doughnut',
					data: DoughnutChartData,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChart.toFixed(2) + " %",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_mem").innerHTML = '&nbsp;';
				document.getElementById("chart_mem").innerHTML = '<canvas id="widget-spot-mem" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartsMem = data.dataw.MEM_ACTIVE/1048576;
    
				var DoughnutChartDataMem = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartsMem,
							(data.dataw.MEM_TOTAL/1048576) - percentageDoughnutChartsMem
						]
					}]
				};
				
				var canvasSpotByMem = document.getElementById("widget-spot-mem").getContext("2d");
				var myDoughnutChartMem = new Chart(canvasSpotByMem, {
					type: 'doughnut',
					data: DoughnutChartDataMem,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartsMem.toFixed(2) + " GB",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				
				document.getElementById("chart_maxcpu").innerHTML = '&nbsp;';
				document.getElementById("chart_maxcpu").innerHTML = '<canvas id="widget-spot-maxcpu" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartmaxcpu = data.dataw.MAX_CPU_USAGE;
    
				var DoughnutChartDatamaxcpu = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartmaxcpu,
							100-percentageDoughnutChartmaxcpu
						]
					}]
				};
				
				var canvasSpotByTimemaxcpu = document.getElementById("widget-spot-maxcpu").getContext("2d");
				var myDoughnutChartmaxcpu = new Chart(canvasSpotByTimemaxcpu, {
					type: 'doughnut',
					data: DoughnutChartDatamaxcpu,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartmaxcpu.toFixed(2) + " %",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_maxcpum").innerHTML = '&nbsp;';
				document.getElementById("chart_maxcpum").innerHTML = '<canvas id="widget-spot-maxcpum" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartmaxcpum = data.datawm.MAX_CPU_USAGE;
    
				var DoughnutChartDatamaxcpum = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartmaxcpum,
							100-percentageDoughnutChartmaxcpum
						]
					}]
				};
				
				var canvasSpotByTimemaxcpum = document.getElementById("widget-spot-maxcpum").getContext("2d");
				var myDoughnutChartmaxcpum = new Chart(canvasSpotByTimemaxcpum, {
					type: 'doughnut',
					data: DoughnutChartDatamaxcpum,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartmaxcpum.toFixed(2) + " %",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_avgcpu").innerHTML = '&nbsp;';
				document.getElementById("chart_avgcpu").innerHTML = '<canvas id="widget-spot-avgcpu" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartavgcpu = data.dataw.AVG_CPU_USAGE;
    
				var DoughnutChartDataavgcpu = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartavgcpu,
							100-percentageDoughnutChartavgcpu
						]
					}]
				};
				
				var canvasSpotByTimeavgcpu = document.getElementById("widget-spot-avgcpu").getContext("2d");
				var myDoughnutChartavgcpu = new Chart(canvasSpotByTimeavgcpu, {
					type: 'doughnut',
					data: DoughnutChartDataavgcpu,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartavgcpu.toFixed(2) + " %",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_avgcpum").innerHTML = '&nbsp;';
				document.getElementById("chart_avgcpum").innerHTML = '<canvas id="widget-spot-avgcpum" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartavgcpum = data.datawm.AVG_CPU_USAGE;
    
				var DoughnutChartDataavgcpum = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartavgcpum,
							100-percentageDoughnutChartavgcpum
						]
					}]
				};
				
				var canvasSpotByTimeavgcpum = document.getElementById("widget-spot-avgcpum").getContext("2d");
				var myDoughnutChartavgcpum = new Chart(canvasSpotByTimeavgcpum, {
					type: 'doughnut',
					data: DoughnutChartDataavgcpum,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartavgcpum.toFixed(2) + " %",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_avgcpumx").innerHTML = '&nbsp;';
				document.getElementById("chart_avgcpumx").innerHTML = '<canvas id="widget-spot-avgcpumx" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartavgcpumx = data.datawm.AVG_MAX_CPU;
    
				var DoughnutChartDataavgcpumx = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartavgcpumx,
							100-percentageDoughnutChartavgcpumx
						]
					}]
				};
				
				var canvasSpotByTimeavgcpumx = document.getElementById("widget-spot-avgcpumx").getContext("2d");
				var myDoughnutChartavgcpumx = new Chart(canvasSpotByTimeavgcpumx, {
					type: 'doughnut',
					data: DoughnutChartDataavgcpumx,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartavgcpumx.toFixed(2) + " %",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				
				document.getElementById("chart_maxmem").innerHTML = '&nbsp;';
				document.getElementById("chart_maxmem").innerHTML = '<canvas id="widget-spot-maxmem" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartsmaxmem = data.dataw.MAX_MEM_ACTIVE/1048576;
    
				var DoughnutChartDatamaxmem = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartsmaxmem,
							(data.dataw.MEM_TOTAL/1048576) - percentageDoughnutChartsmaxmem
						]
					}]
				};
				
				var canvasSpotBymaxmem = document.getElementById("widget-spot-maxmem").getContext("2d");
				var myDoughnutChartmaxmem = new Chart(canvasSpotBymaxmem, {
					type: 'doughnut',
					data: DoughnutChartDatamaxmem,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartsmaxmem.toFixed(2) + " GB",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_maxmemm").innerHTML = '&nbsp;';
				document.getElementById("chart_maxmemm").innerHTML = '<canvas id="widget-spot-maxmemm" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartsmaxmemm = data.datawm.MAX_MEM_ACTIVE/1048576;
    
				var DoughnutChartDatamaxmemm = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartsmaxmemm,
							(data.datawm.MEM_TOTAL/1048576) - percentageDoughnutChartsmaxmemm
						]
					}]
				};
				
				var canvasSpotBymaxmemm = document.getElementById("widget-spot-maxmemm").getContext("2d");
				var myDoughnutChartmaxmemm = new Chart(canvasSpotBymaxmemm, {
					type: 'doughnut',
					data: DoughnutChartDatamaxmemm,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartsmaxmemm.toFixed(2) + " GB",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_avgmem").innerHTML = '&nbsp;';
				document.getElementById("chart_avgmem").innerHTML = '<canvas id="widget-spot-avgmem" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartsavgmem = data.dataw.AVG_MEM_ACTIVE/1048576;
    
				var DoughnutChartDataavgmem = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartsavgmem,
							(data.dataw.MEM_TOTAL/1048576) - percentageDoughnutChartsavgmem
						]
					}]
				};
				
				var canvasSpotByavgmem = document.getElementById("widget-spot-avgmem").getContext("2d");
				var myDoughnutChartavgmem = new Chart(canvasSpotByavgmem, {
					type: 'doughnut',
					data: DoughnutChartDataavgmem,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartsavgmem.toFixed(2) + " GB",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				document.getElementById("chart_avgmemm").innerHTML = '&nbsp;';
				document.getElementById("chart_avgmemm").innerHTML = '<canvas id="widget-spot-avgmemm" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartsavgmemm = data.datawm.AVG_MEM_ACTIVE/1048576;
    
				var DoughnutChartDataavgmemm = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartsavgmemm,
							(data.datawm.MEM_TOTAL/1048576) - percentageDoughnutChartsavgmemm
						]
					}]
				};
				
				var canvasSpotByavgmemm = document.getElementById("widget-spot-avgmemm").getContext("2d");
				var myDoughnutChartavgmemm = new Chart(canvasSpotByavgmemm, {
					type: 'doughnut',
					data: DoughnutChartDataavgmemm,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartsavgmemm.toFixed(2) + " GB",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_avgmemmx").innerHTML = '&nbsp;';
				document.getElementById("chart_avgmemmx").innerHTML = '<canvas id="widget-spot-avgmemmx" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartsavgmemmx = data.datawm.AVG_MAX_MEM/1048576;
    
				var DoughnutChartDataavgmemmx = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#0e93e6',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartsavgmemmx,
							(data.datawm.MEM_TOTAL/1048576) - percentageDoughnutChartsavgmemmx
						]
					}]
				};
				
				var canvasSpotByavgmemmx = document.getElementById("widget-spot-avgmemmx").getContext("2d");
				var myDoughnutChartavgmemmx = new Chart(canvasSpotByavgmemmx, {
					type: 'doughnut',
					data: DoughnutChartDataavgmemmx,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: percentageDoughnutChartsavgmemmx.toFixed(2) + " GB",
								color: '#000',
								fontStyle: 'Lato',
							}
						}      
					}
				});
				
				
				document.getElementById("chart_store").innerHTML = '&nbsp;';
				document.getElementById("chart_store").innerHTML = '<canvas id="widget-spot-store" style="margin-top: -15px;"></canvas>';
				
				var percentageDoughnutChartstore = data.dataw.STORE_PER;
    
				var DoughnutChartDatastore = {
					labels: [
						"Prime Time",
						"Non Prime Time"
					],
					datasets: [{
						backgroundColor: [
							'#FF0000',
							'#FFDEDE'
							
						],
						label: 'Main Server',
						borderWidth: 0,
						cutoutPercentage: 75,
						data: [
							percentageDoughnutChartstore,
							100 - percentageDoughnutChartstore
						]
					}]
				};
				
				var canvasSpotBystore = document.getElementById("widget-spot-store").getContext("2d");
				var myDoughnutChartstore = new Chart(canvasSpotBystore, {
					type: 'doughnut',
					data: DoughnutChartDatastore,
					options: {       
					animation: false,					
				  cutoutPercentage: 90,    
						maintainAspectRatio: false,
						 legend: {
							display: false
						 },
						 tooltips: {
							enabled: false
						 },
				  elements: {
							center: {
								text: data.dataw.STORE_AVAIL + "B /" +data.dataw.STORE_SIZE +"B",
								color: '#000',
								fontStyle: 'Lato',
								fontSizeToUse: '16px',
							}
						}      
					}
				});
				// myDoughnutChart.data.datasets[0].data = [data.dataw.CPU_USAGE, 100-data.dataw.CPU_USAGE];
				// myDoughnutChart.update();					
				 
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
		
		
		

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
	
	cpu_usage();
	
});




$(function () {	

  var user_id = $.cookie(window.cookie_prefix + "user_id");
              var token = $.cookie(window.cookie_prefix + "token");    
 
	
	
	
});


</script>	
    
</body>

</html>
